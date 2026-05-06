<x-app-layout>
    <div class="bg-slate-50 min-h-screen">

        {{-- Banner --}}
        <div class="w-full h-48 md:h-64 bg-slate-900 relative">
            <img src="{{ asset('storage/' . $creator->avatar) }}" class="w-full h-full object-cover opacity-60"
                alt="Banner Background">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 -mt-16 relative z-10">

                {{-- Sidebar --}}
                <aside class="lg:col-span-3 space-y-6">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 text-center lg:text-left">

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

                        <h1 class="text-2xl font-black text-slate-900 leading-tight mb-2">
                            {{ $creator->name }}
                        </h1>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">
                            Member Sejak {{ $creator->created_at->translatedFormat('Y') }}
                        </p>

                        {{-- Statistik --}}
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <div class="bg-slate-50 rounded-xl p-3 text-center">
                                <p class="text-xl font-black text-slate-900">{{ $totalEvents }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Total Event</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3 text-center">
                                <p class="text-xl font-black text-slate-900">
                                    {{ \App\Models\Ticket::whereHas('event', fn($q) => $q->where('user_id', $creator->id))->where('status', 'active')->count() }}
                                </p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Tiket Terjual
                                </p>
                            </div>
                        </div>

                        {{-- Sosmed --}}
                        <div
                            class="pt-4 border-t border-slate-100 flex justify-center lg:justify-start gap-4 text-slate-300">
                            <a href="#" class="hover:text-pink-500 transition">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="hover:text-blue-600 transition">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                            <a href="#" class="hover:text-slate-900 transition">
                                <i class="fas fa-globe text-xl"></i>
                            </a>
                        </div>
                    </div>
                </aside>

                {{-- Main Content --}}
                <div class="lg:col-span-9 space-y-6 pb-20">

                    {{-- Tab & Sort --}}
                    <div x-data="{ tab: '{{ request('tab', 'active') }}' }">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-2">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <nav class="flex">
                                    <a href="{{ route('creator.show', ['id' => $creator->id, 'tab' => 'active', 'sort' => request('sort', 'nearest')]) }}"
                                        class="px-8 py-3 text-sm font-bold transition
                        {{ request('tab', 'active') === 'active'
                            ? 'text-blue-600 border-b-2 border-blue-600'
                            : 'text-slate-400 hover:text-slate-600' }}">
                                        Event Aktif
                                    </a>
                                    <a href="{{ route('creator.show', ['id' => $creator->id, 'tab' => 'past', 'sort' => request('sort', 'nearest')]) }}"
                                        class="px-8 py-3 text-sm font-bold transition
                        {{ request('tab') === 'past'
                            ? 'text-blue-600 border-b-2 border-blue-600'
                            : 'text-slate-400 hover:text-slate-600' }}">
                                        Event Lalu
                                    </a>
                                </nav>

                                <div class="flex items-center gap-3 px-4 pb-2 md:pb-0">
                                    <span class="text-xs font-bold text-slate-400 uppercase">Urutkan:</span>
                                    <form method="GET" action="{{ route('creator.show', $creator->id) }}"
                                        id="creatorForm">
                                        <input type="hidden" name="tab" value="{{ request('tab', 'active') }}">
                                        <select name="sort"
                                            onchange="document.getElementById('creatorForm').submit()"
                                            class="text-sm font-bold border-none bg-slate-50 rounded-lg focus:ring-0 cursor-pointer text-slate-700">
                                            <option value="nearest"
                                                {{ request('sort', 'nearest') === 'nearest' ? 'selected' : '' }}>
                                                Waktu Mulai (Terdekat)</option>
                                            <option value="price_asc"
                                                {{ request('sort') === 'price_asc' ? 'selected' : '' }}>
                                                Harga Terendah</option>
                                            <option value="price_desc"
                                                {{ request('sort') === 'price_desc' ? 'selected' : '' }}>
                                                Harga Tertinggi</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-sm font-medium text-slate-500">
                        Tampil <span class="text-slate-900 font-bold">{{ $events->total() }}</span>
                        dari total <span class="text-slate-900 font-bold">{{ $totalEvents }}</span> event
                    </p>

                    {{-- Grid Event --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @forelse ($events as $event)
                            @php
                                $minPrice = $event->ticketTypes->where('is_active', true)->min('price');
                            @endphp
                            <a href="{{ route('event.show', $event->id) }}"
                                class="group bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all overflow-hidden flex flex-col">

                                <div class="relative aspect-[4/3] overflow-hidden">
                                    <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop' }}"
                                        alt="{{ $event->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute top-4 left-4">
                                        <span
                                            class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase text-blue-600 shadow-sm">
                                            {{ $event->category->name ?? 'Event' }}
                                        </span>
                                    </div>
                                    {{-- Badge status --}}
                                    @if ($event->status === 'completed' || $event->end_date < now())
                                        <div class="absolute top-4 right-4">
                                            <span
                                                class="bg-slate-800/80 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase text-white shadow-sm">
                                                Selesai
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-6 flex flex-col flex-1 space-y-4">
                                    <div class="space-y-2">
                                        <h3
                                            class="font-bold text-slate-800 leading-snug group-hover:text-blue-600 transition line-clamp-2">
                                            {{ $event->title }}
                                        </h3>
                                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                                            <i class="far fa-calendar-alt text-blue-500"></i>
                                            <span>{{ $event->start_date->translatedFormat('j M Y') }}</span>
                                        </div>
                                    </div>

                                    <p class="text-xl font-black text-slate-900 mt-auto">
                                        @if ($minPrice)
                                            Rp{{ number_format($minPrice, 0, ',', '.') }}
                                        @else
                                            Gratis
                                        @endif
                                    </p>

                                    <hr class="border-slate-50">

                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full overflow-hidden border border-slate-100 flex-shrink-0">
                                            @if ($creator->avatar)
                                                <img src="{{ asset('storage/' . $creator->avatar) }}"
                                                    alt="{{ $creator->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                                    <span class="text-white font-bold text-[10px]">
                                                        {{ strtoupper(substr($creator->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <span
                                            class="text-xs font-bold text-slate-500 uppercase tracking-tighter truncate">
                                            {{ $creator->name }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-3 text-center py-20 text-slate-400">
                                <i class="fas fa-calendar-times text-4xl mb-4 opacity-30 block"></i>
                                <p class="font-semibold">
                                    Belum ada event {{ request('tab') === 'past' ? 'yang telah lewat' : 'aktif' }}.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if ($events->hasPages())
                        <div class="flex justify-center mt-8">
                            {{ $events->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
