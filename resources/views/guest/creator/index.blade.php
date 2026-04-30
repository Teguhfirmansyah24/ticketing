<x-app-layout>
    <section class="relative bg-[#E5E7EB] min-h-[600px] overflow-hidden flex items-center justify-center py-20">

        <div class="absolute top-0 left-10 opacity-80">
            <img src="https://img.icons8.com/color/100/null/spotlight.png" class="w-24 rotate-12">
        </div>
        <div class="absolute top-0 right-10 opacity-80">
            <img src="https://img.icons8.com/color/100/null/spotlight.png" class="w-24 -rotate-12">
        </div>

        <div class="absolute left-0 bottom-20 w-64 hidden lg:block">
            <img src="https://www.pngarts.com/files/3/Hand-Holding-Microphone-PNG-High-Quality-Image.png"
                class="z-20 relative">
            <div class="absolute top-0 left-10 text-[#FF5722] text-8xl font-black opacity-20 rotate-12">★</div>
        </div>

        <div class="absolute left-10 bottom-0 w-80 hidden xl:block translate-y-10">
            <img src="https://pngimg.com/uploads/laptop/laptop_PNG5910.png" class="z-10 relative">
        </div>

        <div class="absolute right-0 bottom-0 w-72 hidden lg:block">
            <img src="https://pngimg.com/uploads/basketball/basketball_PNG1103.png"
                class="z-20 relative w-48 float-right mr-10 mb-10">
            <div class="absolute bottom-10 right-20 text-[#FF5722] text-9xl font-black opacity-20 -rotate-12">★</div>
        </div>

        <div class="absolute right-10 top-20 w-40 hidden xl:block rotate-12">
            <img src="https://pngimg.com/uploads/iphone_11/iphone_11_PNG3.png" class="w-full">
        </div>

        <div class="relative z-30 max-w-4xl mx-auto px-4 text-center">
            <div class="flex justify-center mb-6">
                <div class="bg-white px-4 py-2 rounded-lg shadow-sm flex items-center gap-2">
                    <span class="font-black text-blue-900 text-xl italic">LOKÉT</span>
                    <span class="bg-orange-500 text-white px-2 py-0.5 rounded text-xs font-bold italic">Creator</span>
                </div>
            </div>

            <h1 class="text-4xl md:text-6xl font-black text-slate-900 mb-4 tracking-tight">
                Hi, <span class="font-serif italic text-slate-700">EVENT CREATOR!</span>
            </h1>
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-12">
                Mau bikin <span class="text-orange-500 underline decoration-4 underline-offset-8">event kamu
                    sendiri?</span>
            </h2>

            <p class="text-xl font-bold text-slate-800 mb-12">
                LOKÉT siap jadi <span class="text-blue-600">#SolusiEvent</span> kamu
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-white rounded-[2rem] p-10 shadow-xl border border-white">
                    <p class="text-slate-500 font-bold mb-4">Dipercaya oleh</p>
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <i class="fas fa-users text-blue-900 text-3xl"></i>
                        <span class="text-5xl font-black text-orange-500">
                            {{ number_format($totalUsers, 0, ',', '.') }}+
                        </span>
                    </div>
                    <p class="text-blue-900 font-black text-xl leading-tight">
                        Event Creators di<br>seluruh Indonesia!
                    </p>
                </div>
                <div class="bg-white rounded-[2rem] p-10 shadow-xl border border-white">
                    <p class="text-slate-500 font-bold mb-4">Mendukung</p>
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <i class="fas fa-star text-blue-900 text-3xl"></i>
                        <span class="text-5xl font-black text-orange-500">
                            {{ number_format($totalAllEvents, 0, ',', '.') }}+
                        </span>
                    </div>
                    <p class="text-blue-900 font-black text-xl leading-tight">
                        Event di Indonesia
                    </p>
                </div>
            </div>

            <a href="{{ route('creator.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white text-lg font-bold px-12 py-5 rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95 w-full md:w-auto">
                Buat Event Sekarang
            </a>
        </div>
    </section>

    <section class="py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-blue-900 leading-tight">
                    Beragam jenis event,<br>semua bisa pakai LOKÉT
                </h2>
            </div>

            <div class="relative flex items-center justify-center min-h-[500px]" x-data="{ active: 0 }">

                <button
                    class="absolute left-4 lg:left-20 z-40 bg-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center border border-gray-100 hover:bg-gray-50 transition"
                    @click="active = active > 0 ? active - 1 : {{ $featuredEvents->count() - 1 }}">
                    <i class="fas fa-chevron-left text-gray-400"></i>
                </button>

                <div class="relative w-full max-w-[400px] h-[550px]">
                    @foreach ($featuredEvents as $index => $event)
                        @php
                            $ticketsSold = $event->tickets_count ?? 0;
                        @endphp
                        <div class="absolute inset-0 transition-all duration-500 transform bg-white rounded-[2rem] shadow-2xl border border-gray-100 overflow-hidden"
                            :class="{
                                'z-30 scale-100 opacity-100 translate-x-0': active === {{ $index }},
                                'z-20 scale-90 opacity-60 -translate-x-32': active > {{ $index }},
                                'z-20 scale-90 opacity-60 translate-x-32': active < {{ $index }}
                            }">

                            {{-- Gambar --}}
                            <div class="w-full h-64 relative overflow-hidden">
                                <img src="{{ $event->banner_image }}" alt="{{ $event->title }}"
                                    class="absolute inset-0 w-full h-full object-cover rounded-t-[2rem]"
                                    onerror="this.onerror=null;this.src='https://placehold.co/600x400?text=Poster+Event';">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>

                                {{-- Badge kategori --}}
                                <div class="absolute top-4 left-4">
                                    <span
                                        class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase text-blue-600 shadow-sm">
                                        {{ $event->category->name ?? 'Event' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Konten --}}
                            <div class="p-8 space-y-6">
                                <h3 class="text-xl font-black text-slate-800 leading-snug h-14 overflow-hidden">
                                    {{ $event->title }}
                                </h3>

                                <div class="space-y-4 pt-4 border-t border-gray-100">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="font-bold text-slate-400">Event Creator</span>
                                        <span class="font-bold text-slate-700 truncate max-w-[180px] text-right">
                                            {{ $event->creator->name }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="font-bold text-slate-400">Jumlah Pengunjung</span>
                                        <span class="font-bold text-slate-700">
                                            {{ number_format($ticketsSold, 0, ',', '.') }} orang
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="font-bold text-slate-400">Tipe Event</span>
                                        <span class="font-bold text-slate-700">
                                            {{ $event->category->name ?? '-' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="font-bold text-slate-400">Tanggal</span>
                                        <span class="font-bold text-slate-700">
                                            {{ $event->start_date->translatedFormat('j M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button
                    class="absolute right-4 lg:right-20 z-40 bg-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center border border-gray-100 hover:bg-gray-50 transition"
                    @click="active = active < {{ $featuredEvents->count() - 1 }} ? active + 1 : 0">
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </button>

            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 flex flex-col lg:flex-row items-center gap-16">
            <div class="flex-1 space-y-6">
                <h2 class="text-4xl md:text-5xl font-black text-blue-900 leading-tight">
                    Hitung Perkiraan Pendapatan Event Kamu
                </h2>
                <p class="text-slate-500 text-lg leading-relaxed">
                    Rencanakan event lebih mantap dengan kalkulator pendapatan. Lihat estimasi pendapatan event-mu di
                    Loket.com dengan rincian biaya yang transparan.
                </p>
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-xl flex items-center gap-3 transition shadow-lg shadow-blue-100">
                    <a href="{{ route('pricing') }}">
                        <i class="fas fa-calculator text-xl"></i>
                        Coba Hitung Sendiri
                    </a>
                </button>
            </div>

            <div class="flex-1 w-full max-w-lg">
                <div class="bg-white rounded-[2rem] shadow-2xl border border-gray-50 p-8">
                    <h4 class="font-black text-slate-800 mb-6">Contoh Perhitungan</h4>

                    <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-blue-600 w-10 h-10 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <span class="font-black text-slate-800">General Admission</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Harga
                                    (Rp)</p>
                                <p class="text-2xl font-black text-slate-800">50.000</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jumlah
                                    Tiket</p>
                                <p class="text-2xl font-black text-slate-800">100</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 px-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-slate-400">Total Penjualan</span>
                            <span class="text-sm font-black text-slate-800">Rp 5.000.000</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-slate-400">Biaya Penjualan Tiket (3,5%)</span>
                            <span class="text-sm font-black text-red-500">- Rp 175.000</span>
                        </div>

                        <div
                            class="bg-green-50 border border-green-100 rounded-xl p-4 mt-6 flex justify-between items-center">
                            <span class="font-black text-green-700">Pendapatan Kamu</span>
                            <span class="font-black text-green-700 text-lg">Rp 4.825.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white border-t border-gray-50">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h3 class="text-3xl md:text-4xl font-black text-blue-900 mb-16">
                Mereka sudah sukses bikin event keren di LOKÉT
            </h3>

            <div
                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-12 items-center opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                <img src="https://assets.loket.com/images/partner-1.png" alt="Ismaya"
                    class="h-8 mx-auto object-contain">
                <img src="https://assets.loket.com/images/partner-2.png" alt="CK Star"
                    class="h-10 mx-auto object-contain">
                <img src="https://assets.loket.com/images/partner-3.png" alt="Dyandra"
                    class="h-8 mx-auto object-contain">
                <img src="https://assets.loket.com/images/partner-4.png" alt="Plainsong"
                    class="h-6 mx-auto object-contain">
                <img src="https://assets.loket.com/images/partner-5.png" alt="Ekresa"
                    class="h-8 mx-auto object-contain">
                <img src="https://assets.loket.com/images/partner-6.png" alt="Antara Suara"
                    class="h-10 mx-auto object-contain">
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-black text-blue-900 mb-4">
                    Bareng LOKÉT, mereka mewujudkan event impian
                </h2>
                <p class="text-slate-500 text-lg">
                    Banyak event creator yang telah merasakan kemudahannya, dan kamu juga<br class="hidden md:block">
                    bisa menjadi seperti mereka. Simak inspirasinya:
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                @php
                    $testimonials = [
                        [
                            'name' => 'Adi Praja',
                            'role' => 'Founder & Director of Operational Boss Creator',
                            'event' => 'Pestapora 2025',
                            'image' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Adi',
                            'quote' =>
                                'Smooth banget kerja sama bareng LOKÉT, service-nya juga bagus. Top notch deh pokoknya. Jadi, saya merekomendasikan LOKÉT, karena jika kamu ingin membuat satu acara atau festival, please pakai LOKÉT, karena service-nya cepet, fast response, terus juga seamless banget.',
                        ],
                        [
                            'name' => 'Nida Sihaloho',
                            'role' => 'Lead Ticketing Ismaya Live',
                            'event' => 'We The Fest 2024',
                            'image' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Nida',
                            'quote' =>
                                'Kita pakai sistem RFID (Sistem LOKÉT) karena sistem RFID lebih safety, nggak ribet, dan lebih tersistem. Karena RFID nggak cuma bisa buat gate masuk untuk tiketnya tapi bisa juga untuk semua pembayaran di event Ismaya Live.',
                        ],
                        [
                            'name' => 'Denara',
                            'role' => 'Assistant Marketing Manager Puyo Desserts',
                            'event' => 'SEVENTEEN TREATS with PUYO',
                            'image' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Denara',
                            'quote' =>
                                'Sistemnya (LOKÉT) itu mudah banget, create event-nya gampang, dan kalau misalkan ada kendala pun, tim LOKÉT juga responnya cepet banget. Jadi, kalau ada problem langsung di-solved dalam waktu singkat. Keren LOKÉT!',
                        ],
                    ];
                @endphp

                @foreach ($testimonials as $item)
                    <div class="flex flex-col h-full">
                        <div class="mb-6 relative">
                            <i class="fas fa-quote-left text-blue-600 text-3xl mb-4 block"></i>
                            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-slate-100 shadow-sm">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>

                        <div class="flex-grow">
                            <p class="text-slate-600 leading-relaxed text-sm italic mb-8">
                                "{{ $item['quote'] }}"
                            </p>
                        </div>

                        <div class="w-12 h-0.5 bg-blue-600 mb-4"></div>

                        <div>
                            <h4 class="font-black text-slate-800 text-lg uppercase tracking-tight">
                                {{ $item['name'] }}
                            </h4>
                            <p class="text-[12px] text-slate-400 font-bold leading-tight uppercase mt-1">
                                {{ $item['role'] }}<br>
                                <span class="text-slate-500 font-black">{{ $item['event'] }}</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20 bg-[#1A2C50]">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-white">Informasi buat upgrade event kamu</h2>
            </div>

            <div class="relative group" x-data="{
                scroll: 0,
                scrollToNext() { this.$refs.slider.scrollBy({ left: 350, behavior: 'smooth' }) },
                scrollToPrev() { this.$refs.slider.scrollBy({ left: -350, behavior: 'smooth' }) }
            }">

                <button @click="scrollToPrev()"
                    class="absolute -left-4 top-1/2 -translate-y-1/2 z-20 bg-white w-10 h-10 rounded-full shadow-xl flex items-center justify-center hover:bg-gray-50 transition-all opacity-0 group-hover:opacity-100 border border-gray-100">
                    <i class="fas fa-chevron-left text-gray-400 text-sm"></i>
                </button>

                <div x-ref="slider" class="flex overflow-x-auto gap-6 scroll-smooth no-scrollbar pb-8 px-2"
                    style="scrollbar-width: none; -ms-overflow-style: none;">

                    @php
                        $articles = [
                            [
                                'title' => 'Biar Eventmu Ngga Rugi, Cek Cara Menentukan Harga Tiket Di sini!',
                                'desc' =>
                                    'Menetapkan harga tiket event adalah tugas paling tricky ketika membuat event. Kalau terlalu mahal, siapa yang beli?',
                                'image' => 'https://images.unsplash.com/photo-1556742044-3c52d6e88c62?q=80&w=400',
                                'color' => 'bg-[#E96464]',
                            ],
                            [
                                'title' => 'Jenis-Jenis Tiket Event, Mana Yang Cocok Buat Event-mu?',
                                'desc' =>
                                    'Event creator mana sih yang ngga suka sama kata Sold Out? Kata sold out itu bisa meningkatkan value dari event kamu.',
                                'image' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=400',
                                'color' => 'bg-[#C5A347]',
                            ],
                            [
                                'title' => 'Contoh Hybrid Event Yang Bisa Menginspirasi Event Kamu',
                                'desc' =>
                                    'Waktunya kamu bikin event dengan terobosan baru, hybrid event! Event hybrid adalah event yang menggabungkan...',
                                'image' => 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=400',
                                'color' => 'bg-[#1A2C50]',
                            ],
                            [
                                'title' => 'Strategi Marketing Event Biar Rame Pengunjung!',
                                'desc' =>
                                    'Promosi adalah kunci. Pelajari bagaimana cara memasarkan event kamu di media sosial dengan budget minim.',
                                'image' => 'https://images.unsplash.com/photo-1551818255-e6e10975bc17?q=80&w=400',
                                'color' => 'bg-[#2E7D32]',
                            ],
                        ];
                    @endphp

                    @foreach ($articles as $article)
                        <div
                            class="flex-none w-80 bg-white rounded-[1.5rem] overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                            <div class="h-44 relative overflow-hidden {{ $article['color'] }}">
                                <img src="{{ $article['image'] }}" alt="Thumbnail"
                                    class="w-full h-full object-cover opacity-90 transition-transform duration-500">
                            </div>

                            <div class="p-6 space-y-3">
                                <h4 class="text-lg font-black text-slate-800 leading-tight line-clamp-2 h-12">
                                    {{ $article['title'] }}
                                </h4>
                                <p class="text-slate-500 text-xs leading-relaxed line-clamp-3">
                                    {{ $article['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button @click="scrollToNext()"
                    class="absolute -right-4 top-1/2 -translate-y-1/2 z-20 bg-white w-10 h-10 rounded-full shadow-xl flex items-center justify-center hover:bg-gray-50 transition-all opacity-0 group-hover:opacity-100 border border-gray-100">
                    <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                </button>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-black text-blue-900 leading-tight">
                    Mau mulai jadi event creator<br>di Loket.com?
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-[2rem] overflow-hidden shadow-xl border border-gray-100 flex flex-col">
                    <div class="h-40 bg-[#FF7A30] relative overflow-hidden">
                        <div class="absolute inset-0 opacity-20"
                            style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;">
                        </div>
                    </div>

                    <div class="p-10 flex flex-col flex-grow items-center text-center">
                        <p class="text-slate-600 text-sm leading-relaxed mb-10">
                            Cocok untuk berbagai kebutuhan event. Dalam hitungan menit, kamu sudah bisa mulai jual tiket
                            dan kelola semuanya dengan simpel.
                        </p>

                        <div class="mt-auto w-full">
                            <a href="#"
                                class="inline-block w-full py-4 border-2 border-slate-100 text-slate-700 font-bold rounded-xl hover:bg-blue-500 hover:text-white transition-colors">
                                Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] overflow-hidden shadow-xl border border-gray-100 flex flex-col">
                    <div class="h-40 bg-[#1A2C50] relative overflow-hidden">
                        <div class="absolute inset-0 opacity-20"
                            style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;">
                        </div>
                    </div>

                    <div class="p-10 flex flex-col flex-grow items-center text-center">
                        <p class="text-slate-600 text-sm leading-relaxed mb-10">
                            Solusi untuk kebutuhan event dengan pengaturan lebih lengkap dan dukungan khusus dari tim
                            LOKÉT.
                        </p>

                        <div class="mt-auto w-full">
                            <a href="#"
                                class="inline-block w-full py-4 border-2 border-slate-100 text-slate-700 font-bold rounded-xl hover:bg-blue-500 hover:text-white transition-colors">
                                Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-black text-blue-900">
                    Update & insight terbaru dunia event
                </h2>
            </div>

            <div class="relative group" x-data="{
                scrollToNext() { this.$refs.insightSlider.scrollBy({ left: 400, behavior: 'smooth' }) },
                    scrollToPrev() { this.$refs.insightSlider.scrollBy({ left: -400, behavior: 'smooth' }) }
            }">

                <button @click="scrollToPrev()"
                    class="absolute -left-5 top-1/2 -translate-y-1/2 z-20 bg-white w-12 h-12 rounded-full shadow-xl flex items-center justify-center hover:bg-gray-50 transition-all border border-gray-100 group-hover:scale-110">
                    <i class="fas fa-chevron-left text-gray-400"></i>
                </button>

                <div x-ref="insightSlider" class="flex overflow-x-auto gap-6 scroll-smooth no-scrollbar pb-10 px-4"
                    style="scrollbar-width: none; -ms-overflow-style: none;">

                    @php
                        $insights = [
                            [
                                'image' => 'https://images.unsplash.com/photo-1531058021387-483a7a46479a?w=400',
                                'handle' => '@loketcomcreator',
                                'time' => '4 days ago',
                                'play' => true,
                            ],
                            [
                                'image' => 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=400',
                                'handle' => '@loketcomcreator',
                                'time' => '4 days ago',
                                'play' => false,
                            ],
                            [
                                'image' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=400',
                                'handle' => '@loketcomcreator',
                                'time' => '5 days ago',
                                'play' => true,
                            ],
                            [
                                'image' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=400',
                                'handle' => '@loketcomcreator',
                                'time' => '6 days ago',
                                'play' => true,
                            ],
                        ];
                    @endphp

                    @foreach ($insights as $item)
                        <div
                            class="flex-none w-[350px] aspect-square relative rounded-[2rem] overflow-hidden shadow-lg group/card cursor-pointer">
                            <img src="{{ $item['image'] }}"
                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-110">

                            <div class="absolute inset-0 bg-black/30 group-hover/card:bg-black/20 transition-colors">
                            </div>

                            @if ($item['play'])
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div
                                        class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/30 transition-transform group-hover/card:scale-125">
                                        <i class="fas fa-play text-white text-xl ml-1"></i>
                                    </div>
                                </div>
                            @endif

                            <div class="absolute bottom-6 left-6 right-6 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-bold text-sm">{{ $item['handle'] }}</p>
                                        <p class="text-[10px] opacity-80">{{ $item['time'] }}</p>
                                    </div>
                                    <i class="fab fa-instagram text-xl"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button @click="scrollToNext()"
                    class="absolute -right-5 top-1/2 -translate-y-1/2 z-20 bg-white w-12 h-12 rounded-full shadow-xl flex items-center justify-center hover:bg-gray-50 transition-all border border-gray-100 group-hover:scale-110">
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </button>
            </div>

            <div class="text-center mt-12 space-y-4">
                <p class="text-sm font-bold text-slate-500">Cek lengkapnya di</p>
                <a href="#"
                    class="inline-flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-100 transition-all active:scale-95">
                    <i class="fab fa-instagram text-xl"></i>
                    @loketcomcreator
                </a>
            </div>
        </div>
    </section>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</x-app-layout>
