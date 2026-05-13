<x-admin-layout>
<style>
    @media print {
        /* 1. Global Color Force - Ensures the Cyan background prints */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        /* 2. Hide navigation, filters, and non-essential UI */
        nav, aside, header, .no-print, [role="navigation"], 
        form, select, input[type="month"], .flex.gap-3, .flex.gap-2 {
            display: none !important;
        }       

        /* 3. Reset Main Layout for Paper */
        main, .content, body {
            margin: 0 !important;
            padding: 0 !important;
            display: block !important;
            width: 100% !important;
            background: white !important;
        }

        /* 4. Container & Header Formatting */
        .p-6 {
            margin: 0 !important;
            padding: 10px !important;
        }

        h1 {
            font-size: 24pt !important;
            margin-bottom: 5px !important;
        }
        
        p.text-sky-600 {
            margin-bottom: 20px !important;
            color: #333 !important;
        }

        /* 5. Grid Layouts: Force Cards (5 columns) and Charts (2 columns) */
        .grid {
            display: grid !important;
            gap: 15px !important;
        }

        /* Top Stats Cards */
        .grid-cols-1.md\:grid-cols-2.lg\:grid-cols-5, 
        .lg\:grid-cols-5 {
            grid-template-columns: repeat(5, 1fr) !important;
        }

        /* Charts Section */
        .grid-cols-1.lg\:grid-cols-2, 
        .lg\:grid-cols-2 {
            grid-template-columns: repeat(2, 1fr) !important;
            margin-top: 20px !important;
        }

        /* 6. Card & Background Styling */
        .bg-white {
            page-break-inside: avoid;
            border: 1px solid #e2e8f0 !important;
            box-shadow: none !important;
            border-radius: 12px !important;
        }

        /* Force the Status Pending Cyan Background */
        .bg-sky-600 {
            background-color: #0284c7 !important; /* Cyan color */
            color: white !important;
            border-radius: 12px !important;
            page-break-inside: avoid;
        }

        /* Ensure white text inside the cyan card stays white */
        .bg-sky-600 h3, .bg-sky-600 p {
            color: white !important;
        }

        /* Reset black text for other cards to ensure readability */
        .bg-white .text-sky-900, .bg-white h3 {
            color: #0c4a6e !important;
        }

        canvas {
            max-width: 100% !important;
            height: auto !important;
        }
    }
