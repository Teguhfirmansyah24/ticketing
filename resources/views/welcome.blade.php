<x-app-layout>

    {{-- Banner --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div x-data="{
                current: 0,
                slides: [
                    @foreach ($bannerEvents as $event)
                {
                    image: '{{ asset('storage/' . $event->banner_image) }}',
                    title: '{{ addslashes($event->title) }}',
                    category: '{{ addslashes($event->category->name ?? 'Event') }}',
                    location: '{{ addslashes($event->location) }}',
                    url: '{{ route('event.show', $event->id) }}'
                }{{ !$loop->last ? ',' : '' }} @endforeach
                ],
                next() {
                    this.current = (this.current + 1) % this.slides.length;
                },
                prev() {
                    this.current = (this.current - 1 + this.slides.length) % this.slides.length;
                },
                init() {
                    setInterval(() => {
                        this.next();
                    }, 5000);
                }
            }"
                class="relative overflow-hidden rounded-2xl bg-black shadow-2xl group cursor-pointer">
                <div class="relative h-[300px] md:h-[280px]">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="current === index" x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="absolute inset-0">

                            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent z-10"></div>

                            <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover">

                            <a :href="slide.url" class="absolute inset-0 z-20 flex items-center px-12">
                                <div class="max-w-md" x-show="current === index"
                                    x-transition:enter="delay-300 duration-500">
                                    <span class="text-white/70 text-xs uppercase tracking-widest"
                                        x-text="slide.category"></span>
                                    <h3 class="text-red-600 font-black text-5xl italic tracking-tighter mt-1"
                                        x-text="slide.title"></h3>
                                    <p class="text-white text-sm mt-2 tracking-widest uppercase"
                                        x-text="slide.location"></p>
                                </div>
                            </a>
                        </div>
                    </template>
                </div>

                {{-- Prev Button --}}
                <button @click="prev()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 z-30 p-2 rounded-full bg-white/10 hover:bg-white/20 text-white opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                {{-- Next Button --}}
                <button @click="next()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-30 p-2 rounded-full bg-white/10 hover:bg-white/20 text-white opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                {{-- Dots --}}
                <div
                    class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 flex space-x-2 bg-black/40 px-3 py-2 rounded-full backdrop-blur-sm">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="current = index" :class="current === index ? 'w-8 bg-white' : 'w-2 bg-white/40'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                    </template>
                </div>
            </div>

        </div>
    </div>
    {{-- End Banner --}}

    {{-- Kategori event --}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">

                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-slate-800 tracking-tight">Kategori Event</h3>
                </div>

                <div class="flex space-x-4 overflow-x-auto pb-4 scroll-smooth snap-x snap-proximity"
                    style="scrollbar-width: none; -ms-overflow-style: none;" onmouseover="this.style.cursor='grab'"
                    onmousedown="this.style.cursor='grabbing'" onmouseup="this.style.cursor='grab'">
                    @foreach ($categories as $index => $category)
                        <div class="flex-none w-36 md:w-44 snap-start">
                            <a href="{{ route('event.index') }}?category={{ $category->slug }}"
                                class="group block text-center">
                                <div
                                    class="relative overflow-hidden rounded-2xl mb-3 transition-all duration-300 group-hover:shadow-md border border-gray-100 bg-white">
                                    <div class="h-24 flex items-center justify-center p-4">
                                        @if ($category->icon)
                                           <img src="{{ asset('storage/' . $category->icon) }}" 
                                                alt="{{ $category->name }}"
                                                class="w-16 h-16 object-contain drop-shadow-md group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <svg class="w-16 h-16 text-white opacity-80" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="p-3 bg-white h-16 flex items-center justify-center">
                                        <span class="text-xs md:text-sm font-semibold text-gray-700 leading-tight">
                                            {{ $category->name }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    {{-- End Kategori Event --}}


    {{-- Event Seru --}}
    <div class="py-10" x-data="{
        hovered: false,
        scroll(direction) {
            const container = this.$refs.eventContainer;
            const scrollAmount = 800;
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative" @mouseenter="hovered = true"
            @mouseleave="hovered = false">

            <h3 class="text-2xl font-bold text-slate-800 mb-6 px-4 md:px-0">Event Seru Lagi Nunggu Kamu</h3>

            <div class="relative">

                {{-- Tombol Kiri --}}
                <button @click="scroll('left')" x-show="hovered" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-40 bg-white/90 p-3 rounded-full shadow-xl text-gray-800 hover:bg-white -ml-4 border border-gray-100 hidden md:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                {{-- Container Event --}}
                <div x-ref="eventContainer" class="flex space-x-5 overflow-x-auto pb-8 snap-x snap-proximity px-2"
                    style="scrollbar-width: none; -ms-overflow-style: none;">

                    @foreach ($events as $event)
                        @php
                            $minPrice = $event->ticketTypes->where('is_active', true)->min('price');
                        @endphp
                        <div class="flex-none w-[280px] md:w-[320px] snap-start">
                            <a href="{{ route('event.show', $event->id) }}">
                                <div
                                    class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full">
                                    <div class="relative h-44 overflow-hidden">
                                        <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop' }}"
                                            alt="{{ $event->title }}"
                                            class="w-full h-full object-cover cursor-pointer">
                                    </div>

                                    <div class="p-5 flex flex-col flex-grow">
                                        <h4
                                            class="font-bold text-gray-800 text-lg leading-tight line-clamp-2 mb-2 h-12">
                                            {{ $event->title }}
                                        </h4>
                                        <p class="text-sm text-gray-500 mb-4">
                                            {{ $event->start_date->format('d M Y') }}
                                        </p>

                                        <div class="mt-auto">
                                            <p class="text-lg font-black text-gray-900 mb-4">
                                                @if ($minPrice)
                                                    Rp{{ number_format($minPrice, 0, ',', '.') }}
                                                @else
                                                    Gratis
                                                @endif
                                            </p>

                                            <hr class="border-gray-100 mb-4">

                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-6 h-6 rounded-full bg-gray-200 flex-shrink-0 flex items-center justify-center text-[10px] font-bold">
                                                    {{ substr($event->creator->name, 0, 1) }}
                                                </div>
                                                <span class="text-xs font-medium text-gray-600 truncate">
                                                    {{ $event->creator->name }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>

                {{-- Tombol Kanan --}}
                <button @click="scroll('right')" x-show="hovered"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-40 bg-white/90 p-3 rounded-full shadow-xl text-gray-800 hover:bg-white -mr-4 border border-gray-100 hidden md:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    {{-- End Event Seru --}}

    {{-- Top Event --}}
    <div class="py-12 bg-[#1b2d55]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-2xl font-bold text-white mb-8 px-4 md:px-0 tracking-wide">Top Events</h3>

            <div class="flex flex-col md:flex-row items-center justify-between gap-8 md:gap-4 px-4 md:px-0">

                @forelse ($topEvents as $index => $event)
                    <div class="flex items-center space-x-2 group cursor-pointer">
                        <a href="{{ route('event.show', $event->id) }}" class="flex items-center space-x-2">

                            {{-- Nomor Rank --}}
                            <div class="relative">
                                <span class="text-7xl md:text-8xl font-black text-transparent"
                                    style="-webkit-text-stroke: 2px rgba(255,255,255,0.6);">
                                    {{ $index + 1 }}
                                </span>
                            </div>

                            {{-- Card Event --}}
                            <div class="relative w-64 h-36 md:w-72 md:h-40 rounded-xl overflow-hidden shadow-2xl">
                                <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop' }}"
                                    alt="{{ $event->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent">
                                </div>

                                <div class="absolute bottom-3 left-3 right-3">
                                    <h4 class="text-xs font-bold text-white truncate">
                                        {{ $event->title }}
                                    </h4>
                                    <p class="text-[10px] text-white/60 mt-1 truncate">
                                        {{ $event->venue }}, {{ $event->location }}
                                    </p>
                                </div>
                            </div>

                        </a>
                    </div>

                @empty
                    {{-- Fallback kalau belum ada event --}}
                    <div class="text-white/50 text-sm">Belum ada top event saat ini.</div>
                @endforelse

            </div>
        </div>
    </div>
    {{-- End Top Event --}}

    {{-- Creator Favorit --}}
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-10 px-4 md:px-0">
                <h3 class="text-2xl font-bold text-slate-800 tracking-wide">Creator Favorit</h3>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-8 px-4 md:px-0">

                @forelse ($topCreators as $creator)
                    <div class="relative group">
                        <a href="{{ route('creator.show', $creator->id) }}"
                            class="relative z-10 bg-white rounded-2xl p-6 border border-gray-100 text-center transition-all duration-300 group-hover:-translate-y-2 shadow-sm group-hover:shadow-xl flex flex-col items-center h-full">

                            {{-- Avatar --}}
                            <div
                                class="w-20 h-20 rounded-full overflow-hidden mb-4 border-2 border-blue-500 p-0.5 shadow-md">
                                @if ($creator->avatar)
                                    <img src="{{ asset('storage/' . $creator->avatar) }}" alt="{{ $creator->name }}"
                                        class="w-full h-full object-cover rounded-full"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div style="display:none"
                                        class="w-full h-full rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                        <span class="text-white font-bold text-xl">
                                            {{ strtoupper(substr($creator->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @else
                                    <div
                                        class="w-full h-full rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                        <span class="text-white font-bold text-xl">
                                            {{ strtoupper(substr($creator->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Nama --}}
                            <h4
                                class="text-sm font-bold text-slate-800 mb-1 group-hover:text-blue-600 transition-colors truncate w-full">
                                {{ $creator->name }}
                            </h4>

                            {{-- Jumlah tiket terjual --}}
                            <p class="text-[10px] text-slate-500 line-clamp-2 h-7 leading-tight mb-4">
                                {{ $creator->total_tickets_sold ?? 0 }} tiket terjual
                            </p>

                            <div class="mt-auto pt-2 w-full">
                                <span
                                    class="text-[11px] font-bold text-blue-600 bg-blue-50 px-4 py-1.5 rounded-full group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                    Lihat Profil
                                </span>
                            </div>
                        </a>
                    </div>

                @empty
                    <div class="col-span-5 text-center text-slate-400 text-sm">
                        Belum ada creator saat ini.
                    </div>
                @endforelse

            </div>
        </div>
    </div>
    {{-- End Creator Favorit --}}

    {{-- Event per Kategori --}}
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-16">

            @forelse ($categoryEvents as $categoryEvent)
                <section>
                    <div class="flex items-center justify-between mb-8 px-4 md:px-0">
                        <h3 class="text-2xl font-bold text-slate-900 tracking-tight">
                            {{ $categoryEvent->name }}
                        </h3>
                        <a href="{{ route('event.index') }}?category={{ $categoryEvent->slug }}"
                            class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition group flex items-center">
                            Lihat lebih banyak
                            <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <div class="flex space-x-4 overflow-x-auto pb-6 snap-x snap-proximity px-2"
                        style="scrollbar-width: none; -ms-overflow-style: none;">

                        @foreach ($categoryEvent->events as $event)
                            @php
                                $minPrice = $event->ticketTypes->where('is_active', true)->min('price');
                            @endphp

                            <div class="flex-none w-[280px] md:w-[300px] snap-start">
                                <a href="{{ route('event.show', $event->id) }}"
                                    class="group block h-full bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100">

                                    {{-- Gambar --}}
                                    <div class="relative h-44 overflow-hidden">
                                        <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop' }}"
                                            alt="{{ $event->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                                        {{-- Badge Kategori --}}
                                        <div
                                            class="absolute top-3 left-3 bg-gradient-to-r from-orange-400 to-amber-500 px-2.5 py-1 rounded-full text-[9px] font-bold text-white uppercase">
                                            {{ $categoryEvent->name }}
                                        </div>
                                    </div>

                                    {{-- Konten --}}
                                    <div class="p-4 flex flex-col justify-between h-48">
                                        <div class="space-y-1.5">
                                            <h4
                                                class="font-bold text-slate-900 text-base leading-tight line-clamp-2 group-hover:text-blue-600 transition-colors">
                                                {{ $event->title }}
                                            </h4>
                                            <p class="text-xs font-medium text-slate-500">
                                                {{ $event->start_date->format('d M Y') }}
                                            </p>
                                            <p class="text-base font-black text-slate-950">
                                                @if ($minPrice)
                                                    Rp{{ number_format($minPrice, 0, ',', '.') }}
                                                @else
                                                    Gratis
                                                @endif
                                            </p>
                                        </div>

                                        {{-- Creator --}}
                                        <div class="pt-3 border-t border-slate-100 flex items-center space-x-2">
                                            <div
                                                class="w-7 h-7 rounded-md bg-blue-50 flex items-center justify-center border border-blue-100 text-xs font-black text-blue-700">
                                                {{ strtoupper(substr($event->creator->name, 0, 1)) }}
                                            </div>
                                            <span class="text-xs font-semibold text-slate-600 truncate">
                                                {{ $event->creator->name }}
                                            </span>
                                        </div>
                                    </div>

                                </a>
                            </div>
                        @endforeach

                    </div>
                </section>

            @empty
                <div class="text-center text-slate-400 text-sm py-10">
                    Belum ada event tersedia saat ini.
                </div>
            @endforelse

            <div class="flex justify-center">
                <a href="{{ route('event.index') }}"
                    class="inline-flex items-center space-x-2 px-8 py-3 border-2 border-blue-600 text-blue-600 font-bold text-sm rounded-xl hover:bg-blue-600 hover:text-white transition-all duration-300 active:scale-95">
                    <span>Jelajah Lebih Banyak Event</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

        </div>
    </div>
    {{-- End Event --}}
    
    <style>
        /* Sembunyikan scrollbar di semua browser */
        .overflow-x-auto::-webkit-scrollbar {
            display: none;
        }
    </style>

</x-app-layout>
