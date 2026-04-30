<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Success / Error Alert --}}
    @if (session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check text-emerald-600 text-sm"></i>
            </div>
            <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4 flex gap-3">
            <div class="w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fas fa-exclamation text-red-600 text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-red-700 mb-1">Terdapat kesalahan:</p>
                <ul class="list-disc pl-4 text-xs text-red-600 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="post" action="{{ route('member.profile.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('patch')

        {{-- Section: Avatar --}}
        <div class="bg-slate-50 rounded-2xl border border-slate-100 p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">

                {{-- Avatar Preview --}}
                <div class="relative group flex-shrink-0">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-white shadow-lg">
                        <img id="avatar-preview"
                            src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=1d4ed8&color=fff&size=200' }}"
                            class="w-full h-full object-cover" alt="{{ $user->name }}">
                    </div>
                    <label for="avatar-input"
                        class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-2xl opacity-0 group-hover:opacity-100 cursor-pointer transition-all">
                        <div class="text-center">
                            <i class="fas fa-camera text-white text-lg block mb-1"></i>
                            <span class="text-white text-[10px] font-bold">Ganti</span>
                        </div>
                    </label>
                    <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*"
                        onchange="previewImage(event)">
                </div>

                {{-- Info Avatar --}}
                <div class="flex-1">
                    <h3 class="text-sm font-black text-slate-800 mb-1">
                        {{ $user->name }} {{ $user->last_name }}
                    </h3>
                    <p class="text-xs text-slate-400 mb-3">
                        {{ $user->email }}
                    </p>
                    <label for="avatar-input"
                        class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-600 text-xs font-bold px-4 py-2 rounded-xl cursor-pointer hover:border-blue-400 hover:text-blue-600 transition-all">
                        <i class="fas fa-upload text-xs"></i>
                        Upload Foto Baru
                    </label>
                    <p class="text-[10px] text-slate-400 mt-2">JPG, PNG, WEBP — Maks. 1MB</p>
                </div>

                {{-- Stats --}}
                <div class="flex gap-4 sm:ml-auto">
                    <div class="text-center bg-white rounded-xl px-4 py-3 border border-slate-100 shadow-sm">
                        <p class="text-xl font-black text-slate-800">{{ $user->events()->count() }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Event Dibuat
                        </p>
                    </div>
                    <div class="text-center bg-white rounded-xl px-4 py-3 border border-slate-100 shadow-sm">
                        <p class="text-xl font-black text-slate-800">{{ $user->tickets()->count() }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Tiket Dibeli
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section: Informasi Akun --}}
        <div class="space-y-1">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Informasi Akun</h3>
            <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nama Depan --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                    Nama Depan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        placeholder="Nama depan"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 transition-colors placeholder-slate-300"
                        required>
                </div>
                @error('name')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Belakang --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                    Nama Belakang
                </label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}"
                    placeholder="Nama belakang (opsional)"
                    class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 transition-colors placeholder-slate-300">
                @error('last_name')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="space-y-2 md:col-span-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                    Email <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        placeholder="email@contoh.com"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 pl-11 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 transition-colors placeholder-slate-300"
                        required>
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-sm"></i>
                </div>
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="flex items-center gap-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                        <i class="fas fa-exclamation-triangle text-amber-500 text-sm flex-shrink-0"></i>
                        <div>
                            <p class="text-xs font-bold text-amber-700">Email belum diverifikasi.</p>
                            <button form="send-verification" class="text-xs text-blue-600 font-bold underline mt-0.5">
                                Kirim ulang email verifikasi
                            </button>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-emerald-500 text-xs"></i>
                        <p class="text-[10px] text-emerald-600 font-bold">Email terverifikasi</p>
                    </div>
                @endif
                @error('email')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Section: Informasi Pribadi --}}
        <div class="space-y-1 pt-2">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Informasi Pribadi</h3>
            <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nomor Ponsel --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                    Nomor Ponsel
                </label>
                <div
                    class="flex items-center border-2 border-slate-200 rounded-xl overflow-hidden focus-within:border-blue-500 transition-colors">
                    <div class="flex items-center gap-2 px-3 py-3 bg-slate-50 border-r border-slate-200 flex-shrink-0">
                        <img src="https://flagcdn.com/w20/id.png" class="w-4 h-3 rounded-sm" alt="ID">
                        <span class="text-sm font-bold text-slate-600">+62</span>
                    </div>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                        placeholder="812xxxx"
                        class="flex-1 px-4 py-3 text-sm font-semibold text-slate-700 outline-none bg-transparent placeholder-slate-300">
                </div>
                @error('phone')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jenis Kelamin --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                    Jenis Kelamin
                </label>
                <div class="flex gap-3">
                    <label
                        class="flex-1 flex items-center gap-3 border-2 rounded-xl px-4 py-3 cursor-pointer transition-all
                        {{ old('gender', $user->gender) === 'L' ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-slate-300' }}">
                        <input type="radio" name="gender" value="L"
                            {{ old('gender', $user->gender) === 'L' ? 'checked' : '' }}
                            class="text-blue-600 focus:ring-blue-500">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-mars text-blue-500 text-sm"></i>
                            <span class="text-sm font-bold text-slate-700">Laki-laki</span>
                        </div>
                    </label>
                    <label
                        class="flex-1 flex items-center gap-3 border-2 rounded-xl px-4 py-3 cursor-pointer transition-all
                        {{ old('gender', $user->gender) === 'P' ? 'border-pink-500 bg-pink-50' : 'border-slate-200 hover:border-slate-300' }}">
                        <input type="radio" name="gender" value="P"
                            {{ old('gender', $user->gender) === 'P' ? 'checked' : '' }}
                            class="text-pink-600 focus:ring-pink-500">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-venus text-pink-500 text-sm"></i>
                            <span class="text-sm font-bold text-slate-700">Perempuan</span>
                        </div>
                    </label>
                </div>
                @error('gender')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                    Tanggal Lahir
                </label>
                <div class="relative">
                    <input type="date" name="birth_date" id="birth_date"
                        value="{{ old('birth_date', $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '') }}"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 pl-11 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 transition-colors">
                    <i class="far fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-sm"></i>
                </div>
                @error('birth_date')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Member Sejak --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                    Member Sejak
                </label>
                <div class="relative">
                    <input type="text" value="{{ $user->created_at->translatedFormat('j M Y') }}"
                        class="w-full border-2 border-slate-100 rounded-xl px-4 py-3 pl-11 text-sm font-semibold text-slate-400 bg-slate-50 cursor-not-allowed"
                        readonly>
                    <i class="fas fa-shield-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-sm"></i>
                </div>
            </div>

        </div>

        {{-- Tombol Simpan --}}
        <div class="flex items-center justify-between pt-6 border-t border-slate-100">
            <p class="text-xs text-slate-400">
                <i class="fas fa-info-circle mr-1"></i>
                Field dengan tanda <span class="text-red-500 font-bold">*</span> wajib diisi
            </p>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg shadow-blue-200 transition-all flex items-center gap-2">
                <i class="fas fa-save text-sm"></i>
                Simpan Perubahan
            </button>
        </div>

    </form>
</section>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('avatar-preview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Highlight radio button saat dipilih
    document.querySelectorAll('input[name="gender"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('input[name="gender"]').forEach(r => {
                const label = r.closest('label');
                if (r.value === 'L') {
                    label.classList.toggle('border-blue-500', r.checked);
                    label.classList.toggle('bg-blue-50', r.checked);
                    label.classList.toggle('border-slate-200', !r.checked);
                } else {
                    label.classList.toggle('border-pink-500', r.checked);
                    label.classList.toggle('bg-pink-50', r.checked);
                    label.classList.toggle('border-slate-200', !r.checked);
                }
            });
        });
    });
</script>
