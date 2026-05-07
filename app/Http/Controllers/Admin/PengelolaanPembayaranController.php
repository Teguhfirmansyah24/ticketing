<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PengelolaanPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Kita ambil data Order, urutkan dari yang terbaru
        // Kita 'load' juga relasi user dan items-nya
        $query = Order::with(['user', 'orderItems.ticketType.event']);

        // Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('order_code', 'like', "%$search%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
        }

        // Fitur Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('admin.pembayaran.index', compact('orders'));
    }

    public function approve($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'approved']);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['user', 'orderItems.ticketType.event'])->findOrFail($id);
        return view('admin.pembayaran.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.pembayaran.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all()); // Sesuaikan field yang mau diupdate

        return redirect()->route('admin.pembayaran.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return back()->with('success', 'Data transaksi berhasil dihapus!');
    }
}
