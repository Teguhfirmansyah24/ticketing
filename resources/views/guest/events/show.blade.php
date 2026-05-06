<x-app-layout>
    <div class="bg-slate-50 text-slate-800 antialiased">

        {{-- ===== HERO HEADER ===== --}}
        <header class="relative overflow-hidden text-white py-12 px-6 md:px-12 mb-10">
            <div class="absolute inset-0 z-0 scale-110 bg-cover bg-center blur-lg brightness-[0.4]"
                style="background-image: linear-gradient(to right, rgba(0,0,0,0.8), rgba(0,0,0,0.3)),
                url('{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop' }}')">
            </div>

            <div class="relative z-10 max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1 space-y-5 text-center md:text-left">
                    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                        {{ $event->title }}
                    </h1>
                    <div class="space-y-3 font-medium opacity-90">
                        <p class="flex items-center gap-3 justify-center md:justify-start">
                            <i class="fas fa-map-marker-alt text-lg"></i>
                            {{ $event->venue }}, {{ $event->location }}
                        </p>
                        <p class="flex items-center gap-3 justify-center md:justify-start">
                            <i class="far fa-calendar-alt text-lg"></i>
                            {{ $event->start_date->translatedFormat('j M Y, H:i') }} -
                            {{ $event->end_date->translatedFormat('H:i') }} WIB
                        </p>
                        <p class="flex items-center gap-3 justify-center md:justify-start">
                            <i class="fas fa-tag text-lg"></i>
                            {{ $event->category->name ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="w-full md:w-auto max-w-sm">
                    <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop' }}"
                        alt="{{ $event->title }}" class="w-full h-auto rounded-xl shadow-2xl border-4 border-white/20">
                </div>
            </div>
        </header>

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="max-w-7xl mx-auto px-6 md:px-12 py-8 grid grid-cols-1 md:grid-cols-12 gap-10">

            {{-- LEFT COLUMN --}}
            <div class="md:col-span-8 space-y-12">

                {{-- Tab Nav --}}
                <div class="sticky top-0 z-30 bg-slate-50 border-b border-gray-200" x-data="{
                    activeTab: 'deskripsi',
                    init() {
                        const hash = window.location.hash.replace('#', '');
                        if (hash) this.activeTab = hash;
                        window.addEventListener('scroll', () => {
                            const deskripsi = document.getElementById('deskripsi');
                            const tiket = document.getElementById('tiket');
                            const scrollY = window.scrollY + 150;
                            if (tiket && scrollY >= tiket.offsetTop) {
                                this.activeTab = 'tiket';
                            } else if (deskripsi && scrollY >= deskripsi.offsetTop) {
                                this.activeTab = 'deskripsi';
                            }
                        });
                    }
                }">
                    <nav class="flex space-x-8">
                        <a href="#deskripsi" @click="activeTab = 'deskripsi'"
                            :class="activeTab === 'deskripsi' ? 'border-blue-600 text-blue-600' :
                                'border-transparent text-slate-400'"
                            class="border-b-2 px-1 py-4 text-sm font-semibold whitespace-nowrap transition-colors duration-200">
                            Deskripsi
                        </a>
                        <a href="#tiket" @click="activeTab = 'tiket'"
                            :class="activeTab === 'tiket' ? 'border-blue-600 text-blue-600' :
                                'border-transparent text-slate-400'"
                            class="border-b-2 px-1 py-4 text-sm font-semibold whitespace-nowrap transition-colors duration-200">
                            Tiket
                        </a>
                    </nav>
                </div>

                {{-- Deskripsi --}}
                <div id="deskripsi" class="space-y-4">
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $event->title }}</h2>
                    <p class="text-slate-600 leading-relaxed max-w-2xl">
                        {{ $event->description }}
                    </p>
                </div>

                {{-- Tiket --}}
                <div id="tiket" class="mt-12 space-y-6">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-ticket-alt text-2xl text-blue-900 -rotate-45"></i>
                        <h2 class="text-2xl font-bold text-blue-900">Tiket</h2>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="flex items-center justify-between p-6 bg-gray-50">
                            <div class="space-y-1">
                                <h3 class="text-xl font-bold text-slate-800">Pilih Tiket</h3>
                                <p class="text-sm text-slate-500">
                                    {{ $event->ticketTypes->count() }} kategori tiket
                                    @php $minPrice = $event->ticketTypes->min('price'); @endphp
                                    @if ($minPrice)
                                        — Harga mulai dari Rp{{ number_format($minPrice, 0, ',', '.') }}
                                    @else
                                        — Gratis
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 divide-y divide-gray-100">
                            @forelse ($event->ticketTypes as $ticketType)
                                @php
                                    $available = $ticketType->quota - $ticketType->sold;
                                    $isSoldOut = $available <= 0;
                                @endphp
                                <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-12">
                                        <span class="text-lg font-bold text-slate-700 w-36">
                                            @if ($ticketType->price > 0)
                                                Rp{{ number_format($ticketType->price, 0, ',', '.') }}
                                            @else
                                                Gratis
                                            @endif
                                        </span>
                                        <div class="space-y-1">
                                            <p class="font-bold text-slate-800 uppercase">{{ $ticketType->name }}</p>
                                            @if ($ticketType->description)
                                                <p class="text-xs text-slate-500">{{ $ticketType->description }}</p>
                                            @endif
                                            <p class="text-xs text-slate-400 font-medium">
                                                Penjualan berakhir {{ $event->start_date->translatedFormat('j M Y') }}
                                                •
                                                {{ $isSoldOut ? 'Habis' : $available . ' tiket tersisa' }}
                                            </p>
                                        </div>
                                    </div>

                                    @if ($isSoldOut)
                                        <span
                                            class="px-4 py-1.5 rounded-full bg-red-50 text-red-500 text-xs font-bold self-start md:self-center border border-red-100 uppercase tracking-wider">
                                            Sold Out
                                        </span>
                                    @else
                                        <span
                                            class="px-4 py-1.5 rounded-full bg-green-50 text-green-500 text-xs font-bold self-start md:self-center border border-green-100 uppercase tracking-wider">
                                            Available
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <div class="p-6 text-center text-slate-400 text-sm">
                                    Belum ada tiket tersedia.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT SIDEBAR --}}
            <aside class="md:col-span-4">
                <div class="sticky top-10 space-y-8">
                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 ring-1 ring-black/5">
                        <div class="space-y-6">

                            <div class="space-y-4">
                                <h3 class="font-extrabold text-slate-900 tracking-tight uppercase text-sm opacity-50">
                                    Detail Event
                                </h3>
                                <div class="space-y-3.5 font-medium text-slate-700">
                                    <p class="flex items-start gap-3.5">
                                        <i class="fas fa-map-marker-alt text-blue-600 text-lg mt-0.5"></i>
                                        <span>{{ $event->venue }}, {{ $event->location }}</span>
                                    </p>
                                    <p class="flex items-start gap-3.5">
                                        <i class="far fa-calendar-alt text-blue-600 text-lg mt-0.5"></i>
                                        <span>
                                            {{ $event->start_date->translatedFormat('j M Y, H:i') }} -
                                            {{ $event->end_date->translatedFormat('H:i') }} WIB
                                        </span>
                                    </p>
                                    <p class="flex items-start gap-3.5">
                                        <i class="fas fa-tag text-blue-600 text-lg mt-0.5"></i>
                                        <span>{{ $event->category->name ?? '-' }}</span>
                                    </p>
                                </div>
                            </div>

                            <hr class="border-gray-100">



                            {{-- Creator --}}
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-2xl ring-4 ring-slate-100 overflow-hidden
                                    {{ $event->creator->avatar ? '' : 'bg-slate-800' }}">
                                    @if ($event->creator->avatar)
                                        <img src="{{ asset('storage/' . $event->creator->avatar) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($event->creator->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        Diselenggarakan oleh
                                    </p>
                                    <p class="text-lg font-extrabold text-slate-900">
                                        {{ $event->creator->name }}
                                    </p>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            <div class="flex items-center justify-between gap-4">
                                <div class="space-y-1">
                                    <p class="text-sm font-medium text-slate-500">Harga mulai dari</p>
                                    <p class="text-3xl font-extrabold text-slate-900">
                                        @php $minPrice = $event->ticketTypes->min('price'); @endphp
                                        @if ($minPrice)
                                            Rp{{ number_format($minPrice, 0, ',', '.') }}
                                        @else
                                            Gratis
                                        @endif
                                    </p>
                                </div>
                                @auth
                                    <a href="{{ route('orders.create', $event->id) }}"
                                        class="inline-block bg-blue-600 text-white px-4 py-3.5 rounded-xl font-bold text-lg shadow-lg hover:bg-blue-700 active:scale-95 transition-all text-center">
                                        Beli Tiket
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="inline-block bg-blue-600 text-white px-4 py-3.5 rounded-xl font-bold text-sm shadow-lg hover:bg-blue-700 active:scale-95 transition-all text-center">
                                        Login untuk Beli
                                    </a>
                                @endauth
                            </div>

                        </div>
                    </div>

                    {{-- Share --}}
                    <div class="space-y-4 text-center">
                        <h4 class="text-sm font-semibold text-slate-500">Bagikan Event</h4>
                        <div class="flex items-center justify-center gap-3">
                            <button onclick="navigator.clipboard.writeText(window.location.href)"
                                class="flex items-center justify-center w-10 h-10 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 hover:scale-110 transition-all"
                                title="Salin link">
                                <i class="far fa-copy text-lg"></i>
                            </button>
                            <a href="https://wa.me/?text={{ urlencode($event->title . ' - ' . url()->current()) }}"
                                target="_blank"
                                class="flex items-center justify-center w-10 h-10 rounded-full bg-green-500 text-white hover:bg-green-600 hover:scale-110 transition-all">
                                <i class="fab fa-whatsapp text-xl"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank"
                                class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white hover:bg-blue-700 hover:scale-110 transition-all">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ urlencode(url()->current()) }}"
                                target="_blank"
                                class="flex items-center justify-center w-10 h-10 rounded-full bg-black text-white hover:bg-slate-800 hover:scale-110 transition-all">
                                <i class="fab fa-x-twitter text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </aside>
        </main>

        {{-- ===== EVENT REKOMENDASI ===== --}}
        <div class="mt-16 max-w-7xl mx-auto px-6 pb-24">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Event Untuk Kamu</h2>
                <div class="hidden md:flex gap-2">
                    <button onclick="scrollContainer('left')"
                        class="w-10 h-10 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-600 hover:bg-slate-900 hover:text-white transition shadow-sm">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button onclick="scrollContainer('right')"
                        class="w-10 h-10 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-600 hover:bg-slate-900 hover:text-white transition shadow-sm">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <div id="eventScroll" class="flex gap-6 overflow-x-auto snap-x snap-mandatory pb-4 select-none"
                style="-ms-overflow-style: none; scrollbar-width: none;">

                @forelse ($relatedEvents as $related)
                    @php $relatedMinPrice = $related->ticketTypes->where('is_active', true)->min('price'); @endphp
                    <a href="{{ route('events.show', $related->slug) }}"
                        class="snap-start min-w-[280px] md:min-w-[320px] bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all group cursor-pointer">
                        <div class="relative aspect-video overflow-hidden rounded-t-3xl">
                            <img src="{{ $related->banner_image ? asset('storage/' . $related->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=600' }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                alt="{{ $related->title }}">
                        </div>
                        <div class="p-6 space-y-4">
                            <h3 class="font-bold text-slate-800 leading-snug line-clamp-2 h-12">
                                {{ $related->title }}
                            </h3>
                            <p class="text-xl font-black text-blue-600">
                                @if ($relatedMinPrice)
                                    Rp{{ number_format($relatedMinPrice, 0, ',', '.') }}
                                @else
                                    Gratis
                                @endif
                            </p>
                            <hr class="border-slate-50">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-[10px]">
                                    {{ strtoupper(substr($related->creator->name, 0, 1)) }}
                                </div>
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-tighter truncate">
                                    {{ $related->creator->name }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-slate-400 text-sm">Belum ada event rekomendasi.</p>
                @endforelse

            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            function scrollContainer(direction) {
                const container = document.getElementById('eventScroll');
                container.scrollBy({
                    left: direction === 'left' ? -350 : 350,
                    behavior: 'smooth'
                });
            }
        </script>
    @endpush

</x-app-layout>
