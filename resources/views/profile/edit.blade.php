<x-user-layout>
    {{-- Container Utama: flex-1 dan min-h-screen memastikan konten memenuhi layar ke bawah --}}
    <div class="flex-1 flex flex-col min-h-screen bg-white transition-all duration-300">
        <div class="py-8 px-4 sm:px-10 lg:px-16 w-full max-w-[1600px] mx-auto">

            {{-- Breadcrumb sesuai foto --}}
            <div class="flex items-center gap-2 mb-8 bg-gray-100/50 self-start px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Informasi Dasar</span>
            </div>

            <div class="w-full">
                {{-- Header Informasi Personal --}}
                <div class="mb-10 border-b border-gray-100 pb-5">
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Informasi Personal</h2>
                </div>

                <div class="space-y-16">
                    {{-- Form Update Profil: Tanpa shadow/card agar menyatu dengan background sesuai referensi --}}
                    <div class="w-full">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <hr class="border-gray-100">

                    {{-- Bagian Password: Dibuat grid untuk menjaga stabilitas layout saat zoom out --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 pb-20">
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold text-slate-800">Keamanan Akun</h3>
                            <p class="text-sm text-gray-500">Pastikan akun Anda menggunakan kata sandi yang panjang dan
                                acak untuk tetap aman.</p>
                        </div>
                        <div class="p-8 bg-gray-50/50 rounded-3xl border border-gray-100 shadow-sm">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
