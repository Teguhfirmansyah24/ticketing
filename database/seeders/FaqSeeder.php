<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // Pembeli
            [
                'question' => 'Bagaimana cara membeli tiket?',
                'answer'   => 'Pilih event yang diinginkan, pilih jenis tiket, lalu klik Beli Tiket. Setelah itu lakukan pembayaran sesuai metode yang dipilih dan tiket akan dikirimkan ke akunmu.',
                'type'     => 'pembeli',
                'order'    => 1,
            ],
            [
                'question' => 'Metode pembayaran apa saja yang tersedia?',
                'answer'   => 'Kami menerima pembayaran melalui transfer bank (BCA, BRI, Mandiri, BNI), e-wallet (OVO, DANA, GoPay), dan QRIS.',
                'type'     => 'pembeli',
                'order'    => 2,
            ],
            [
                'question' => 'Bagaimana cara mendapatkan tiket setelah bayar?',
                'answer'   => 'Setelah pembayaran diverifikasi oleh admin, tiket digital akan otomatis tersedia di akunmu lengkap dengan QR code yang bisa ditunjukkan saat masuk venue.',
                'type'     => 'pembeli',
                'order'    => 3,
            ],
            [
                'question' => 'Bagaimana cara mengajukan refund?',
                'answer'   => 'Refund dapat diajukan maksimal 3 hari sebelum event berlangsung. Hubungi tim support kami melalui email support@loket.com dengan menyertakan kode order.',
                'type'     => 'pembeli',
                'order'    => 4,
            ],
            [
                'question' => 'Apakah tiket bisa dipindahtangankan?',
                'answer'   => 'Tiket bersifat personal dan tidak dapat dipindahtangankan. QR code pada tiket hanya berlaku untuk satu orang sesuai data pendaftaran.',
                'type'     => 'pembeli',
                'order'    => 5,
            ],

            // Pembuat
            [
                'question' => 'Bagaimana cara membuat event?',
                'answer'   => 'Login ke akunmu, masuk ke Dashboard, lalu klik Buat Event. Isi detail event seperti nama, deskripsi, lokasi, tanggal, dan tambahkan jenis tiket beserta harganya.',
                'type'     => 'pembuat',
                'order'    => 1,
            ],
            [
                'question' => 'Berapa lama proses verifikasi event?',
                'answer'   => 'Event akan ditinjau oleh tim admin dalam 1x24 jam. Setelah disetujui, event akan otomatis tampil di halaman publik dan bisa dibeli oleh pembeli.',
                'type'     => 'pembuat',
                'order'    => 2,
            ],
            [
                'question' => 'Bagaimana sistem pembayaran hasil penjualan tiket?',
                'answer'   => 'Hasil penjualan tiket akan dikumpulkan dan dicairkan ke rekeningmu maksimal 7 hari kerja setelah event selesai berlangsung.',
                'type'     => 'pembuat',
                'order'    => 3,
            ],
            [
                'question' => 'Apakah saya bisa mengedit event setelah dipublish?',
                'answer'   => 'Kamu bisa mengedit detail event selama belum ada tiket yang terjual. Jika sudah ada pembeli, perubahan hanya bisa dilakukan pada deskripsi dan informasi tambahan.',
                'type'     => 'pembuat',
                'order'    => 4,
            ],
            [
                'question' => 'Bagaimana cara melihat laporan penjualan?',
                'answer'   => 'Masuk ke Dashboard lalu pilih menu Event yang ingin dilihat. Di sana tersedia laporan lengkap jumlah tiket terjual, pendapatan, dan data pembeli.',
                'type'     => 'pembuat',
                'order'    => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create([...$faq, 'is_active' => true]);
        }
    }
}
