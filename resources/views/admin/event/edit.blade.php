<x-admin-layout>
    <div class="p-6 max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.event-admin') }}" 
                    class="text-sky-500 hover:text-sky-700 transition-colors">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h1 class="text-2xl font-extrabold text-sky-900">Edit Event</h1>
            </div>
            <p class="text-sky-600 text-sm">Perbarui informasi event yang sudah ada</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-sky-100/50 border border-sky-100 overflow-hidden">
            {{-- Header Card --}}
            <div class="bg-gradient-to-r from-sky-600 to-sky-500 px-8 py-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur">
                        <i class="fas fa-calendar-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-white font-bold text-lg">{{ $event->title }}</h2>
                        <p class="text-sky-100 text-sm">Edit informasi event di bawah ini</p>
                    </div>
                </div>
            </div>

            {{-- Form Body --}}
            <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                {{-- Judul Event --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-sky-600 uppercase tracking-wider">
                        <i class="fas fa-heading mr-2 text-xs"></i> Judul Event
                    </label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}" 
                        class="w-full rounded-xl border-sky-100 bg-sky-50/30 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all px-4 py-3"
                        placeholder="Masukkan judul event">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Lokasi --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-sky-600 uppercase tracking-wider">
                        <i class="fas fa-map-marker-alt mr-2 text-xs"></i> Lokasi
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-sky-300">
                            <i class="fas fa-location-dot"></i>
                        </span>
                        <input type="text" name="location" value="{{ old('location', $event->location) }}" 
                            class="w-full rounded-xl border-sky-100 bg-sky-50/30 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all pl-11 pr-4 py-3"
                            placeholder="Masukkan lokasi event">
                    </div>
                    @error('location')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-sky-600 uppercase tracking-wider">
                        <i class="fas fa-align-left mr-2 text-xs"></i> Deskripsi
                    </label>
                    <textarea name="description" rows="6" 
                        class="w-full rounded-xl border-sky-100 bg-sky-50/30 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all px-4 py-3 resize-none"
                        placeholder="Deskripsikan event secara lengkap...">{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-col sm:flex-row gap-3 justify-end pt-6 border-t border-sky-100">
                    <a href="{{ route('admin.event-admin') }}" 
                        class="px-6 py-3 rounded-xl text-sm font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-all text-center flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" 
                        class="bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white rounded-xl px-8 py-3 text-sm font-bold transition-all shadow-lg shadow-sky-200 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Update Event
                    </button>
                </div>
            </form>
        </div>

        {{-- Preview Card (Opsional) --}}
        <div class="mt-6 bg-sky-50/30 rounded-2xl p-4 border border-sky-100">
            <div class="flex items-center gap-3 text-sky-600">
                <i class="fas fa-info-circle text-sm"></i>
                <p class="text-xs font-medium">Pastikan data event sudah benar sebelum menyimpan perubahan.</p>
            </div>
        </div>
    </div>
</x-admin-layout>