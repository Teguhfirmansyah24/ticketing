<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @foreach ($events as $event)
        @php
            $minPrice = $event->ticketTypes->where('is_active', true)->min('price');
            $totalQuota = $event->ticketTypes->sum('quota');
            $totalSold = $event->ticketTypes->sum('sold');
            $soldPercent = $totalQuota > 0 ? ($totalSold / $totalQuota) * 100 : 0;
        @endphp

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col group">

            {{-- Banner --}}
            <div class="relative h-40 overflow-hidden">
                <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=600' }}"
                    alt="{{ $event->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                {{-- Badge Status --}}
                <div class="absolute top-3 left-3">
                    @if ($type === 'aktif')
                        <span
                            class="bg-emerald-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                            Aktif
                        </span>
                    @elseif ($type === 'draft')
                        <span
                            class="bg-slate-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                            Draft
                        </span>
                    @else
                        <span
                            class="bg-gray-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                            Selesai
                        </span>
                    @endif
                </div>

                {{-- Kategori --}}
                <div class="absolute top-3 right-3">
                    <span class="bg-white/20 backdrop-blur text-white text-[10px] font-bold px-2.5 py-1 rounded-full">
                        {{ $event->category->name ?? '-' }}
                    </span>
                </div>

                {{-- Tanggal --}}
                <div class="absolute bottom-3 left-4">
                    <p class="text-white text-xs font-bold">
                        <i class="far fa-calendar-alt mr-1.5"></i>
                        {{ $event->start_date->translatedFormat('j M Y') }}
                    </p>
                </div>
            </div>

            {{-- Konten --}}
            <div class="p-5 flex flex-col flex-1 space-y-4">
                <div>
                    <h3 class="font-black text-slate-800 leading-snug line-clamp-2">
                        {{ $event->title }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1 flex items-center gap-1.5">
                        <i class="fas fa-map-marker-alt text-blue-400"></i>
                        {{ $event->venue }}, {{ $event->location }}
                    </p>
                </div>

                {{-- Progress Tiket --}}
                @if ($totalQuota > 0)
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center text-[10px]">
                            <span class="font-bold text-slate-400 uppercase tracking-widest">Tiket Terjual</span>
                            <span class="font-black text-slate-700">{{ $totalSold }} / {{ $totalQuota }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full transition-all duration-500
                                {{ $soldPercent >= 90 ? 'bg-red-500' : ($soldPercent >= 60 ? 'bg-orange-400' : 'bg-blue-500') }}"
                                style="width: {{ $soldPercent }}%"></div>
                        </div>
                    </div>
                @endif

                {{-- Harga --}}
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Harga Mulai</p>
                        <p class="text-base font-black text-slate-800">
                            @if ($minPrice)
                                Rp{{ number_format($minPrice, 0, ',', '.') }}
                            @else
                                Gratis
                            @endif
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Pendapatan</p>
                        <p class="text-base font-black text-emerald-600">
                            Rp{{ number_format($event->ticketTypes->sum(fn($t) => $t->sold * $t->price), 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="mt-auto pt-3 border-t border-slate-50 flex items-center gap-2">
                    <a href="{{ route('event.show', $event->id) }}"
                        class="flex-1 flex items-center justify-center gap-2 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-bold py-2.5 rounded-xl transition-colors border border-slate-100">
                        <i class="fas fa-eye text-xs"></i>
                        Lihat
                    </a>
                    {{-- {{ route('user.events.edit', $event->id) }} --}}
                    <a href=""
                        class="flex-1 flex items-center justify-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold py-2.5 rounded-xl transition-colors border border-blue-100">
                        <i class="fas fa-edit text-xs"></i>
                        Edit
                    </a>
                    <a href="{{ route('creator.eventsaya.stats', $event->id) }}"
                        class="flex-1 flex items-center justify-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 text-xs font-bold py-2.5 rounded-xl transition-colors border border-emerald-100">
                        <i class="fas fa-chart-bar text-xs"></i>
                        Statistik
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
