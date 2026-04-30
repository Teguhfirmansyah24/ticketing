<x-creator-layout>
    <div class="p-4 sm:p-6 lg:p-8" x-data="{ activeTab: 'aktif' }">
        <div class="max-w-[1440px] mx-auto">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 mb-8 bg-gray-100/50 self-start px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Event Saya</span>
            </div>

            {{-- Search & Sort --}}
            <form method="GET" action="{{ route('creator.eventsaya.index') }}"
                class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">

                <div
                    class="flex items-center w-full max-w-lg bg-slate-50 border border-slate-200 rounded-xl p-1.5 focus-within:bg-white focus-within:ring-4 focus-within:ring-blue-500/10 focus-within:border-blue-500 transition-all duration-200">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Event Saya"
                        class="flex-grow bg-transparent border-none px-3 py-1.5 text-sm placeholder:text-slate-400 focus:ring-0 outline-none">
                    <button type="submit"
                        class="flex items-center justify-center w-9 h-9 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm shadow-blue-200 transition-all active:scale-95 shrink-0">
                        <i class="fas fa-search text-[13px]"></i>
                    </button>
                </div>

                <div class="flex items-center gap-3 self-end">
                    <span class="text-xs font-bold text-slate-500">Urutkan:</span>
                    <select name="sort" onchange="this.form.submit()"
                        class="bg-white border border-gray-200 text-slate-700 text-xs rounded-lg block p-2 font-medium focus:ring-blue-500">
                        <option value="nearest" {{ request('sort', 'nearest') === 'nearest' ? 'selected' : '' }}>
                            Waktu Mulai (Terdekat)
                        </option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>
                            Waktu Mulai (Terlama)
                        </option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>
                            Nama Event (A-Z)
                        </option>
                    </select>
                </div>
            </form>

            {{-- Tab Navigation --}}
            <div class="border-b border-gray-200 mb-8">
                <nav class="flex gap-8 justify-center sm:justify-start">
                    <button @click="activeTab = 'aktif'"
                        :class="activeTab === 'aktif'
                            ?
                            'border-blue-600 text-slate-900' :
                            'border-transparent text-slate-400 hover:text-slate-600'"
                        class="pb-4 px-4 border-b-2 font-bold text-[10px] uppercase tracking-widest transition-all flex items-center gap-2">
                        Event Aktif
                        @if ($activeEvents->count() > 0)
                            <span class="bg-blue-600 text-white text-[9px] font-black px-2 py-0.5 rounded-full">
                                {{ $activeEvents->count() }}
                            </span>
                        @endif
                    </button>
                    <button @click="activeTab = 'draft'"
                        :class="activeTab === 'draft'
                            ?
                            'border-blue-600 text-slate-900' :
                            'border-transparent text-slate-400 hover:text-slate-600'"
                        class="pb-4 px-4 border-b-2 font-bold text-[10px] uppercase tracking-widest transition-all flex items-center gap-2">
                        Event Draft
                        @if ($draftEvents->count() > 0)
                            <span class="bg-slate-400 text-white text-[9px] font-black px-2 py-0.5 rounded-full">
                                {{ $draftEvents->count() }}
                            </span>
                        @endif
                    </button>
                    <button @click="activeTab = 'lalu'"
                        :class="activeTab === 'lalu'
                            ?
                            'border-blue-600 text-slate-900' :
                            'border-transparent text-slate-400 hover:text-slate-600'"
                        class="pb-4 px-4 border-b-2 font-bold text-[10px] uppercase tracking-widest transition-all flex items-center gap-2">
                        Event Lalu
                        @if ($pastEvents->count() > 0)
                            <span class="bg-slate-400 text-white text-[9px] font-black px-2 py-0.5 rounded-full">
                                {{ $pastEvents->count() }}
                            </span>
                        @endif
                    </button>
                </nav>
            </div>

            {{-- Tab Contents --}}

            {{-- Event Aktif --}}
            <div x-show="activeTab === 'aktif'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

                @if ($activeEvents->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-calendar-plus text-4xl text-slate-300"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-800 mb-2">Belum ada event aktif</h4>
                        <p class="text-sm text-slate-400 mb-6">Silakan buat eventmu dengan klik button di bawah.</p>
                        <a href="{{ route('creator.create') }}"
                            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition flex items-center gap-2">
                            <i class="fas fa-plus text-sm"></i>
                            Buat Event
                        </a>
                    </div>
                @else
                    @include('creator.eventsaya._event_grid', [
                        'events' => $activeEvents,
                        'type' => 'aktif',
                    ])
                @endif
            </div>

            {{-- Event Draft --}}
            <div x-show="activeTab === 'draft'" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

                @if ($draftEvents->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-file-invoice text-4xl text-slate-300"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-800 mb-2">Belum ada draft event</h4>
                        <p class="text-sm text-slate-400">Draft event yang Anda simpan akan muncul di sini.</p>
                    </div>
                @else
                    @include('creator.eventsaya._event_grid', [
                        'events' => $draftEvents,
                        'type' => 'draft',
                    ])
                @endif
            </div>

            {{-- Event Lalu --}}
            <div x-show="activeTab === 'lalu'" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

                @if ($pastEvents->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-history text-4xl text-slate-300"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-800 mb-2">Riwayat event kosong</h4>
                        <p class="text-sm text-slate-400">Event yang telah selesai akan dipindahkan ke tab ini.</p>
                    </div>
                @else
                    @include('creator.eventsaya._event_grid', ['events' => $pastEvents, 'type' => 'lalu'])
                @endif
            </div>

            {{-- Footer --}}
            <div class="mt-16 border-t border-gray-50 pt-8 flex justify-end">
                <p class="text-[10px] font-medium text-gray-400 tracking-wide">
                    © {{ date('Y') }} LOKÉT (PT Global Loket Sejahtera)
                </p>
            </div>

        </div>
    </div>
</x-creator-layout>
