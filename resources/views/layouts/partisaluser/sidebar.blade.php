<aside :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="bg-[#1a2b4b] text-white hidden lg:flex flex-col shrink-0 h-screen sticky top-0 border-r border-white/10 transition-all duration-300 ease-in-out">

    <div class="p-6 mb-4 overflow-hidden">
        <div class="flex items-center gap-2 whitespace-nowrap">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <i class="fas fa-ticket-alt text-blue-500 text-xl"></i>
                <span x-show="sidebarOpen" x-transition.opacity class="text-xl font-black tracking-tight uppercase">
                    LOKET <span class="text-blue-500">12</span>
                </span>
            </a>
        </div>
    </div>

    <nav class="flex-grow flex flex-col px-0 overflow-hidden">
        <a href="{{ route('event.index') }}"
            class="flex items-center gap-4 px-6 py-4 text-slate-300 hover:bg-white/5 transition group whitespace-nowrap">
            <i class="fas fa-compass text-lg group-hover:text-blue-400 w-6 text-center"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="font-medium">Jelajah Event</span>
        </a>

        <a href="{{ route('member.tiket.index') }}"
            class="flex items-center gap-4 px-6 py-4 transition whitespace-nowrap {{ request()->routeIs('member.tiket.index') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 group' }}">
            <i
                class="fas fa-ticket-alt text-lg w-6 text-center {{ request()->routeIs('member.tiket.index') ? '' : 'group-hover:text-blue-400' }}"></i>
            <span x-show="sidebarOpen" x-transition.opacity
                class="{{ request()->routeIs('member.tiket.index') ? 'font-bold' : 'font-medium' }}">
                Tiket Saya
            </span>
        </a>

        <div class="mt-8 px-6 mb-2 whitespace-nowrap">
            <span x-show="sidebarOpen" x-transition.opacity
                class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Akun</span>
            <hr x-show="!sidebarOpen" class="border-white/10">
        </div>

        <a href="{{ route('member.profile.edit') }}"
            class="flex items-center gap-4 px-6 py-4 transition whitespace-nowrap {{ request()->routeIs('member.profile.edit') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 group' }}">
            <i
                class="fas fa-user text-lg w-6 text-center {{ request()->routeIs('member.profile.edit') ? '' : 'group-hover:text-blue-400' }}"></i>
            <span x-show="sidebarOpen" x-transition.opacity
                class="{{ request()->routeIs('member.profile.edit') ? 'font-bold' : 'font-medium' }}">
                Informasi Dasar
            </span>
        </a>

        <a href="{{ route('member.pengaturan.index') }}"
            class="flex items-center gap-4 px-6 py-4 transition whitespace-nowrap {{ request()->routeIs('member.pengaturan.index') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 group' }}">
            <i
                class="fas fa-cog text-lg w-6 text-center {{ request()->routeIs('member.pengaturan.index') ? '' : 'group-hover:text-blue-400' }}"></i>
            <span x-show="sidebarOpen" x-transition.opacity
                class="{{ request()->routeIs('member.pengaturan.index') ? 'font-bold' : 'font-medium' }}">
                Pengaturan
            </span>
        </a>
        <div class="mt-8 px-6 mb-2 whitespace-nowrap">
            <span x-show="sidebarOpen" x-transition.opacity
                class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Mode User</span>
            <hr x-show="!sidebarOpen" class="border-white/10">
        </div>

        <a href="{{ route('creator.dashboard') }}"
            class="flex items-center gap-4 px-6 py-4 text-slate-300 hover:bg-white/5 transition group whitespace-nowrap">
            <i class="fas fa-exchange-alt text-lg group-hover:text-blue-400 w-6 text-center"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="font-medium">Beralih Ke Event Creator</span>
        </a>
    </nav>

    <div class="p-4 border-t border-white/5">
        <button @click="sidebarOpen = !sidebarOpen"
            class="flex items-center gap-4 px-2 py-3 w-full text-slate-400 hover:text-white transition group whitespace-nowrap">
            <div class="w-8 h-8 rounded-full border border-slate-600 flex items-center justify-center group-hover:border-white transition-transform duration-300"
                :class="!sidebarOpen ? 'rotate-180' : ''">
                <i class="fas fa-chevron-left text-xs"></i>
            </div>
            <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-medium">Singkat Menu</span>
        </button>
    </div>
</aside>
