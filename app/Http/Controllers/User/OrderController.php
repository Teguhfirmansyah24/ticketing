<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TicketType;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderController extends Controller
{
    /**
     * Step 1: Form Pemesanan
     */
    public function create($eventId)
    {
        $event = Event::with([
            'category',
            'creator',
            'ticketTypes' => fn($q) => $q->where('is_active', true)->orderBy('price')
        ])->where('status', 'published')->findOrFail($eventId);

        return view('user.order.create', compact('event'));
    }

    /**
     * Step 2: Simpan Order & Kurangi Stok (Sold)
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id'          => 'required|exists:events,id',
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'phone'              => 'required|string|max:20',
            'id_number'         => 'required|string|max:20',
            'agree'             => 'required|accepted',
            'tickets'           => 'required|array',
            'tickets.*.id'      => 'required|exists:ticket_types,id',
            'tickets.*.qty'     => 'required|integer|min:0',
        ]);

        $selectedTickets = collect($request->tickets)->filter(fn($t) => $t['qty'] > 0);

        if ($selectedTickets->isEmpty()) {
            return back()->withErrors(['tickets' => 'Silakan pilih minimal 1 jenis tiket.'])->withInput();
        }

        $event = Event::findOrFail($request->event_id);
        $totalAmount = 0;
        $items = [];

        foreach ($selectedTickets as $item) {
            $ticketType = TicketType::findOrFail($item['id']);
            $available = $ticketType->quota - $ticketType->sold;

            if ($item['qty'] > $available) {
                return back()->withErrors(['tickets' => "Tiket {$ticketType->name} hanya tersisa {$available}."])->withInput();
            }

            $subtotal     = $ticketType->price * $item['qty'];
            $totalAmount += $subtotal;

            $items[] = [
                'ticket_type_id' => $ticketType->id,
                'name'           => $ticketType->name,
                'quantity'       => $item['qty'],
                'price'          => $ticketType->price,
                'subtotal'       => $subtotal,
            ];
        }

        try {
            $order = DB::transaction(function () use ($event, $request, $totalAmount, $items) {
                $order = Order::create([
                    'user_id'      => auth()->id(),
                    'event_id'     => $event->id,
                    'order_code'   => 'ORD-' . strtoupper(Str::random(10)),
                    'total_amount' => $totalAmount,
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'phone'        => $request->phone,
                    'id_number'    => $request->id_number,
                    'status'       => 'pending',
                    'expired_at'   => now()->addMinutes(15),
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id'       => $order->id,
                        'ticket_type_id' => $item['ticket_type_id'],
                        'quantity'       => $item['quantity'],
                        'price'          => $item['price'],
                        'subtotal'       => $item['subtotal'],
                    ]);

                    // Stok otomatis berkurang di database (Admin & User sinkron)
                    TicketType::find($item['ticket_type_id'])->increment('sold', $item['quantity']);
                }

                return $order;
            });

            return redirect()->route('orders.confirm', $order->id);
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Step 3: Halaman Konfirmasi Pembayaran
     */
    public function confirm($id)
    {
        $order = Order::with(['orderItems.ticketType', 'event'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $orderData = [
            'event_id'     => $order->event_id,
            'name'         => $order->name,
            'email'        => $order->email,
            'phone'        => $order->phone,
            'id_number'    => $order->id_number,
            'total_amount' => $order->total_amount,
            'items'        => $order->orderItems
        ];

        return view('user.order.confirm', [
            'order'     => $order,
            'orderData' => $orderData,
            'orderId'   => $order->id,
            'event'     => $order->event
        ]);
    }

    /**
     * Step 4: Ambil Token Midtrans
     */
    public function getSnapToken(Order $order, MidtransService $midtransService)
    {
        try {
            if ($order->orderItems->isEmpty()) {
                return response()->json(['error' => 'Tiket tidak ditemukan.'], 422);
            }

            $token = $midtransService->createSnapToken($order);
            return response()->json(['token' => $token]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Step 5: Update Status Jadi Approved
     */
    public function paymentSuccess($id)
    {
        // Ambil order beserta itemnya
        $order = Order::with('orderItems.ticketType')->where('user_id', auth()->id())->findOrFail($id);

        if ($order->status !== 'approved') {
            // 1. Update status order jadi approved
            $order->status = 'approved';
            $order->save();

            // 2. GENERATE TIKET (Ini bagian yang kurang!)
            foreach ($order->orderItems as $item) {
                // Kita buat looping berdasarkan quantity yang dibeli
                for ($i = 0; $i < $item->quantity; $i++) {
                    \App\Models\Ticket::create([
                        'user_id'        => $order->user_id,
                        'event_id'       => $order->event_id,
                        'ticket_type_id' => $item->ticket_type_id,
                        'order_item_id'  => $item->id,
                        'ticket_code'    => 'TIX-' . strtoupper(\Illuminate\Support\Str::random(12)),
                        'status'         => 'active', // Tiket langsung aktif
                    ]);
                }
            }
        }

        return view('user.order.success', compact('order'));
    }


    /**
     * Step 6: Daftar Tiket Saya
     */
    public function index()
    {
        $orders = Order::with('event')
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('user.order.index', compact('orders'));
    }

    public function cancel(Order $order)
    {
        // 1. Validasi: Pastikan hanya pemilik order yang bisa cancel
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // 2. Validasi: Hanya bisa cancel jika status masih pending
        if ($order->status === 'pending') {
            try {
                // Menggunakan Database Transaction untuk keamanan data
                DB::transaction(function () use ($order) {
                    foreach ($order->orderItems()->with('ticketType')->get() as $item) {
                        if ($item->ticketType) {
                            $item->ticketType->decrement('sold', $item->quantity);
                        }
                    }

                    // Update status pesanan menjadi cancelled
                    $order->update(['status' => 'cancelled']);
                });

                return back()->with('success', 'Pesanan berhasil dibatalkan dan stok telah dikembalikan.');
            } catch (\Exception $e) {
                // Jika terjadi error sistem, kembalikan pesan error
                return back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'Pesanan tidak dapat dibatalkan (mungkin sudah terbayar atau kadaluwarsa).');
    }
}
