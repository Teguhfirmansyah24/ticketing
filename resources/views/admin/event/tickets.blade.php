<x-admin-layout>
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
    <h3 class="text-lg font-bold mb-4">Manajemen Tiket: {{ $event->title }}</h3>

    <!-- Form Tambah Tiket -->
    <form action="{{ route('admin.tickets.store', $event->id) }}" method="POST" class="grid grid-cols-4 gap-4 mb-8">
        @csrf
        <input type="text" name="name" placeholder="Nama Tiket (VIP/Reguler)" class="rounded-xl border-gray-200 text-sm">
        <input type="number" name="price" placeholder="Harga (0 jika gratis)" class="rounded-xl border-gray-200 text-sm">
        <input type="number" name="quota" placeholder="Jumlah Stok" class="rounded-xl border-gray-200 text-sm">
        <button type="submit" class="bg-blue-600 text-white rounded-xl px-4 py-2 text-sm font-bold hover:bg-blue-700">
            + Tambah Tiket
        </button>
    </form>
    <!-- Tabel List Tiket -->
    <table class="w-full text-left">
        <thead class="bg-gray-50 text-slate-500 text-xs uppercase">
            <tr>
                <th class="px-4 py-3">Nama Tiket</th>
                <th class="px-4 py-3">Harga</th>
                <th class="px-4 py-3">Stok</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($tickets as $ticket)
            <tr class="text-sm">
                <td class="px-4 py-4 font-medium">{{ $ticket->name }}</td>
                <td class="px-4 py-4">Rp{{ number_format($ticket->price, 0, ',', '.') }}</td>
                <td class="px-4 py-4">
                    <span class="px-2 py-1 {{ ($ticket->quota ?? 0) < 10 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }} rounded-lg font-bold">
                        {{ $ticket->quota ?? 0 }}
                    </span>
                </td>
                <td class="px-4 py-4 text-right">
                    <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-admin-layout>