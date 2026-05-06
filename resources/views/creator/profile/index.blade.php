<x-creator-layout>
    <div class="py-6" x-data="{
        alamat: '{{ old('address', auth()->user()->address) }}',
        tentang: '{{ old('about', auth()->user()->about) }}',
        totalAlamat: 150,
        totalTentang: 250,
    }">
        {{-- Header Full Width --}}
        <div class="px-4 sm:px-6 lg:px-8 border-b border-slate-200 pb-4 mb-8">
            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 mb-8 bg-gray-100/50 self-start px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Informasi Dasar</span>
            </div>

            <div class="flex justify-between items-center max-w-[1440px] mx-auto">
                <div class="flex items-center gap-6">
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Informasi Personal</h2>
                </div>
                <button form="creator-form" type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-2.5 rounded-xl font-bold text-xs transition shadow-lg shadow-blue-200 uppercase tracking-wider">
                    Simpan
                </button>
            </div>
        </div>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto">
                <form id="creator-form" action="{{ route('creator.profile.update') }}" method="POST"
                    enctype="multipart/form-data" class="space-y-12">
                    @csrf
                    @method('PUT')

                    {{-- Banner Upload --}}
                    <div x-data="{ previewBanner: '{{ auth()->user()->banner ? asset('storage/' . auth()->user()->banner) : '' }}' }"
                        class="relative border-2 border-dashed border-slate-200 rounded-2xl overflow-hidden hover:border-blue-400 transition-all cursor-pointer group"
                        style="height: 180px;" onclick="document.getElementById('bannerInput').click()">

                        <input type="file" id="bannerInput" name="banner" class="hidden" accept="image/*"
                            @change="
            const file = $event.target.files[0];
            if (file) previewBanner = URL.createObjectURL(file);
        ">

                        <template x-if="previewBanner">
                            <img :src="previewBanner" class="w-full h-full object-cover absolute inset-0">
                        </template>

                        <div class="absolute inset-0 flex flex-col items-center justify-center"
                            :class="previewBanner ? 'bg-black/40 opacity-0 group-hover:opacity-100' : 'bg-slate-50'">
                            <div
                                class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition">
                                <i class="fas fa-plus text-orange-500 text-2xl"></i>
                            </div>
                            <h4 class="font-bold mb-1" :class="previewBanner ? 'text-white' : 'text-slate-700'">
                                Unggah gambar/poster/banner
                            </h4>
                            <p class="text-sm" :class="previewBanner ? 'text-white/70' : 'text-slate-400'">
                                Direkomendasikan 1200×200px, maks 2MB
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-12">
                        {{-- Avatar Section --}}
                        <div class="w-full md:w-1/4 flex flex-col items-center">
                            <div class="relative group mb-6" x-data="{ previewAvatar: '{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : '' }}' }">
                                <div
                                    class="w-40 h-40 rounded-full overflow-hidden border-4 border-white shadow-xl bg-blue-100">
                                    <template x-if="previewAvatar">
                                        <img :src="previewAvatar" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!previewAvatar">
                                        <div
                                            class="w-full h-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                            <span class="text-white font-black text-5xl">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </template>
                                </div>
                                <label
                                    class="absolute bottom-2 right-2 bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center cursor-pointer border-4 border-white hover:bg-blue-700 transition shadow-lg">
                                    <i class="fas fa-camera text-sm"></i>
                                    <input type="file" name="avatar" class="hidden" accept="image/*"
                                        @change="
                    const file = $event.target.files[0];
                    if (file) previewAvatar = URL.createObjectURL(file);
                ">
                                </label>
                            </div>
                            <p class="text-[11px] text-slate-400 leading-relaxed text-center px-4">
                                Pastikan kamu mengunggah foto atau logo organizer karena akan ditampilkan di halaman
                                event kamu.
                            </p>
                        </div>

                        {{-- Main Fields --}}
                        <div class="flex-1 space-y-10">
                            {{-- Tautan Singkat --}}
                            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Tautan
                                        Singkat Profil</span>
                                    <div class="flex gap-4">
                                        <button type="button"
                                            onclick="navigator.clipboard.writeText('{{ url('/creators/' . auth()->user()->id) }}')"
                                            class="text-orange-500 text-[10px] font-bold uppercase hover:underline">
                                            Salin
                                        </button>
                                        <a href="{{ route('creator.index', auth()->user()->id) }}" target="_blank"
                                            class="text-orange-500 text-[10px] font-bold uppercase hover:underline">
                                            Lihat Profil <i class="fas fa-external-link-alt ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                                <div
                                    class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-500 font-mono">
                                    {{ url('/creators/' . auth()->user()->id) }}
                                </div>
                            </div>

                            {{-- Form Grid --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                                {{-- Nama Organizer --}}
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Nama
                                        Organizer <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ auth()->user()->name }}"
                                        class="w-full border-b-2 border-slate-100 py-2 outline-none focus:border-blue-500 transition-colors font-medium">
                                    <p class="text-[10px] text-slate-400">Nama kamu akan ditampilkan sebagai Nama
                                        Penyelenggara di halaman event kamu.</p>
                                </div>

                                {{-- Email --}}
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Email</label>
                                    <div class="flex items-center justify-between border-b-2 border-slate-100 py-2">
                                        <span class="font-medium text-slate-700">{{ auth()->user()->email }}</span>
                                        <span
                                            class="text-[10px] font-bold text-emerald-500 uppercase flex items-center gap-1">
                                            <i class="fas fa-check-circle"></i> Terverifikasi
                                        </span>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                        Nomor Ponsel <span class="text-red-500">*</span>
                                    </label>
                                    <div
                                        class="flex items-center border-b-2 border-slate-100 focus-within:border-blue-500 transition py-2 gap-2">
                                        <span class="text-sm font-bold text-slate-400">+62</span>
                                        <input type="tel" name="phone"
                                            value="{{ old('phone', auth()->user()->phone) }}" placeholder="812xxxx"
                                            class="w-full outline-none font-medium bg-transparent text-slate-700">
                                    </div>
                                </div>

                                {{-- Alamat --}}
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <label
                                            class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Alamat</label>
                                        <span class="text-[10px] text-slate-400 font-bold">
                                            Sisa karakter <span x-text="totalAlamat - alamat.length"></span>
                                        </span>
                                    </div>
                                    <textarea name="address" x-model="alamat" maxlength="150" rows="2" placeholder="Masukkan alamat organisasi..."
                                        class="w-full border-b-2 border-slate-100 py-2 outline-none focus:border-blue-500 transition-colors font-medium resize-none bg-transparent"></textarea>
                                </div>

                                {{-- Tentang Kami --}}
                                <div class="space-y-2 md:col-span-2">
                                    <div class="flex justify-between">
                                        <label
                                            class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Tentang
                                            Kami</label>
                                        <span class="text-[10px] text-slate-400 font-bold">
                                            Sisa karakter <span x-text="totalTentang - tentang.length"></span>
                                        </span>
                                    </div>
                                    <textarea name="about" x-model="tentang" maxlength="250" rows="3"
                                        placeholder="Ceritakan tentang organizer kamu..."
                                        class="w-full border-b-2 border-slate-100 py-2 outline-none focus:border-blue-500 transition-colors font-medium resize-none bg-transparent"></textarea>
                                </div>

                                {{-- Featured Event --}}
                                <div class="space-y-2 md:col-span-2">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Featured
                                        Event</label>
                                    <select name="featured_event_id"
                                        class="w-full border-b-2 border-slate-100 py-2 outline-none focus:border-blue-500 transition-colors font-medium bg-transparent cursor-pointer">
                                        <option value="">Pilih Event Unggulan</option>
                                        @foreach ($events as $event)
                                            <option value="{{ $event->id }}"
                                                {{ old('featured_event_id', auth()->user()->featured_event_id) == $event->id ? 'selected' : '' }}>
                                                {{ $event->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Twitter --}}
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Username
                                        Twitter</label>
                                    <div
                                        class="flex items-center gap-2 border-b-2 border-slate-100 focus-within:border-blue-500 transition py-2">
                                        <span class="text-slate-400 font-bold">@</span>
                                        <input type="text" name="twitter"
                                            value="{{ old('twitter', auth()->user()->twitter) }}"
                                            placeholder="username"
                                            class="w-full outline-none font-medium bg-transparent text-slate-700">
                                    </div>
                                </div>

                                {{-- Instagram --}}
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Username
                                        Instagram</label>
                                    <div
                                        class="flex items-center gap-2 border-b-2 border-slate-100 focus-within:border-blue-500 transition py-2">
                                        <span class="text-slate-400 font-bold">@</span>
                                        <input type="text" name="instagram"
                                            value="{{ old('instagram', auth()->user()->instagram) }}"
                                            placeholder="username"
                                            class="w-full outline-none font-medium bg-transparent text-slate-700">
                                    </div>
                                </div>

                                {{-- Facebook --}}
                                <div class="space-y-2 md:col-span-2">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Facebook
                                        URL</label>
                                    <div
                                        class="flex items-center gap-2 border-b-2 border-slate-100 focus-within:border-blue-500 transition py-2">
                                        <i class="fab fa-facebook text-blue-500"></i>
                                        <input type="url" name="facebook"
                                            value="{{ old('facebook', auth()->user()->facebook) }}"
                                            placeholder="https://facebook.com/nama-halaman"
                                            class="w-full outline-none font-medium bg-transparent text-slate-700">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Footer Branding --}}
        <div
            class="mt-20 border-t border-slate-100 px-8 py-8 flex justify-between items-center max-w-[1440px] mx-auto">
            <p class="text-[10px] font-bold text-slate-400 italic">Data yang kamu buat akan tampil di halaman profil
                kamu.</p>
            <p class="text-[10px] font-black text-slate-300 tracking-[0.2em] uppercase">
                © 2026 LOKET (PT Global Loket Sejahtera)
            </p>
        </div>
    </div>
</x-creator-layout>
