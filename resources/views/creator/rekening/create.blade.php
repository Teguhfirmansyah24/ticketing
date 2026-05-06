<x-creator-layout>
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-3xl mx-auto space-y-8">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 bg-gray-100/50 px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <a href="{{ route('creator.rekening.index') }}"
                    class="text-[10px] font-bold text-gray-400 uppercase tracking-wider hover:text-blue-600 transition">
                    Rekening
                </a>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Tambah</span>
            </div>

            {{-- Header --}}
            <div class="flex items-center gap-4 border-b border-slate-200 pb-6">
                <a href="{{ route('creator.rekening.index') }}"
                    class="inline-flex items-center justify-center w-10 h-10 border border-blue-600 rounded-xl text-blue-600 hover:bg-blue-50 transition shadow-sm">
                    <i class="fas fa-chevron-left text-xs"></i>
                </a>
                <div>
                    <h2 class="text-xl font-black text-slate-800">Tambah Rekening</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Pastikan data rekening sudah benar sebelum disimpan</p>
                </div>
            </div>

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-2xl p-4 flex gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5 flex-shrink-0"></i>
                    <ul class="text-sm text-red-600 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li class="font-bold">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('creator.rekening.store') }}" method="POST"
                class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                @csrf

                {{-- Header Form --}}
                <div class="px-8 py-5 border-b border-gray-100 flex items-center gap-3 bg-slate-800">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                        <i class="fas fa-university text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-white">Informasi Rekening Bank</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Data ini digunakan untuk pencairan hasil penjualan</p>
                    </div>
                </div>

                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Bank --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                Bank <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="bank_name" required
                                    class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:border-blue-500 transition outline-none appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Bank</option>
                                    @foreach ([
        'BCA' => 'Bank Central Asia (BCA)',
        'BRI' => 'Bank Rakyat Indonesia (BRI)',
        'BNI' => 'Bank Negara Indonesia (BNI)',
        'Mandiri' => 'Bank Mandiri',
        'CIMB' => 'CIMB Niaga',
        'Permata' => 'Bank Permata',
        'BTN' => 'Bank Tabungan Negara (BTN)',
        'Danamon' => 'Bank Danamon',
        'BSI' => 'Bank Syariah Indonesia (BSI)',
        'Jenius' => 'Jenius (BTPN)',
        'Lainnya' => 'Lainnya',
    ] as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('bank_name') === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <i
                                    class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                            </div>
                            @error('bank_name')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nama Pemilik --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                Nama Pemilik Rekening <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="account_name"
                                value="{{ old('account_name', auth()->user()->name) }}"
                                placeholder="Nama sesuai buku tabungan"
                                class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:border-blue-500 transition outline-none placeholder-slate-300 uppercase"
                                required>
                            @error('account_name')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nomor Rekening --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                Nomor Rekening <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="account_number" value="{{ old('account_number') }}"
                                placeholder="Contoh: 1234567890"
                                class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:border-blue-500 transition outline-none placeholder-slate-300 font-mono tracking-wider"
                                required>
                            @error('account_number')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kantor Cabang --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                Kantor Cabang <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="branch" value="{{ old('branch') }}"
                                placeholder="Contoh: KCP Bandung Dago"
                                class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:border-blue-500 transition outline-none placeholder-slate-300"
                                required>
                            @error('branch')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kota --}}
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                Kota <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="city" value="{{ old('city') }}"
                                placeholder="Kota pembukaan rekening"
                                class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:border-blue-500 transition outline-none placeholder-slate-300"
                                required>
                            @error('city')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Info --}}
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3">
                        <i class="fas fa-shield-alt text-amber-500 flex-shrink-0 mt-0.5"></i>
                        <p class="text-xs text-amber-700 leading-relaxed font-medium">
                            Data rekening kamu aman dan hanya digunakan untuk keperluan pencairan hasil penjualan tiket.
                            Pastikan nomor rekening dan nama pemilik sudah benar.
                        </p>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex items-center justify-end gap-4 pt-2">
                        <a href="{{ route('creator.rekening.index') }}"
                            class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-800 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-xl font-bold text-sm transition shadow-lg shadow-blue-200 active:scale-95 uppercase tracking-wide flex items-center gap-2">
                            <i class="fas fa-save text-xs"></i>
                            Simpan Rekening
                        </button>
                    </div>
                </div>
            </form>

        </div>

        {{-- Footer --}}
        <div class="mt-16 border-t border-slate-50 pt-8 flex justify-end">
            <p class="text-[10px] font-medium text-slate-300 tracking-wide uppercase">
                © {{ date('Y') }} LOKÉT (PT Global Loket Sejahtera)
            </p>
        </div>
    </div>
</x-creator-layout>
