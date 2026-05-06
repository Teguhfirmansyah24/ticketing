<x-admin-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-sky-900">Tambah Kategori</h1>
                <p class="text-sky-600 text-sm">Input data kategori baru untuk konten landing page.</p>
            </div>
            <a href="{{ route('admin.Kategori.index') }}"
                class="group flex items-center text-sky-600 hover:text-sky-800 transition-all font-semibold text-sm">
                <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Kembali
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-sky-100/50 border border-sky-100 overflow-hidden">
            <div class="bg-sky-600 px-8 py-4">
                <h3 class="text-white font-bold flex items-center tracking-wide">
                    <i class="fa-solid fa-plus-circle mr-3"></i> FORM ENTRI KATEGORI
                </h3>
            </div>

            <form action="{{ route('admin.Kategori.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="p-8 space-y-7">
                @csrf

                <div>
                    <label for="category_name" class="block text-xs font-bold text-sky-900 uppercase tracking-widest mb-2 ml-1">Nama Kategori</label>
                    <input type="text" id="category_name" name="name" value="{{ old('name') }}"
                        class="w-full px-5 py-3.5 rounded-2xl border border-sky-100 bg-sky-50/20 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all placeholder:text-gray-300"
                        placeholder="Contoh: Perangkat Elektronik" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-2 ml-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_slug" class="block text-xs font-bold text-sky-900 uppercase tracking-widest mb-2 ml-1">Slug URL</label>
                    <input type="text" id="category_slug" name="slug" value="{{ old('slug') }}"
                        class="w-full px-5 py-3.5 rounded-2xl border border-sky-100 bg-sky-50/20 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all placeholder:text-gray-300"
                        placeholder="perangkat-elektronik">
                </div>

                <div>
                    <label for="category_description" class="block text-xs font-bold text-sky-900 uppercase tracking-widest mb-2 ml-1">Deskripsi Singkat</label>
                    <textarea id="category_description" name="description" rows="3"
                        class="w-full px-5 py-3.5 rounded-2xl border border-sky-100 bg-sky-50/20 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all placeholder:text-gray-300">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="category_icon" class="block text-xs font-bold text-sky-900 uppercase tracking-widest mb-2 ml-1">Icon Visual</label>
                    <div class="relative group">
                        <input type="file" id="category_icon" name="icon"
                            class="w-full px-5 py-3 border-2 border-dashed border-sky-100 rounded-2xl bg-sky-50/10 text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-sky-600 file:text-white hover:file:bg-sky-700 transition-all cursor-pointer">
                    </div>
                    
                    <div id="preview_container" class="mt-4 hidden animate-fadeIn">
                        <p class="text-[10px] font-bold text-sky-400 uppercase mb-2">Pratinjau Gambar:</p>
                        <img id="image_preview" class="w-24 h-24 object-cover rounded-2xl border-2 border-sky-100 shadow-sm">
                    </div>

                    @error('icon')
                        <p class="text-red-500 text-xs mt-2 ml-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between bg-gradient-to-r from-sky-50 to-white border border-sky-100 rounded-2xl p-5">
                    <div class="pr-4">
                        <p class="text-sm font-bold text-sky-900">Publikasikan</p>
                        <p class="text-[11px] text-sky-600 leading-tight">Aktifkan agar kategori muncul di halaman utama.</p>
                    </div>

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                        <div class="w-12 h-6 bg-gray-200 rounded-full peer peer-checked:bg-sky-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-6"></div>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <button type="reset"
                        class="px-6 py-3 rounded-xl text-sky-500 hover:text-sky-700 font-bold text-sm transition-colors">
                        RESET
                    </button>

                    <button type="submit"
                        class="px-10 py-3.5 bg-sky-600 hover:bg-sky-700 text-white rounded-2xl font-extrabold shadow-lg shadow-sky-200 hover:shadow-sky-300 hover:-translate-y-0.5 transition-all active:scale-95">
                        SIMPAN DATA
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const iconInput = document.getElementById('category_icon');
        const previewImg = document.getElementById('image_preview');
        const previewContainer = document.getElementById('preview_container');

        iconInput.addEventListener('change', function () {
            const [file] = this.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
                previewContainer.classList.remove('hidden');
            }
        });
    </script>
</x-admin-layout>