<x-admin-layout>
    <div class="p-6 space-y-8">
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

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100">
                <span class="font-bold">Berhasil!</span> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl shadow-sky-100/50 border border-sky-100 overflow-hidden">
            <div class="p-6 border-b border-sky-50 flex flex-wrap gap-4 items-center justify-between bg-sky-50/20">
                <form action="" method="GET" class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-sky-300">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kode Order atau Nama..." 
                        class="w-full pl-11 pr-4 py-3 rounded-2xl border border-sky-100 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all text-sm bg-white">
                </form>
                
                <div class="flex gap-2">
                    <select onchange="window.location.href=this.value" class="px-4 py-3 rounded-2xl border border-sky-100 text-sm font-semibold text-sky-800 outline-none focus:ring-4 focus:ring-sky-500/10 bg-white">
                        <option value="{{ request()->fullUrlWithQuery(['status' => '']) }}">Semua Status</option>
                        <option value="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="{{ request()->fullUrlWithQuery(['status' => 'approved']) }}" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="{{ request()->fullUrlWithQuery(['status' => 'expired']) }}" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="{{ request()->fullUrlWithQuery(['status' => 'cancelled']) }}" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-sky-600 text-white">
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Order Code / Tgl</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Pelanggan</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Detail Tiket</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Total Pembayaran</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em]">Status</th>
                            <th class="px-6 py-4 font-bold uppercase text-[10px] tracking-[0.2em] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sky-50">
                        @forelse($orders as $order)
                        <tr class="hover:bg-sky-50/30 transition-colors">
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-sky-900">#{{ $order->order_code }}</div>
                                <div class="text-[10px] text-sky-500 font-bold mt-1 uppercase">
                                    {{ $order->created_at?->format('d M Y • H:i') ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-gray-800">{{ $order->user?->name ?? $order->name ?? 'User Terhapus' }}</div>
                                <div class="text-[11px] text-gray-400">{{ $order->user?->email ?? $order->email }}</div>
                            </td>

                            <td class="px-6 py-5">
                                @php $firstItem = $order->orderItems->first(); @endphp
                                <div class="text-sm font-semibold text-gray-700">
                                    {{ $firstItem?->ticketType?->name ?? 'Tiket Tidak Ditemukan' }} 
                                    @if($order->orderItems->count() > 1) 
                                        <span class="text-sky-500">(+{{ $order->orderItems->count() - 1 }})</span>
                                    @endif
                                </div>
                                <div class="text-[10px] px-2 py-0.5 bg-sky-50 text-sky-600 rounded-md inline-block mt-1 font-medium">
                                    {{ $order->event?->title ?? 'Event Tidak Ditemukan' }}
                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-sky-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                <div class="text-[10px] text-emerald-500 font-bold tracking-tight uppercase italic">Midtrans / Gateway</div>
                            </td>

                            <td class="px-6 py-5">
                        @if($order->status == 'approved' || $order->status == 'success')
                            <span class="px-3 py-1.5 rounded-xl bg-emerald-100 text-emerald-600 text-[10px] font-black uppercase tracking-wider flex items-center w-fit">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span> Approved
                            </span>
                        @elseif($order->status == 'pending')
                            <span class="px-3 py-1.5 rounded-xl bg-amber-100 text-amber-600 text-[10px] font-black uppercase tracking-wider flex items-center w-fit">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-2 animate-pulse"></span> Pending
                            </span>
                        @elseif($order->status == 'expired')
                            <span class="px-3 py-1.5 rounded-xl bg-red-100 text-red-600 text-[10px] font-black uppercase tracking-wider flex items-center w-fit">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></span> Expired
                            </span>
                        @elseif($order->status == 'cancelled')
                            <span class="px-3 py-1.5 rounded-xl bg-gray-100 text-gray-600 text-[10px] font-black uppercase tracking-wider flex items-center w-fit">
                                <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-2"></span> Cancelled
                            </span>
                        @else
                            <span class="px-3 py-1.5 rounded-xl bg-red-100 text-red-600 text-[10px] font-black uppercase tracking-wider">
                                {{ ucfirst($order->status) }}
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Detail -->
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                            class="p-2 bg-sky-50 text-sky-600 rounded-lg hover:bg-sky-600 hover:text-white transition-all shadow-sm" 
                            title="Lihat Detail">
                                <i class="fa-solid fa-eye text-[10px]"></i>
                            </a>

                            @if($order->status == 'pending')
                                <!-- Approve Only -->
                                <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" 
                                    onsubmit="return confirm('Approve pesanan ini?')">
                                    @csrf
                                    <button type="submit" 
                                            class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-all shadow-sm" 
                                            title="Approve">
                                        <i class="fa-solid fa-check text-[10px]"></i>
                                    </button>
                                </form>
                            @endif

                            <!-- Edit -->
                            <a href="{{ route('admin.orders.edit', $order->id) }}" 
                            class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-600 hover:text-white transition-all shadow-sm" 
                            title="Edit Transaksi">
                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" 
                                onsubmit="return confirm('Hapus data transaksi ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm" 
                                        title="Hapus Data">
                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </td>                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sky-400 italic font-bold">
                                Belum ada transaksi masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-sky-50/20 border-t border-sky-50">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>