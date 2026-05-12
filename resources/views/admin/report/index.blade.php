<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .glass-card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border-radius: 1.25rem;
            transition: all 0.3s ease;
        }
        .btn-action {
            border-radius: 0.75rem;
            font-weight: 600;
        }
        .custom-table thead th {
            background-color: #f8fafc;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.7rem;
        }
    </style>

    <div class="p-8 bg-[#fbfcfd] min-h-screen font-sans text-slate-700">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 no-print">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Laporan Performa</h1>
                <p class="text-slate-500 text-sm mt-1">Pantau statistik penjualan secara real-time.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('admin.report.index') }}" class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center bg-white border border-slate-200 rounded-xl px-3 py-2 shadow-sm">
                        <input name="date_from" type="date" class="border-none p-0 text-sm focus:ring-0" value="{{ $dateFrom ?? now()->startOfMonth()->format('Y-m-d') }}">
                        <span class="mx-2 text-slate-300">—</span>
                        <input name="date_to" type="date" class="border-none p-0 text-sm focus:ring-0" value="{{ $dateTo ?? now()->format('Y-m-d') }}">
                    </div>
                    <button type="submit" class="btn-action bg-blue-600 text-white px-5 py-2.5 hover:bg-blue-700">Update</button>
                </form>
                <button onclick="window.print()" class="btn-action bg-white border border-slate-200 text-slate-600 px-5 py-2.5 hover:bg-slate-50">Cetak</button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="glass-card p-6 border-t-4 border-t-blue-500">
                <p class="text-xs font-bold text-slate-400 uppercase">Revenue</p>
                <h3 class="text-2xl font-black text-slate-900 mt-2" id="statRevenue">Rp 0</h3>
            </div>
            <div class="glass-card p-6 border-t-4 border-t-indigo-500">
                <p class="text-xs font-bold text-slate-400 uppercase">Tiket Terjual</p>
                <h3 class="text-2xl font-black text-slate-900 mt-2" id="statTickets">0</h3>
            </div>
            <div class="glass-card p-6 border-t-4 border-t-sky-400">
                <p class="text-xs font-bold text-slate-400 uppercase">Event Aktif</p>
                <h3 class="text-2xl font-black text-slate-900 mt-2" id="statEvents">0</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8 no-print">
            <div class="glass-card p-6 lg:col-span-2">
                <h4 class="font-bold text-slate-800 mb-6 flex items-center">
                    <span class="w-2 h-6 bg-blue-500 rounded-full mr-3"></span> Tren Pendapatan per Event
                </h4>
                <div class="h-[300px]"><canvas id="salesChart"></canvas></div>
            </div>
            <div class="glass-card p-6">
                <h4 class="font-bold text-slate-800 mb-6">Sebaran Kategori</h4>
                <div class="h-[250px] flex items-center justify-center"><canvas id="categoryChart"></canvas></div>
            </div>
        </div>

        <div class="glass-card overflow-hidden">
            <div class="px-6 py-5 bg-white border-b border-slate-100 flex justify-between items-center">
                <h4 class="font-bold text-slate-800">Detail Penjualan Unit</h4>
                <span class="text-[10px] bg-slate-100 text-slate-500 px-3 py-1 rounded-full font-bold uppercase">Master Data</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left custom-table">
                    <thead>
                        <tr>
                            <th class="px-6 py-4">Event & Kategori</th>
                            <th class="px-6 py-4 text-center">Terjual</th>
                            <th class="px-6 py-4 text-center">Okupansi</th>
                            <th class="px-6 py-4 text-right">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody id="eventTableBody" class="divide-y divide-slate-50"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const originalEventData = @json($eventPerformance);
        let sChart = null, cChart = null;

        function formatRupiah(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount || 0);
        }

        function updateDashboard(data) {
            const tableBody = document.getElementById('eventTableBody');
            tableBody.innerHTML = '';

            if (!data || data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="4" class="px-6 py-6 text-center text-slate-500">Tidak ada data.</td></tr>';
                document.getElementById('statRevenue').innerText = 'Rp 0';
                document.getElementById('statTickets').innerText = '0';
                document.getElementById('statEvents').innerText = '0';
                renderCharts([]);
                return;
            }

            let totalRev = 0, totalSld = 0;
            data.forEach(event => {
                totalRev += event.revenue;
                totalSld += event.sold_count;
                const occ = Math.min(100, event.sold_count);

                tableBody.innerHTML += `
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 text-sm">${event.title}</div>
                            <div class="text-[10px] text-slate-400 uppercase">${event.category_name}</div>
                        </td>
                        <td class="px-6 py-4 text-center font-semibold text-sm">${event.sold_count.toLocaleString('id-ID')}</td>
                        <td class="px-6 py-4 w-48">
                            <div class="flex items-center gap-2">
                                <div class="flex-grow bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-blue-500 h-full" style="width: ${occ}%"></div>
                                </div>
                                <span class="text-[10px] font-bold text-slate-500">${occ}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-sm">${formatRupiah(event.revenue)}</td>
                    </tr>`;
            });

            document.getElementById('statRevenue').innerText = formatRupiah(totalRev);
            document.getElementById('statTickets').innerText = totalSld.toLocaleString('id-ID');
            document.getElementById('statEvents').innerText = data.filter(e => e.is_active).length;
            renderCharts(data);
        }

        function renderCharts(data) {
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            if (sChart) sChart.destroy();
            sChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: data.length ? data.map(e => e.title.substring(0, 10)) : ['No Data'],
                    datasets: [{
                        label: 'Revenue',
                        data: data.length ? data.map(e => e.revenue) : [0],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.05)',
                        fill: true, tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
            });

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
                        backgroundColor: ['#3b82f6', '#6366f1', '#0ea5e9', '#f43f5e', '#8b5cf6', '#e2e8f0']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, cutout: '75%' }
            });
        }

        window.onload = () => updateDashboard(originalEventData);
    </script>
</x-admin-layout>