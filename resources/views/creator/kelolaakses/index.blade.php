<x-creator-layout>
    <div class="p-4 sm:p-6 lg:p-8" x-data="{ showModalPeran: false, showModalUndang: false }">
        <div class="max-w-[1440px] mx-auto space-y-10">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 bg-gray-100/50 px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Kelola Akses</span>
            </div>

            {{-- ===== SECTION: PENGGUNA ===== --}}
            <div class="space-y-6">

                {{-- Header --}}
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <h2 class="text-xl font-black text-slate-800">Anggota Tim</h2>
                        <span class="bg-blue-100 text-blue-700 text-xs font-black px-3 py-1 rounded-full">
                            {{ $members->total() }} orang
                        </span>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <button @click="showModalPeran = true"
                            class="border border-blue-600 text-blue-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-blue-50 transition flex items-center gap-2">
                            <i class="fas fa-info-circle"></i> Info Peran
                        </button>
                        <a href="{{ route('creator.kelolaakses.create') }}">
                            <button
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg text-sm font-bold flex items-center gap-2 transition">
                                Undang <i class="fas fa-plus text-[10px]"></i>
                            </button>
                        </a>
                    </div>
                </div>

                {{-- Filter --}}
                <form method="GET" action="{{ route('creator.kelolaakses.index') }}"
                    class="bg-white border border-slate-100 rounded-2xl p-4 flex flex-wrap items-center gap-4 shadow-sm">
                    <div
                        class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 flex-1 min-w-48 focus-within:border-blue-500 transition">
                        <i class="fas fa-search text-slate-400 text-xs mr-2"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau email..."
                            class="bg-transparent border-none text-sm outline-none w-full focus:ring-0 p-0">
                    </div>

                    <select name="role" onchange="this.form.submit()"
                        class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-600 outline-none focus:border-blue-500 cursor-pointer">
                        <option value="">Semua Peran</option>
                        <option value="check-in-crew" {{ request('role') === 'check-in-crew' ? 'selected' : '' }}>
                            Check-in Crew</option>
                        <option value="finance" {{ request('role') === 'finance' ? 'selected' : '' }}>Finance
                        </option>
                        <option value="operation" {{ request('role') === 'operation' ? 'selected' : '' }}>
                            Operation</option>
                        <option value="ticketing-kasir" {{ request('role') === 'ticketing-kasir' ? 'selected' : '' }}>
                            Ticketing Kasir</option>
                    </select>

                    <select name="status" onchange="this.form.submit()"
                        class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-600 outline-none focus:border-blue-500 cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif
                        </option>
                    </select>

                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-blue-700 transition">
                        Cari
                    </button>

                    @if (request()->hasAny(['search', 'role', 'status']))
                        <a href="{{ route('creator.kelolaakses.index') }}"
                            class="text-xs font-bold text-red-400 hover:text-red-600 flex items-center gap-1">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </form>

                {{-- Tabel --}}
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-100 bg-slate-50">
                                    <th class="py-4 px-6">Nama</th>
                                    <th class="py-4 px-6">Email</th>
                                    <th class="py-4 px-6">Peran</th>
                                    <th class="py-4 px-6">Bergabung</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                    <th class="py-4 px-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse ($members as $member)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-9 h-9 rounded-xl overflow-hidden bg-blue-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                    @if ($member->user->avatar)
                                                        <img src="{{ asset('storage/' . $member->user->avatar) }}"
                                                            class="w-full h-full object-cover">
                                                    @else
                                                        {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                                    @endif
                                                </div>
                                                <span class="text-sm font-bold text-slate-700">
                                                    {{ $member->user->name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-sm text-slate-500">
                                            {{ $member->user->email }}
                                        </td>
                                        <td class="py-4 px-6">
                                            @php
                                                $roleColors = [
                                                    'check-in-crew' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                    'finance' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                    'operation' => 'bg-purple-50 text-purple-600 border-purple-100',
                                                    'ticketing-kasir' =>
                                                        'bg-orange-50 text-orange-600 border-orange-100',
                                                ];
                                                $roleLabels = [
                                                    'check-in-crew' => 'Check-in Crew',
                                                    'finance' => 'Finance',
                                                    'operation' => 'Operation',
                                                    'ticketing-kasir' => 'Ticketing Kasir',
                                                ];
                                            @endphp
                                            <span
                                                class="text-[10px] font-black px-3 py-1 rounded-full border uppercase
                                                {{ $roleColors[$member->role] ?? 'bg-slate-50 text-slate-500 border-slate-100' }}">
                                                {{ $roleLabels[$member->role] ?? $member->role }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-xs text-slate-400 font-medium">
                                            {{ $member->created_at->translatedFormat('j M Y') }}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <form action="{{ route('creator.kelolaakses.toggle', $member->id) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="text-[10px] font-black px-3 py-1 rounded-full border uppercase transition
                                                        {{ $member->status === 'active'
                                                            ? 'bg-emerald-50 text-emerald-600 border-emerald-100 hover:bg-red-50 hover:text-red-500 hover:border-red-100'
                                                            : 'bg-slate-100 text-slate-400 border-slate-200 hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-100' }}">
                                                    {{ $member->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <form action="{{ route('creator.kelolaakses.destroy', $member->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="text-xs text-red-400 hover:text-red-600 font-bold transition flex items-center gap-1 ml-auto">
                                                    <i class="fas fa-trash-alt text-xs"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-16 text-center">
                                            <div
                                                class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-users text-3xl text-slate-300"></i>
                                            </div>
                                            <p class="font-bold text-slate-400">Belum ada anggota tim</p>
                                            <p class="text-xs text-slate-300 mt-1">Undang anggota untuk membantu
                                                mengelola eventmu</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($members->hasPages())
                        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                            <p class="text-xs text-slate-400 font-medium">
                                Menampilkan {{ $members->firstItem() }} - {{ $members->lastItem() }}
                                dari {{ $members->total() }} anggota
                            </p>
                            {{ $members->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <hr class="border-slate-100">

            {{-- ===== SECTION: EVENT ===== --}}
            <div class="space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <h2 class="text-xl font-black text-slate-800">Event</h2>
                        <span class="bg-blue-100 text-blue-700 text-xs font-black px-3 py-1 rounded-full">
                            {{ $events->total() }} event
                        </span>
                    </div>
                </div>

                {{-- Filter Event --}}
                <form method="GET" action="{{ route('creator.kelolaakses.index') }}"
                    class="bg-white border border-slate-100 rounded-2xl p-4 flex flex-wrap items-center gap-4 shadow-sm"
                    x-data="{ openStatus: false }">

                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if (request('role'))
                        <input type="hidden" name="role" value="{{ request('role') }}">
                    @endif
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <div
                        class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 flex-1 min-w-48 focus-within:border-blue-500 transition">
                        <i class="fas fa-search text-slate-400 text-xs mr-2"></i>
                        <input type="text" name="event_search" value="{{ request('event_search') }}"
                            placeholder="Cari event..."
                            class="bg-transparent border-none text-sm outline-none w-full focus:ring-0 p-0">
                    </div>

                    <select name="event_status" onchange="this.form.submit()"
                        class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-600 outline-none focus:border-blue-500 cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('event_status') === 'aktif' ? 'selected' : '' }}>Event Aktif
                        </option>
                        <option value="draft" {{ request('event_status') === 'draft' ? 'selected' : '' }}>Event Draft
                        </option>
                        <option value="lalu" {{ request('event_status') === 'lalu' ? 'selected' : '' }}>Event Lalu
                        </option>
                    </select>

                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-blue-700 transition">
                        Cari
                    </button>
                </form>

                {{-- Tabel Event --}}
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-100 bg-slate-50">
                                    <th class="py-4 px-6">Nama Event</th>
                                    <th class="py-4 px-6">Kategori</th>
                                    <th class="py-4 px-6">Kapasitas</th>
                                    <th class="py-4 px-6">Tanggal</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse ($events as $event)
                                    @php
                                        $totalQuota = $event->ticketTypes->sum('quota');
                                        $totalSold = $event->ticketTypes->sum('sold');
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition">
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
                                        <td class="py-4 px-6">
                                            <div class="space-y-1">
                                                <p class="text-xs font-bold text-slate-700">
                                                    {{ $totalSold }} / {{ $totalQuota }}
                                                </p>
                                                <div class="w-24 bg-slate-100 rounded-full h-1.5">
                                                    <div class="h-1.5 rounded-full bg-blue-500"
                                                        style="width: {{ $totalQuota > 0 ? ($totalSold / $totalQuota) * 100 : 0 }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-xs text-slate-400 font-medium">
                                            {{ $event->start_date->translatedFormat('j M Y') }}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if ($event->status === 'published' && $event->end_date >= now())
                                                <span
                                                    class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-[10px] font-black px-3 py-1 rounded-full uppercase">Aktif</span>
                                            @elseif ($event->status === 'draft')
                                                <span
                                                    class="bg-slate-100 text-slate-500 border border-slate-200 text-[10px] font-black px-3 py-1 rounded-full uppercase">Draft</span>
                                            @else
                                                <span
                                                    class="bg-gray-100 text-gray-500 border border-gray-200 text-[10px] font-black px-3 py-1 rounded-full uppercase">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-16 text-center">
                                            <div
                                                class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-calendar-times text-3xl text-slate-300"></i>
                                            </div>
                                            <p class="font-bold text-slate-400">Belum ada event</p>
                                            <p class="text-xs text-slate-300 mt-1">Buat event untuk memulainya</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($events->hasPages())
                        <div class="px-6 py-4 border-t border-slate-100">
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- ===== MODAL: UNDANG ANGGOTA ===== --}}
        <div x-show="showModalUndang" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showModalUndang = false"></div>
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md relative z-10"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-black text-slate-800">Undang Anggota Tim</h3>
                    <button @click="showModalUndang = false" class="text-slate-400 hover:text-slate-600 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('creator.kelolaakses.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                            Email Pengguna <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" placeholder="email@contoh.com"
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 transition placeholder-slate-300"
                            required>
                        <p class="text-[10px] text-slate-400">Pengguna harus sudah terdaftar di LOKÉT</p>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                            Peran <span class="text-red-500">*</span>
                        </label>
                        <select name="role"
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:border-blue-500 transition bg-white cursor-pointer"
                            required>
                            <option value="">Pilih peran</option>
                            <option value="check-in-crew">Check-in Crew</option>
                            <option value="finance">Finance</option>
                            <option value="operation">Operation</option>
                            <option value="ticketing-kasir">Ticketing Kasir</option>
                        </select>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="showModalUndang = false"
                            class="flex-1 border-2 border-slate-200 text-slate-600 py-3 rounded-xl font-bold text-sm hover:bg-slate-50 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold text-sm transition shadow-lg shadow-blue-200">
                            Undang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== MODAL: INFO PERAN ===== --}}
        <div x-show="showModalPeran" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showModalPeran = false"></div>
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl relative z-10"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-black text-slate-800">Daftar Peran & Penjelasan</h3>
                    <button @click="showModalPeran = false" class="text-slate-400 hover:text-slate-600 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-6 max-h-[60vh] overflow-y-auto space-y-4">
                    @foreach ([['icon' => 'fa-qrcode', 'color' => 'blue', 'title' => 'Check-in Crew', 'desc' => 'Bertugas memvalidasi tiket pengunjung di lokasi acara menggunakan aplikasi pemindai.'], ['icon' => 'fa-file-invoice-dollar', 'color' => 'emerald', 'title' => 'Finance', 'desc' => 'Mengelola laporan penjualan, data transaksi, dan informasi rekening.'], ['icon' => 'fa-tasks', 'color' => 'purple', 'title' => 'Operation', 'desc' => 'Membantu pengaturan detail event dan manajemen kuota tiket.'], ['icon' => 'fa-cash-register', 'color' => 'orange', 'title' => 'Ticketing Kasir', 'desc' => 'Melayani pembelian tiket secara on-the-spot (OTS) dan mencetak bukti pembayaran.']] as $peran)
                        <div
                            class="p-4 bg-{{ $peran['color'] }}-50 rounded-xl border border-{{ $peran['color'] }}-100">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fas {{ $peran['icon'] }} text-{{ $peran['color'] }}-600"></i>
                                <h4 class="font-black text-{{ $peran['color'] }}-900">{{ $peran['title'] }}</h4>
                            </div>
                            <p class="text-sm text-{{ $peran['color'] }}-700 leading-relaxed">{{ $peran['desc'] }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="p-6 border-t border-slate-100 bg-slate-50 text-right">
                    <button @click="showModalPeran = false"
                        class="px-6 py-2.5 bg-slate-800 text-white rounded-xl font-bold text-sm hover:bg-slate-900 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-16 border-t border-slate-50 pt-8 flex justify-end">
            <p class="text-[10px] font-medium text-slate-300 tracking-wide uppercase">
                © {{ date('Y') }} LOKÉT (PT Global Loket Sejahtera)
            </p>
        </div>
    </div>
</x-creator-layout>
