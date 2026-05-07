<x-creator-layout>
    <div class="py-6">
        <div class="px-4 sm:px-6 lg:px-8 border-b border-slate-200 pb-4 mb-8">
            <div class="flex items-center gap-2 mb-6 bg-gray-100/50 px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Informasi Legal</span>
            </div>

            <div class="flex justify-between items-center max-w-[1440px] mx-auto">
                <h2 class="text-2xl font-black text-slate-800">Informasi Legal</h2>
                @if (!$latest || $latest->status === 'rejected')
                    <a href="{{ route('creator.legal.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-bold text-xs transition shadow-lg shadow-blue-200 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-plus text-xs"></i>
                        Buat Dokumen
                    </a>
                @endif
            </div>
        </div>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto space-y-6">

                {{-- Alert --}}
                @if (session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center gap-3">
                        <i class="fas fa-check-circle text-emerald-500"></i>
                        <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
                    </div>
                @endif

                {{-- Status Card --}}
                <div
                    class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm flex flex-col md:flex-row items-center gap-8">
                    @if (!$latest)
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-alt text-3xl text-slate-400"></i>
                        </div>
                        <div class="flex-1 text-center md:text-left space-y-2">
                            <h3 class="text-xl font-black text-slate-800">
                                Status Verifikasi: <span class="text-slate-400">Belum Ada Dokumen</span>
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed">
                                Kamu belum mengunggah dokumen legal. Klik "Buat Dokumen" untuk memulai proses
                                verifikasi.
                            </p>
                        </div>
                    @elseif ($latest->status === 'pending')
                        <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-3xl text-amber-500"></i>
                        </div>
                        <div class="flex-1 text-center md:text-left space-y-2">
                            <h3 class="text-xl font-black text-slate-800">
                                Status Verifikasi: <span class="text-amber-500">Menunggu Verifikasi</span>
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed">
                                Dokumen kamu sedang ditinjau oleh tim kami. Proses verifikasi membutuhkan waktu 1-3 hari
                                kerja.
                            </p>
                        </div>
                    @elseif ($latest->status === 'verified')
                        <div
                            class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check-circle text-3xl text-emerald-500"></i>
                        </div>
                        <div class="flex-1 text-center md:text-left space-y-2">
                            <h3 class="text-xl font-black text-slate-800">
                                Status Verifikasi: <span class="text-emerald-500">Terverifikasi</span>
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed">
                                Akun kamu telah terverifikasi dan dapat melakukan penarikan saldo penjualan.
                            </p>
                        </div>
                    @else
                        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-times-circle text-3xl text-red-500"></i>
                        </div>
                        <div class="flex-1 text-center md:text-left space-y-2">
                            <h3 class="text-xl font-black text-slate-800">
                                Status Verifikasi: <span class="text-red-500">Ditolak</span>
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed">
                                Dokumen kamu ditolak.
                                @if ($latest->notes)
                                    Alasan: <span class="font-bold text-red-600">{{ $latest->notes }}</span>
                                @endif
                                Silakan unggah ulang dokumen yang benar.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- List Dokumen --}}
                @if ($latest)
                    <div class="space-y-4">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest">Dokumen Tersimpan</h4>

                        @if ($latest->type === 'individu')

                            {{-- KTP --}}
                            <div
                                class="flex items-center justify-between p-5 bg-white border border-slate-100 rounded-2xl group hover:border-blue-200 transition">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center group-hover:bg-red-100 transition">
                                        <i class="fas fa-id-card text-red-400 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">Kartu Tanda Penduduk (KTP)</p>
                                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">
                                            {{ $latest->ktp_name }} — {{ $latest->ktp_number }}
                                        </p>
                                        <p class="text-[10px] text-slate-300 font-medium">
                                            Diunggah {{ $latest->created_at->translatedFormat('j M Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if ($latest->ktp_file)
                                        <a href="{{ asset('storage/' . $latest->ktp_file) }}" target="_blank"
                                            class="text-[10px] font-bold text-blue-500 hover:underline">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                    @endif
                                    @include('creator.legal._status_badge', ['status' => $latest->status])
                                </div>
                            </div>

                            {{-- NPWP --}}
                            @if ($latest->npwp_number || $latest->npwp_file)
                                <div
                                    class="flex items-center justify-between p-5 bg-white border border-slate-100 rounded-2xl group hover:border-blue-200 transition">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition">
                                            <i class="fas fa-file-invoice-dollar text-amber-400 text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700">NPWP</p>
                                            <p class="text-[10px] text-slate-400 font-medium mt-0.5">
                                                {{ $latest->npwp_name ?? '-' }} — {{ $latest->npwp_number ?? '-' }}
                                            </p>
                                            <p class="text-[10px] text-slate-300 font-medium">
                                                Diunggah {{ $latest->created_at->translatedFormat('j M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        @if ($latest->npwp_file)
                                            <a href="{{ asset('storage/' . $latest->npwp_file) }}" target="_blank"
                                                class="text-[10px] font-bold text-blue-500 hover:underline">
                                                <i class="fas fa-eye mr-1"></i> Lihat
                                            </a>
                                        @endif
                                        @include('creator.legal._status_badge', [
                                            'status' => $latest->status,
                                        ])
                                    </div>
                                </div>
                            @endif
                        @else
                            {{-- NPWP Badan Hukum --}}
                            <div
                                class="flex items-center justify-between p-5 bg-white border border-slate-100 rounded-2xl group hover:border-blue-200 transition">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition">
                                        <i class="fas fa-file-invoice text-amber-400 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">NPWP Badan Hukum</p>
                                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">
                                            {{ $latest->npwp_name ?? '-' }} — {{ $latest->npwp_number ?? '-' }}
                                        </p>
                                        <p class="text-[10px] text-slate-300 font-medium">
                                            Diunggah {{ $latest->created_at->translatedFormat('j M Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if ($latest->npwp_file)
                                        <a href="{{ asset('storage/' . $latest->npwp_file) }}" target="_blank"
                                            class="text-[10px] font-bold text-blue-500 hover:underline">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                    @endif
                                    @include('creator.legal._status_badge', ['status' => $latest->status])
                                </div>
                            </div>

                            {{-- Anggaran Dasar --}}
                            @if ($latest->deed_number || $latest->deed_file)
                                <div
                                    class="flex items-center justify-between p-5 bg-white border border-slate-100 rounded-2xl group hover:border-blue-200 transition">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition">
                                            <i class="fas fa-file-contract text-blue-400 text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700">Anggaran Dasar</p>
                                            <p class="text-[10px] text-slate-400 font-medium mt-0.5">
                                                {{ $latest->deed_name ?? '-' }} — {{ $latest->deed_number ?? '-' }}
                                            </p>
                                            <p class="text-[10px] text-slate-300 font-medium">
                                                Diunggah {{ $latest->created_at->translatedFormat('j M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        @if ($latest->deed_file)
                                            <a href="{{ asset('storage/' . $latest->deed_file) }}" target="_blank"
                                                class="text-[10px] font-bold text-blue-500 hover:underline">
                                                <i class="fas fa-eye mr-1"></i> Lihat
                                            </a>
                                        @endif
                                        @include('creator.legal._status_badge', [
                                            'status' => $latest->status,
                                        ])
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                @endif

            </div>
        </div>

        <div class="mt-16 border-t border-slate-100 px-8 py-8 flex justify-end">
            <p class="text-[10px] font-black text-slate-300 tracking-widest uppercase">
                © {{ date('Y') }} LOKÉT (PT Global Loket Sejahtera)
            </p>
        </div>
    </div>
</x-creator-layout>
