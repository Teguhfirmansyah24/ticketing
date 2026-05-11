<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReportController extends Controller
{
        public function index()
        {
            $totalRevenue = Order::where('status', 'paid')->sum('total_amount');
            $ticketsSold  = Ticket::count();
            $activeEvents = Event::where('status', 'published')->count();

            $eventPerformance = Event::withCount('tickets')
                ->with(['category', 'tickets.order'])
                ->get()
                ->map(function ($event) {
                    $revenue = $event->tickets
                        ->filter(fn($t) => $t->order && $t->order->status === 'paid')
                        ->sum(fn($t) => $t->order->total_amount ?? 0);

                        return [
                            'id'             => $event->id,
                            'title'          => $event->title,
                            'category_name'  => $event->category->name ?? 'Uncategorized',
                            'category_slug'  => $event->category
                                                ? '/' . \Illuminate\Support\Str::slug($event->category->name)
                                                : '/uncategorized',
                            'sold_count'     => $event->tickets_count,
                            'total_capacity' => $event->total_capacity ?? 0,
                            'is_active'      => $event->status === 'published',
                            'event_date'     => $event->start_date
                                                ? $event->start_date->format('Y-m-d')
                                                : now()->format('Y-m-d'),
                            'revenue'        => $revenue,
                        ];
                });

            return view('admin.report.index', compact(
                'totalRevenue',
                'ticketsSold',
                'activeEvents',
                'eventPerformance'
            ));
        }






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
