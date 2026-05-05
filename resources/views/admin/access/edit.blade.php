<x-admin-layout>
    <div class="p-6 max-w-2xl mx-auto"> <!-- Ukuran max-w dikecilkan ke 2xl agar form tidak terlalu lebar saat memanjang ke bawah -->
        
        <!-- Breadcrumbs / Back Button -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-sky-800">Edit Data Akses</h1>
                <p class="text-sky-600/70 text-sm">Pastikan informasi yang diubah sudah benar sebelum menyimpan.</p>
            </div>
            <a href="{{ route('admin.access.index') }}" class="flex items-center text-sky-600 hover:text-sky-800 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-sky-100 overflow-hidden">
            <div class="bg-sky-600 p-4">
                <h3 class="text-white font-semibold flex items-center">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Formulir Perubahan Data
                </h3>
            </div>

            <form action="{{ route('admin.access.update', $user->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <!-- Container Vertikal -->
                <div class="flex flex-col space-y-6">
                    
                    <!-- Input Nama -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-sky-900">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                            class="w-full px-4 py-3 rounded-xl border border-sky-200 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all outline-none bg-sky-50/30 text-gray-700"
                            placeholder="Masukkan Nama...">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                  
                    <!-- Input Bagian/Role -->
                    <div class="space-y-2">
                        <label for="access" class="block text-sm font-semibold text-sky-900">Bagian / Role</label>
                        <div class="relative">
                            <select id="access" name="role" 
                                class="w-full px-4 py-3 rounded-xl border border-sky-200 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all outline-none bg-sky-50/30 text-gray-700 appearance-none">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                            <!-- Custom Arrow Icon untuk Select -->
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-sky-600">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-sky-50">
                    <button type="reset" class="px-6 py-2.5 rounded-xl text-sky-600 hover:bg-sky-50 font-medium transition-all">
                        Reset
                    </button>
                    <button type="submit" class="px-8 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-bold shadow-lg shadow-sky-200 transition-all flex items-center">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                    </button>
                </div> 
            </form>
        </div>
    </div>
</x-admin-layout>