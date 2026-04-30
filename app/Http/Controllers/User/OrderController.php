<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function create($eventId)
    {
        $event = Event::with([
            'category',
            'creator',
            'ticketTypes' => fn($q) => $q->where('is_active', true)->orderBy('price')
        ])->where('status', 'published')->findOrFail($eventId);

        $paymentMethods = PaymentMethod::where('is_active', true)->get()->groupBy('type');

        return view('user.order.create', compact('event', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id'          => 'required|exists:events,id',
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'phone'             => 'required|string|max:20',
            'id_number'         => 'required|string|max:20',
            'birth_date'        => 'required|date',
            'agree'             => 'required|accepted',
            'tickets'           => 'required|array',
            'tickets.*.id'      => 'required|exists:ticket_types,id',
            'tickets.*.qty'     => 'required|integer|min:0',
        ]);

        // Cek apakah ada tiket yang dipilih
        $selectedTickets = collect($request->tickets)->filter(fn($t) => $t['qty'] > 0);

        if ($selectedTickets->isEmpty()) {
            return back()->withErrors(['tickets' => 'Pilih minimal 1 tiket.'])->withInput();
        }

        $event = Event::findOrFail($request->event_id);

        // Hitung total
        $totalAmount = 0;
        $items = [];

        foreach ($selectedTickets as $item) {
            $ticketType = TicketType::findOrFail($item['id']);

            // Cek kuota
            $available = $ticketType->quota - $ticketType->sold;
            if ($item['qty'] > $available) {
                return back()->withErrors([
                    'tickets' => "Tiket {$ticketType->name} hanya tersisa {$available} tiket."
                ])->withInput();
            }

            // Cek max per transaksi
            if ($event->max_tickets_per_transaction && $item['qty'] > $event->max_tickets_per_transaction) {
                return back()->withErrors([
                    'tickets' => "Maksimal {$event->max_tickets_per_transaction} tiket per transaksi."
                ])->withInput();
            }

            $subtotal     = $ticketType->price * $item['qty'];
            $totalAmount += $subtotal;

            $items[] = [
                'ticket_type'  => $ticketType,
                'quantity'     => $item['qty'],
                'price'        => $ticketType->price,
                'subtotal'     => $subtotal,
            ];
        }

        // Simpan data ke session untuk step konfirmasi
        session([
            'order_data' => [
                'event_id'    => $event->id,
                'name'        => $request->name,
                'email'       => $request->email,
                'phone'       => $request->phone,
                'id_number'   => $request->id_number,
                'birth_date'  => $request->birth_date,
                'items'       => collect($items)->map(fn($i) => [
                    'ticket_type_id' => $i['ticket_type']->id,
                    'name'           => $i['ticket_type']->name,
                    'quantity'       => $i['quantity'],
                    'price'          => $i['price'],
                    'subtotal'       => $i['subtotal'],
                ])->values()->toArray(),
                'total_amount' => $totalAmount,
            ]
        ]);

        return redirect()->route('orders.confirm');
    }

    public function confirm()
    {
        $orderData = session('order_data');
        if (!$orderData) return redirect()->route('home');

        $event          = Event::with(['creator', 'category'])->findOrFail($orderData['event_id']);
        $paymentMethods = PaymentMethod::where('is_active', true)->get()->groupBy('type');

        return view('user.order.confirm', compact('orderData', 'event', 'paymentMethods'));
    }

    public function pay(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $orderData = session('order_data');
        if (!$orderData) return redirect()->route('home');

        $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);

        // Buat order
        $order = Order::create([
            'user_id'      => auth()->id(),
            'order_code'   => 'ORD-' . strtoupper(Str::random(10)),
            'total_amount' => $orderData['total_amount'],
            'status'       => 'pending',
            'expired_at'   => now()->addMinutes(15),
        ]);

        // Buat order items
        foreach ($orderData['items'] as $item) {
            OrderItem::create([
                'order_id'       => $order->id,
                'ticket_type_id' => $item['ticket_type_id'],
                'quantity'       => $item['quantity'],
                'price'          => $item['price'],
                'subtotal'       => $item['subtotal'],
            ]);

            // Update sold count
            TicketType::find($item['ticket_type_id'])->increment('sold', $item['quantity']);
        }

        // Buat payment
        Payment::create([
            'order_id'     => $order->id,
            'payment_code' => 'PAY-' . strtoupper(Str::random(10)),
            'amount'       => $orderData['total_amount'],
            'method'       => $paymentMethod->type,
            'status'       => 'pending',
        ]);

        // Hapus session
        session()->forget('order_data');

        return redirect()->route('orders.payment', $order->id);
    }

    public function payment($orderId)
    {
        $order = Order::with([
            'orderItems.ticketType.event',
            'payment'
        ])->where('user_id', auth()->id())->findOrFail($orderId);

        $paymentMethod = PaymentMethod::where('type', $order->payment->method)
            ->where('is_active', true)
            ->first();

        return view('user.order.payment', compact('order', 'paymentMethod'));
    }

    public function uploadProof(Request $request, $orderId)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $order = Order::where('user_id', auth()->id())->findOrFail($orderId);

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        $order->payment->update([
            'payment_proof' => $path,
            'status'        => 'verifying',
            'paid_at'       => now(),
        ]);

        return redirect()->route('orders.payment', $order->id)
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
}
