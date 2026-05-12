<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->query('date_from');
        $dateTo   = $request->query('date_to');

        // We fetch EVERYTHING first to see what's actually in your DB
        $eventQuery = Event::with(['category', 'tickets.orderItem.order']);

        // Only filter if the user explicitly searched for dates
        if ($dateFrom && $dateTo) {
            $from = \Illuminate\Support\Carbon::parse($dateFrom)->startOfDay();
            $to   = \Illuminate\Support\Carbon::parse($dateTo)->endOfDay();

            // Simple check: event must have started before the end of our range
            $eventQuery->where('start_date', '<=', $to);
        }

        $eventPerformance = $eventQuery->get()->map(function ($event) use ($dateFrom, $dateTo) {
            // Filter tickets that have a PAID order
            $paidTickets = $event->tickets->filter(function($t) {
                return $t->orderItem && 
                    $t->orderItem->order && 
                    $t->orderItem->order->status === 'paid';
            });

            // Revenue calculation
            $revenue = $paidTickets->sum(fn($t) => $t->orderItem->order->total_amount ?? 0);
            $soldCount = $paidTickets->count();

            return [
                'id'            => $event->id,
                'title'         => $event->title,
                'category_name' => $event->category->name ?? 'Uncategorized',
                'sold_count'    => (int) $soldCount,
                'is_active'     => true, // Force true to show in stats for now
                'revenue'       => (int) $revenue,
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