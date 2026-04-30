<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            // Bank Transfer
            ['name' => 'BCA',     'type' => 'bank_transfer', 'account_number' => '1234567890', 'account_name' => 'PT Tiket App Indonesia'],
            ['name' => 'BRI',     'type' => 'bank_transfer', 'account_number' => '0987654321', 'account_name' => 'PT Tiket App Indonesia'],
            ['name' => 'Mandiri', 'type' => 'bank_transfer', 'account_number' => '1122334455', 'account_name' => 'PT Tiket App Indonesia'],
            ['name' => 'BNI',     'type' => 'bank_transfer', 'account_number' => '5544332211', 'account_name' => 'PT Tiket App Indonesia'],

            // E-Wallet
            ['name' => 'OVO',     'type' => 'e-wallet', 'account_number' => '081234567890', 'account_name' => 'PT Tiket App Indonesia'],
            ['name' => 'DANA',    'type' => 'e-wallet', 'account_number' => '081234567890', 'account_name' => 'PT Tiket App Indonesia'],
            ['name' => 'GoPay',   'type' => 'e-wallet', 'account_number' => '081234567890', 'account_name' => 'PT Tiket App Indonesia'],

            // QRIS
            ['name' => 'QRIS',   'type' => 'qris', 'account_number' => null, 'account_name' => 'PT Tiket App Indonesia'],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create([...$method, 'is_active' => true]);
        }
    }
}
