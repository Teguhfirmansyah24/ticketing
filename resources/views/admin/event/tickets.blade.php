<x-admin-layout>
    <div class="max-w-6xl mx-auto py-8 px-4">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-800">Manajemen Tiket: {{ $event->title }}</h3>
                <a href="{{ route('admin.event-admin') }}" class="text-sm text-gray-500 hover:text-blue-600">
                    &larr; Kembali ke Event
                </a>
            </div>

            <!-- Notifikasi Sukses/Error -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Tambah Tiket -->
            <div class="bg-gray-50 p-5 rounded-xl mb-8">
                <h4 class="text-sm font-semibold mb-3 text-slate-600">Tambah Jenis Tiket Baru</h4>
                <form action="{{ route('admin.tickets.store', $event->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @csrf
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Nama Tiket</label>
                        <input type="text" name="name" placeholder="Contoh: VIP / Reguler" 
                               class="w-full rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Harga (Rp)</label>
                        <input type="number" name="price" placeholder="0 untuk gratis" 
                               class="w-full rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Jumlah Stok</label>
                        <input type="number" name="stock" placeholder="Contoh: 100" 
                               class="w-full rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 text-white rounded-xl px-4 py-2.5 text-sm font-bold hover:bg-blue-700 transition-colors shadow-sm shadow-blue-200">
                            + Tambah Tiket
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel List Tiket -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Nama Tiket</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Harga</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Stok</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tickets as $ticket)
                        <tr class="text-sm hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-700">{{ $ticket->name }}</td>
                            <td class="px-6 py-4 text-slate-600">
                                @if($ticket->price == 0)
                                    <span class="text-green-600 font-bold uppercase text-xs">Gratis</span>
                                @else
                                    Rp{{ number_format($ticket->price, 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1.5 {{ $ticket->stock < 10 ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }} rounded-lg font-bold text-xs">
                                    {{ $ticket->stock }} Tersedia
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus tiket ini?');">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                                Belum ada jenis tiket yang dibuat untuk event ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>