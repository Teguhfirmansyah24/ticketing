<x-admin-layout>
    <div class="p-6">
        <div class="mb-6 flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-bold text-sky-800">Kelola Kategori</h1>
                <p class="text-sky-600/70 text-sm">Manajemen kategori untuk mengelompokkan data Anda.</p>
            </div>
            
            <a href="{{ route('admin.Kategori.create') }}" 
               class="bg-sky-600 hover:bg-sky-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-lg shadow-sky-100 flex items-center">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Kategori
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl shadow-sky-100/50 border border-sky-100 overflow-hidden">
            <div class="bg-sky-50/50 p-4 border-b border-sky-100 flex items-center">
                <i class="fa-solid fa-list-ul text-sky-600 mr-2"></i>
                <span class="font-bold text-sky-900 text-xs uppercase tracking-widest">Daftar Kategori</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-sky-600 text-white">
                        <tr>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Icon</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Nama Kategori</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Slug / Link</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Aktif</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sky-50">
                        @foreach ($categories as $category)
                        <tr class="hover:bg-sky-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-100 overflow-hidden flex items-center justify-center p-1 shadow-sm">
                                    @if($category->icon)
                                        <img src="{{ asset('storage/' . $category->icon) }}" 
                                             alt="{{ $category->name }}" 
                                             class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <i class="fa-solid fa-image text-sky-200"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-sky-900">{{ $category->name }}</div>
                                <div class="text-[10px] text-sky-500 italic line-clamp-1 max-w-[200px]">
                                    {{ $category->description ?? 'Tidak ada deskripsi' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-sky-50 text-sky-600 border border-sky-100 px-3 py-1 rounded-lg text-xs font-mono font-medium">
                                    /{{ $category->slug }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-sky-50 text-sky-600 border border-sky-100 px-3 py-1 rounded-lg text-xs font-mono font-medium">
                                    {{ $category->is_active }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.Kategori.edit', $category->id) }}" 
                                       class="text-sky-600 hover:text-sky-900 bg-sky-50 hover:bg-sky-100 p-2.5 rounded-xl transition-all"
                                       title="Edit Kategori">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <!-- Hapus -->
                                    <form action="{{ route('admin.Kategori.destroy', $category->id) }}" 
                                          method="post" 
                                          class="inline"
                                          onsubmit="return confirm('Hapus kategori ini juga akan berdampak pada data terkait. Lanjutkan?')">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" 
                                                class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2.5 rounded-xl transition-all"
                                                title="Hapus Kategori">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if($categories->isEmpty())
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-solid fa-folder-open text-sky-100 text-5xl mb-3"></i>
                                    <p class="text-gray-400 font-medium">Belum ada data kategori tersimpan.</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            <div class="p-5 bg-sky-50/30 border-t border-sky-100 flex justify-between items-center">
                <p class="text-[11px] font-bold text-sky-700 uppercase tracking-wider">Total: {{ $categories->count() }} Entri</p>
                
                {{-- $categories->links() --}}
            </div>
        </div>
    </div>
</x-admin-layout>