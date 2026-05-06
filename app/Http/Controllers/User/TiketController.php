<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function index()
{
    $userId = auth()->id();

    // Ambil tiket yang ordernya sudah lunas / approved
    $activeTickets = Ticket::where('user_id', $userId)
        ->whereHas('orderItem.order', function($query) {
            $query->where('status', 'approved'); // Sesuaikan dengan nama status di DB kamu
        })
        ->where('status', 'active') // Pastikan status tiketnya aktif
        ->with(['event', 'ticketType', 'orderItem.order'])
        ->get();

    $pastTickets = Ticket::where('user_id', $userId)
        ->where(function($query) {
            $query->where('status', 'used')
                  ->orWhere('status', 'cancelled');
        })
        ->get();

    return view('user.tiket.index', compact('activeTickets', 'pastTickets'));
}

    public function show($ticket_code)
{
    // Cari tiket berdasarkan kode yang diklik
    $ticket = Ticket::where('ticket_code', $ticket_code)
        ->where('user_id', auth()->id())
        ->with(['event', 'ticketType', 'orderItem.order'])
        ->firstOrFail();

    return view('user.tiket.show', compact('ticket'));
}
}   