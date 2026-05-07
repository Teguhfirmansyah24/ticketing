<x-creator-layout>
    <div class="flex-1 flex flex-col min-h-screen bg-white transition-all duration-300">
        <div class="py-8 px-4 sm:px-10 lg:px-16 w-full max-w-[1600px] mx-auto">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 mb-8 bg-gray-100/50 self-start px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Pengaturan</span>
            </div>

            {{-- Tutup Akun Section (Sesuai Gambar Referensi) --}}
            <div x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="bg-blue-50/30 border border-blue-100 rounded-2xl p-6 cursor-pointer hover:bg-red-50 hover:border-red-100 transition group">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-800 group-hover:text-red-600 transition">Tutup Akun</h3>
                    <i class="fas fa-chevron-right text-sm text-slate-400 group-hover:text-red-400 transition"></i>
                </div>
            </div>

            {{-- Modal Konfirmasi --}}
            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('member.profile.destroy') }}" class="p-8">
                    @csrf
                    @method('delete')

                    <div class="mb-6">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight">
                            {{ __('Apakah Anda yakin ingin menutup akun?') }}
                        </h2>
                        <p class="mt-2 text-sm text-slate-500">
                            {{ __('Setelah akun Anda dihapus, semua data dan riwayat tiket akan dihapus secara permanen. Masukkan kata sandi Anda untuk mengonfirmasi.') }}
                        </p>
                    </div>

                    <div class="mt-6">
                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                        <input id="password" name="password" type="password"
                            class="block w-full border-0 border-b border-gray-200 focus:ring-0 focus:border-red-600 px-0 shadow-none rounded-none text-sm"
                            placeholder="{{ __('Masukkan Kata Sandi Anda') }}" />
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" x-on:click="$dispatch('close')"
                            class="px-6 py-2.5 text-sm font-bold text-slate-400 hover:text-slate-600 transition">
                            {{ __('Batal') }}
                        </button>

                        <button type="submit"
                            class="px-8 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-red-100 transition">
                            {{ __('Tutup Akun Sekarang') }}
                        </button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>
    <div class="py-6 px-16 flex justify-end">
        <p class="text-[10px] font-medium text-gray-400 tracking-wide uppercase">
            © 2026 LOKET (PT Global Loket Sejahtera)
        </p>
    </div>
</x-creator-layout>
