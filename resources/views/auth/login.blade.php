<x-guest-layout>
    <div class="bg-white w-full py-6 px-10 shadow-sm">
        <h1 class="text-2xl font-bold tracking-tighter text-center">
            <a href="{{ '/' }}"><span class="text-[#002d72]">TICKETING</span></a>
        </h1>
    </div>

    <div class="min-h-[calc(100vh-80px)] flex flex-col items-center justify-center bg-white py-12 px-4 sm:px-6 lg:px-8"">

        <div class="max-w-5xl w-full grid grid-cols-1 md:grid-cols-2 gap-16 items-center">

            <div class="hidden md:flex flex-col items-center text-center">
                <div class="w-full max-w-sm mb-8">
                    <img src="{{ asset('assets/images/Auth.png') }}" alt="Halo" class="w-full h-auto">
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 mb-4 leading-tight">
                    Tidak lagi ketinggalan event dan film favoritmu
                </h2>
                <p class="text-gray-500 text-sm px-6">
                    Gabung dan rasakan kemudahan beli tiket dan mengelola event di LOKET.
                </p>
            </div>

            <div class="flex justify-center">
                <div
                    class="w-full max-w-md bg-white p-10 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.06)] border border-gray-50">

                    <h3 class="text-xl font-bold text-gray-900 mb-1 text-center">Masuk ke akunmu</h3>
                    <p class="text-sm text-gray-500 mb-8 text-center">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline ml-1">
                            Daftar
                        </a>
                    </p>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                            <input id="email" type="email" name="email" :value="old('email')" required
                                autofocus
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all outline-none" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                            <input id="password" type="password" name="password" :value="old('password')" required
                                autofocus
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all outline-none" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mt-8">
                            <button type="submit"
                                class="w-full bg-[#0049cc] hover:bg-[#003da8] text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-100 transition-all transform active:scale-[0.98]">
                                Masuk
                            </button>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                    name="remember">
                                <span class="ms-2 text-xs text-gray-500 font-medium">{{ __('Ingat Saya') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-xs text-blue-600 hover:underline" href="{{ route('password.request') }}">
                                    {{ __('Lupa password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
