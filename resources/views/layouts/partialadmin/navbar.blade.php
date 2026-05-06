<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-40">
    <div class="max-w-full mx-auto px-6 lg:px-10">
        <div class="flex justify-between h-20">

            <!-- Left Side: Context Indicator -->
            <div class="flex items-center gap-4">
            </div>

            <!-- Right Side: Actions & Profile -->
            <div class="flex items-center gap-6">
                <!-- Secondary Action -->
                <a href=""
                    class="hidden lg:flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">
                    <i class="fas fa-plus-circle text-xs"></i>
                    <span>Buat Event</span>
                </a>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button @click="open = ! open"
                        class="group flex items-center gap-3 p-1 pr-4 rounded-full border border-slate-200 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all duration-300 focus:outline-none">

                        <!-- Avatar -->
                        <div
                            class="w-9 h-9 rounded-full overflow-hidden bg-gradient-to-tr from-indigo-600 to-blue-600 flex items-center justify-center text-white ring-2 ring-white shadow-sm flex-shrink-0">
                            @if (Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <span
                                    class="text-sm font-black">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @endif
                        </div>

                        <div class="text-left hidden md:block">
                            <p class="text-[13px] font-black text-slate-800 leading-none mb-0.5">
                                {{ Auth::user()->name }}</p>
                            <p class="text-[10px] font-medium text-slate-400 uppercase tracking-tighter leading-none">
                                Organizer</p>
                        </div>

                        <i class="fas fa-chevron-down text-[10px] text-slate-300 group-hover:text-indigo-400 transition-transform duration-300"
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
                        class="absolute right-0 mt-3 w-72 bg-white rounded-[24px] shadow-2xl shadow-indigo-900/10 border border-slate-100 py-3 z-50 overflow-hidden"
                        style="display: none;">

                        <!-- Switch Account Section -->

                        <!-- Main admin Links -->
                        <div class="px-2 space-y-1">
                            <p class="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Manajemen</p>
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all group">
                                <i class="fas fa-home w-5 text-slate-400 group-hover:text-indigo-500"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{route('admin.event-admin')}}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all group">
                                <i class="fas fa-tag w-5 text-slate-400 group-hover:text-indigo-500"></i>
                                <span>Event Admin</span>
                            </a>
                            <a href="{{route('admin.access.index')}}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all group">
                                <i class="fas fa-user-shield w-5 text-slate-400 group-hover:text-indigo-500"></i>
                                <span>Kelola Akses</span>
                            </a>
                            <a href="{{route('admin.Kategori.index')}}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all group">
                                <i class="fas fa-tag w-5 text-slate-400 group-hover:text-indigo-500"></i>
                                <span>Kategori</span>
                            </a>
                        </div>

                        <div class="my-2 border-t border-slate-50"></div>
                        <div class="my-2 border-t border-slate-50"></div>

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
