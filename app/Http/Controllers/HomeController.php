<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $bannerEvents = Event::with(['category'])
            ->where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        $categories = EventCategory::where('is_active', true)->get();

        $events = Event::with(['category', 'ticketTypes'])
            ->where('status', 'published')
            ->latest()
            ->take(10)
            ->get();

        $topEvents = Event::with(['ticketTypes'])
            ->where('status', 'published')
            ->withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->take(3)
            ->get();

        $topCreators = User::where('role', 'user')
            ->withCount(['events as total_tickets_sold' => function ($query) {
                $query->join('tickets', 'tickets.event_id', '=', 'events.id')
                    ->where('tickets.status', 'active')
                    ->select(DB::raw('count(tickets.id)'));
            }])
            ->orderBy('total_tickets_sold', 'desc')
            ->take(5)
            ->get();

        $categoryEvents = EventCategory::where('is_active', true)
            ->with(['events' => function ($query) {
                $query->with(['ticketTypes', 'creator'])
                    ->where('status', 'published')
                    ->latest()
                    ->take(8);
            }])
            ->get()
            ->filter(fn($cat) => $cat->events->count() > 0)
            ->take(3); // hanya kategori yang punya event

        return view('welcome', compact('bannerEvents', 'categories', 'events', 'topEvents', 'topCreators', 'categoryEvents'));
    }
}
