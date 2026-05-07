<x-admin-layout>
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold">Manajemen Tiket: {{ $event->title }}</h3>
        <a href="{{ route('admin.event-admin') }}" class="text-sm text-gray-500 hover:text-blue-600">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Event
        </a>
    </div>

    <!-- Form Tambah Tiket -->
    <form action="{{ route('admin.tickets.store', $event->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 bg-slate-50 p-4 rounded-xl border border-slate-100">
        @csrf
        <div class="flex flex-col gap-1">
            <label class="text-[10px] font-bold uppercase text-slate-400 ml-1">Nama Tiket</label>
            <input type="text" name="name" placeholder="VIP / Reguler" class="rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[10px] font-bold uppercase text-slate-400 ml-1">Harga (Rp)</label>
            <input type="number" name="price" placeholder="Contoh: 150000" class="rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[10px] font-bold uppercase text-slate-400 ml-1">Kuota Awal</label>
            <input type="number" name="quota" placeholder="Contoh: 500" class="rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-blue-600 text-white rounded-xl px-4 py-2.5 text-sm font-bold hover:bg-blue-700 transition shadow-sm shadow-blue-200">
                <i class="fas fa-plus mr-1"></i> Tambah Tiket
            </button>
        </div>
    </form>

    <!-- Tabel List Tiket -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-semibold border-b border-gray-100">Nama Tiket</th>
                    <th class="px-6 py-4 font-semibold border-b border-gray-100">Harga</th>
                    <th class="px-6 py-4 font-semibold border-b border-gray-100 text-center">Terjual</th>
                    <th class="px-6 py-4 font-semibold border-b border-gray-100 text-center">Sisa Stok</th>
                    <th class="px-6 py-4 font-semibold border-b border-gray-100 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tickets as $ticket)
                @php
                    $remaining = $ticket->quota - $ticket->sold; // Logika Pengurangan Stok
                @endphp
                <tr class="text-sm hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-slate-700">{{ $ticket->name }}</td>
                    <td class="px-6 py-4 text-slate-600 font-medium">
                        {{ $ticket->price == 0 ? 'Gratis' : 'Rp' . number_format($ticket->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-slate-400 font-medium">{{ $ticket->sold }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{-- Warna berubah merah jika sisa stok sedikit (<= 5) --}}
                        <span class="px-3 py-1 rounded-lg font-bold {{ $remaining <= 5 ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}">
                            {{ $remaining }}
                        </span>
                        <span class="text-[10px] text-gray-400 ml-1">/ {{ $ticket->quota }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tiket ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 transition p-2">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">
                        Belum ada data tiket untuk event ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-admin-layout>