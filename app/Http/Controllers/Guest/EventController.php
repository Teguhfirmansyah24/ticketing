<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['category', 'ticketTypes', 'creator'])
            ->where('status', 'published');

        // Filter search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('location', 'like', '%' . $request->search . '%')
                    ->orWhere('venue', 'like', '%' . $request->search . '%');
            });
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter harga
        if ($request->filled('price')) {
            if ($request->price === 'free') {
                $query->whereDoesntHave('ticketTypes', fn($q) => $q->where('price', '>', 0));
            } elseif ($request->price === 'paid') {
                $query->whereHas('ticketTypes', fn($q) => $q->where('price', '>', 0));
            }
        }

        // Filter lokasi
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filter waktu
        if ($request->filled('time')) {
            match ($request->time) {
                'today'     => $query->whereDate('start_date', today()),
                'tomorrow'  => $query->whereDate('start_date', today()->addDay()),
                'this_week' => $query->whereBetween('start_date', [today(), today()->endOfWeek()]),
                'this_month' => $query->whereMonth('start_date', today()->month),
                default     => null
            };
        }

        // Sort
        match ($request->sort ?? '') {
            'oldest'     => $query->oldest('start_date'),
            'price_asc'  => $query->orderBy(
                \App\Models\TicketType::select('price')
                    ->whereColumn('event_id', 'events.id')
                    ->where('is_active', true)
                    ->orderBy('price', 'asc')
                    ->limit(1),
                'asc'
            ),
            'price_desc' => $query->orderBy(
                \App\Models\TicketType::select('price')
                    ->whereColumn('event_id', 'events.id')
                    ->where('is_active', true)
                    ->orderBy('price', 'desc')
                    ->limit(1),
                'desc'
            ),
            'latest'     => $query->latest('start_date'),
            default      => null,
        };

        $events     = $query->paginate(6)->withQueryString();
        $categories = EventCategory::where('is_active', true)->get();

        // Ambil lokasi unik untuk filter
        $locations = Event::where('status', 'published')
            ->select('location')
            ->distinct()
            ->pluck('location');

        return view('guest.events.index', compact('events', 'categories', 'locations'));
    }

    public function show($id)
    {
        $event = Event::with([
            'category',
            'creator',
            'ticketTypes' => function ($query) {
                $query->where('is_active', true)->orderBy('price');
            }
        ])->findOrFail($id);

        $relatedEvents = Event::with(['ticketTypes', 'creator'])
            ->where('event_category_id', $event->event_category_id)
            ->where('id', '!=', $event->id)
            ->where('status', 'published')
            ->latest()
            ->take(8)
            ->get();

        return view('guest.events.show', compact('event', 'relatedEvents'));
    }
}
