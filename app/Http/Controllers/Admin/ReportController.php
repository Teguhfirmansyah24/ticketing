<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->query('date_from');
        $dateTo   = $request->query('date_to');

        // 1. Get Orders directly (just like Dashboard) but add Date Filtering
        $orderQuery = Order::with(['event', 'orderItems.ticketType'])
            ->where('status', 'approved'); // Changed from 'paid' to 'approved' to match Dashboard

        if ($dateFrom && $dateTo) {
            $from = \Illuminate\Support\Carbon::parse($dateFrom)->startOfDay();
            $to   = \Illuminate\Support\Carbon::parse($dateTo)->endOfDay();
            $orderQuery->whereBetween('created_at', [$from, $to]);
        }

        $orders = $orderQuery->get();

        // 2. Group data by Event to satisfy your table and charts
        // This transforms the orders into the performance format your view expects
        $eventPerformance = $orders->groupBy('event_id')->map(function ($eventOrders) {
            $firstOrder = $eventOrders->first();
            return [
                'id'            => $firstOrder->event->id ?? 0,
                'title'         => $firstOrder->event->title ?? 'Deleted Event',
                'category_name' => $firstOrder->event->category->name ?? 'General',
                'sold_count'    => $eventOrders->count(),
                'is_active'     => true,
                'revenue'       => (int) $eventOrders->sum('total_amount'),
            ];
        })->values();

        return view('admin.report.index', [
            'totalRevenue'     => $eventPerformance->sum('revenue'),
            'ticketsSold'      => $eventPerformance->sum('sold_count'),
            'activeEvents'     => $eventPerformance->count(), 
            'eventPerformance' => $eventPerformance,
            'dateFrom'         => $dateFrom,
            'dateTo'           => $dateTo
        ]);
    }
}