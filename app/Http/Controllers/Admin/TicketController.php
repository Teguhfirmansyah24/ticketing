<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Menampilkan halaman manajemen tiket untuk event tertentu.
     */
  public function index(Event $event)
{
    // Mengambil ulang data dari DB agar stok terbaru muncul
    $tickets = $event->ticketTypes()->latest()->get(); 
    return view('admin.event.tickets', compact('event', 'tickets'));
}

    /**
     * Menyimpan tiket baru ke database.
     */
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0', 
            'quota' => 'required|integer|min:0', // Menggunakan quota sesuai error sebelumnya
        ]);

        $event->ticketTypes()->create($validated);

        return back()->with('success', 'Tiket berhasil ditambahkan!');
    }

    /**
     * Logika untuk simulasi pembelian (MENGURANGI STOK).
     * Kamu bisa memanggil route ini dari tombol "Beli" di halaman depan.
     */
   public function checkout(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $ticket = TicketType::findOrFail($id);
    $jumlah = $request->quantity;

    // 1. Cek apakah stok (quota) mencukupi
    if ($ticket->quota < $jumlah) {
        return back()->with('error', 'Stok tidak mencukupi! Sisa: ' . $ticket->quota);
    }

    // Gunakan DB Transaction agar jika satu gagal, semua dibatalkan
    DB::transaction(function () use ($ticket, $jumlah) {
        // 2. Mengurangi stok di tabel ticket_types
        $ticket->decrement('quota', $jumlah);

        // 3. GENERATE TIKET ke tabel 'tickets'
        // Looping sebanyak jumlah tiket yang dibeli
        for ($i = 0; $i < $jumlah; $i++) {
            Ticket::create([
                'user_id'        => auth()->id(), // ID user yang sedang login
                'event_id'       => $ticket->event_id,
                'ticket_type_id' => $ticket->id,
                'ticket_code'    => 'TIX-' . strtoupper(Str::random(10)), // Generate kode unik
                'status'         => 'active',
                // Jika kamu punya order_item_id, tambahkan di sini. 
                // Untuk simulasi ini, kita kosongi atau sesuaikan dengan skema DB kamu.
            ]);
        }
    });

    return back()->with('success', "Berhasil membeli $jumlah tiket $ticket->name! Cek di menu Tiket Saya.");
}

    /**
     * Update data tiket (Stok atau Harga).
     */
    public function update(Request $request, TicketType $ticket)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
        ]);

        $ticket->update($validated);
        return back()->with('success', 'Data tiket diperbarui!');
    }

    /**
     * Menghapus tiket.
     */
    public function destroy(TicketType $ticket)
    {
        $ticket->delete();
        return back()->with('success', 'Tiket dihapus!');
    }
}