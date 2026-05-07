<x-creator-layout>
    <div class="py-6" x-data="{ tipeLegal: 'individu' }">

        <div class="px-4 sm:px-6 lg:px-8 border-b border-slate-200 pb-4 mb-8">
            <div class="flex items-center gap-2 mb-6 bg-gray-100/50 px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <a href="{{ route('creator.legal.index') }}"
                    class="text-[10px] font-bold text-gray-400 uppercase tracking-wider hover:text-blue-600 transition">
                    Informasi Legal
                </a>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Buat</span>
            </div>

            <div class="flex justify-between items-center max-w-[1440px] mx-auto">
                <div class="flex items-center gap-4">
                    <a href="{{ route('creator.legal.index') }}"
                        class="inline-flex items-center justify-center w-10 h-10 border border-blue-600 rounded-xl text-blue-600 hover:bg-blue-50 transition shadow-sm">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </a>
                    <h2 class="text-2xl font-black text-slate-800">Informasi Legal</h2>
                </div>
                <div class="flex items-center gap-3 bg-slate-50 px-4 py-2 rounded-lg border border-slate-100">
                    <span class="text-xs font-bold text-slate-400 uppercase">Status</span>
                    <div class="h-4 w-px bg-slate-200"></div>
                    <span class="text-xs font-black text-red-500 uppercase tracking-wider">Belum Terverifikasi</span>
                </div>
            </div>
        </div>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto space-y-6">

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

                <form action="{{ route('creator.legal.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    {{-- Card: Individu --}}
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden transition-all duration-300"
                        :class="tipeLegal === 'individu' ? 'border-blue-300' : ''">

                        <label
                            class="flex items-center justify-between p-6 cursor-pointer hover:bg-slate-50/50 transition"
                            @click="tipeLegal = 'individu'">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="tipe_legal" value="individu" x-model="tipeLegal"
                                    class="w-5 h-5 text-blue-600 border-slate-300 focus:ring-blue-500">
                                <div>
                                    <span class="font-black text-slate-700 text-lg">Individu</span>
                                    <p class="text-xs text-slate-400 mt-0.5">KTP dan NPWP pribadi</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 transition-transform duration-300"
                                :class="tipeLegal === 'individu' ? 'rotate-180 text-blue-500' : ''"></i>
                        </label>

                        <div x-show="tipeLegal === 'individu'" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                            <div class="p-8 border-t border-slate-100 space-y-10">

                                {{-- Upload KTP & NPWP --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                    {{-- KTP --}}
                                    <div x-data="{ previewKtp: null }">
                                        <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:border-blue-400 hover:bg-blue-50/30 transition-all cursor-pointer group"
                                            onclick="document.getElementById('file_ktp').click()">
                                            <input type="file" id="file_ktp" name="file_ktp" class="hidden"
                                                accept="image/*,application/pdf"
                                                @change="previewKtp = $event.target.files[0]?.name">

                                            <template x-if="!previewKtp">
                                                <div>
                                                    <div
                                                        class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                                                        <i class="fas fa-id-card text-red-400 text-2xl"></i>
                                                    </div>
                                                    <p
                                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                                        Unggah dokumen KTP
                                                    </p>
                                                    <p class="text-[10px] text-slate-300 mt-1">JPG, PNG, PDF — Maks 2MB
                                                    </p>
                                                </div>
                                            </template>
                                            <template x-if="previewKtp">
                                                <div>
                                                    <i
                                                        class="fas fa-check-circle text-emerald-500 text-3xl mb-2 block"></i>
                                                    <p class="text-xs font-bold text-emerald-600" x-text="previewKtp">
                                                    </p>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="mt-4 space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                Nomor KTP <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="ktp_number" value="{{ old('ktp_number') }}"
                                                placeholder="16 digit nomor KTP" maxlength="16"
                                                class="w-full border-b-2 border-slate-200 py-2.5 outline-none focus:border-blue-500 transition font-mono tracking-wider text-sm placeholder-slate-300">
                                            @error('ktp_number')
                                                <p class="text-xs text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mt-4 space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                Nama Lengkap (sesuai KTP) <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="ktp_name"
                                                value="{{ old('ktp_name', auth()->user()->name) }}"
                                                class="w-full border-b-2 border-slate-200 py-2.5 outline-none focus:border-blue-500 transition font-semibold text-sm placeholder-slate-300 uppercase">
                                        </div>
                                        <div class="mt-4 space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                Alamat (sesuai KTP) <span class="text-red-500">*</span>
                                            </label>
                                            <textarea name="ktp_address" rows="2"
                                                class="w-full border-b-2 border-slate-200 py-2.5 outline-none focus:border-blue-500 transition font-semibold text-sm resize-none">{{ old('ktp_address') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- NPWP --}}
                                    <div x-data="{ previewNpwp: null }">
                                        <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:border-blue-400 hover:bg-blue-50/30 transition-all cursor-pointer group"
                                            onclick="document.getElementById('file_npwp').click()">
                                            <input type="file" id="file_npwp" name="individu_file_npwp"
                                                class="hidden" accept="image/*,application/pdf"
                                                @change="previewNpwp = $event.target.files[0]?.name">

                                            <template x-if="!previewNpwp">
                                                <div>
                                                    <div
                                                        class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                                                        <i class="fas fa-file-invoice text-amber-400 text-2xl"></i>
                                                    </div>
                                                    <p
                                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                                        Unggah dokumen NPWP
                                                    </p>
                                                    <p class="text-[10px] text-slate-300 mt-1">JPG, PNG, PDF — Maks 2MB
                                                        (opsional)</p>
                                                </div>
                                            </template>
                                            <template x-if="previewNpwp">
                                                <div>
                                                    <i
                                                        class="fas fa-check-circle text-emerald-500 text-3xl mb-2 block"></i>
                                                    <p class="text-xs font-bold text-emerald-600"
                                                        x-text="previewNpwp"></p>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="mt-4 space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                Nomor NPWP <span
                                                    class="text-slate-300 font-medium normal-case">(opsional)</span>
                                            </label>
                                            <input type="text" name="individu_npwp_number"
                                                value="{{ old('individu_npwp_number') }}"
                                                placeholder="15 digit nomor NPWP"
                                                class="w-full border-b-2 border-slate-200 py-2.5 outline-none focus:border-blue-500 transition font-mono tracking-wider text-sm placeholder-slate-300">
                                        </div>
                                        <div class="mt-4 space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                Nama (sesuai NPWP)
                                            </label>
                                            <input type="text" name="individu_npwp_name"
                                                value="{{ old('individu_npwp_name') }}"
                                                class="w-full border-b-2 border-slate-200 py-2.5 outline-none focus:border-blue-500 transition font-semibold text-sm uppercase">
                                        </div>
                                        <div class="mt-4 space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                Alamat (sesuai NPWP)
                                            </label>
                                            <textarea name="individu_npwp_address" rows="2"
                                                class="w-full border-b-2 border-slate-200 py-2.5 outline-none focus:border-blue-500 transition font-semibold text-sm resize-none">{{ old('individu_npwp_address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card: Badan Hukum --}}
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden transition-all duration-300"
                        :class="tipeLegal === 'badan_hukum' ? 'border-blue-300' : ''">

                        <label
                            class="flex items-center justify-between p-6 cursor-pointer hover:bg-slate-50/50 transition"
                            @click="tipeLegal = 'badan_hukum'">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="tipe_legal" value="badan_hukum" x-model="tipeLegal"
                                    class="w-5 h-5 text-blue-600 border-slate-300 focus:ring-blue-500">
                                <div>
                                    <span class="font-black text-slate-700 text-lg">Badan Hukum</span>
                                    <p class="text-xs text-slate-400 mt-0.5">NPWP perusahaan dan Anggaran Dasar</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 transition-transform duration-300"
                                :class="tipeLegal === 'badan_hukum' ? 'rotate-180 text-blue-500' : ''"></i>
                        </label>

                        <div x-show="tipeLegal === 'badan_hukum'"
                            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100">
                            <div class="p-8 border-t border-slate-100 space-y-10">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                                    {{-- NPWP Badan Hukum --}}
                                    <div x-data="{ previewNpwpBh: null }">
                                        <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:border-blue-400 hover:bg-blue-50/30 transition-all cursor-pointer group"
                                            onclick="document.getElementById('file_npwp_bh').click()">
                                            <input type="file" id="file_npwp_bh" name="file_npwp" class="hidden"
                                                accept="image/*,application/pdf"
                                                @change="previewNpwpBh = $event.target.files[0]?.name">

                                            <template x-if="!previewNpwpBh">
                                                <div>
                                                    <div
                                                        class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                                                        <i class="fas fa-file-invoice text-amber-400 text-2xl"></i>
                                                    </div>
                                                    <p
                                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                                        Unggah NPWP</p>
                                                    <p class="text-[10px] text-slate-300 mt-1">JPG, PNG, PDF — Maks 2MB
                                                    </p>
                                                </div>
                                            </template>
                                            <template x-if="previewNpwpBh">
                                                <div>
                                                    <i
                                                        class="fas fa-check-circle text-emerald-500 text-3xl mb-2 block"></i>
                                                    <p class="text-xs font-bold text-emerald-600"
                                                        x-text="previewNpwpBh"></p>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="mt-4 space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Nomor
                                                NPWP</label>
                                            <input type="text" name="npwp_number"
                                                value="{{ old('npwp_number') }}" placeholder="15 digit nomor NPWP"
                                                class="w-full border-b-2 border-slate-200 py-2.5 outline-none focus:border-blue-500 transition font-mono tracking-wider text-sm placeholder-slate-300">
                                        </div>
                                        <div class="mt-4 space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Nama
                                                (sesuai NPWP)</label>
                                            <input type="text" name="npwp_name" value="{{ old('npwp_name') }}"
                                                class="w-full border-b-2 border-slate-200 py-2.5 outline-none focus:border-blue-500 transition font-semibold text-sm uppercase">
                                        </div>
                                        <div class="mt-4 space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Alamat
                                                (sesuai NPWP)</label>
                                            <textarea name="npwp_address" rows="2"
                                                class="w-full border-b-2 border-slate-200 py-2.5 outline-none focus:border-blue-500 transition font-semibold text-sm resize-none">{{ old('npwp_address') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- Anggaran Dasar --}}
                                    <div x-data="{ previewDeed: null }">
                                        <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:border-blue-400 hover:bg-blue-50/30 transition-all cursor-pointer group"
                                            onclick="document.getElementById('file_deed').click()">
                                            <input type="file" id="file_deed" name="file_deed" class="hidden"
                                                accept="image/*,application/pdf"
                                                @change="previewDeed = $event.target.files[0]?.name">

                                            <template x-if="!previewDeed">
                                                <div>
                                                    <div
                                                        class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                                                        <i class="fas fa-file-contract text-blue-400 text-2xl"></i>
                                                    </div>
                                                    <p
                                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                                        Unggah Anggaran Dasar</p>
                                                    <p class="text-[10px] text-slate-300 mt-1">JPG, PNG, PDF — Maks 2MB
                                                    </p>
                                                </div>
                                            </template>
                                            <template x-if="previewDeed">
                                                <div>
                                                    <i
                                                        class="fas fa-check-circle text-emerald-500 text-3xl mb-2 block"></i>
                                                    <p class="text-xs font-bold text-emerald-600"
                                                        x-text="previewDeed"></p>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="mt-4 space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Nomor
                                                Anggaran Dasar</label>
                                            <input type="text" name="deed_number"
                                                value="{{ old('deed_number') }}" placeholder="Nomor dokumen"
                                                class="w-full border-b-2 border-slate-200 py-2.5 outline-none focus:border-blue-500 transition font-semibold text-sm placeholder-slate-300">
                                        </div>
                                        <div class="mt-4 space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Nama
                                                (sesuai Anggaran Dasar)</label>
                                            <input type="text" name="deed_name" value="{{ old('deed_name') }}"
                                                class="w-full border-b-2 border-slate-200 py-2.5 outline-none focus:border-blue-500 transition font-semibold text-sm uppercase">
                                        </div>
                                        <div class="mt-4 space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Alamat
                                                (sesuai Anggaran Dasar)</label>
                                            <textarea name="deed_address" rows="2"
                                                class="w-full border-b-2 border-slate-200 py-2.5 outline-none focus:border-blue-500 transition font-semibold text-sm resize-none">{{ old('deed_address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Form --}}
                    <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-6 space-y-4">
                        <p class="text-xs text-blue-700 leading-relaxed font-medium">
                            Harap perhatikan kesesuaian antara identitas pada KTP dan NPWP. Jika NPWP tidak diunggah,
                            Anda dianggap tidak memiliki NPWP.
                        </p>
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="agree" value="1" required
                                class="mt-1 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-xs text-slate-600 font-bold leading-relaxed">
                                Dengan ini saya menyatakan bahwa semua informasi yang disampaikan adalah benar dan dapat
                                dipertanggungjawabkan.
                            </span>
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-14 py-4 rounded-xl font-black text-xs shadow-xl shadow-blue-200 transition-all active:scale-95 uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-paper-plane text-xs"></i>
                            Kirim Informasi Legal
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <div class="mt-16 border-t border-slate-100 px-8 py-8 flex justify-end">
            <p class="text-[10px] font-black text-slate-300 tracking-widest uppercase">
                © {{ date('Y') }} LOKÉT (PT Global Loket Sejahtera)
            </p>
        </div>
    </div>
</x-creator-layout>
