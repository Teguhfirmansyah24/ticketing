<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Sidebar Filter --}}
            <aside class="w-full lg:w-1/4 space-y-4">
                <form method="GET" action="{{ route('event.index') }}" id="filterForm">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">

                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-lg font-bold text-slate-900">Filter</h2>
                            <a href="{{ route('event.index') }}"
                                class="text-blue-600 hover:rotate-180 transition-transform duration-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </a>
                        </div>

                        {{-- Filter Harga --}}
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
                            <div x-show="open" class="pb-4 space-y-2 text-sm text-slate-500">
                                @foreach ($locations as $location)
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="radio" name="location" value="{{ $location }}"
                                            class="rounded text-blue-600"
                                            {{ request('location') === $location ? 'checked' : '' }}
                                            onchange="document.getElementById('filterForm').submit()">
                                        <span>{{ $location }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Filter Tipe / Harga --}}
                        <div x-data="{ open: {{ request('price') === 'paid' ? 'true' : 'false' }} }" class="border-b border-gray-100">
                            <button type="button" @click="open = !open"
                                class="flex items-center justify-between w-full py-4 text-sm font-semibold text-slate-700">
                                <span>Tipe Event</span>
                                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" class="pb-4 space-y-2 text-sm text-slate-500">
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" name="price" value="paid" class="rounded text-blue-600"
                                        {{ request('price') === 'paid' ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()">
                                    <span>Berbayar</span>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" name="price" value="free" class="rounded text-blue-600"
                                        {{ request('price') === 'free' ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()">
                                    <span>Gratis</span>
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
                            <div x-show="open" class="pb-4 space-y-2 text-sm text-slate-500">
                                @foreach ($categories as $category)
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="radio" name="category" value="{{ $category->slug }}"
                                            class="rounded text-blue-600"
                                            {{ request('category') === $category->slug ? 'checked' : '' }}
                                            onchange="document.getElementById('filterForm').submit()">
                                        <span>{{ $category->name }}</span>
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
                            <div x-show="open" class="pb-4 space-y-3 text-sm text-slate-500">
                                @foreach ([
        'today' => 'Hari Ini',
        'tomorrow' => 'Besok',
        'this_week' => 'Minggu Ini',
        'this_month' => 'Bulan Ini',
    ] as $value => $label)
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="radio" name="time" value="{{ $value }}"
                                            class="w-4 h-4 text-blue-600 border-gray-300"
                                            {{ request('time') === $value ? 'checked' : '' }}
                                            onchange="document.getElementById('filterForm').submit()">
                                        <span>{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </form>
            </aside>

            {{-- Main Content --}}
            <main class="flex-grow">

                {{-- Search & Sort --}}
                <form method="GET" action="{{ route('event.index') }}"
                    class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
                    @if (request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if (request('price'))
                        <input type="hidden" name="price" value="{{ request('price') }}">
                    @endif
                    @if (request('location'))
                        <input type="hidden" name="location" value="{{ request('location') }}">
                    @endif
                    @if (request('time'))
                        <input type="hidden" name="time" value="{{ request('time') }}">
                    @endif

                    <p class="text-sm text-slate-500 font-medium">
                        Menampilkan
                        <span class="text-slate-900 font-bold">{{ $events->firstItem() ?? 0 }} -
                            {{ $events->lastItem() ?? 0 }}</span>
                        dari total
                        <span class="text-slate-900 font-bold">{{ $events->total() }}</span> event
                    </p>

                    <div class="flex items-center space-x-3">
                        {{-- Sort --}}
                        <div class="relative">
                            <select name="sort" onchange="this.form.submit()"
                                class="appearance-none bg-white border border-gray-200 text-slate-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block pl-3 pr-10 py-2.5 outline-none shadow-sm cursor-pointer">
                                <option value="" {{ !request('sort') ? 'selected' : '' }}>
                                    Tampilkan Semua</option>
                                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>
                                    Terbaru</option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>
                                    Terlama</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>
                                    Harga Termurah</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>
                                    Harga Termahal</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Grid Event --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse ($events as $event)
                        @php
                            $minPrice = $event->ticketTypes->where('is_active', true)->min('price');
                        @endphp
                        <a href="{{ route('event.show', $event->id) }}"
                            class="group h-full bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col">
                            <div class="relative h-44 overflow-hidden">
                                <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop' }}"
                                    alt="{{ $event->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div
                                    class="absolute top-3 left-3 bg-gradient-to-r from-blue-500 to-indigo-500 px-2.5 py-1 rounded-full text-[9px] font-bold text-white uppercase">
                                    {{ $event->category->name ?? '-' }}
                                </div>
                            </div>

                            <div class="p-4 flex-grow flex flex-col justify-between">
                                <div class="space-y-1.5">
                                    <h4
                                        class="font-bold text-slate-900 text-base leading-tight line-clamp-2 group-hover:text-blue-600 transition-colors">
                                        {{ $event->title }}
                                    </h4>
                                    <p class="text-xs font-medium text-slate-400">
                                        {{ $event->start_date->format('d M Y') }}
                                    </p>
                                    <p class="text-base font-black text-slate-900">
                                        @if ($minPrice)
                                            Rp{{ number_format($minPrice, 0, ',', '.') }}
                                        @else
                                            Gratis
                                        @endif
                                    </p>
                                </div>

                                <div class="pt-3 mt-3 border-t border-slate-100 flex items-center space-x-2.5">
                                    <div
                                        class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center text-[10px] font-bold text-blue-600 border border-blue-100">
                                        {{ strtoupper(substr($event->creator->name, 0, 1)) }}
                                    </div>
                                    <span class="text-[10px] font-semibold text-slate-500 truncate">
                                        {{ $event->creator->name }}
                                    </span>
                                </div>
                            </div>
                        </a>

                    @empty
                        <div class="col-span-3 text-center py-20 text-slate-400">
                            <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="font-semibold text-lg">Tidak ada event ditemukan</p>
                            <p class="text-sm mt-1">Coba ubah filter atau kata kunci pencarian</p>
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
</x-app-layout>
