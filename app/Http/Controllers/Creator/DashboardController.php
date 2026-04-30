<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Event aktif milik creator
        $activeEvents = Event::where('user_id', $user->id)
            ->where('status', 'published')
            ->where('end_date', '>=', now())
            ->count();

        // Event draft
        $draftEvents = Event::where('user_id', $user->id)
            ->where('status', 'draft')
            ->count();

        // Total transaksi dari semua event creator
        $totalTransactions = Order::whereHas('orderItems.ticketType.event', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('status', 'paid')->count();

        // Total tiket terjual
        $totalTicketsSold = Ticket::whereHas('event', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('status', '!=', 'cancelled')->count();

        // Total penjualan (revenue)
        $totalRevenue = Order::whereHas('orderItems.ticketType.event', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->where('status', 'paid')
            ->sum('total_amount');

        // Total pengunjung unik (unique buyers)
        $totalVisitors = Order::whereHas('orderItems.ticketType.event', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->where('status', 'paid')
            ->distinct('user_id')
            ->count('user_id');

        // Cek kelengkapan profil untuk misi
        $missions = [
            'phone'   => !empty($user->phone),
            'profile' => !empty($user->birth_date) && !empty($user->gender),
            'legal'   => !empty($user->id_number ?? null),
        ];
        $missionsDone    = collect($missions)->filter()->count();
        $missionsTotal   = count($missions);
        $missionsPercent = ($missionsDone / $missionsTotal) * 100;

        return view('creator.dashboard', compact(
            'activeEvents',
            'draftEvents',
            'totalTransactions',
            'totalTicketsSold',
            'totalRevenue',
            'totalVisitors',
            'missions',
            'missionsDone',
            'missionsTotal',
            'missionsPercent'
        ));
    }
}
