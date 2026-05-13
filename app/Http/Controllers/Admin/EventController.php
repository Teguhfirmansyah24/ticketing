<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['category', 'creator', 'ticketTypes']);

        // ====================== FILTER ======================

        // 1. Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($c) use ($search) {
                      $c->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Filter Waktu
        if ($request->filled('time')) {
            $now = Carbon::now();

            switch ($request->time) {
                case 'today':
                    $query->whereDate('start_date', $now->toDateString());
                    break;

                case 'tomorrow':
                    $query->whereDate('start_date', $now->copy()->addDay()->toDateString());
                    break;

                case 'this_week':
                    $query->whereBetween('start_date', [
                        $now->copy()->startOfWeek()->toDateTimeString(),
                        $now->copy()->endOfWeek()->toDateTimeString()
                    ]);
                    break;

                case 'this_month':
                    $query->whereMonth('start_date', $now->month)
                          ->whereYear('start_date', $now->year);
                    break;
            }
        }

        // 3. Filter Kategori
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 4. Filter Harga (Free / Paid)
        if ($request->price === 'free') {
            $query->whereDoesntHave('ticketTypes', function ($q) {
                $q->where('price', '>', 0);
            });
        } elseif ($request->price === 'paid') {
            $query->whereHas('ticketTypes', function ($q) {
                $q->where('price', '>', 0);
            });
        }

        // 5. Filter Lokasi
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // ====================== SORTING ======================
        if (in_array($request->sort, ['price_asc', 'price_desc'])) {
            $direction = ($request->sort === 'price_asc') ? 'asc' : 'desc';

            $query->addSelect([
                'min_price' => TicketType::select('price')
                    ->whereColumn('event_id', 'events.id')
                    ->orderBy('price', 'asc')
                    ->limit(1)
            ])->orderBy('min_price', $direction);

        } elseif ($request->sort === 'oldest') {
            $query->oldest();
        } else {
            $query->latest(); // default
        }

        $events = $query->paginate(6)->withQueryString();

        // Untuk dropdown filter lokasi
        $locations = Event::distinct()->pluck('location');

        return view('admin.event.index', compact('events', 'locations'));
    }

    public function create()
    {
        $categories = EventCategory::all();
        return view('admin.event.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'category_id'    => 'required|exists:event_categories,id',
            'location'       => 'required|string|max:255',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'description'    => 'nullable|string',
            'banner_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            // tambahkan field lain sesuai migration kamu
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('events', 'public');
        }

        Event::create($validated);

        return redirect()->route('admin.event.index')
                         ->with('success', 'Event berhasil dibuat!');
    }

    public function show(string $id)
    {
        $event = Event::with(['category', 'creator', 'ticketTypes'])->findOrFail($id);
        return view('admin.event.show', compact('event'));
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        $categories = EventCategory::all();

        return view('admin.event.edit', compact('event', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'category_id'    => 'required|exists:event_categories,id',
            'location'       => 'required|string|max:255',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'description'    => 'nullable|string',
            'banner_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('banner_image')) {
            // Hapus gambar lama
            if ($event->banner_image) {
                Storage::disk('public')->delete($event->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.event.index')
                         ->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        // Hapus banner image jika ada
        if ($event->banner_image) {
            Storage::disk('public')->delete($event->banner_image);
        }

        $event->delete();

        return redirect()->route('admin.event.index')
                         ->with('success', 'Event berhasil dihapus.');
    }
}