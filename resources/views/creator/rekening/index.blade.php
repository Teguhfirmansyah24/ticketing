<x-creator-layout>
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-[1440px] mx-auto space-y-8">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 bg-gray-100/50 px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Rekening</span>
            </div>

            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-slate-200 pb-5">
                <div>
                    <h2 class="text-xl font-black text-slate-800">Rekening Kamu</h2>
                    <p class="text-xs text-slate-400 mt-1">Kelola rekening bank untuk pencairan hasil penjualan tiket</p>
                </div>
                <a href="{{ route('creator.rekening.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-xs transition shadow-lg shadow-blue-200 flex items-center gap-2">
                    <i class="fas fa-plus text-xs"></i>
                    Tambah Rekening
                </a>
            </div>

            {{-- Alert --}}
            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
                </div>
            @endif

            @if ($accounts->isEmpty())
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-24 space-y-6">
                    <div class="text-amber-800 opacity-60">
                        <svg viewBox="0 0 24 24" class="w-28 h-28" fill="none" stroke="currentColor" stroke-width="1"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2" />
                            <line x1="2" y1="10" x2="22" y2="10" />
                            <line x1="7" y1="15" x2="7.01" y2="15" />
                            <line x1="11" y1="15" x2="11.01" y2="15" />
                        </svg>
                    </div>
                    <div class="text-center space-y-3 max-w-sm">
                        <h3 class="font-black text-slate-700 text-lg">Belum ada rekening</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            Masukkan rekening kamu terlebih dahulu untuk dapat memproses penarikan hasil penjualan
                            tiket.
                        </p>
                        <a href="{{ route('creator.rekening.create') }}"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold text-sm transition shadow-lg shadow-blue-200 mt-2">
                            <i class="fas fa-plus text-xs"></i>
                            Masukkan Rekening
                        </a>
                    </div>
                </div>
            @else
                {{-- List Rekening --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach ($accounts as $account)
                        <div
                            class="bg-white rounded-2xl border shadow-sm overflow-hidden
                            {{ $account->is_primary ? 'border-blue-300' : 'border-slate-100' }}">

                            {{-- Header Card --}}
                            <div
                                class="px-6 py-4 flex items-center justify-between
                                {{ $account->is_primary ? 'bg-blue-600' : 'bg-slate-800' }}">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-university text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-white font-black text-sm">{{ $account->bank_name }}</p>
                                        @if ($account->is_primary)
                                            <span class="text-[10px] text-blue-200 font-bold uppercase tracking-widest">
                                                ★ Rekening Utama
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <svg viewBox="0 0 24 24" class="w-12 h-8 text-white opacity-30" fill="none"
                                    stroke="currentColor" stroke-width="1">
                                    <rect x="2" y="5" width="20" height="14" rx="2" />
                                    <line x1="2" y1="10" x2="22" y2="10" />
                                </svg>
                            </div>

                            {{-- Body Card --}}
                            <div class="p-6 space-y-4">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                            Nomor Rekening
                                        </span>
                                        <span class="text-sm font-black text-slate-800 font-mono tracking-wider">
                                            {{ $account->account_number }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                            Atas Nama
                                        </span>
                                        <span class="text-sm font-bold text-slate-700 uppercase">
                                            {{ $account->account_name }}
                                        </span>
                                    </div>
                                    @if ($account->branch)
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                                Cabang
                                            </span>
                                            <span class="text-sm font-bold text-slate-700">
                                                {{ $account->branch }}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                            Ditambahkan
                                        </span>
                                        <span class="text-xs text-slate-400 font-medium">
                                            {{ $account->created_at->translatedFormat('j M Y') }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Aksi --}}
                                <div class="pt-3 border-t border-slate-50 flex items-center gap-2">
                                    @if (!$account->is_primary)
                                        <form action="{{ route('creator.rekening.primary', $account->id) }}"
                                            method="POST" class="flex-1">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="w-full flex items-center justify-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold py-2.5 rounded-xl transition border border-blue-100">
                                                <i class="fas fa-star text-xs"></i>
                                                Jadikan Utama
                                            </button>
                                        </form>
                                    @else
                                        <div
                                            class="flex-1 flex items-center justify-center gap-2 bg-blue-600 text-white text-xs font-bold py-2.5 rounded-xl border border-blue-500">
                                            <i class="fas fa-check text-xs"></i>
                                            Rekening Utama
                                        </div>
                                    @endif

                                    <form action="{{ route('creator.rekening.destroy', $account->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus rekening ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-500 text-xs font-bold py-2.5 px-4 rounded-xl transition border border-red-100">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Info --}}
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex gap-4">
                    <i class="fas fa-info-circle text-amber-500 text-lg flex-shrink-0 mt-0.5"></i>
                    <div class="space-y-1">
                        <p class="text-sm font-bold text-amber-800">Informasi Rekening</p>
                        <p class="text-xs text-amber-700 leading-relaxed">
                            Hasil penjualan tiket akan dicairkan ke <span class="font-bold">Rekening Utama</span> kamu.
                            Pastikan data rekening sudah benar sebelum mengajukan pencairan.
                        </p>
                    </div>
                </div>
            @endif

        </div>

        {{-- Footer --}}
        <div class="mt-16 border-t border-slate-50 pt-8 flex justify-end">
            <p class="text-[10px] font-medium text-slate-300 tracking-wide uppercase">
                © {{ date('Y') }} LOKÉT (PT Global Loket Sejahtera)
            </p>
        </div>
    </div>
</x-creator-layout>
