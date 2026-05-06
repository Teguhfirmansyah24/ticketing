<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Gunakan query builder agar tidak bentrok saat join
        $query = Event::with(['category', 'creator', 'ticketTypes']);

        // 1. Logika Filter Waktu
        if ($request->filled('time')) {
            // Gunakan copy() agar object $now tidak berubah-ubah saat dimanipulasi
            $now = Carbon::now();

            switch ($request->time) {
                case 'today':
                    $query->whereDate('start_date', $now->toDateString());
                    break;
                case 'tomorrow':
                    $query->whereDate('start_date', $now->copy()->addDay()->toDateString());
                    break;
                case 'this_week':
                    // Gunakan whereBetween dengan jam awal dan akhir minggu agar data datetime terjaring semua
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

        // 2. Logika Filter Kategori
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 3. Logika Filter Harga
        if ($request->price === 'free') {
            // Event dianggap gratis jika tidak punya tiket berbayar sama sekali
            $query->whereDoesntHave('ticketTypes', function ($q) {
                $q->where('price', '>', 0);
            });
        } elseif ($request->price === 'paid') {
            $query->whereHas('ticketTypes', function ($q) {
                $q->where('price', '>', 0);
            });
        }

        // 4. Logika Filter Lokasi
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // 5. Logika Sorting (Perbaikan Join agar tidak duplikat)
        if (in_array($request->sort, ['price_asc', 'price_desc'])) {
            $direction = ($request->sort === 'price_asc') ? 'asc' : 'desc';
            
            // Menggunakan subquery agar row event tidak double jika tiketnya banyak
            $query->addSelect(['min_price' => \App\Models\TicketType::select('price')
                ->whereColumn('event_id', 'events.id')
                ->orderBy('price', 'asc')
                ->limit(1)
            ])->orderBy('min_price', $direction);
        } elseif ($request->sort === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $events = $query->paginate(6)->withQueryString();
        $locations = Event::distinct()->pluck('location'); 

        return view('admin.event.index', compact('events', 'locations'));
    }

    // ... method lainnya tetap
    public function create() 
    { 
        return view('admin.event.create');
    }

    public function store(Request $request) 
    { 
        /* Logika simpan data */
    }

    public function show(string $id) 
    {
         /* Logika detail */ 
    }

    public function edit(string $id) 
{
    $event = Event::findOrFail($id);
    // Ambil semua kategori agar bisa dipilih di dropdown menu
    $categories = Category::all(); 
    
    return view('admin.event.edit', compact('event', 'categories'));   
}

public function update(Request $request, string $id) 
{
    $event = Event::findOrFail($id);
    
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'location'    => 'required',
        'category_id' => 'required|exists:categories,id', // Tambahkan validasi FK
        'description' => 'nullable|string',
        'start_date'  => 'required|date',
        'end_date'    => 'required|date|after:start_date',
        // Tambahkan field lain sesuai migration kamu
    ]);

    $event->update($validated);

    return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui!');
}

    public function destroy(string $id)
{
    $event = Event::findOrFail($id);
    
    // Hapus foto dari storage jika ada
    if ($event->banner_image) {
        Storage::disk('public')->delete($event->banner_image);
    }
    
    $event->delete();
    return redirect()->back()->with('success', 'Event berhasil dihapus');
}
}