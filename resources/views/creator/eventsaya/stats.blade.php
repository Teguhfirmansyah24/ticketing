<x-creator-layout>
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-[1440px] mx-auto space-y-8">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 bg-gray-100/50 px-3 py-1 rounded-lg w-fit">
                <a href="{{ route('creator.eventsaya.index') }}"
                    class="text-[10px] font-bold text-gray-400 uppercase tracking-wider hover:text-blue-600 transition">
                    Event Saya
                </a>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Statistik Event</span>
            </div>

            {{-- Header Event --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="relative h-40 overflow-hidden">
                    <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=600' }}"
                        alt="{{ $event->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/30"></div>
                    <div class="absolute inset-0 flex items-center px-8 gap-6">
                        <div class="flex-1">
                            <span
                                class="bg-white/20 backdrop-blur text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest mb-3 inline-block">
                                {{ $event->category->name ?? 'Event' }}
                            </span>
                            <h1 class="text-white text-2xl font-black leading-tight mt-1">
                                {{ $event->title }}
                            </h1>
                            <p class="text-white/70 text-xs mt-2 flex items-center gap-4">
                                <span><i
                                        class="far fa-calendar-alt mr-1.5"></i>{{ $event->start_date->translatedFormat('j M Y, H:i') }}
                                    WIB</span>
                                <span><i class="fas fa-map-marker-alt mr-1.5"></i>{{ $event->venue }},
                                    {{ $event->location }}</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('event.show', $event->id) }}"
                                class="flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition">
                                <i class="fas fa-eye"></i> Lihat Event
                            </a>
                            {{-- {{ route('user.events.edit', $event->id) }} --}}
                            <a href=""
                                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-lg">
                                <i class="fas fa-edit"></i> Edit Event
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistik Utama --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-blue-600 text-sm"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tiket
                            Terjual</span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-light text-slate-800">{{ number_format($totalSold) }}</span>
                        <span class="text-sm text-slate-400">/ {{ number_format($totalQuota) }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full {{ $soldPercent >= 90 ? 'bg-red-500' : ($soldPercent >= 60 ? 'bg-orange-400' : 'bg-blue-500') }}"
                            style="width: {{ $soldPercent }}%"></div>
                    </div>
                    <p class="text-[10px] text-slate-400">{{ number_format($soldPercent, 1) }}% terjual</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-emerald-600 text-sm"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total
                            Pendapatan</span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold">Rp</p>
                        <p class="text-3xl font-light text-slate-800">
                            {{ number_format($totalRevenue, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center">
                            <i class="fas fa-credit-card text-purple-600 text-sm"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Transaksi</span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-light text-slate-800">{{ number_format($totalTransactions) }}</span>
                        <span class="text-sm text-slate-400">Berhasil</span>
                    </div>
                    @if ($pendingTransactions > 0)
                        <p class="text-[10px] text-amber-500 font-bold">
                            <i class="fas fa-clock mr-1"></i>{{ $pendingTransactions }} menunggu verifikasi
                        </p>
                    @endif
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center">
                            <i class="fas fa-users text-orange-600 text-sm"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pembeli
                            Unik</span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-light text-slate-800">{{ number_format($uniqueBuyers) }}</span>
                        <span class="text-sm text-slate-400">Orang</span>
                    </div>
                </div>

            </div>

            {{-- Statistik Per Jenis Tiket --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-white text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-slate-800">Statistik Per Jenis Tiket</h2>
                        <p class="text-xs text-slate-400">Rincian penjualan tiket per kategori</p>
                    </div>
                </div>

                <div class="divide-y divide-gray-50">
                    @foreach ($ticketStats as $stat)
                        <div class="p-6 flex flex-col md:flex-row md:items-center gap-6">
                            <div class="flex-1 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-black text-slate-800 uppercase text-sm">{{ $stat['name'] }}
                                        </h3>
                                        <p class="text-xs text-slate-400 mt-0.5">
                                            @if ($stat['price'] > 0)
                                                Rp{{ number_format($stat['price'], 0, ',', '.') }} / tiket
                                            @else
                                                Gratis
                                            @endif
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-black text-slate-800">
                                            {{ $stat['sold'] }} <span class="text-slate-400 font-medium text-sm">/
                                                {{ $stat['quota'] }}</span>
                                        </p>
                                        <p class="text-[10px] text-slate-400">tiket terjual</p>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <div class="w-full bg-slate-100 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-700
                                            {{ $stat['sold_percent'] >= 90 ? 'bg-red-500' : ($stat['sold_percent'] >= 60 ? 'bg-orange-400' : 'bg-blue-500') }}"
                                            style="width: {{ $stat['sold_percent'] }}%"></div>
                                    </div>
                                    <div class="flex justify-between text-[10px] text-slate-400">
                                        <span>{{ number_format($stat['sold_percent'], 1) }}% terjual</span>
                                        <span>{{ $stat['available'] }} tersisa</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-4 md:flex-col md:items-end md:gap-1">
                                <div class="bg-emerald-50 rounded-xl px-4 py-3 text-right border border-emerald-100">
                                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">
                                        Pendapatan</p>
                                    <p class="text-lg font-black text-emerald-700">
                                        Rp{{ number_format($stat['revenue'], 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Total --}}
                <div
                    class="px-6 py-5 bg-slate-50 border-t border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-black text-slate-500 uppercase tracking-widest">Total Keseluruhan</p>
                        <p class="text-sm text-slate-400 mt-0.5">{{ $totalSold }} dari {{ $totalQuota }} tiket
                            terjual</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total
                            Pendapatan</p>
                        <p class="text-2xl font-black text-slate-800">
                            Rp{{ number_format($totalRevenue, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Transaksi Terbaru --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-600 flex items-center justify-center">
                        <i class="fas fa-receipt text-white text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-slate-800">Transaksi Terbaru</h2>
                        <p class="text-xs text-slate-400">10 transaksi paling baru</p>
                    </div>
                </div>

                @if ($recentOrders->isEmpty())
                    <div class="p-12 text-center">
                        <i class="fas fa-receipt text-4xl text-slate-200 mb-3 block"></i>
                        <p class="text-slate-400 font-bold">Belum ada transaksi</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-100">
                                    <th
                                        class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        Order</th>
                                    <th
                                        class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        Pembeli</th>
                                    <th
                                        class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        Tiket</th>
                                    <th
                                        class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        Total</th>
                                    <th
                                        class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($recentOrders as $order)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <span class="text-xs font-black text-slate-700 font-mono">
                                                {{ $order->order_code }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-slate-700">
                                                        {{ $order->user->name }}</p>
                                                    <p class="text-[10px] text-slate-400">{{ $order->user->email }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="space-y-0.5">
                                                @foreach ($order->orderItems as $item)
                                                    <p class="text-xs text-slate-600 font-medium">
                                                        {{ $item->ticketType->name }} (x{{ $item->quantity }})
                                                    </p>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-xs font-black text-slate-800">
                                                Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($order->status === 'paid')
                                                <span
                                                    class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-[10px] font-black px-3 py-1 rounded-full uppercase">
                                                    Lunas
                                                </span>
                                            @elseif ($order->status === 'pending')
                                                <span
                                                    class="bg-amber-50 text-amber-600 border border-amber-100 text-[10px] font-black px-3 py-1 rounded-full uppercase">
                                                    Pending
                                                </span>
                                            @elseif ($order->status === 'cancelled')
                                                <span
                                                    class="bg-red-50 text-red-500 border border-red-100 text-[10px] font-black px-3 py-1 rounded-full uppercase">
                                                    Dibatalkan
                                                </span>
                                            @else
                                                <span
                                                    class="bg-slate-50 text-slate-500 border border-slate-100 text-[10px] font-black px-3 py-1 rounded-full uppercase">
                                                    {{ $order->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-xs text-slate-400 font-medium">
                                                {{ $order->created_at->translatedFormat('j M Y, H:i') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Footer --}}
            <div class="border-t border-gray-50 pt-8 flex justify-end">
                <p class="text-[10px] font-medium text-gray-400 tracking-wide">
                    © {{ date('Y') }} LOKÉT (PT Global Loket Sejahtera)
                </p>
            </div>

        </div>
    </div>
</x-creator-layout>
