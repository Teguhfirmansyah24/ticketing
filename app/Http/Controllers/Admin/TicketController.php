<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Menampilkan halaman manajemen tiket untuk event tertentu
    public function index(Event $event)
    {
        // Menggunakan eager loading agar lebih cepat saat data banyak
        $tickets = $event->ticketTypes()->latest()->get();
        return view('admin.event.tickets', compact('event', 'tickets'));
    }

    // Menyimpan tiket baru
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Gunakan numeric min 0 untuk tiket gratis, atau min 1000 jika wajib bayar
            'price' => 'required|numeric|min:0', 
            'stock' => 'required|integer|min:0',
            // Tambahkan validasi tanggal jika ada (opsional)
            // 'sale_start_date' => 'nullable|date',
        ]);

        // Gunakan variabel $validated agar hanya data terverifikasi yang masuk
        $event->ticketTypes()->create($validated);

        return back()->with('success', 'Tiket berhasil ditambahkan!');
    }

    // Update stok atau harga
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

    // Hapus tiket
    public function destroy(TicketType $ticket)
    {
        // Cek dulu apakah sudah ada yang beli tiket ini? 
        // Jika sudah ada transaksi, sebaiknya tiket tidak bisa dihapus (soft delete)
        $ticket->delete();
        return back()->with('success', 'Tiket dihapus!');
    }
}