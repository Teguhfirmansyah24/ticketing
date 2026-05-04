<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Exception;

class MidtransService
{
    public function __construct()
    {
        // Pastikan di .env sudah ada MIDTRANS_SERVER_KEY
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    public function createSnapToken(Order $order): string
    {
        // Pastikan relasi 'orderItems' dan 'ticketType' sudah di-load agar tidak null
        $order->load(['orderItems.ticketType']);

        if ($order->orderItems->isEmpty()) {
            throw new Exception('Order tidak memiliki item tiket.');
        }

        // --- SOLUSI ERROR 500: Order ID harus unik setiap kali request ---
        // Kita tambahkan timestamp di belakangnya supaya Midtrans tidak menolak
        $uniqueOrderId = $order->order_code . '-' . time();

        $transactionDetails = [
            'order_id'     => $uniqueOrderId, 
            'gross_amount' => (int) $order->total_amount,
        ];

        $customerDetails = [
            'first_name' => $order->name,
            'email'      => $order->email,
            'phone'      => $order->phone,
        ];

        $itemDetails = $order->orderItems->map(function ($item) {
            return [
                'id'       => (string) $item->ticket_type_id,
                'price'    => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name'     => substr($item->ticketType->name ?? 'Tiket Loket', 0, 50),
            ];
        })->toArray();

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details'    => $customerDetails,
            'item_details'        => $itemDetails,
        ];

        try {
            // Jika request ke Midtrans gagal, dia akan melempar Exception
            return Snap::getSnapToken($params);
        } catch (Exception $e) {
            // Catat error aslinya di storage/logs/laravel.log
            \Log::error('Midtrans API Error: ' . $e->getMessage());
            throw new Exception('Midtrans Error: ' . $e->getMessage());
        }
    }

    public function checkStatus(string $orderId)
    {
        try {
            return Transaction::status($orderId);
        } catch (Exception $e) {
            throw new Exception('Gagal mengecek status: ' . $e->getMessage());
        }
    }

    public function cancelTransaction(string $orderId)
    {
        try {
            return Transaction::cancel($orderId);
        } catch (Exception $e) {
            throw new Exception('Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }
}