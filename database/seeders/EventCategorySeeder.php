<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Hiburan',       'description' => 'Konser, pertunjukan, dan acara hiburan lainnya'],
            ['name' => 'Workshop',      'description' => 'Pelatihan dan workshop berbagai bidang'],
            ['name' => 'Seminar',       'description' => 'Seminar dan konferensi profesional'],
            ['name' => 'Olahraga',      'description' => 'Event olahraga dan kompetisi'],
            ['name' => 'Seni & Budaya', 'description' => 'Pameran seni, pertunjukan budaya, dan festival'],
            ['name' => 'Teknologi',     'description' => 'Tech talk, hackathon, dan event teknologi'],
            ['name' => 'Pendidikan',    'description' => 'Event edukatif dan akademik'],
            ['name' => 'Bisnis',        'description' => 'Networking, pameran bisnis, dan entrepreneurship'],
            ['name' => 'Komunitas',     'description' => 'Gathering dan event komunitas lokal'],
            ['name' => 'Lainnya',       'description' => 'Event yang tidak masuk kategori lainnya'],
        ];

        foreach ($categories as $category) {
            EventCategory::create([
                'name'        => $category['name'],
                'slug'        => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active'   => true,
            ]);
        }
    }
}
