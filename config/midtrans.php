<?php
// config/midtrans.php

return [
    'merchant_id'   => env('MIDTRANS_MERCHANT_ID'),
    'client_key'    => env('MIDTRANS_CLIENT_KEY'),
    'server_key'    => env('MIDTRANS_SERVER_KEY'),

    // Environment: Sandbox (Testing) vs Production (Real Money)
    // Jangan sampai tertukar! Server Key Production beda dengan Sandbox.
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // Sanitized: Membersihkan input dari karakter aneh yang bisa merusak request
    'is_sanitized'  => env('MIDTRANS_IS_SANITIZED', true),

    // 3DS (3-D Secure): Wajib ON untuk transaksi Kartu Kredit (Visa/Mastercard)
    // agar user diminta OTP oleh bank penerbit. Standar keamanan BI.
    'is_3ds'        => env('MIDTRANS_IS_3DS', true),

    // URL untuk Snap JS (berbeda untuk Sandbox dan Production)
    // Script ini akan diload di frontend (Blade)
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',
];