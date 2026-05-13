<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Order; // Pastikan model Order di-import
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // 1. Ambil pesanan yang BELUM DIBAYAR (Pending)
        // Kita ambil dari model Order karena tiket biasanya belum aktif/terbit
        $pendingTickets = Order::where('user_id', $userId)
            ->where('status', 'pending')
            ->with(['orderItems.ticketType.event'])
            ->get();

        // 2. Ambil tiket yang ordernya sudah lunas / approved
        $activeTickets = Ticket::where('user_id', $userId)
            ->whereHas('orderItem.order', function ($query) {
                $query->where('status', 'approved');
            })
            ->where('status', 'active')
            ->with(['event', 'ticketType', 'orderItem.order'])
            ->get();

        // 3. Ambil tiket yang sudah lalu
        $pastTickets = Ticket::where('user_id', $userId)
            ->whereIn('status', ['used', 'cancelled'])
            ->with(['event'])
            ->get();

        return view('user.tiket.index', compact('pendingTickets', 'activeTickets', 'pastTickets'));
    }

    public function show($ticket_code)
    {
        $ticket = Ticket::where('ticket_code', $ticket_code)
            ->where('user_id', auth()->id())
            ->with(['event', 'ticketType', 'orderItem.order'])
            ->firstOrFail();

        return view('user.tiket.show', compact('ticket'));
    }
}
