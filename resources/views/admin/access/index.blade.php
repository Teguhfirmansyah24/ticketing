<x-admin-layout>
    <div class="p-6">
        <!-- Header Halaman -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-sky-800">Kelola Akses</h1>
            <p class="text-sky-600/70 text-sm">Manajemen izin akses pengguna dan konfigurasi sistem.</p>
        </div>

        <!-- Card Container -->
        <div class="bg-white rounded-xl shadow-md border border-sky-100 overflow-hidden">
            <!-- Table Action (Optional: Tombol Tambah dsb) -->
            <div class="bg-sky-50/50 p-4 border-b border-sky-100 flex justify-between items-center">
                <span class="font-semibold text-sky-900">Daftar yang memiliki akses terhadap web ini</span>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <form  method="post">
                    @csrf
                    @method('post')
                <table class="w-full text-left border-collapse">
                    <thead class="bg-sky-600 text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">Nama</th>
                            <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">Role</th>
                            <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sky-100">
                        @foreach ($users as $user)
                        <tr class="hover:bg-sky-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-700 font-medium">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sky-600">{{ $user->role }}</td>
                         <td class="px-6 py-4">
                            
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('admin.access.edit', $user->id) }}" 
                                class="text-sky-600 hover:text-sky-900 bg-sky-50 hover:bg-sky-100 p-2 rounded-lg transition-colors"
                                title="Edit User">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.access.destroy', $user->id) }}" 
                                    method="post" 
                                    class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors"
                                            title="Hapus User">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>
            </div>
            
            <div class="p-4 bg-gray-50 border-t border-sky-100 text-xs text-gray-500">
                Menampilkan 3 data akses terbaru.
            </div>
        </div>
    </div>
</x-admin-layout>