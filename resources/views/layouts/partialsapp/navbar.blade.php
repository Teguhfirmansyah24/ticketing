<nav class="w-full flex flex-col font-sans">
    <div class="bg-[#003da8] text-white py-2 px-6 text-xs">
        <div class="max-w-7xl mx-auto flex justify-end items-center gap-6 opacity-80">
            <a href="{{ route('creator.index') }}" class="hover:underline">Mulai Jadi Event Creator</a>
            <a href="{{ route('pricing') }}" class="hover:underline">Biaya</a>
            <a href="{{ route('blog.index') }}" class="hover:underline">Blog</a>
            <a href="{{ route('help.index') }}" class="hover:underline">Pusat Bantuan</a>
            <div class="flex items-center gap-1 border-l border-blue-400 pl-4 uppercase font-bold">
                <span>🇮🇩 id</span>
            </div>
        </div>
    </div>

    <div class="bg-[#1b2d55] text-white py-4 px-6">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">

            <div class="flex-shrink-0">
                <h1 class="text-xl font-bold tracking-tighter flex items-center">
                    <a href="{{ route('home') }}"><span>TICKETING</span></a>
                </h1>
            </div>

            <div class="flex-grow max-w-md mx-4 hidden md:block">
                <form action="{{ route('event.index') }}" method="GET">
                    <div class="relative flex items-center">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari event seru di sini"
                            class="w-full bg-[#24375d] border-none text-white text-sm placeholder-gray-400 rounded-l-md py-2 px-4 focus:ring-1 focus:ring-blue-400 outline-none">
                        <button type="submit"
                            class="bg-[#0049cc] p-2.5 rounded-r-md hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden lg:flex items-center gap-5 mr-2 text-xs font-semibold whitespace-nowrap">
                    @auth
                        <a href="{{ route('creator.create') }}" class="flex items-center gap-1.5 hover:text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Buat Event
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-1.5 hover:text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Buat Event
                        </a>
                    @endauth
                    <a href="{{ route('event.index') }}" class="flex items-center gap-1.5 hover:text-blue-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                        Jelajah Event
                    </a>
                </div>

                <div class="flex items-center gap-2 whitespace-nowrap">
                    @auth
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="right" width="64"> {{-- Lebar ditambah agar muat teks panjang --}}
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-full overflow-hidden bg-blue-600 hover:bg-blue-700 focus:outline-none transition border-2 border-white shadow-sm">
                                        @if (Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                                alt="{{ Auth::user()->name }}"
                                                class="w-full h-full object-cover rounded-full"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <span style="display:none"
                                                class="w-full h-full flex items-center justify-center text-white text-sm font-bold">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </span>
                                        @else
                                            <span class="text-white text-sm font-bold">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </span>
                                        @endif
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                                        <a href="{{ route('creator.dashboard') }}"
                                            class="flex items-center justify-between group">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                                                    <i class="fas fa-user-tie"></i>
                                                </div>
                                                <div>
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase leading-none">
                                                        Beralih ke akun</p>
                                                    <p class="text-sm font-bold text-blue-600 group-hover:underline">Event
                                                        Creator</p>
                                                </div>
                                            </div>
                                            <i
                                                class="fas fa-chevron-right text-xs text-gray-300 group-hover:text-blue-600"></i>
                                        </a>
                                    </div>

                                    <div class="py-2">
                                        <x-dropdown-link href="{{ route('event.index') }}"
                                            class="flex items-center gap-3 py-3">
                                            <i class="fas fa-compass text-gray-400 w-5"></i>
                                            <span class="text-gray-700 font-medium">{{ __('Jelajah Event') }}</span>
                                        </x-dropdown-link>

                                        <x-dropdown-link href="{{ route('member.tiket.index') }}"
                                            class="flex items-center gap-3 py-3">
                                            <i class="fas fa-ticket-alt text-gray-400 w-5"></i>
                                            <span class="text-gray-700 font-medium">{{ __('Tiket Saya') }}</span>
                                        </x-dropdown-link>
                                    </div>

                                    <hr class="border-gray-100">

                                    <div class="py-2">
                                        <x-dropdown-link href="{{ route('member.profile.edit') }}"
                                            class="flex items-center gap-3 py-3">
                                            <i class="fas fa-user-circle text-gray-400 w-5"></i>
                                            <span class="text-gray-700 font-medium">{{ __('Informasi Dasar') }}</span>
                                        </x-dropdown-link>

                                        <x-dropdown-link href="{{ route('member.pengaturan.index') }}"
                                            class="flex items-center gap-3 py-3">
                                            <i class="fas fa-cog text-gray-400 w-5"></i>
                                            <span class="text-gray-700 font-medium">{{ __('Pengaturan') }}</span>
                                        </x-dropdown-link>
                                    </div>

                                    <hr class="border-gray-100">

                                    <div class="py-1">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                class="flex items-center gap-3 py-3 text-red-600 hover:bg-red-50"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                <i class="fas fa-sign-out-alt w-5"></i>
                                                <span class="font-bold">{{ __('Keluar') }}</span>
                                            </x-dropdown-link>
                                        </form>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @else
                        {{-- Tombol Login/Daftar tetap sama --}}
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-block px-4 py-1.5 bg-transparent border border-white hover:bg-white/10 text-white rounded-md text-xs font-bold transition-all">
                                Daftar
                            </a>
                        @endif

                        <a href="{{ route('login') }}"
                            class="inline-block px-6 py-2 bg-[#0049cc] border border-[#0049cc] hover:bg-blue-700 text-white rounded-md text-xs font-bold transition-all shadow-md">
                            Masuk
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</nav>
