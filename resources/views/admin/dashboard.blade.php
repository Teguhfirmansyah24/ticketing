<x-admin-layout>
    <div class="p-6 space-y-8">
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-extrabold text-sky-900">Pengelolaan Pembelian</h1>
                <p class="text-sky-600 text-sm">Pantau performa pembayaran dan transaksi Anda hari ini.</p>
            </div>
            <div class="flex gap-3">
                <button class="bg-white border border-sky-200 text-sky-600 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-sky-50 transition-all flex items-center shadow-sm">
                    <i class="fa-solid fa-file-export mr-2"></i> Export Report
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-sky-500 uppercase tracking-widest">Total Transaksi</p>
                    <i class="fas fa-credit-card text-sky-200 text-xl"></i>
                </div>
                <h3 class="text-2xl font-black text-sky-900">{{ $orders->count() }}</h3>
                <p class="text-[10px] text-emerald-500 mt-2 font-bold italic">Update otomatis</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-sky-500 uppercase tracking-widest">Pendapatan</p>
                    <i class="fas fa-wallet text-sky-200 text-xl"></i>
                </div>
                <h3 class="text-2xl font-black text-sky-900">Rp {{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</h3>
                <p class="text-[10px] text-emerald-500 mt-2 font-bold">Berdasarkan halaman ini</p>
            </div>

            <div class="bg-sky-600 p-6 rounded-3xl shadow-lg shadow-sky-200">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-sky-100 uppercase tracking-widest">Status Pending</p>
                    <i class="fas fa-clock text-sky-300 text-xl"></i>
                </div>
                <h3 class="text-2xl font-black text-white">{{ $orders->where('status', 'pending')->count() }}</h3>
                <p class="text-[10px] text-sky-200 mt-2 font-bold">Perlu tindakan admin</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-sky-500 uppercase tracking-widest">Status Berhasil</p>
                    <i class="fas fa-check-circle text-sky-200 text-xl"></i>
                </div>
                <h3 class="text-2xl font-black text-sky-900">{{ $orders->where('status', 'approved')->count() }}</h3>
                <p class="text-[10px] text-sky-400 mt-2 font-bold">Transaksi sukses</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Laporan Bulanan</h3>
                    <span class="text-xs text-gray-400">Jan - Jun 2026</span>
                </div>
                <div class="h-72"><canvas id="chartSatu"></canvas></div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Tren Penyelesaian</h3>
                    <span class="text-xs text-gray-400">Jan - Jun 2026</span>
                </div>
                <div class="h-72"><canvas id="chartDua"></canvas></div>
            </div>
        </div>

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
                        <tr class="bg-sky-600 text-white text-[10px] uppercase tracking-[0.2em] font-bold">
                            <th class="px-6 py-4">Order Code</th>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Tiket</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sky-50">
                        @forelse($orders->when(request('status'), function($query) {
                            return $query->where('status', request('status'));
                        }) as $order)
                        <tr class="hover:bg-sky-50/30 transition-colors">
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-sky-900">#{{ $order->order_code }}</div>
                                <div class="text-[10px] text-sky-500 font-bold uppercase mt-1">{{ $order->created_at?->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-gray-800">{{ $order->user?->name ?? $order->name ?? 'User Terhapus' }}</div>
                                <div class="text-[11px] text-gray-400">{{ $order->user?->email ?? $order->email }}</div>
                            </td>
                            <td class="px-6 py-5">
                                @php $item = $order->orderItems->first(); @endphp
                                <div class="text-sm font-semibold text-gray-700">{{ $item?->ticketType?->name ?? 'N/A' }}</div>
                                <div class="text-[10px] px-2 py-0.5 bg-sky-50 text-sky-600 rounded-md inline-block mt-1 font-medium italic">
                                    {{ $order->event?->title ?? 'Event N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-5 font-black text-sky-900 text-sm">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider flex items-center w-fit {{ $order->status == 'approved' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-2 animate-pulse {{ $order->status == 'approved' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span> 
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-10 text-center text-sky-400 italic font-bold">Belum ada transaksi masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-sky-50/20 border-t border-sky-50">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const globalLabels = @json($labels);

    // Chart Satu: Bar (Transaksi Masuk)
    const ctx1 = document.getElementById('chartSatu').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: globalLabels,
            datasets: [{
                label: 'Transaksi Masuk',
                data: @json($dataMasuk),
                backgroundColor: '#0ea5e9',
                borderRadius: 12,
                barThickness: 25,
            }]
        },
        options: { maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });

    // Chart Dua: Line (Tren Penyelesaian/Approved)
    const ctx2 = document.getElementById('chartDua').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: globalLabels,
            datasets: [{
                label: 'Selesai',
                data: @json($dataSelesai),
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#10B981'
            }]
        },
        options: { maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });
</script>
@endpush
</x-admin-layout>