<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Maintaining consistency with dashboard styles */
        .glass-card {
            background: white;
            border: 1px solid #e0f2fe; /* sky-100 */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border-radius: 1.5rem;
            transition: all 0.3s ease;
        }
        .btn-action {
            border-radius: 0.75rem;
            font-weight: 600;
        }
        @media print {
            .no-print { display: none !important; }
            .p-8 { padding: 0 !important; }
        }
    </style>

    <div class="p-8 bg-[#fbfcfd] min-h-screen font-sans text-slate-700">
        
        <!-- Header Section -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4 no-print">
            <div>
                <h1 class="text-2xl font-extrabold text-sky-900">Laporan Performa</h1>
                <p class="text-sky-600 text-sm mt-1">Pantau statistik penjualan secara real-time.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('admin.report.index') }}" class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center bg-white border border-sky-200 rounded-xl px-3 py-2 shadow-sm">
                        <input name="date_from" type="date" class="border-none p-0 text-sm focus:ring-0 text-sky-800" value="{{ $dateFrom ?? now()->startOfMonth()->format('Y-m-d') }}">
                        <span class="mx-2 text-sky-300">—</span>
                        <input name="date_to" type="date" class="border-none p-0 text-sm focus:ring-0 text-sky-800" value="{{ $dateTo ?? now()->format('Y-m-d') }}">
                    </div>
                    <button type="submit" class="btn-action bg-sky-600 text-white px-5 py-2.5 hover:bg-sky-700 transition-all shadow-sm">Update</button>
                </form>
                <button onclick="window.print()" class="btn-action bg-white border border-sky-200 text-sky-600 px-5 py-2.5 hover:bg-sky-50 shadow-sm flex items-center">
                    <i class="fas fa-print mr-2"></i> Cetak
                </button>
            </div>
        </div>

        <!-- Updated Stat Cards to match Dashboard Admin (image_fc3b32.png) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Revenue Card -->
            <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-sky-500 uppercase tracking-widest">Pendapatan</p>
                    <i class="fas fa-wallet text-sky-200 text-xl"></i>
                </div>
                <h3 class="text-2xl font-black text-sky-900" id="statRevenue">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-emerald-500 mt-2 font-bold italic">Berdasarkan periode terpilih</p>
            </div>

            <!-- Tiket Terjual Card (Blue Highlight match) -->
            <div class="bg-sky-600 p-6 rounded-3xl shadow-lg shadow-sky-200">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-sky-100 uppercase tracking-widest">Tiket Terjual</p>
                    <i class="fas fa-ticket-alt text-sky-300 text-xl"></i>
                </div>
                <h3 class="text-2xl font-black text-white" id="statTickets">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-sky-200 mt-2 font-bold uppercase italic">Volume Penjualan</p>
            </div>

            <!-- Event Aktif Card -->
            <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-sky-500 uppercase tracking-widest">Event Berjalan</p>
                    <i class="fas fa-calendar-check text-sky-200 text-xl"></i>
                </div>
                <h3 class="text-2xl font-black text-sky-900" id="statEvents">{{ $activeEvents }}</h3>
                <p class="text-[10px] text-sky-400 mt-2 font-bold italic">Total event terpantau</p>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8 no-print">
            <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm lg:col-span-2">
                <h4 class="font-bold text-slate-800 mb-6 flex items-center">
                    <span class="w-2 h-6 bg-sky-500 rounded-full mr-3"></span> Tren Pendapatan per Event
                </h4>
                <div class="h-[300px]"><canvas id="salesChart"></canvas></div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm">
                <h4 class="font-bold text-slate-800 mb-6">Sebaran Kategori</h4>
                <div class="h-[250px] flex items-center justify-center"><canvas id="categoryChart"></canvas></div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-3xl shadow-xl shadow-sky-100/50 border border-sky-100 overflow-hidden">
            <div class="px-6 py-5 bg-sky-50/20 border-b border-sky-50 flex justify-between items-center">
                <h4 class="font-bold text-sky-900 text-lg">Detail Penjualan Unit</h4>
                <span class="text-[10px] bg-sky-100 text-sky-600 px-3 py-1 rounded-full font-bold uppercase tracking-widest">Master Data</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-sky-600 text-white text-[10px] uppercase tracking-[0.2em] font-bold">
                            <th class="px-6 py-4">Event & Kategori</th>
                            <th class="px-6 py-4 text-center">Terjual</th>
                            <th class="px-6 py-4 text-right">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody id="eventTableBody" class="divide-y divide-sky-50">
                        @forelse($eventPerformance as $event)
                        <tr class="hover:bg-sky-50/30 transition-colors">
                            <td class="px-6 py-5">
                                <div class="text-sm font-black text-sky-900">{{ $event['title'] }}</div>
                                <div class="text-[10px] text-sky-500 font-bold uppercase mt-1">{{ $event['category_name'] }}</div>
                            </td>
                            <td class="px-6 py-5 text-center font-bold text-sky-800 text-sm">
                                {{ number_format($event['sold_count'], 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5 text-right font-black text-sky-900 text-sm">
                                Rp {{ number_format($event['revenue'], 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-sky-400 italic font-bold">Tidak ada data untuk periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const originalEventData = @json($eventPerformance);
        let sChart = null, cChart = null;

        function renderCharts(data) {
            // Line Chart: Revenue per Event
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            if (sChart) sChart.destroy();
            sChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: data.length ? data.map(e => e.title.length > 15 ? e.title.substring(0, 15) + '...' : e.title) : ['No Data'],
                    datasets: [{
                        label: 'Revenue',
                        data: data.length ? data.map(e => e.revenue) : [0],
                        borderColor: '#0284c7',
                        backgroundColor: 'rgba(2, 132, 199, 0.1)',
                        fill: true, 
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#0284c7'
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    plugins: { legend: { display: false } },
                    scales: { 
                        y: { beginAtZero: true, grid: { color: '#f0f9ff' } },
                        x: { grid: { display: false } }
                    } 
                }
            });

            // Doughnut Chart: Categories
            const catCounts = {};
            data.forEach(e => { catCounts[e.category_name] = (catCounts[e.category_name] || 0) + 1; });
            
            const catCtx = document.getElementById('categoryChart').getContext('2d');
            if (cChart) cChart.destroy();
            cChart = new Chart(catCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(catCounts).length ? Object.keys(catCounts) : ['Empty'],
                    datasets: [{
                        data: Object.values(catCounts).length ? Object.values(catCounts) : [1],
                        backgroundColor: ['#0ea5e9', '#6366f1', '#38bdf8', '#f43f5e', '#8b5cf6', '#e2e8f0']
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    cutout: '75%',
                    plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } } }
                }
            });
        }

        window.onload = () => renderCharts(originalEventData);
    </script>
</x-admin-layout>