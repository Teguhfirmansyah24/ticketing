<x-creator-layout>
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-[1440px] mx-auto space-y-8">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 bg-gray-100/50 self-start px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Dashboard</span>
            </div>

            {{-- Section: Misi --}}
            <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-6 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <h3 class="text-sm font-bold text-slate-800">
                        Ayo selesaikan misi! Lengkapi akun profilmu.
                    </h3>
                    <div class="flex items-center gap-3 flex-1 max-w-md">
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-500"
                                style="width: {{ $missionsPercent }}%"></div>
                        </div>
                        <span class="text-xs font-bold text-slate-400 whitespace-nowrap">
                            {{ $missionsDone }} / {{ $missionsTotal }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- Misi 1: Verifikasi Nomor Ponsel --}}
                    <div
                        class="bg-white p-4 rounded-xl border flex items-center justify-between shadow-sm transition
                        {{ $missions['phone'] ? 'border-green-200 bg-green-50/30' : 'border-blue-100' }}">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg flex items-center justify-center
                                {{ $missions['phone'] ? 'bg-green-100' : 'bg-green-50' }}">
                                @if ($missions['phone'])
                                    <i class="fas fa-check text-green-600"></i>
                                @else
                                    <i class="fas fa-mobile-alt text-green-600"></i>
                                @endif
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-slate-600 leading-tight">
                                    Verifikasi Nomor<br>Ponselmu
                                </p>
                                @if ($missions['phone'])
                                    <span class="text-[10px] text-green-600 font-bold">Selesai ✓</span>
                                @endif
                            </div>
                        </div>
                        @if (!$missions['phone'])
                            <a href="{{ route('member.profile.edit') }}"
                                class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition">
                                Verifikasi
                            </a>
                        @endif
                    </div>

                    {{-- Misi 2: Lengkapi Profil --}}
                    <div
                        class="bg-white p-4 rounded-xl border flex items-center justify-between shadow-sm transition
                        {{ $missions['profile'] ? 'border-green-200 bg-green-50/30' : 'border-blue-100' }}">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg flex items-center justify-center
                                {{ $missions['profile'] ? 'bg-green-100' : 'bg-blue-50' }}">
                                @if ($missions['profile'])
                                    <i class="fas fa-check text-green-600"></i>
                                @else
                                    <i class="fas fa-user text-blue-600"></i>
                                @endif
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-slate-600 leading-tight">
                                    Lengkapi detail<br>informasi dasar
                                </p>
                                @if ($missions['profile'])
                                    <span class="text-[10px] text-green-600 font-bold">Selesai ✓</span>
                                @endif
                            </div>
                        </div>
                        @if (!$missions['profile'])
                            <a href="{{ route('member.profile.edit') }}"
                                class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition">
                                Lengkapi
                            </a>
                        @endif
                    </div>

                    {{-- Misi 3: Informasi Legal --}}
                    <div
                        class="bg-white p-4 rounded-xl border flex items-center justify-between shadow-sm transition
                        {{ $missions['legal'] ? 'border-green-200 bg-green-50/30' : 'border-blue-100' }}">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg flex items-center justify-center
                                {{ $missions['legal'] ? 'bg-green-100' : 'bg-cyan-50' }}">
                                @if ($missions['legal'])
                                    <i class="fas fa-check text-green-600"></i>
                                @else
                                    <i class="fas fa-file-contract text-cyan-600"></i>
                                @endif
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-slate-600 leading-tight">
                                    Lengkapi detail<br>informasi legal
                                </p>
                                @if ($missions['legal'])
                                    <span class="text-[10px] text-green-600 font-bold">Selesai ✓</span>
                                @endif
                            </div>
                        </div>
                        @if (!$missions['legal'])
                            <a href=""
                                class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition">
                                Lengkapi
                            </a>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Section: Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Event Aktif --}}
                <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2 text-slate-400">
                            <i class="fas fa-calendar-check text-sm"></i>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Event Aktif</span>
                        </div>
                        <a href="{{ route('creator.eventsaya.index') }}"
                            class="text-[10px] font-bold text-orange-500 hover:underline flex items-center gap-1">
                            Detail <i class="fas fa-external-link-alt text-[8px]"></i>
                        </a>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-light text-slate-800 tracking-tighter">
                            {{ $activeEvents }}
                        </span>
                        <span class="text-sm font-medium text-slate-400">Event</span>
                    </div>
                </div>

                {{-- Event Draft --}}
                <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2 text-slate-400">
                            <i class="fas fa-layer-group text-sm"></i>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Event Draft</span>
                        </div>
                        <a href="{{ route('creator.eventsaya.index') }}"
                            class="text-[10px] font-bold text-orange-500 hover:underline flex items-center gap-1">
                            Detail <i class="fas fa-external-link-alt text-[8px]"></i>
                        </a>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-light text-slate-800 tracking-tighter">
                            {{ $draftEvents }}
                        </span>
                        <span class="text-sm font-medium text-slate-400">Event</span>
                    </div>
                </div>

                {{-- Total Transaksi --}}
                <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2 text-slate-400">
                            <i class="fas fa-credit-card text-sm"></i>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Total Transaksi</span>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-light text-slate-800 tracking-tighter">
                            {{ number_format($totalTransactions, 0, ',', '.') }}
                        </span>
                        <span class="text-sm font-medium text-slate-400">Transaksi</span>
                    </div>
                </div>

                {{-- Total Tiket Terjual --}}
                <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2 text-slate-400">
                            <i class="fas fa-ticket-alt text-sm"></i>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Total Tiket Terjual</span>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-light text-slate-800 tracking-tighter">
                            {{ number_format($totalTicketsSold, 0, ',', '.') }}
                        </span>
                        <span class="text-sm font-medium text-slate-400">Tiket</span>
                    </div>
                </div>

                {{-- Total Penjualan --}}
                <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2 text-slate-400">
                            <i class="fas fa-money-bill-wave text-sm"></i>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Total Penjualan</span>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xl font-medium text-slate-400">Rp</span>
                        <span class="text-4xl font-light text-slate-800 tracking-tighter">
                            {{ number_format($totalRevenue, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Total Pengunjung --}}
                <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-2 text-slate-400">
                            <i class="fas fa-users text-sm"></i>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Total Pengunjung</span>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-light text-slate-800 tracking-tighter">
                            {{ number_format($totalVisitors, 0, ',', '.') }}
                        </span>
                        <span class="text-sm font-medium text-slate-400">Orang</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-creator-layout>