</style>


    <div class="p-6 space-y-8">
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-extrabold text-sky-900">Pengelolaan Pembelian</h1>
                <p class="text-sky-600 text-sm">Pantau performa pembayaran dan transaksi Anda hari ini.</p>
            </div>
            <div class="flex gap-3">
                <button onclick="window.print()"
                    class="bg-white border border-sky-200 text-sky-600 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-sky-50 transition-all flex items-center shadow-sm no-print">
                    <i class="fa-solid fa-print mr-2"></i> Print Report
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            {{-- Card 1: Total Transaksi --}}
            <a href="{{ route('admin.pembayaran.index') }}"
                class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm transition-all hover:border-sky-300">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-sky-500 uppercase tracking-widest">Total Transaksi</p>
                    <i class="fas fa-credit-card text-sky-200 text-xl"></i>
                </div>
                <h3 class="text-2xl font-black text-sky-900">{{ $orders->count() }}</h3>
                <p class="text-[10px] text-emerald-500 mt-2 font-bold italic">Update otomatis</p>
            </a>

            <div
                class="group relative bg-white p-6 rounded-3xl border border-sky-100 shadow-sm transition-all hover:border-sky-300 cursor-help">
                <!-- Hover Tooltip Content -->
                <div
                    class="absolute invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-300 bottom-full left-1/2 -translate-x-1/2 mb-4 w-56 bg-sky-900 text-white p-4 rounded-2xl shadow-xl z-50">
                    <div class="space-y-2">
                        <div
                            class="flex justify-between items-center text-[10px] uppercase tracking-wider font-bold text-sky-300">
                            <span>Breakdown Status</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-medium text-emerald-400">Approved:</span>
                            <span class="text-sm font-black">Rp
                                {{ number_format($orders->where('status', 'approved')->sum('total_amount'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-medium text-amber-400">Pending:</span>
                            <span class="text-sm font-black">Rp
                                {{ number_format($orders->where('status', 'pending')->sum('total_amount'), 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <!-- Tooltip Arrow -->
                    <div
                        class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-sky-900">
                    </div>
                </div>

                <!-- Main Card Content -->
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-sky-500 uppercase tracking-widest">Pendapatan Total</p>
                    <i class="fas fa-wallet text-sky-200 text-xl"></i>
                </div>
                <h3 class="text-2xl font-black text-sky-900">Rp
                    {{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</h3>
                <div class="flex items-center mt-2">
                    <p class="text-[10px] text-emerald-500 font-bold">Berdasarkan halaman ini</p>
                    <i class="fas fa-circle-info ml-1 text-[10px] text-sky-300"></i>
                </div>
            </div>

            {{-- Card 3: Status Pending (Highlight) --}}
            <a href="{{ route('admin.pembayaran.index', ['status' => 'pending']) }}"
                class="block bg-sky-600 p-6 rounded-3xl shadow-lg shadow-sky-200 transition-all hover:bg-sky-700">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-sky-100 uppercase tracking-widest">Status Pending</p>
                    <i class="fas fa-clock text-sky-300 text-xl"></i>
                </div>
                <h3 class="text-2xl font-black text-white">{{ $orders->where('status', 'pending')->count() }}</h3>
                <p class="text-[10px] text-sky-200 mt-2 font-bold">Perlu tindakan admin</p>
            </a>

            {{-- Card 4: Status Berhasil --}}
            <a href="{{ route('admin.pembayaran.index', ['status' => 'approved']) }}"
                class="block bg-white p-6 rounded-3xl border border-emerald-100 shadow-sm transition-all hover:border-emerald-300">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-emerald-500 uppercase tracking-widest">Status Berhasil</p>
                    <i class="fas fa-check-circle text-emerald-200 text-xl"></i>
                </div>
                <h3 class="text-2xl font-black text-emerald-900">{{ $orders->where('status', 'approved')->count() }}
                </h3>
                <p class="text-[10px] text-emerald-400 mt-2 font-bold">Transaksi sukses</p>
            </a>

            {{-- Card 5: Status Dibatalkan --}}
            <a href="{{ route('admin.pembayaran.index', ['status' => 'cancel']) }}"
                class="block bg-white p-6 rounded-3xl border border-rose-100 shadow-sm transition-all hover:border-rose-300">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-rose-500 uppercase tracking-widest">Status Dibatalkan</p>
                    <i class="fas fa-times-circle text-rose-200 text-xl"></i>
                </div>
                <h3 class="text-2xl font-black text-rose-900">{{ $orders->where('status', 'cancelled')->count() }}</h3>
                <p class="text-[10px] text-rose-400 mt-2 font-bold">Transaksi dibatalkan</p>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach (['Laporan Bulanan' => 'chartSatu', 'Tren Penyelesaian' => 'chartDua'] as $title => $id)
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $title }}</h3>
                            <span class="text-[10px] font-medium text-gray-400 italic">{{ $startDateLabel }} -
                                {{ $endDateLabel }}</span>
                        </div>

                        <form action="" method="GET" class="flex items-center gap-2">
                            {{-- Keep existing filters --}}
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if (request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif

                            {{-- Week/Month Toggle --}}
                            <select name="view" onchange="this.form.submit()"
                                class="text-[10px] font-bold border-none bg-sky-50 text-sky-600 rounded-lg px-2 py-1 focus:ring-0">
                                <option value="month" {{ request('view') == 'month' ? 'selected' : '' }}>MONTHLY
                                </option>
                                <option value="week" {{ request('view') == 'week' ? 'selected' : '' }}>WEEKLY
                                </option>
                            </select>

                            <input type="month" name="until" value="{{ request('until', now()->format('Y-m')) }}"
                                onchange="this.form.submit()"
                                class="text-[10px] font-bold text-sky-600 border-none bg-sky-50 rounded-lg py-1 px-2 cursor-pointer focus:ring-0">
                        </form>
                    </div>
                    <div class="h-72"><canvas id="{{ $id }}"></canvas></div>
                </div>
            @endforeach
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-sky-100/50 border border-sky-100 overflow-hidden no-print">
            <div class="p-6 border-b border-sky-50 flex flex-wrap gap-4 items-center justify-between bg-sky-50/20">
                <form action="" method="GET" class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-sky-300">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari Kode Order atau Nama..."
                        class="w-full pl-11 pr-4 py-3 rounded-2xl border border-sky-100 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all text-sm bg-white">
                </form>

                <div class="flex gap-2">
                    <select onchange="window.location.href=this.value"
                        class="px-4 py-3 rounded-2xl border border-sky-100 text-sm font-semibold text-sky-800 outline-none focus:ring-4 focus:ring-sky-500/10 bg-white">
                        <option value="{{ request()->fullUrlWithQuery(['status' => '']) }}">Semua Status</option>
                        <option value="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
                            {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="{{ request()->fullUrlWithQuery(['status' => 'approved']) }}"
                            {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="{{ request()->fullUrlWithQuery(['status' => 'expired']) }}"
                            {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="{{ request()->fullUrlWithQuery(['status' => 'cancelled']) }}"
                            {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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
                        @forelse($orders as $order)
                            <tr class="hover:bg-sky-50/30 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="text-sm font-black text-sky-900">#{{ $order->order_code }}</div>
                                    <div class="text-[10px] text-sky-500 font-bold uppercase mt-1">
                                        {{ $order->created_at?->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-gray-800">
                                        {{ $order->user?->name ?? ($order->name ?? 'User Terhapus') }}</div>
                                    <div class="text-[11px] text-gray-400">{{ $order->user?->email ?? $order->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @php $item = $order->orderItems->first(); @endphp
                                    <div class="text-sm font-semibold text-gray-700">
                                        {{ $item?->ticketType?->name ?? 'N/A' }}</div>
                                    <div
                                        class="text-[10px] px-2 py-0.5 bg-sky-50 text-sky-600 rounded-md inline-block mt-1 font-medium italic">
                                        {{ $order->event?->title ?? 'Event N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 font-black text-sky-900 text-sm">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-5">
                                    @php
                                        // Logika penentuan warna berdasarkan status
                                        if ($order->status == 'approved') {
                                            $bgColor = 'bg-emerald-100';
                                            $textColor = 'text-emerald-600';
                                            $dotColor = 'bg-emerald-500';
                                        } elseif ($order->status == 'pending') {
                                            $bgColor = 'bg-amber-100';
                                            $textColor = 'text-amber-600';
                                            $dotColor = 'bg-amber-500';
                                        } elseif ($order->status == 'cancelled') {
                                            $bgColor = 'bg-red-100';
                                            $textColor = 'text-red-600';
                                            $dotColor = 'bg-red-500';
                                        } else {
                                            $bgColor = 'bg-gray-100';
                                            $textColor = 'text-gray-500';
                                            $dotColor = 'bg-gray-400';
                                        }
                                    @endphp

                                    <span
                                        class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider flex items-center w-fit {{ $bgColor }} {{ $textColor }}">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full mr-2 {{ $order->status == 'pending' ? 'animate-pulse' : '' }} {{ $dotColor }}"></span>
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-sky-400 italic font-bold">
                                    @if (request('search'))
                                        Data tidak ditemukan untuk pencarian "{{ request('search') }}"
                                    @else
                                        Belum ada transaksi masuk.
                                    @endif
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
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
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
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        </script>
    @endpush
</x-admin-layout>
