<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'user_id'           => 2,
                'event_category_id' => 1,
                'title'             => 'Konser Musik Nusantara 2025',
                'description'       => 'Konser musik terbesar yang menampilkan artis-artis ternama Indonesia.',
                'location'          => 'Bandung, Jawa Barat',
                'venue'             => 'Stadion Gelora Bandung Lautan Api',
                'start_date'        => '2025-08-10 18:00:00',
                'end_date'          => '2025-08-10 23:00:00',
                'status'            => 'published',
            ],
            [
                'user_id'           => 2,
                'event_category_id' => 2,
                'title'             => 'Workshop UI/UX Design Pemula',
                'description'       => 'Belajar dasar-dasar UI/UX design menggunakan Figma dari nol.',
                'location'          => 'Jakarta Selatan',
                'venue'             => 'Gedung Coworking Space Jakarta',
                'start_date'        => '2025-07-20 09:00:00',
                'end_date'          => '2025-07-20 17:00:00',
                'status'            => 'published',
            ],
            [
                'user_id'           => 2,
                'event_category_id' => 3,
                'title'             => 'Seminar Nasional Kewirausahaan Muda',
                'description'       => 'Seminar inspiratif untuk para pemuda yang ingin memulai bisnis.',
                'location'          => 'Surabaya, Jawa Timur',
                'venue'             => 'Hotel Bumi Surabaya',
                'start_date'        => '2025-09-05 08:00:00',
                'end_date'          => '2025-09-05 16:00:00',
                'status'            => 'published',
            ],
            [
                'user_id'           => 3,
                'event_category_id' => 6,
                'title'             => 'Hackathon Indonesia 2025',
                'description'       => 'Kompetisi hackathon 24 jam untuk para developer muda Indonesia.',
                'location'          => 'Yogyakarta',
                'venue'             => 'Universitas Gadjah Mada',
                'start_date'        => '2025-10-15 08:00:00',
                'end_date'          => '2025-10-16 08:00:00',
                'status'            => 'published',
            ],
            [
                'user_id'           => 3,
                'event_category_id' => 4,
                'title'             => 'Fun Run Bandung 5K & 10K',
                'description'       => 'Lari santai bersama di kota Bandung sambil menikmati udara pagi.',
                'location'          => 'Bandung, Jawa Barat',
                'venue'             => 'Lapangan Gasibu Bandung',
                'start_date'        => '2025-07-27 05:30:00',
                'end_date'          => '2025-07-27 09:00:00',
                'status'            => 'published',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
