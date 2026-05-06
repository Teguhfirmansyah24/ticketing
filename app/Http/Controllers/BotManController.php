<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver;

use Illuminate\Http\Request;

class BotManController extends Controller
{
    /**
     * Handle incoming BotMan messages.
     * Route: GET|POST /botman
     *
     * Catatan penting tentang hears() + regex:
     * - BotMan mengenali pola sebagai REGEX hanya jika string diawali dengan "/"
     * - Tanpa "/" → BotMan melakukan exact match (penyebab selalu masuk fallback)
     * - Flag "i" = case-insensitive (cocok: "Halo", "HALO", "halo")
     * - Pola ".*kata.*" = cocok jika kata muncul di mana saja dalam kalimat
     */
    public function handle(Request $request): void
    {
        // 1. Daftarkan WebDriver
        DriverManager::loadDriver(WebDriver::class);

        // 1.5. Fix issue: BotMan Web Driver tidak membaca JSON payload secara otomatis.
        // Kita inject json payload ke parameter bag agar dibaca oleh BotMan
        if ($request->isJson()) {
            $request->request->replace($request->json()->all());
        }

        // 2. Buat instance BotMan dengan request Laravel yang sudah dimodifikasi
        $botman = BotManFactory::create([], null, $request);

        // 3. Daftarkan intents — urutan PENTING, fallback HARUS paling bawah
        $this->registerIntents($botman);

        // 4. WAJIB dipanggil agar BotMan memproses pesan
        $botman->listen();
    }

    /**
     * Tampilkan UI frame chatbot.
     * Route: GET /botman/chat
     */
    public function chat()
    {
        return view('botman.chat');
    }

    // =========================================================
    // PRIVATE — Registrasi intent dengan REGEX (/pattern/flags)
    // =========================================================

