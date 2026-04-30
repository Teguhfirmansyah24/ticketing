<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;

class CreatorController extends Controller
{
    public function index()
    {
        $totalUsers     = User::where('role', 'user')->count();
        $totalAllEvents = Event::where('status', 'published')->count();

        $creators = User::where('role', 'user')
            ->withCount(['events as total_tickets_sold' => function ($query) {
                $query->join('tickets', 'tickets.event_id', '=', 'events.id')
                    ->where('tickets.status', 'active')
                    ->select(DB::raw('count(tickets.id)'));
            }])
            ->withCount('events as total_events')
            ->orderBy('total_tickets_sold', 'desc')
            ->paginate(12);

        $featuredEvents = Event::with(['ticketTypes', 'creator', 'category'])
            ->where('status', 'published')
            ->withCount('tickets')
            ->latest()
            ->take(5)
            ->get();

        return view('guest.creator.index', compact(
            'creators',
            'totalUsers',
            'totalAllEvents',
            'featuredEvents'
        ));
    }

    public function create()
    {
        $categories = EventCategory::where('is_active', true)->get();
        return view('guest.creator.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'event_category_id' => 'required|exists:event_categories,id',
            'description'      => 'nullable|string',
            'start_date'       => 'required|date',
            'start_time'       => 'required',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
            'end_time'         => 'nullable',
            'location'         => 'required|string|max:255',
            'venue'            => 'required|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'contact_name'     => 'required|string|max:255',
            'contact_email'    => 'required|email|max:255',
            'contact_phone'    => 'required|string|max:20',
            'max_tickets_per_transaction' => 'required|integer|min:1|max:10',
            'one_email_one_transaction'   => 'nullable|boolean',
            'one_ticket_one_buyer'        => 'nullable|boolean',
            'status'           => 'required|in:draft,published',

            // Tiket
            'tickets'                  => 'nullable|array',
            'tickets.*.name'           => 'required|string|max:255',
            'tickets.*.price'          => 'required|numeric|min:0',
            'tickets.*.quota'          => 'required|integer|min:1',
            'tickets.*.description'    => 'nullable|string',
        ]);

        // Upload banner
        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('banners', 'public');
        }

        // Gabungkan tanggal dan waktu
        $startDate = $request->start_date . ' ' . $request->start_time;
        $endDate   = ($request->end_date ?? $request->start_date) . ' ' . ($request->end_time ?? $request->start_time);

        // Buat event
        $event = Event::create([
            'user_id'                     => auth()->id(),
            'event_category_id'           => $request->event_category_id,
            'title'                       => $request->title,
            'description'                 => $request->description,
            'location'                    => $request->location,
            'venue'                       => $request->venue,
            'banner_image'                => $bannerPath,
            'start_date'                  => $startDate,
            'end_date'                    => $endDate,
            'contact_name'                => $request->contact_name,
            'contact_email'               => $request->contact_email,
            'contact_phone'               => $request->contact_phone,
            'max_tickets_per_transaction' => $request->max_tickets_per_transaction,
            'one_email_one_transaction'   => $request->boolean('one_email_one_transaction'),
            'one_ticket_one_buyer'        => $request->boolean('one_ticket_one_buyer'),
            'status'                      => $request->status,
        ]);

        // Buat ticket types
        if ($request->has('tickets')) {
            foreach ($request->tickets as $ticket) {
                TicketType::create([
                    'event_id'    => $event->id,
                    'name'        => $ticket['name'],
                    'description' => $ticket['description'] ?? null,
                    'price'       => $ticket['price'],
                    'quota'       => $ticket['quota'],
                    'sold'        => 0,
                    'is_active'   => true,
                ]);
            }
        }

        return redirect()->route('creator.create')
            ->with('success', 'Event berhasil dibuat!');
    }

    public function show(Request $request, $id)
    {
        $creator = User::where('role', 'user')->findOrFail($id);

        $query = Event::with(['ticketTypes', 'creator', 'category'])
            ->where('user_id', $creator->id);

        // Tab aktif / lalu
        if ($request->tab === 'past') {
            $query->where(function ($q) {
                $q->where('status', 'completed')
                    ->orWhere('end_date', '<', now());
            });
        } else {
            $query->where('status', 'published')
                ->where('end_date', '>=', now());
        }

        // Sort
        match ($request->sort ?? 'nearest') {
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
            default      => $query->orderBy('start_date', 'asc'),
        };

        $events      = $query->paginate(9)->withQueryString();
        $totalEvents = Event::where('user_id', $creator->id)->count();

        return view('guest.creator.show', compact(
            'creator',
            'events',
            'totalEvents'
        ));
    }
}
