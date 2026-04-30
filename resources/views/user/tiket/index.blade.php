<x-user-layout>
    <div class="transition-all duration-300 ease-in-out w-full">
        <div x-data="{ activeTab: 'aktif' }" class="py-8 px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 mb-8 bg-gray-100/50 self-start px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Tiket Saya</span>
            </div>

            {{-- Tab Navigation --}}
            <div class="border-b border-gray-200 mb-10">
                <nav class="flex gap-8 sm:gap-12">
                    <button @click="activeTab = 'aktif'"
                        :class="activeTab === 'aktif'
                            ?
                            'text-slate-900 border-blue-600 border-b-4' :
                            'text-gray-400 border-transparent hover:text-gray-600'"
                        class="pb-4 px-2 text-sm font-bold transition-all relative top-[2px] whitespace-nowrap flex items-center gap-2">
                        Tiket Saya
                        @if ($activeTickets->count() > 0)
                            <span class="bg-blue-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full">
                                {{ $activeTickets->count() }}
                            </span>
                        @endif
                    </button>
                    <button @click="activeTab = 'lalu'"
                        :class="activeTab === 'lalu'
                            ?
                            'text-slate-900 border-blue-600 border-b-4' :
                            'text-gray-400 border-transparent hover:text-gray-600'"
                        class="pb-4 px-2 text-sm font-bold transition-all relative top-[2px] whitespace-nowrap flex items-center gap-2">
                        Tiket Lalu
                        @if ($pastTickets->count() > 0)
                            <span class="bg-slate-200 text-slate-600 text-[10px] font-black px-2 py-0.5 rounded-full">
                                {{ $pastTickets->count() }}
                            </span>
                        @endif
                    </button>
                </nav>
            </div>

            {{-- Tab Tiket Aktif --}}
            <div x-show="activeTab === 'aktif'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="w-full">

                @if ($activeTickets->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="mb-6 relative">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-ticket-alt text-5xl text-gray-300 rotate-[-15deg]"></i>
                            </div>
                            <div
                                class="absolute -bottom-2 -right-2 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm">
                                <i class="fas fa-search text-gray-300 text-xs"></i>
                            </div>
                        </div>
                        <h3 class="text-gray-500 text-base font-medium mb-2">
                            Kamu belum memiliki tiket aktif.
                        </h3>
                        <a href="{{ route('event.index') }}"
                            class="text-blue-600 font-bold hover:underline transition-all text-sm">
                            Cari Event Sekarang
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                        @foreach ($activeTickets as $ticket)
                            <a href="{{ route('user.tickets.show', $ticket->ticket_code) }}"
                                class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:shadow-lg transition-all duration-300">

                                {{-- Banner --}}
                                <div class="relative h-36 overflow-hidden">
                                    <img src="{{ $ticket->event->banner_image ? asset('storage/' . $ticket->event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=600' }}"
                                        alt="{{ $ticket->event->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                                    {{-- Badge Status --}}
                                    <div class="absolute top-3 right-3">
                                        <span
                                            class="bg-emerald-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                                            Aktif
                                        </span>
                                    </div>

                                    {{-- Kategori --}}
                                    <div class="absolute top-3 left-3">
                                        <span
                                            class="bg-white/20 backdrop-blur text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                            {{ $ticket->event->category->name ?? 'Event' }}
                                        </span>
                                    </div>

                                    {{-- Tanggal di atas gambar --}}
                                    <div class="absolute bottom-3 left-4">
                                        <p class="text-white text-xs font-bold">
                                            <i class="far fa-calendar-alt mr-1.5"></i>
                                            {{ $ticket->event->start_date->translatedFormat('j M Y, H:i') }} WIB
                                        </p>
                                    </div>
                                </div>

                                {{-- Konten --}}
                                <div class="p-5 flex flex-col flex-1 space-y-4">
                                    <div>
                                        <h3
                                            class="font-black text-slate-800 leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors">
                                            {{ $ticket->event->title }}
                                        </h3>
                                        <p class="text-xs text-slate-400 mt-1 flex items-center gap-1.5">
                                            <i class="fas fa-map-marker-alt text-blue-500"></i>
                                            {{ $ticket->event->venue }}, {{ $ticket->event->location }}
                                        </p>
                                    </div>

                                    <div class="pt-3 border-t border-slate-50 space-y-2">
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Jenis
                                                Tiket</span>
                                            <span
                                                class="text-xs font-bold text-slate-700">{{ $ticket->ticketType->name }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kode
                                                Tiket</span>
                                            <span
                                                class="text-xs font-bold text-slate-700 font-mono bg-slate-50 px-2 py-0.5 rounded">
                                                {{ substr($ticket->ticket_code, 0, 12) }}...
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Order</span>
                                            <span class="text-xs font-bold text-slate-700 font-mono">
                                                {{ $ticket->orderItem->order->order_code }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-auto">
                                        <div
                                            class="flex items-center justify-between bg-blue-50 rounded-xl px-4 py-3 border border-blue-100">
                                            <span class="text-xs font-bold text-blue-700">Lihat E-Tiket & QR Code</span>
                                            <i class="fas fa-chevron-right text-blue-400 text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Tab Tiket Lalu --}}
            <div x-show="activeTab === 'lalu'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                style="display: none;" class="w-full">

                @if ($pastTickets->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-history text-5xl text-gray-300"></i>
                        </div>
                        <h3 class="text-gray-500 text-base font-medium">
                            Tidak ada riwayat tiket dari event yang sudah lalu.
                        </h3>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                        @foreach ($pastTickets as $ticket)
                            <a href="{{ route('user.tickets.show', $ticket->ticket_code) }}"
                                class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col opacity-75 hover:opacity-100 transition-all duration-300">

                                {{-- Banner --}}
                                <div class="relative h-36 overflow-hidden">
                                    <img src="{{ $ticket->event->banner_image ? asset('storage/' . $ticket->event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=600' }}"
                                        alt="{{ $ticket->event->title }}" class="w-full h-full object-cover grayscale">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                                    {{-- Badge Status --}}
                                    <div class="absolute top-3 right-3">
                                        @if ($ticket->status === 'used')
                                            <span
                                                class="bg-slate-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                                                Sudah Dipakai
                                            </span>
                                        @elseif ($ticket->status === 'cancelled')
                                            <span
                                                class="bg-red-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                                                Dibatalkan
                                            </span>
                                        @else
                                            <span
                                                class="bg-slate-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                                                Selesai
                                            </span>
                                        @endif
                                    </div>

                                    <div class="absolute bottom-3 left-4">
                                        <p class="text-white text-xs font-bold">
                                            <i class="far fa-calendar-alt mr-1.5"></i>
                                            {{ $ticket->event->start_date->translatedFormat('j M Y') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Konten --}}
                                <div class="p-5 flex flex-col flex-1 space-y-4">
                                    <div>
                                        <h3 class="font-black text-slate-600 leading-snug line-clamp-2">
                                            {{ $ticket->event->title }}
                                        </h3>
                                        <p class="text-xs text-slate-400 mt-1 flex items-center gap-1.5">
                                            <i class="fas fa-map-marker-alt text-slate-400"></i>
                                            {{ $ticket->event->venue }}, {{ $ticket->event->location }}
                                        </p>
                                    </div>

                                    <div class="pt-3 border-t border-slate-50 space-y-2">
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Jenis
                                                Tiket</span>
                                            <span
                                                class="text-xs font-bold text-slate-500">{{ $ticket->ticketType->name }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kode
                                                Tiket</span>
                                            <span
                                                class="text-xs font-mono text-slate-500 bg-slate-50 px-2 py-0.5 rounded">
                                                {{ substr($ticket->ticket_code, 0, 12) }}...
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-auto">
                                        <div
                                            class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">
                                            <span class="text-xs font-bold text-slate-500">Lihat Detail Tiket</span>
                                            <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-user-layout>
