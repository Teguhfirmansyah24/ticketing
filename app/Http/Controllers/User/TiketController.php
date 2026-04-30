<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function index()
    {
        // Tiket aktif — event belum selesai
        $activeTickets = Ticket::with(['event.category', 'ticketType', 'orderItem.order'])
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->whereHas('event', fn($q) => $q->where('end_date', '>=', now()))
            ->latest()
            ->get();

        // Tiket lalu — event sudah selesai atau tiket sudah dipakai
        $pastTickets = Ticket::with(['event.category', 'ticketType', 'orderItem.order'])
            ->where('user_id', auth()->id())
            ->where(function ($q) {
                $q->where('status', 'used')
                    ->orWhere('status', 'cancelled')
                    ->orWhereHas('event', fn($q) => $q->where('end_date', '<', now()));
            })
            ->latest()
            ->get();

        return view('user.tiket.index', compact('activeTickets', 'pastTickets'));
    }

    public function show($ticketCode)
    {
        $ticket = Ticket::with(['event.category', 'event.creator', 'ticketType', 'orderItem.order'])
            ->where('user_id', auth()->id())
            ->where('ticket_code', $ticketCode)
            ->firstOrFail();

        return view('user.tiket.show', compact('ticket'));
    }
}
