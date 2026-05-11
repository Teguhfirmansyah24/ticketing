<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* MODERN MINIMALIST STYLES */
        .glass-card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border-radius: 1.25rem;
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        .btn-action {
            border-radius: 0.75rem;
            transition: all 0.2s;
            font-weight: 600;
        }
        .custom-table thead th {
            background-color: #f8fafc;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.05em;
        }

        @media print {
            nav, aside, .no-print { display: none !important; }
            .glass-card { box-shadow: none !important; border: 1px solid #ddd !important; }
            body { background: white !important; }
        }
    </style>

    <div class="p-8 bg-[#fbfcfd] min-h-screen font-sans text-slate-700">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 no-print">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Laporan Performa</h1>
                <p class="text-slate-500 text-sm mt-1">Pantau statistik penjualan dan okupansi event secara real-time.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center bg-white border border-slate-200 rounded-xl px-3 py-2 shadow-sm">
                    <i class="far fa-calendar-alt text-slate-400 mr-2"></i>
                    <input type="date" id="dateFrom" class="border-none p-0 text-sm focus:ring-0 text-slate-600" value="{{ request('date_from', now()->startOfMonth()->format('Y-m-d')) }}">
                    <span class="mx-2 text-slate-300">—</span>
                    <input type="date" id="dateTo" class="border-none p-0 text-sm focus:ring-0 text-slate-600" value="{{ request('date_to', now()->format('Y-m-d')) }}">
                </div>
                <button id="applyFilterBtn" class="btn-action bg-blue-600 text-white px-5 py-2.5 hover:bg-blue-700 shadow-lg shadow-blue-200">
                    Update
                </button>
                <button onclick="window.print()" class="btn-action bg-white border border-slate-200 text-slate-600 px-5 py-2.5 hover:bg-slate-50">
                    <i class="fas fa-print mr-2"></i>Cetak
                </button>
            </div>
        </div>

        <!-- STAT CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="glass-card p-6 border-t-4 border-t-blue-500">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Revenue</p>
                <h3 class="text-2xl font-black text-slate-900 mt-2" id="statRevenue">Rp 0</h3>
            </div>
            <div class="glass-card p-6 border-t-4 border-t-indigo-500">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tiket Terjual</p>
                <h3 class="text-2xl font-black text-slate-900 mt-2" id="statTickets">0</h3>
            </div>
            <div class="glass-card p-6 border-t-4 border-t-sky-400">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Event Aktif</p>
                <h3 class="text-2xl font-black text-slate-900 mt-2" id="statEvents">0</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8 no-print">
            <div class="glass-card p-6 lg:col-span-2">
                <h4 class="font-bold text-slate-800 mb-6 flex items-center">
                    <span class="w-2 h-6 bg-blue-500 rounded-full mr-3"></span> Tren Pendapatan per Event
                </h4>
                <div class="h-[300px]">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            <div class="glass-card p-6">
                <h4 class="font-bold text-slate-800 mb-6">Sebaran Kategori</h4>
                <div class="h-[250px] flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="glass-card overflow-hidden border-none shadow-xl">
            <div class="px-6 py-5 bg-white border-b border-slate-100 flex justify-between items-center">
                <h4 class="font-bold text-slate-800">Detail Penjualan Unit</h4>
                <span class="text-[10px] bg-slate-100 text-slate-500 px-3 py-1 rounded-full font-bold uppercase tracking-widest">Master Data</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left custom-table">
                    <thead>
                        <tr>
                            <th class="px-6 py-4">Event & Kategori</th>
                            <th class="px-6 py-4 text-center">Terjual</th>
                            <th class="px-6 py-4 text-right">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody id="eventTableBody" class="divide-y divide-slate-50">
                        <!-- Data injected by JS -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

<script>
    // Data dari Laravel Controller
    const originalEventData = @json($eventPerformance);

    let sChart = null;
    let cChart = null;

    function cleanNumber(val) {
        if (typeof val === 'number') return val;
        if (!val) return 0;

        let clean = val.toString().replace(/[^0-9.-]+/g, "");
        return parseFloat(clean) || 0;
    }

    function formatRupiah(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount || 0);
    }

    function updateDashboard(data) {

        const tableBody = document.getElementById('eventTableBody');

        if (!data || data.length === 0) {
            return;
        }

        let totalRevenue = 0;
        let totalSold = 0;

        tableBody.innerHTML = '';

        data.forEach(event => {

            const revenue = cleanNumber(event.revenue || 0);
            const sold = cleanNumber(event.sold_count || 0);

            totalRevenue += revenue;
            totalSold += sold;

            const name = event.title || event.name || 'Tanpa Nama';
            const catName = event.category_name || 'Tanpa Kategori';

            // Progress dummy dari sold ticket
            const occ = Math.min(100, sold);

            tableBody.innerHTML += `
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800 text-sm">${name}</div>
                        <div class="text-[10px] text-slate-400 font-medium uppercase">${catName}</div>
                    </td>

                    <td class="px-6 py-4 text-center font-semibold text-slate-700 text-sm">
                        ${sold.toLocaleString('id-ID')}
                    </td>

                    <td class="px-6 py-4 w-64">
                        <div class="flex items-center gap-3">
                            <div class="flex-grow bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-blue-500 h-full rounded-full"
                                    style="width: ${occ}%">
                                </div>
                            </div>

                            <span class="text-[10px] font-bold text-slate-500">
                                ${occ}%
                            </span>
                        </div>
                    </td>

                    <td class="px-6 py-4 text-right font-bold text-slate-900 text-sm">
                        ${formatRupiah(revenue)}
                    </td>
                </tr>
            `;
        });

        // UPDATE UI CARDS
        document.getElementById('statRevenue').innerText =
            formatRupiah(totalRevenue);

        document.getElementById('statTickets').innerText =
            totalSold.toLocaleString('id-ID');

        document.getElementById('statEvents').innerText =
            data.length;

        renderCharts(data);
    }

    function renderCharts(data) {

        // --- Line Chart ---
        const salesCtx = document.getElementById('salesChart').getContext('2d');

        if (sChart) sChart.destroy();

        sChart = new Chart(salesCtx, {
            type: 'line',

            data: {
                labels: data.map(e => {
                    const name = e.title || e.name || 'N/A';
                    return name.length > 12
                        ? name.substring(0, 10) + '..'
                        : name;
                }),

                datasets: [{
                    label: 'Revenue',
                    data: data.map(e => cleanNumber(e.revenue)),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff'
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            font: {
                                size: 10
                            },

                            callback: (v) =>
                                'Rp' + v.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

        // --- Doughnut Chart ---
        const categoryCounts = {};

        data.forEach(e => {
            const cName = e.category_name || 'Lainnya';
            categoryCounts[cName] = (categoryCounts[cName] || 0) + 1;
        });

        const catCtx = document.getElementById('categoryChart').getContext('2d');

        if (cChart) cChart.destroy();

        cChart = new Chart(catCtx, {
            type: 'doughnut',

            data: {
                labels: Object.keys(categoryCounts),

                datasets: [{
                    data: Object.values(categoryCounts),

                    backgroundColor: [
                        '#3b82f6',
                        '#6366f1',
                        '#0ea5e9',
                        '#f43f5e',
                        '#8b5cf6'
                    ],

                    borderWidth: 0
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',

                plugins: {
                    legend: {
                        position: 'bottom',

                        labels: {
                            usePointStyle: true,

                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    }

    window.onload = function () {
        if (originalEventData) {
            updateDashboard(originalEventData);
        }
    };

    document.getElementById('applyFilterBtn').onclick = function () {

        const from = document.getElementById('dateFrom').value;
        const to = document.getElementById('dateTo').value;

        const filtered = originalEventData.filter(e => {

            const date = e.event_date;

            return (!from || date >= from)
                && (!to || date <= to);
        });

        updateDashboard(filtered);
    };
</script>
</x-admin-layout>