<section class="space-y-6">
    <header class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-slate-800">
            {{ __('Pengaturan') }}
        </h2>
    </header>

    {{-- Newsletter Section (Sesuai Gambar Referensi) --}}
    <div class="bg-blue-50/30 border border-blue-100 rounded-2xl p-6 mb-4">
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h3 class="text-base font-bold text-slate-800">Newsletter</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Saya bersedia menerima informasi terkini terkait event dan promosi di <span
                        class="text-blue-600 font-medium">Loket.com</span>
                </p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer" checked>
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                </div>
            </label>
        </div>
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
</section>
