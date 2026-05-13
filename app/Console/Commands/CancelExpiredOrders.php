<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CancelExpiredOrders extends Command
{
    // Nama command yang dipanggil di terminal/kernel
    protected $signature = 'orders:cancel-expired';
    protected $description = 'Membatalkan order yang lebih dari 24 jam dan mengembalikan stok';

    public function handle()
{
    // Ambil order pending yang usianya > 24 jam
    $expiredOrders = Order::where('status', 'pending')
        ->where('created_at', '<', now()->subDay())
        ->get();

    foreach ($expiredOrders as $order) {
        DB::transaction(function () use ($order) {
            foreach ($order->orderItems as $item) {
                // Mengurangi angka terjual = menambah sisa kuota
                $item->ticketType->decrement('sold', $item->quantity);
            }
            // Status diubah ke 'expired' agar beda dengan 'cancelled' manual
            $order->update(['status' => 'expired']);
        });
    }
    $this->info('Order kadaluwarsa telah dibersihkan.');
}
}