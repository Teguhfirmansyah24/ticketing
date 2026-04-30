<?php

namespace Database\Seeders;

use App\Models\TicketType;
use Illuminate\Database\Seeder;

class TicketTypeSeeder extends Seeder
{
    public function run(): void
    {
        $ticketTypes = [
            // Event 1 - Konser Musik
            ['event_id' => 1, 'name' => 'VVIP',    'description' => 'Akses area paling depan + meet & greet', 'price' => 750000, 'quota' => 50],
            ['event_id' => 1, 'name' => 'VIP',     'description' => 'Akses area VIP + merchandise eksklusif',  'price' => 450000, 'quota' => 150],
            ['event_id' => 1, 'name' => 'Regular', 'description' => 'Akses area umum',                         'price' => 150000, 'quota' => 500],

            // Event 2 - Workshop UI/UX
            ['event_id' => 2, 'name' => 'Early Bird', 'description' => 'Harga spesial pembelian awal + modul gratis', 'price' => 150000, 'quota' => 30],
            ['event_id' => 2, 'name' => 'Regular',    'description' => 'Termasuk makan siang dan sertifikat',          'price' => 250000, 'quota' => 70],

            // Event 3 - Seminar Kewirausahaan
            ['event_id' => 3, 'name' => 'Umum',    'description' => 'Akses seminar + seminar kit', 'price' => 100000, 'quota' => 200],
            ['event_id' => 3, 'name' => 'Pelajar', 'description' => 'Harga khusus pelajar/mahasiswa', 'price' => 50000, 'quota' => 100],

            // Event 4 - Hackathon
            ['event_id' => 4, 'name' => 'Tim (3 orang)', 'description' => 'Pendaftaran per tim isi 3 orang', 'price' => 300000, 'quota' => 50],

            // Event 5 - Fun Run
            ['event_id' => 5, 'name' => '5K',  'description' => 'Kategori lari 5 kilometer + medali finisher',  'price' => 100000, 'quota' => 300],
            ['event_id' => 5, 'name' => '10K', 'description' => 'Kategori lari 10 kilometer + medali finisher', 'price' => 150000, 'quota' => 200],
        ];

        foreach ($ticketTypes as $type) {
            TicketType::create([...$type, 'sold' => 0, 'is_active' => true]);
        }
    }
}
