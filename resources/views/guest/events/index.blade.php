<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Sidebar Filter --}}
            <aside class="w-full lg:w-1/4 space-y-4">
                {{-- Form utama untuk filter radio & select --}}
                <form method="GET" action="{{ route('event.index') }}" id="filterForm">
                    {{-- Hidden input agar saat filter sidebar diklik, sort yang sedang aktif tidak hilang --}}
                    @if (request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">

                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-lg font-bold text-slate-900">Filter</h2>
                            <a href="{{ route('event.index') }}"
                                class="text-blue-600 hover:rotate-180 transition-transform duration-500"
                                title="Reset Filter">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </a>
                        </div>

                        {{-- Filter Toggle Harga (Gratis Only) --}}
                        <div class="flex items-center justify-between py-4 border-b border-gray-100"
                            x-data="{ checked: {{ request('price') === 'free' ? 'true' : 'false' }} }">
                            <span class="text-sm font-semibold text-slate-700">Hanya Gratis</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" x-model="checked"
                                    @change="
                                        const url = new URL(window.location.href);
                                        if (checked) {
                                            url.searchParams.set('price', 'free');
                                        } else {
                                            url.searchParams.delete('price');
                                        }
                                        url.searchParams.delete('page');
                                        window.location.href = url.toString();
                                    ">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                            </label>
                        </div>

                        {{-- Filter Lokasi --}}
                        <div x-data="{ open: {{ request('location') ? 'true' : 'false' }} }" class="border-b border-gray-100">
                            <button type="button" @click="open = !open"
                                class="flex items-center justify-between w-full py-4 text-sm font-semibold text-slate-700">
                                <span>Lokasi</span>
                                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-cloak class="pb-4 space-y-2 text-sm text-slate-500">
                                @foreach ($locations as $location)
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="radio" name="location" value="{{ $location }}"
                                            class="rounded-full text-blue-600 focus:ring-blue-500"
                                            {{ request('location') === $location ? 'checked' : '' }}
                                            onchange="document.getElementById('filterForm').submit()">
                                        <span
                                            class="group-hover:text-slate-900 transition-colors">{{ $location }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Filter Tipe Event --}}
                        <div x-data="{ open: {{ request('price') && request('price') !== 'free' ? 'true' : 'false' }} }" class="border-b border-gray-100">
                            <button type="button" @click="open = !open"
                                class="flex items-center justify-between w-full py-4 text-sm font-semibold text-slate-700">
                                <span>Tipe Event</span>
                                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-cloak class="pb-4 space-y-2 text-sm text-slate-500">
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="price" value="paid"
                                        class="rounded-full text-blue-600 focus:ring-blue-500"
                                        {{ request('price') === 'paid' ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()">
                                    <span class="group-hover:text-slate-900 transition-colors">Berbayar</span>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="price" value="free"
                                        class="rounded-full text-blue-600 focus:ring-blue-500"
                                        {{ request('price') === 'free' ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()">
                                    <span class="group-hover:text-slate-900 transition-colors">Gratis</span>
                                </label>
                            </div>
                        </div>

                        {{-- Filter Kategori --}}
                        <div x-data="{ open: {{ request('category') ? 'true' : 'false' }} }" class="border-b border-gray-100">
                            <button type="button" @click="open = !open"
                                class="flex items-center justify-between w-full py-4 text-sm font-semibold text-slate-700">
                                <span>Kategori</span>
                                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-cloak class="pb-4 space-y-2 text-sm text-slate-500">
                                @foreach ($categories as $category)
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="radio" name="category" value="{{ $category->slug }}"
                                            class="rounded-full text-blue-600 focus:ring-blue-500"
                                            {{ request('category') === $category->slug ? 'checked' : '' }}
                                            onchange="document.getElementById('filterForm').submit()">
                                        <span
                                            class="group-hover:text-slate-900 transition-colors">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Filter Waktu --}}
                        <div x-data="{ open: {{ request('time') ? 'true' : 'false' }} }" class="border-b border-gray-100">
                            <button type="button" @click="open = !open"
                                class="flex items-center justify-between w-full py-4 text-sm font-semibold text-slate-700">
                                <span>Waktu</span>
                                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-cloak class="pb-4 space-y-3 text-sm text-slate-500">
                                @foreach ([
        'today' => 'Hari Ini',
        'tomorrow' => 'Besok',
        'this_week' => 'Minggu Ini',
        'this_month' => 'Bulan Ini',
    ] as $value => $label)
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="radio" name="time" value="{{ $value }}"
                                            class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                            {{ request('time') === $value ? 'checked' : '' }}
                                            onchange="document.getElementById('filterForm').submit()">
                                        <span
                                            class="group-hover:text-slate-900 transition-colors">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </form>
            </aside>

            {{-- Main Content --}}
            <main class="flex-grow">

                {{-- Search & Sort Bar --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
                    <p class="text-sm text-slate-500 font-medium">
                        Menampilkan
                        <span class="text-slate-900 font-bold">{{ $events->firstItem() ?? 0 }} -
                            {{ $events->lastItem() ?? 0 }}</span>
                        dari total
                        <span class="text-slate-900 font-bold">{{ $events->total() }}</span> event
                    </p>

                    <div class="flex items-center space-x-3">
                        <form method="GET" action="{{ route('event.index') }}" id="sortForm">
                            {{-- Mempertahankan filter aktif saat sorting berubah --}}
                            @foreach (request()->except('sort', 'page') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach

                            <div class="relative">
                                <select name="sort" onchange="this.form.submit()"
                                    class="appearance-none bg-white border border-gray-200 text-slate-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block pl-3 pr-10 py-2.5 outline-none shadow-sm cursor-pointer">
                                    <option value="" {{ !request('sort') ? 'selected' : '' }}>Tampilkan Semua
                                    </option>
                                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>
                                        Terbaru</option>
                                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>
                                        Terlama</option>
                                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>
                                        Harga Termurah</option>
                                    <option value="price_desc"
                                        {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Termahal
                                    </option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Grid Event --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse ($events as $event)
                        @php
                            // Mengambil harga terendah dari tipe tiket yang aktif
                            $minPrice = $event->ticketTypes->where('is_active', true)->min('price');
                        @endphp
                        <a href="{{ route('event.show', $event->id) }}"
                            class="group h-full bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col">

                            {{-- Banner --}}
                            <div class="relative h-44 overflow-hidden">
                                <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop' }}"
                                    alt="{{ $event->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                                {{-- Kategori Badge --}}
                                <div
                                    class="absolute top-3 left-3 bg-gradient-to-r from-blue-500 to-indigo-500 px-2.5 py-1 rounded-full text-[9px] font-bold text-white uppercase shadow-lg">
                                    {{ $event->category->name ?? 'Uncategorized' }}
                                </div>
                            </div>

                            <div class="p-4 flex-grow flex flex-col justify-between">
                                <div class="space-y-1.5">
                                    <h4
                                        class="font-bold text-slate-900 text-base leading-tight line-clamp-2 group-hover:text-blue-600 transition-colors">
                                        {{ $event->title }}
                                    </h4>
                                    <p class="text-xs font-medium text-slate-400 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $event->start_date->format('d M Y') }}
                                    </p>
                                    <p class="text-base font-black text-slate-900">
                                        @if ($minPrice > 0)
                                            Rp{{ number_format($minPrice, 0, ',', '.') }}
                                        @else
                                            <span class="text-green-600">Gratis</span>
                                        @endif
                                    </p>
                                </div>

                                {{-- Creator Info --}}
                                <div class="pt-3 mt-3 border-t border-slate-100 flex items-center space-x-2.5">
                                    <div
                                        class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center text-[10px] font-bold text-blue-600 border border-blue-100 shadow-sm">
                                        <img src="{{ asset('storage/' . $event->creator->avatar) }}"
                                            alt="{{ $event->creator->name }}"
                                            class="w-full h-full object-cover rounded-full">
                                    </div>
                                    <span class="text-[10px] font-semibold text-slate-500 truncate">
                                        {{ $event->creator->name ?? 'Unknown Creator' }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @empty
                        {{-- Empty State --}}
                        <div
                            class="col-span-full text-center py-20 bg-white rounded-3xl border border-dashed border-gray-200">
                            <div
                                class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="font-bold text-xl text-slate-900">Tidak ada event ditemukan</p>
                            <p class="text-slate-500 mt-1 text-sm">Coba ubah filter atau kata kunci pencarian Anda.</p>
                            <a href="{{ route('event.index') }}"
                                class="mt-6 inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700">
                                Bersihkan semua filter
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($events->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $events->links() }}
                    </div>
                @endif

            </main>
        </div>
    </div>

    {{-- Script tambahan jika diperlukan (opsional karena sudah pakai Alpine.js) --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-app-layout>
