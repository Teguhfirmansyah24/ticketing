<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-40">
    <div class="max-w-full mx-auto px-6 lg:px-10">
        <div class="flex justify-between h-20"> <!-- Tinggi ditambah agar lebih lega -->

            <!-- Left Side: Context Indicator -->
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 py-1.5 px-3 bg-slate-100 rounded-full border border-slate-200">
                    <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                    <span class="text-[11px] font-black uppercase tracking-widest text-slate-600">Mode Pembeli</span>
                </div>
            </div>

            <!-- Right Side: Actions & Profile -->
            <div class="flex items-center gap-6">
                <!-- Secondary Action -->
                <a href="{{ route('creator.create') }}"
                    class="hidden lg:flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">
                    <i class="fas fa-plus-circle text-xs"></i>
                    <span>Buat Event</span>
                </a>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button @click="open = ! open"
                        class="group flex items-center gap-3 p-1 pr-4 rounded-full border border-slate-200 hover:border-blue-200 hover:bg-blue-50/30 transition-all duration-300 focus:outline-none">

                        <!-- Avatar with Status Indicator -->
                        <div class="relative">
                            <div
                                class="w-9 h-9 rounded-full overflow-hidden bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white ring-2 ring-white shadow-sm flex-shrink-0">
                                @if (Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                        alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                @else
                                    <span
                                        class="text-sm font-black">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="text-left hidden md:block">
                            <p class="text-[13px] font-black text-slate-800 leading-none mb-0.5">
                                {{ Auth::user()->name }}</p>
                            <p class="text-[10px] font-medium text-slate-400 uppercase tracking-tighter leading-none">
                                Akun Member</p>
                        </div>

                        <i class="fas fa-chevron-down text-[10px] text-slate-300 group-hover:text-blue-400 transition-transform duration-300"
                            :class="{ 'rotate-180': open }"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        class="absolute right-0 mt-3 w-72 bg-white rounded-[24px] shadow-2xl shadow-blue-900/10 border border-slate-100 py-3 z-50 overflow-hidden"
                        style="display: none;">

                        <!-- Switch Account Section -->
                        <div class="px-3 mb-2">
                            <a href="{{ route('creator.dashboard') }}"
                                class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-blue-200 hover:bg-blue-50 transition-all">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-blue-600 border border-slate-50">
                                        <i class="fas fa-rocket text-sm"></i>
                                    </div>
                                    <div>
                                        <p
                                            class="text-[10px] font-black uppercase text-slate-400 tracking-widest leading-none mb-1">
                                            Beralih ke</p>
                                        <p class="text-sm font-bold text-slate-800 group-hover:text-blue-600">Event
                                            Creator</p>
                                    </div>
                                </div>
                                <i
                                    class="fas fa-arrow-right text-xs text-slate-300 group-hover:text-blue-500 transform group-hover:translate-x-1 transition-all"></i>
                            </a>
                        </div>

                        <!-- Main Links -->
                        <div class="px-2 space-y-1">
                            <p class="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Aktivitas</p>
                            <a href="{{ route('event.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all group">
                                <i class="fas fa-compass w-5 text-slate-400 group-hover:text-blue-500"></i>
                                <span>Jelajah Event</span>
                            </a>
                            <a href="{{ route('member.tiket.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all group">
                                <i class="fas fa-ticket-alt w-5 text-slate-400 group-hover:text-blue-500"></i>
                                <span>Tiket Saya</span>
                            </a>
                        </div>

                        <div class="my-2 border-t border-slate-50"></div>

                        <!-- Account Settings -->
                        <div class="px-2 space-y-1">
                            <a href="{{ route('member.profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all group">
                                <i class="fas fa-user w-5 text-slate-400 group-hover:text-blue-500"></i>
                                <span>Informasi Dasar</span>
                            </a>
                            <a href="{{ route('member.pengaturan.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all group">
                                <i class="fas fa-cog w-5 text-slate-400 group-hover:text-blue-500"></i>
                                <span>Pengaturan</span>
                            </a>
                        </div>

                        <div class="my-2 border-t border-slate-50"></div>

                        <!-- Resources -->
                        <div class="px-2 grid grid-cols-2 gap-1 mb-2">
                            <a href="{{ route('blog.index') }}"
                                class="text-center py-2 rounded-xl text-[11px] font-bold text-slate-500 hover:bg-slate-50">Blog</a>
                            <a href="{{ route('help.index') }}"
                                class="text-center py-2 rounded-xl text-[11px] font-bold text-slate-500 hover:bg-slate-50">Bantuan</a>
                        </div>

                        <!-- Logout -->
                        <div class="px-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl text-[12px] font-black uppercase tracking-widest text-red-500 bg-red-50/50 hover:bg-red-50 transition-all">
                                    <i class="fas fa-power-off text-[10px]"></i>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
