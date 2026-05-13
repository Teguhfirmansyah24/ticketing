<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request) // Added Request $request here
    {
        // 1. Start the query with relationships
        $query = Order::with(['user', 'orderItems.ticketType', 'event']);

        // 2. Handle Status Filter (Dropdown)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Handle Search Filter (Input)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%") // Search in order name
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%"); // Search in user name
                  })
                  ->orWhereHas('orderItems.ticketType', function($t) use ($search) {
                      $t->where('name', 'like', "%{$search}%"); // Search for "Early Bird", etc.
                  })
                  ->orWhereHas('event', function($e) use ($search) {
                      $e->where('title', 'like', "%{$search}%"); // Search in event title
                  });
            });
        }

        // 4. Finalize the orders collection
        $orders = $query->latest()->paginate(10)->withQueryString();

        // Data Dinamis untuk Chart 1 (Keep this as is)
        $chartMasuk = Order::selectRaw('MONTHNAME(created_at) as month, count(*) as total, month(created_at) as month_num')
            ->where('created_at', '>=', now()->subMonths(5))
            ->groupBy('month', 'month_num')
            ->orderBy('month_num')
            ->get();

        // Data Dinamis untuk Chart 2 (Keep this as is)
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