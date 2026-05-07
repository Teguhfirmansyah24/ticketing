<x-admin-layout>
    <div class="p-6 space-y-8">
        <!-- Header Section -->
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-extrabold text-sky-900">Pengelolaan Pembelian</h1>
                <p class="text-sky-600 text-sm">Pantau dan kelola semua transaksi masuk dari pelanggan.</p>
            </div>
            <div class="flex gap-3">
                <button class="bg-white border border-sky-200 text-sky-600 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-sky-50 transition-all flex items-center shadow-sm">
                    <i class="fa-solid fa-file-export mr-2"></i> Export Report
                </button>
            </div>
        </div>
        <!-- Main Table Section -->
        <div class="bg-white rounded-3xl shadow-xl shadow-sky-100/50 border border-sky-100 overflow-hidden">
            <!-- Filter & Search Bar -->
            <div class="p-6 border-b border-sky-50 flex flex-wrap gap-4 items-center justify-between bg-sky-50/20">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-sky-300">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" placeholder="Cari Kode Invoice atau Nama Pelanggan..." 
                        class="w-full pl-11 pr-4 py-3 rounded-2xl border border-sky-100 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all text-sm bg-white">
                </div>
                
                <div class="flex gap-2">
                    <select class="px-4 py-3 rounded-2xl border border-sky-100 text-sm font-semibold text-sky-800 outline-none focus:ring-4 focus:ring-sky-500/10 bg-white">
                        <option>Semua Status</option>
                        <option>Pending</option>
                        <option>Success</option>
                        <option>Expired</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-sky-600 text-white">
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Invoice / Tgl</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Pelanggan</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Item / Kategori</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Total Pembayaran</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Status</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sky-50">
                        <!-- Row 1 (Success Example) -->
                        <tr class="hover:bg-sky-50/30 transition-colors">
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-sky-900">#INV-20240501</div>
                                <div class="text-[10px] text-sky-500 font-bold mt-1 uppercase">07 Mei 2024 • 09:12</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-gray-800">Budi Setiawan</div>
                                <div class="text-[11px] text-gray-400">budi.st@email.com</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-semibold text-gray-700">Apple iPhone 15 Pro</div>
                                <div class="text-[10px] px-2 py-0.5 bg-sky-50 text-sky-600 rounded-md inline-block mt-1">Smartphone</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-sky-900">Rp 18.250.000</div>
                                <div class="text-[10px] text-emerald-500 font-bold tracking-tight">VA Mandiri (Otomatis)</div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1.5 rounded-xl bg-emerald-100 text-emerald-600 text-[10px] font-black uppercase tracking-wider flex items-center w-fit">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span> Success
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- <a href="{{ route('admin.pembayaran.edit', $pembayaran->id) }}" class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm" title="Edit pesanan">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.pembayaran.show', $pembayaran->id) }}" class="p-2.5 bg-sky-50 text-sky-600 rounded-xl hover:bg-sky-600 hover:text-white transition-all shadow-sm" title="Lihat Detail">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a> --}}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Placeholder -->
            <div class="p-6 bg-sky-50/20 border-t border-sky-50 flex flex-wrap justify-between items-center gap-4">
                <p class="text-[11px] font-bold text-sky-700 uppercase tracking-widest">Menampilkan 1-10</p>
                <div class="flex gap-2">
                    <button class="px-4 py-2 rounded-xl bg-white border border-sky-100 text-xs font-bold text-sky-400 cursor-not-allowed">Prev</button>
                    <button class="px-4 py-2 rounded-xl bg-sky-600 text-white text-xs font-bold shadow-md shadow-sky-200">1</button>
                    <button class="px-4 py-2 rounded-xl bg-white border border-sky-100 text-xs font-bold text-sky-600 hover:bg-sky-50">2</button>
                    <button class="px-4 py-2 rounded-xl bg-white border border-sky-100 text-xs font-bold text-sky-600 hover:bg-sky-50">Next</button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>