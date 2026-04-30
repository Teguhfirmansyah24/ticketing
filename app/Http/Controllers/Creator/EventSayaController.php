<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class EventSayaController extends Controller
{
    public function index(Request $request)
    {
        $user  = auth()->user();
        $query = Event::with(['category', 'ticketTypes'])
            ->where('user_id', $user->id);

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sort
        match ($request->sort ?? 'nearest') {
            'oldest'  => $query->orderBy('start_date', 'asc'),
            'name'    => $query->orderBy('title', 'asc'),
            default   => $query->orderBy('start_date', 'desc'),
        };

        // Event aktif
        $activeEvents = (clone $query)
            ->where('status', 'published')
            ->where('end_date', '>=', now())
            ->get();

        // Event draft
        $draftEvents = (clone $query)
            ->where('status', 'draft')
            ->get();

        // Event lalu
        $pastEvents = (clone $query)
            ->where(function ($q) {
                $q->where('status', 'completed')
                    ->orWhere('status', 'cancelled')
                    ->orWhere(function ($q2) {
                        $q2->where('status', 'published')
                            ->where('end_date', '<', now());
                    });
            })
            ->get();

        return view('creator.eventsaya.index', compact(
            'activeEvents',
            'draftEvents',
            'pastEvents'
        ));
    }

    public function show($id)
    {
        $event = Event::with(['category', 'ticketTypes'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        // Statistik per jenis tiket
        $ticketStats = $event->ticketTypes->map(function ($ticket) {
            $revenue     = $ticket->sold * $ticket->price;
            $soldPercent = $ticket->quota > 0 ? ($ticket->sold / $ticket->quota) * 100 : 0;

            return [
                'name'         => $ticket->name,
                'price'        => $ticket->price,
                'quota'        => $ticket->quota,
                'sold'         => $ticket->sold,
                'available'    => $ticket->quota - $ticket->sold,
                'revenue'      => $revenue,
                'sold_percent' => $soldPercent,
            ];
        });

        // Total keseluruhan
        $totalQuota   = $event->ticketTypes->sum('quota');
        $totalSold    = $event->ticketTypes->sum('sold');
        $totalRevenue = $event->ticketTypes->sum(fn($t) => $t->sold * $t->price);
        $soldPercent  = $totalQuota > 0 ? ($totalSold / $totalQuota) * 100 : 0;

        // Total transaksi
        $totalTransactions = Order::whereHas('orderItems.ticketType', function ($q) use ($event) {
            $q->where('event_id', $event->id);
        })->where('status', 'paid')->count();

        // Transaksi pending
        $pendingTransactions = Order::whereHas('orderItems.ticketType', function ($q) use ($event) {
            $q->where('event_id', $event->id);
        })->where('status', 'pending')->count();

        // Pembeli unik
        $uniqueBuyers = Ticket::where('event_id', $event->id)
            ->where('status', '!=', 'cancelled')
            ->distinct('user_id')
            ->count('user_id');

        // Transaksi terbaru
        $recentOrders = Order::with(['user', 'orderItems.ticketType'])
            ->whereHas('orderItems.ticketType', function ($q) use ($event) {
                $q->where('event_id', $event->id);
            })
            ->latest()
            ->take(10)
            ->get();

        return view('creator.eventsaya.stats', compact(
            'event',
            'ticketStats',
            'totalQuota',
            'totalSold',
            'totalRevenue',
            'soldPercent',
            'totalTransactions',
            'pendingTransactions',
            'uniqueBuyers',
            'recentOrders'
        ));
    }
}
