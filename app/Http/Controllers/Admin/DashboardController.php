<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Start the query with relationships (untuk TABEL)
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
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('orderItems.ticketType', function($t) use ($search) {
                      $t->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('event', function($e) use ($search) {
                      $e->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // 4. Finalize the orders collection for the table
        $orders = $query->latest()->paginate(10)->withQueryString();

        // 5. Ambil SEMUA order untuk statistik (TANPA filter status dari request)
        $allOrdersQuery = Order::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $allOrdersQuery->where(function($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $allOrders = $allOrdersQuery->get();

        // 6. Hitung statistik
        $totalTransaksi = $allOrders->count();
        $totalApproved = $allOrders->where('status', 'approved')->sum('total_amount');
        $totalPending = $allOrders->where('status', 'pending')->sum('total_amount');
        
        $jumlahPending = $allOrders->where('status', 'pending')->count();
        $jumlahApproved = $allOrders->where('status', 'approved')->count();
        $jumlahCancelled = $allOrders->where('status', 'cancelled')->count();
        $jumlahExpired = $allOrders->where('status', 'expired')->count();

        // --- DATE & VIEW LOGIC FOR CHARTS ---
        $viewType = $request->get('view', 'month');
        $targetDate = $request->filled('until') 
            ? \Carbon\Carbon::parse($request->until) 
            : now();

        if ($viewType === 'week') {
            $startDate = $targetDate->copy()->startOfMonth();
            $endDate = $targetDate->copy()->endOfMonth();
            
            $rawQuery = "WEEK(created_at) - WEEK(DATE_SUB(created_at, INTERVAL DAYOFMONTH(created_at)-1 DAY)) + 1 as label_num, 'Minggu' as label_text";
            $groupBy = ['label_num'];
        } else {
            $endDate = $targetDate->copy()->endOfMonth();
            $startDate = $endDate->copy()->subMonths(5)->startOfMonth();
            
            $rawQuery = "MONTHNAME(created_at) as label_text, month(created_at) as label_num, year(created_at) as year_num";
            $groupBy = ['label_text', 'label_num', 'year_num'];
        }

        $chartMasuk = Order::selectRaw("count(*) as total, $rawQuery")
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy($groupBy)
            ->when($viewType === 'month', fn($q) => $q->orderBy('year_num')->orderBy('label_num'))
            ->get();

        $chartSelesai = Order::selectRaw("count(*) as total, $rawQuery")
            ->where('status', 'approved')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy($groupBy)
            ->when($viewType === 'month', fn($q) => $q->orderBy('year_num')->orderBy('label_num'))
            ->get();

        return view('admin.dashboard', [
            'orders' => $orders,
            
            // Statistik untuk card
            'totalTransaksi' => $totalTransaksi,
            'totalApproved' => $totalApproved,
            'totalPending' => $totalPending,
            'jumlahPending' => $jumlahPending,
            'jumlahApproved' => $jumlahApproved,
            'jumlahCancelled' => $jumlahCancelled,
            'jumlahExpired' => $jumlahExpired,
            
            // Data untuk chart
            'labels' => $chartMasuk->map(fn($item) => $viewType === 'week' ? "Wk $item->label_num" : "$item->label_text $item->year_num"),
            'dataMasuk' => $chartMasuk->pluck('total'),
            'dataSelesai' => $chartSelesai->pluck('total'),
            'startDateLabel' => $startDate->format('d M Y'),
            'endDateLabel' => $endDate->format('d M Y'),
        ]);
    }
}