    private function registerIntents(BotMan $botman): void
    {
        // ---------------------------------------------------------
        // 1. GREETING — halo, hai, hi, hello, selamat pagi, dst.
        //    Regex: .* di kiri/kanan agar cocok meski ada kata lain
        //    (BotMan otomatis membungkus pola dengan /^...$/miu yang bersifat case-insensitive)
        // ---------------------------------------------------------
        $botman->hears('.*(halo|hai|hi|hello|hey|hei|selamat\s+pagi|selamat\s+siang|selamat\s+malam|selamat\s+datang).*',
            function (BotMan $bot) {
                $bot->reply(
                    "👋 Halo! Selamat datang di *Ticketing Support*.\n\n" .
                    "Saya siap membantu Anda. Pilih topik:\n" .
                    "🎟️ *tiket*   — cek tiket saya\n" .
                    "📅 *event*   — daftar event terbaru\n" .
                    "💰 *harga*   — info harga & pembayaran\n" .
                    "🆘 *bantuan* — panduan penggunaan\n" .
                    "📞 *kontak*  — hubungi kami\n\n" .
                    "Ketik salah satu kata kunci di atas ya! 😊"
                );
            }
        );

        // ---------------------------------------------------------
        // 2. CREATOR — diprioritaskan sebelum event/tiket karena
        //    pola majemuknya overlap ("buat event", "jual tiket")
        // ---------------------------------------------------------
        $botman->hears('.*(creator|buat\s+event|jual\s+tiket|organizer|penyelenggara).*',
            function (BotMan $bot) {
                $bot->reply(
                    "🎪 *Menjadi Event Creator*\n\n" .
                    "Ingin menjual tiket event sendiri? Ini caranya:\n" .
                    "1️⃣ Login ke akun Anda\n" .
                    "2️⃣ Kunjungi */creator/buat-event*\n" .
                    "3️⃣ Isi detail event\n" .
                    "4️⃣ Publikasikan & mulai berjualan! 🚀\n\n" .
                    "Ada pertanyaan seputar creator? Hubungi kami 😊"
                );
            }
        );

        // ---------------------------------------------------------
        // 3. TIKET — beli tiket, cek tiket, tiket saya, my ticket, dst.
        // ---------------------------------------------------------
        $botman->hears('.*(tiket|ticket|beli\s+tiket|cek\s+tiket|my\s+ticket|tiket\s+saya).*',
            function (BotMan $bot) {
                $bot->reply(
                    "🎟️ *Informasi Tiket*\n\n" .
                    "Untuk melihat tiket Anda:\n" .
                    "1️⃣ Login ke akun Anda\n" .
                    "2️⃣ Buka menu *Member → My Tickets*\n" .
                    "3️⃣ Pilih tiket yang ingin dilihat\n\n" .
                    "Tiket belum muncul? Hubungi kami di menu *kontak* 😊"
                );
            }
        );

        // ---------------------------------------------------------
        // 4. EVENT — event, acara, konser, pertunjukan, lihat event
        // ---------------------------------------------------------
        $botman->hears('.*(event|acara|konser|pertunjukan|lihat\s+event|daftar\s+event).*',
            function (BotMan $bot) {
                $bot->reply(
                    "📅 *Event Tersedia*\n\n" .
                    "Kunjungi halaman */events* untuk melihat semua event.\n" .
                    "Anda bisa filter berdasarkan:\n" .
                    "• Kategori\n" .
                    "• Tanggal\n" .
                    "• Lokasi\n\n" .
                    "Ada event spesifik yang ingin Anda cari? 🔍"
                );
            }
        );

        // ---------------------------------------------------------
        // 5. HARGA / PEMBAYARAN — harga, biaya, tarif, bayar, dst.
        // ---------------------------------------------------------
        $botman->hears('.*(harga|biaya|tarif|pricing|bayar|pembayaran|pay|payment).*',
            function (BotMan $bot) {
                $bot->reply(
                    "💰 *Informasi Harga & Pembayaran*\n\n" .
                    "Harga tiket bervariasi per event.\n\n" .
                    "Metode pembayaran yang didukung:\n" .
                    "• Transfer Bank\n" .
                    "• QRIS / GoPay / OVO\n" .
                    "• Kartu Kredit/Debit\n" .
                    "• Alfamart / Indomaret\n\n" .
                    "Semua transaksi aman via *Midtrans* 🔒\n" .
                    "Cek detail harga di halaman */pricing*"
                );
            }
        );

        // ---------------------------------------------------------
        // 6. BANTUAN — bantuan, help, tolong, cara, panduan, how
        // ---------------------------------------------------------
        $botman->hears('.*(bantuan|help|tolong|cara|panduan|bagaimana|how|tutorial).*',
            function (BotMan $bot) {
                $bot->reply(
                    "🆘 *Pusat Bantuan*\n\n" .
                    "Saya bisa bantu dengan:\n" .
                    "• Cara beli tiket → ketik *tiket*\n" .
                    "• Info event → ketik *event*\n" .
                    "• Info harga → ketik *harga*\n" .
                    "• Hubungi CS → ketik *kontak*\n" .
                    "• Jadi creator → ketik *creator*\n\n" .
                    "Atau kunjungi */help* untuk panduan lengkap 📖"
                );
            }
        );

        // ---------------------------------------------------------
        // 7. KONTAK — kontak, contact, hubungi, cs, customer service
        // ---------------------------------------------------------
        $botman->hears('.*(kontak|contact|hubungi|customer\s+service|cs\b|whatsapp|wa\b|email).*',
            function (BotMan $bot) {
                $bot->reply(
                    "📞 *Hubungi Kami*\n\n" .
                    "📧 Email     : support@ticketing.id\n" .
                    "💬 WhatsApp  : +62 812-XXXX-XXXX\n" .
                    "📸 Instagram : @ticketing.id\n\n" .
                    "🕐 Jam operasional:\n" .
                    "   Senin–Jumat: 09.00–18.00 WIB\n\n" .
                    "Tim kami siap membantu! 🤝"
                );
            }
        );

        // ---------------------------------------------------------
        // 8. TERIMA KASIH — makasih, thanks, oke, siap, mantap
        // ---------------------------------------------------------
        $botman->hears('.*(terima\s+kasih|makasih|thanks|thank\s+you|thx|oke|ok\b|siap|mantap|keren).*',
            function (BotMan $bot) {
                $bot->reply(
                    "😊 Sama-sama! Senang bisa membantu.\n\n" .
                    "Jika ada pertanyaan lain, ketik saja ya — saya siap 24/7! 🙌"
                );
            }
        );

        // ---------------------------------------------------------
        // FALLBACK — HARUS DI PALING BAWAH
        // Dipanggil hanya jika TIDAK ADA intent di atas yang cocok
        // ---------------------------------------------------------
        $botman->fallback(function (BotMan $bot) {
            $bot->reply(
                "🤖 Hmm, saya belum mengerti maksud Anda.\n\n" .
                "Coba ketik salah satu kata kunci ini:\n" .
                "• *halo*    — mulai percakapan\n" .
                "• *tiket*   — cek tiket saya\n" .
                "• *event*   — lihat event\n" .
                "• *harga*   — info harga\n" .
                "• *bantuan* — pusat bantuan\n" .
                "• *kontak*  — hubungi CS\n\n" .
                "Atau ketik *bantuan* untuk panduan lengkap 😊"
            );
        });
    }
}