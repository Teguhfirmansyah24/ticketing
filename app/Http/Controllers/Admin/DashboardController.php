<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi dengan relasi user, orderItems, ticketType, dan event untuk ditampilkan di tabel
    $orders = Order::with(['user', 'orderItems.ticketType', 'event'])->latest()->paginate(10);

    // Data Dinamis untuk Chart 1 (Semua Transaksi Masuk)
    $chartMasuk = Order::selectRaw('MONTHNAME(created_at) as month, count(*) as total, month(created_at) as month_num')
        ->where('created_at', '>=', now()->subMonths(5))
        ->groupBy('month', 'month_num')
        ->orderBy('month_num')
        ->get();

    // Data Dinamis untuk Chart 2 (Hanya yang Approved/Selesai)
    $chartSelesai = Order::selectRaw('MONTHNAME(created_at) as month, count(*) as total, month(created_at) as month_num')
        ->where('status', 'approved')
        ->where('created_at', '>=', now()->subMonths(5))
        ->groupBy('month', 'month_num')
        ->orderBy('month_num')
        ->get();

    return view('admin.dashboard', [
        'orders' => $orders,
        'labels' => $chartMasuk->pluck('month'),
        'dataMasuk' => $chartMasuk->pluck('total'),
        'dataSelesai' => $chartSelesai->pluck('total'),
    ]);
}
}