<aside :class="sidebarOpen ? 'w-60' : 'w-16'"
    class="bg-[#1a2b4b] text-white hidden lg:flex flex-col shrink-0 h-screen sticky top-0 border-r border-white/10 transition-all duration-300 ease-in-out z-40 overflow-hidden">

    <div class="px-5 py-6 mb-2">
        <div class="flex items-center gap-2 whitespace-nowrap">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <i class="fas fa-ticket-alt text-blue-500 text-xl"></i>
                <span x-show="sidebarOpen" x-transition.opacity class="text-xl font-black tracking-tight uppercase">
                    LOKET <span class="text-blue-500">12</span>
                </span>
            </a>
        </div>
    </div>

    <div x-show="sidebarOpen" x-transition.opacity class="px-3 mb-6">
        <div
            class="bg-[#111e36] rounded-lg p-2.5 flex items-center justify-between group cursor-pointer border border-white/5 hover:border-white/10 transition">
            <div class="flex items-center gap-2.5 overflow-hidden">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=E11D48&color=fff' }}"
                    class="w-8 h-8 rounded-md object-cover flex-shrink-0">
                <div class="overflow-hidden">
                    <p class="text-white font-bold text-xs truncate">{{ Auth::user()->name }}</p>
                    <p class="text-slate-500 text-[9px]">Admin</p>
                </div>
            </div>
            <i class="fas fa-chevron-up-down text-[8px] text-slate-500 flex-shrink-0"></i>
        </div>
    </div>

    <nav class="flex-grow flex flex-col px-0 overflow-y-auto custom-scrollbar">

        <div class="px-5 mb-1.5">
            <span x-show="sidebarOpen" x-transition.opacity
                class="text-[9px] font-bold uppercase tracking-[0.15em] text-slate-500">Dashboard</span>
            <hr x-show="!sidebarOpen" class="border-white/10">
        </div>

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3.5 px-5 py-3 transition whitespace-nowrap {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 group' }}">
            <i class="fas fa-home text-base w-5 text-center"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-bold">Dashboard</span>
        </a>

        <a href="{{ route('admin.event-admin') }}"
            class="flex items-center gap-3.5 px-5 py-3 transition whitespace-nowrap {{ request()->routeIs('admin.event-admin') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 group' }}">
            <i class="fas fa-file-alt text-base group-hover:text-blue-400 w-5 text-center"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-bold">Event Admin</span>
        </a> 

        <a href="{{ route('admin.Kategori.index') }}"
            class="flex items-center gap-3.5 px-5 py-3 transition whitespace-nowrap {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 group' }}">
           <i class="fas fa-tags text-base group-hover:text-blue-400 w-5 text-center"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-bold">Kategori</span>
        </a>

        <a href="{{ route('admin.access.index') }}"
            class="flex items-center gap-3.5 px-5 py-3 transition whitespace-nowrap {{ request()->routeIs('admin.access.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 group' }}">
            <i class="fas fa-user-shield text-base group-hover:text-blue-400 w-5 text-center"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-bold">Kelola Akses</span>
        </a>
        <a href="{{ route('admin.pembayaran.index') }}"
            class="flex items-center gap-3.5 px-5 py-3 transition whitespace-nowrap {{ request()->routeIs('admin.pembayaran.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 group' }}">
            <i class="fas fa-money-bill-wave text-base group-hover:text-blue-400 w-5 text-center"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-bold">Pembayaran</span>
        </a>

    </nav>

    <div class="p-3 border-t border-white/5 mt-auto">
        <button @click="sidebarOpen = !sidebarOpen"
            class="flex items-center gap-3 px-2 py-2 w-full text-slate-500 hover:text-white transition group whitespace-nowrap">
            <div class="w-7 h-7 rounded-full border border-slate-700 flex items-center justify-center group-hover:border-white transition-transform duration-300"
                :class="!sidebarOpen ? 'rotate-180' : ''">
                <i class="fas fa-chevron-left text-[10px]"></i>
            </div>
            <span x-show="sidebarOpen" x-transition.opacity class="text-xs font-medium uppercase tracking-wider">Singkat
                Menu</span>
        </button>
    </div>
</aside>