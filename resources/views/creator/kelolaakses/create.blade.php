<x-creator-layout>
    <div class="p-4 sm:p-6 lg:p-8" x-data="{ openStatus: false, selectedStatus: '' }">
        <div class="max-w-[1440px] mx-auto space-y-8">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 bg-gray-100/50 px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <a href="{{ route('creator.kelolaakses.index') }}"
                    class="text-[10px] font-bold text-gray-400 uppercase tracking-wider hover:text-blue-600 transition">
                    Kelola Akses
                </a>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Undang</span>
            </div>

            {{-- Alert --}}
            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-2xl p-4 flex gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    <ul class="text-sm text-red-600 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li class="font-bold">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('creator.kelolaakses.store') }}" method="POST">
                @csrf

                {{-- Header: Kembali & Tombol Undang --}}
                <div class="flex items-center justify-between mb-8">
                    <a href="{{ route('creator.kelolaakses.index') }}"
                        class="inline-flex items-center justify-center w-10 h-10 border border-blue-600 rounded-xl text-blue-600 hover:bg-blue-50 transition shadow-sm">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-bold text-sm transition shadow-lg shadow-blue-200 active:scale-95 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-user-plus text-xs"></i>
                        Undang
                    </button>
                </div>

                {{-- Input Email & Peran --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-8">
                    <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
                            <i class="fas fa-user-plus text-white text-sm"></i>
                        </div>
                        <div>
                            <h2 class="font-black text-slate-800">Undang Anggota Tim</h2>
                            <p class="text-xs text-slate-400">Pengguna harus sudah terdaftar di LOKÉT</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                Email Pengguna <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i
                                    class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-sm"></i>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="contoh@email.com"
                                    class="w-full border-2 border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 transition placeholder-slate-300"
                                    required>
                            </div>
                            @error('email')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Peran --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                Peran <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="role"
                                    class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:border-blue-500 transition appearance-none bg-white cursor-pointer"
                                    required>
                                    <option value="" disabled selected>Pilih peran</option>
                                    <option value="check-in-crew"
                                        {{ old('role') === 'check-in-crew' ? 'selected' : '' }}>Check-in Crew</option>
                                    <option value="finance" {{ old('role') === 'finance' ? 'selected' : '' }}>
                                        Finance</option>
                                    <option value="operation" {{ old('role') === 'operation' ? 'selected' : '' }}>
                                        Operation</option>
                                    <option value="ticketing-kasir"
                                        {{ old('role') === 'ticketing-kasir' ? 'selected' : '' }}>Ticketing Kasir
                                    </option>
                                </select>
                                <i
                                    class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs pointer-events-none"></i>
                            </div>
                            @error('role')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Info peran --}}
                    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach ([['icon' => 'fa-qrcode', 'color' => 'blue', 'title' => 'Check-in Crew', 'desc' => 'Validasi tiket di venue'], ['icon' => 'fa-file-invoice-dollar', 'color' => 'emerald', 'title' => 'Finance', 'desc' => 'Kelola laporan & transaksi'], ['icon' => 'fa-tasks', 'color' => 'purple', 'title' => 'Operation', 'desc' => 'Atur detail & kuota event'], ['icon' => 'fa-cash-register', 'color' => 'orange', 'title' => 'Ticketing Kasir', 'desc' => 'Penjualan tiket on-the-spot']] as $peran)
                            <div
                                class="bg-{{ $peran['color'] }}-50 rounded-xl p-3 border border-{{ $peran['color'] }}-100">
                                <div class="flex items-center gap-2 mb-1">
                                    <i class="fas {{ $peran['icon'] }} text-{{ $peran['color'] }}-600 text-xs"></i>
                                    <p class="text-xs font-black text-{{ $peran['color'] }}-800">{{ $peran['title'] }}
                                    </p>
                                </div>
                                <p class="text-[10px] text-{{ $peran['color'] }}-600">{{ $peran['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Section Event --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div
                        class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-600 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-white text-sm"></i>
                            </div>
                            <div>
                                <h2 class="font-black text-slate-800">Akses Event</h2>
                                <p class="text-xs text-slate-400">Pilih event yang dapat diakses anggota ini</p>
                            </div>
                        </div>

                        {{-- Search & Filter --}}
                        <div class="flex items-center gap-3">
                            <div
                                class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 focus-within:border-blue-500 transition w-56">
                                <i class="fas fa-search text-slate-400 text-xs mr-2"></i>
                                <input type="text" id="eventSearch" placeholder="Cari event..."
                                    class="bg-transparent border-none text-sm outline-none w-full focus:ring-0 p-0"
                                    oninput="filterEvents(this.value)">
                            </div>

                            <div class="relative" x-data="{ open: false }">
                                <button type="button" @click="open = !open"
                                    class="flex items-center gap-2 border border-slate-200 bg-white text-slate-600 px-3 py-2 rounded-xl text-xs font-bold hover:border-blue-400 transition">
                                    <i class="fas fa-filter text-xs"></i>
                                    Filter
                                    <i class="fas fa-chevron-down text-[10px]" :class="open ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="open" @click.away="open = false" x-cloak
                                    class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-2xl shadow-xl z-20 p-2">
                                    @foreach (['all' => 'Semua Event', 'aktif' => 'Event Aktif', 'draft' => 'Event Draft', 'lalu' => 'Event Lalu'] as $val => $label)
                                        <a href="{{ route('creator.kelolaakses.create', array_merge(request()->except('event_status'), ['event_status' => $val === 'all' ? '' : $val])) }}"
                                            class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 rounded-xl cursor-pointer text-sm font-bold text-slate-700 transition
                                                {{ request('event_status', 'all') === $val ? 'text-blue-600 bg-blue-50' : '' }}">
                                            {{ $label }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tabel Event --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-100 bg-slate-50">
                                    <th class="py-4 px-6 w-10">
                                        <input type="checkbox" id="checkAll"
                                            class="rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                            onchange="toggleAll(this)">
                                    </th>
                                    <th class="py-4 px-6">Nama Event</th>
                                    <th class="py-4 px-6">Kategori</th>
                                    <th class="py-4 px-6">Tanggal Event</th>
                                    <th class="py-4 px-6">Kadaluarsa</th>
                                    <th class="py-4 px-6 text-center">Kapasitas</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50" id="eventTable">
                                @forelse ($events as $event)
                                    @php
                                        $totalQuota = $event->ticketTypes->sum('quota');
                                        $totalSold = $event->ticketTypes->sum('sold');
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition event-row"
                                        data-title="{{ strtolower($event->title) }}">
                                        <td class="py-4 px-6">
                                            <input type="checkbox" name="event_ids[]" value="{{ $event->id }}"
                                                class="event-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                                    <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=100' }}"
                                                        class="w-full h-full object-cover">
                                                </div>
                                                <div>
                                                    <p class="text-sm font-black text-slate-700 line-clamp-1">
                                                        {{ $event->title }}
                                                    </p>
                                                    <p class="text-xs text-slate-400">{{ $event->venue }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="text-xs font-bold text-slate-500">
                                                {{ $event->category->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-xs text-slate-500 font-medium">
                                            {{ $event->start_date->translatedFormat('j M Y, H:i') }}
                                        </td>
                                        <td class="py-4 px-6 text-xs text-slate-500 font-medium">
                                            {{ $event->end_date->translatedFormat('j M Y, H:i') }}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="space-y-1">
                                                <p class="text-xs font-bold text-slate-700">
                                                    {{ $totalSold }} / {{ $totalQuota }}
                                                </p>
                                                <div class="w-16 bg-slate-100 rounded-full h-1.5 mx-auto">
                                                    <div class="h-1.5 rounded-full bg-blue-500"
                                                        style="width: {{ $totalQuota > 0 ? ($totalSold / $totalQuota) * 100 : 0 }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if ($event->status === 'published' && $event->end_date >= now())
                                                <span
                                                    class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-[10px] font-black px-3 py-1 rounded-full uppercase">
                                                    Aktif
                                                </span>
                                            @elseif ($event->status === 'draft')
                                                <span
                                                    class="bg-slate-100 text-slate-500 border border-slate-200 text-[10px] font-black px-3 py-1 rounded-full uppercase">
                                                    Draft
                                                </span>
                                            @else
                                                <span
                                                    class="bg-gray-100 text-gray-500 border border-gray-200 text-[10px] font-black px-3 py-1 rounded-full uppercase">
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-16 text-center">
                                            <div
                                                class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-calendar-times text-3xl text-slate-300"></i>
                                            </div>
                                            <p class="font-bold text-slate-400">Belum ada event</p>
                                            <p class="text-xs text-slate-300 mt-1">
                                                Buat event terlebih dahulu sebelum mengundang anggota.
                                            </p>
                                            <a href="{{ route('user.events.create') }}"
                                                class="inline-flex items-center gap-2 mt-4 bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-xl">
                                                <i class="fas fa-plus"></i> Buat Event
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($events->hasPages())
                        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                            <p class="text-xs text-slate-400 font-medium">
                                Menampilkan {{ $events->firstItem() }} - {{ $events->lastItem() }}
                                dari {{ $events->total() }} event
                            </p>
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>

            </form>

        </div>

        {{-- Footer --}}
        <div class="mt-16 border-t border-slate-50 pt-8 flex justify-end">
            <p class="text-[10px] font-medium text-slate-300 tracking-wide uppercase">
                © {{ date('Y') }} LOKÉT (PT Global Loket Sejahtera)
            </p>
        </div>
    </div>

    <script>
        // Search event client-side
        function filterEvents(keyword) {
            const rows = document.querySelectorAll('.event-row');
            rows.forEach(row => {
                const title = row.dataset.title;
                row.style.display = title.includes(keyword.toLowerCase()) ? '' : 'none';
            });
        }

        // Check all checkbox
        function toggleAll(source) {
            const checkboxes = document.querySelectorAll('.event-checkbox');
            checkboxes.forEach(cb => cb.checked = source.checked);
        }

        // Uncheck "check all" jika salah satu di-uncheck
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.event-checkbox').forEach(cb => {
                cb.addEventListener('change', () => {
                    const all = document.querySelectorAll('.event-checkbox');
                    const checked = document.querySelectorAll('.event-checkbox:checked');
                    document.getElementById('checkAll').checked = all.length === checked.length;
                });
            });
        });
    </script>

</x-creator-layout>
