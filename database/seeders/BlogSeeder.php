<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan user dengan role admin ada agar tidak error
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            $this->command->error("Admin user tidak ditemukan! Pastikan UserSeeder sudah dijalankan.");
            return;
        }

        $blogs = [
            [
                'title'        => 'Tips Sukses Membuat Event yang Berkesan',
                'excerpt'      => 'Event yang sukses tidak terjadi begitu saja. Dibutuhkan perencanaan matang, eksekusi tepat, dan tim yang solid.',
                'content'      => '<p>Membuat event yang berkesan membutuhkan perencanaan yang matang...</p>',
                'category'     => 'Tips & Trik',
                'thumbnail'    => null,
                'status'       => 'published',
                'published_at' => now()->subDays(3),
                'views'        => 245,
            ],
            [
                'title'        => 'Panduan Lengkap Menjual Tiket Online untuk Pemula',
                'excerpt'      => 'Penjualan tiket online kini semakin mudah dengan platform digital. Pelajari caranya dari nol di sini.',
                'content'      => '<p>Di era digital ini, menjual tiket online adalah cara paling efektif...</p>',
                'category'     => 'Panduan',
                'thumbnail'    => null,
                'status'       => 'published',
                'published_at' => now()->subDays(7),
                'views'        => 189,
            ],
            [
                'title'        => 'Strategi Promosi Event di Media Sosial yang Efektif',
                'excerpt'      => 'Media sosial adalah senjata ampuh untuk promosi event. Pelajari strategi yang terbukti efektif.',
                'content'      => '<p>Promosi event di media sosial bukan hanya soal posting sesering mungkin...</p>',
                'category'     => 'Marketing',
                'thumbnail'    => null,
                'status'       => 'published',
                'published_at' => now()->subDays(10),
                'views'        => 312,
            ],
            [
                'title'        => 'Cara Mengelola Anggaran Event dengan Efisien',
                'excerpt'      => 'Anggaran yang terbatas bukan halangan untuk membuat event berkualitas. Simak tipsnya di sini.',
                'content'      => '<p>Mengelola anggaran event adalah salah satu tantangan terbesar...</p>',
                'category'     => 'Tips & Trik',
                'thumbnail'    => null,
                'status'       => 'published',
                'published_at' => now()->subDays(14),
                'views'        => 156,
            ],
            [
                'title'        => 'Tren Event 2026: Apa yang Populer Tahun Ini?',
                'excerpt'      => 'Dunia event terus berkembang. Kenali tren terbaru yang sedang booming di 2026.',
                'content'      => '<p>Industri event terus berinovasi setiap tahunnya...</p>',
                'category'     => 'Tren',
                'thumbnail'    => null,
                'status'       => 'published',
                'published_at' => now()->subDays(1),
                'views'        => 421,
            ],
            [
                'title'        => 'Memaksimalkan Pengalaman Peserta di Event Kamu',
                'excerpt'      => 'Pengalaman peserta adalah segalanya. Pelajari cara membuat mereka merasa dihargai dan ingin kembali.',
                'content'      => '<p>Event yang sukses bukan hanya diukur dari jumlah tiket yang terjual...</p>',
                'category'     => 'Tips & Trik',
                'thumbnail'    => null,
                'status'       => 'published',
                'published_at' => now()->subDays(5),
                'views'        => 198,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create([
                'user_id'      => $admin->id,
                'title'        => $blog['title'],
                'slug'         => Str::slug($blog['title']), // Mengambil slug dari judul blog masing-masing
                'excerpt'      => $blog['excerpt'],
                'content'      => $blog['content'],
                'category'     => $blog['category'],
                'thumbnail'    => $blog['thumbnail'],
                'status'       => $blog['status'],
                'published_at' => $blog['published_at'],
                'views'        => $blog['views'],
            ]);
        }
    }
}
