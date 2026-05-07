<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PengelolaanPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.ticketType.event']);

        // Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_code', 'like', "%$search%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%$search%");
                  });
            });
        }

        // Fitur Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Simpan hasil query untuk pagination (tabel)
        $orders = $query->latest()->paginate(10);

        // --- LOGIKA UNTUK CHART (6 Bulan Terakhir) ---
        $labels = [];
        $dataMasuk = [];
        $dataSelesai = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y'); // Contoh: Jan 2026

            // Hitung semua transaksi di bulan tersebut
            $dataMasuk[] = Order::whereMonth('created_at', $date->month)
                                ->whereYear('created_at', $date->year)
                                ->count();

            // Hitung transaksi yang sukses (approved) di bulan tersebut
            $dataSelesai[] = Order::where('status', 'approved')
                                  ->whereMonth('created_at', $date->month)
                                  ->whereYear('created_at', $date->year)
                                  ->count();
        }

        // Kirim semua variabel ke view
        return view('admin.pembayaran.index', compact(
            'orders', 
            'labels', 
            'dataMasuk', 
            'dataSelesai'
        ));
    }

    // ... method lainnya (approve, show, edit, update, destroy) tetap sama
    public function approve($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'approved']);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    public function show(string $id)
    {
        $order = Order::with(['user', 'orderItems.ticketType.event'])->findOrFail($id);
        return view('admin.pembayaran.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.pembayaran.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());

        return redirect()->route('admin.pembayaran.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return back()->with('success', 'Data transaksi berhasil dihapus!');
    }
}