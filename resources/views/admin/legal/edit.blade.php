<x-admin-layout>

    <div class="max-w-7xl mx-auto p-6">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-3xl font-black text-sky-900">
                    Edit Legal Documents
                </h1>

                <p class="text-sm text-sky-600 mt-1">
                    Kelola dan perbarui dokumen legal pengguna.
                </p>
            </div>

            <a href="{{ route('admin.legal.index') }}"
                class="group flex items-center text-sm font-semibold text-sky-600 hover:text-sky-800 transition">

                <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>

                Kembali
            </a>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT -->
            <div class="space-y-6">

                <!-- USER INFO -->
                <div class="bg-white border border-sky-100 rounded-3xl p-6 shadow-xl shadow-sky-100/40">

                    <h3 class="flex items-center text-xs font-black uppercase tracking-widest text-sky-900 mb-5">

                        <i class="fa-solid fa-user text-sky-500 mr-2"></i>

                        Informasi User
                    </h3>

                    <div class="space-y-4">

                        <div>
                            <p class="text-[10px] font-bold uppercase text-sky-400">
                                Nama
                            </p>

                            <p class="text-sm font-bold text-gray-800">
                                {{ $user->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] font-bold uppercase text-sky-400">
                                Email
                            </p>

                            <p class="text-sm text-gray-600">
                                {{ $user->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] font-bold uppercase text-sky-400 mb-2">
                                Status Verifikasi
                            </p>

                            @php
                                $status = $user->legalDocuments?->status ?? 'unknown';
                            @endphp

                            <span class="
                                inline-flex items-center px-3 py-1 rounded-full text-xs font-bold

                                {{ $status === 'verified'
                                    ? 'bg-emerald-100 text-emerald-700'
                                    : ($status === 'unverified'
                                        ? 'bg-amber-100 text-amber-700'
                                        : 'bg-red-100 text-red-700') }}
                            ">

                                {{ ucfirst($status) }}

                            </span>

                        </div>

                    </div>

                </div>

                <!-- SUMMARY -->
                <div class="bg-sky-900 rounded-3xl p-6 shadow-xl shadow-sky-900/20 text-white">

                    <h3 class="text-xs font-black uppercase tracking-widest text-sky-300 mb-5">
                        Ringkasan Dokumen
                    </h3>

                    <div class="space-y-4 text-sm">

                        <div class="flex justify-between">
                            <span class="text-sky-300">KTP</span>

                            <span class="font-bold">
                                {{ $user->legalDocuments?->ktp_file ? 'Ada' : 'Belum' }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sky-300">NPWP</span>

                            <span class="font-bold">
                                {{ $user->legalDocuments?->npwp_file ? 'Ada' : 'Belum' }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sky-300">Deed</span>

                            <span class="font-bold">
                                {{ $user->legalDocuments?->deed_file ? 'Ada' : 'Belum' }}
                            </span>
                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="lg:col-span-2">

                <div class="bg-white border border-sky-100 rounded-3xl overflow-hidden shadow-xl shadow-sky-100/40">

                    <!-- TOP -->
                    <div class="bg-sky-600 px-8 py-5">

                        <h3 class="flex items-center text-sm font-bold tracking-wide text-white">

                            <i class="fa-solid fa-gear mr-3"></i>

                            PENGATURAN LEGAL DOCUMENT
                        </h3>

                    </div>

                    <!-- FORM -->
                    <form action="{{ route('admin.legal.update', $user->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="p-8 space-y-8">

                        @csrf
                        @method('PUT')

                        <!-- STATUS -->
                        <div>

                            <label class="block text-xs font-bold uppercase tracking-widest text-sky-900 mb-4">

                                Status Verifikasi
                            </label>

                            <div class="grid grid-cols-3 gap-4">

                                @foreach ([
                                    ['value' => 'unverified', 'icon' => 'clock', 'color' => 'amber', 'label' => 'Unverified'],
                                    ['value' => 'verified', 'icon' => 'circle-check', 'color' => 'emerald', 'label' => 'Verified'],
                                    ['value' => 'rejected', 'icon' => 'circle-xmark', 'color' => 'red', 'label' => 'Rejected'],
                                ] as $item)

                                <label
                                    class="relative flex flex-col items-center justify-center p-4 rounded-2xl border-2 border-sky-50 bg-sky-50/30 cursor-pointer hover:border-sky-200 transition">

                                    <input type="radio"
                                        name="status"
                                        value="{{ $item['value'] }}"
                                        class="sr-only peer"
                                        {{ old('status', $user->legalDocuments?->status) == $item['value'] ? 'checked' : '' }}>

                                    <div
                                        class="absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-{{ $item['color'] }}-500 peer-checked:bg-{{ $item['color'] }}-50/50 transition">
                                    </div>

                                    <i class="fa-solid fa-{{ $item['icon'] }} text-{{ $item['color'] }}-500 mb-2 z-10"></i>

                                    <span class="text-[10px] font-black uppercase text-{{ $item['color'] }}-600 z-10">
                                        {{ $item['label'] }}
                                    </span>

                                </label>

                                @endforeach

                            </div>

                        </div>

                        <!-- FORM GRID -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- KTP NUMBER -->
                            <div>

                                <label class="block text-sm font-bold text-sky-900 mb-2">
                                    KTP Number
                                </label>

                                <input type="text"
                                    name="ktp_number"
                                    value="{{ old('ktp_number', $user->legalDocuments?->ktp_number) }}"
                                    class="w-full rounded-2xl border border-sky-100 bg-sky-50/20 px-5 py-3 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none">

                            </div>

                            <!-- KTP NAME -->
                            <div>

                                <label class="block text-sm font-bold text-sky-900 mb-2">
                                    KTP Name
                                </label>

                                <input type="text"
                                    name="ktp_name"
                                    value="{{ old('ktp_name', $user->legalDocuments?->ktp_name) }}"
                                    class="w-full rounded-2xl border border-sky-100 bg-sky-50/20 px-5 py-3 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none">

                            </div>
                           <div class="space-y-2 md:col-span-2">

                                <label for="verified_at"
                                    class="block text-xs font-bold uppercase tracking-widest text-sky-900 ml-1">

                                    Tanggal dan Waktu Verifikasi Dokumen
                                </label>

                                <div class="relative group">

                                    <!-- ICON -->
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-4 text-sky-300 group-focus-within:text-sky-600 transition-colors pointer-events-none">

                                        <i class="fa-solid fa-calendar-check text-sm"></i>

                                    </div>

                                    <!-- INPUT -->
                                     <input type="datetime-local"
                                            id="verified_at"
                                            name="verified_at"
                                            value="{{ old('verified_at', optional($user->legalDocuments?->verified_at)->format('Y-m-d\TH:i')) }}"
                                            class="w-full pl-11 pr-5 py-3.5 rounded-2xl border border-sky-100 bg-sky-50/30 text-sm font-medium text-sky-900 outline-none transition-all appearance-none cursor-pointer focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10">
                                </div>

                                @error('verified_at')

                                    <p class="text-xs font-medium text-red-500 ml-1">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>
                            <!-- ADDRESS -->
                            <div class="md:col-span-2">

                                <label class="block text-sm font-bold text-sky-900 mb-2">
                                    KTP Address
                                </label>

                                <textarea name="ktp_address"
                                    rows="4"
                                    class="w-full rounded-2xl border border-sky-100 bg-sky-50/20 px-5 py-3 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none">{{ old('ktp_address', $user->legalDocuments?->ktp_address) }}</textarea>

                            </div>

                            <!-- FILE -->

                        <!-- NOTES -->
                        <div>

                            <label class="block text-sm font-bold text-sky-900 mb-2">

                                Catatan Admin
                            </label>

                            <textarea name="notes"
                                rows="4"
                                placeholder="Tambahkan catatan internal..."
                                class="w-full rounded-2xl border border-sky-100 bg-sky-50/20 px-5 py-3 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none">{{ old('notes', $user->legalDocuments?->notes) }}</textarea>

                        </div>

                        <!-- BUTTON -->
                        <div class="flex items-center justify-end gap-4 border-t border-sky-50 pt-6">

                            <a href="{{ route('admin.legal.index') }}"
                                class="px-6 py-3 text-sm font-bold uppercase tracking-widest text-sky-500 hover:text-sky-700 transition">

                                Batal
                            </a>

                            <button type="submit"
                                class="px-10 py-3.5 rounded-2xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-extrabold uppercase tracking-widest shadow-lg shadow-sky-200 hover:shadow-sky-300 hover:-translate-y-0.5 active:scale-95 transition">

                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script>
        const fileInput = document.getElementById('ktp_file');
        const fileNameDisplay = document.getElementById('file_name_display');
        const fileName = document.getElementById('file_name');

        fileInput.addEventListener('change', function() {

            const file = this.files[0];

            if (file) {

                fileName.textContent = file.name;

                fileNameDisplay.classList.remove('hidden');
                fileNameDisplay.classList.add('flex');

            }

        });
    </script>

</x-admin-layout>