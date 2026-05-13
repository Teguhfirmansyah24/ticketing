    <x-admin-layout>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <style>
            .glass-card {
                background: white;
                border: 1px solid #e0f2fe;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                border-radius: 1.5rem;
                transition: all 0.3s ease;
            }
            .btn-action {
                border-radius: 0.75rem;
                font-weight: 600;
            }
            /* Cursor pointer for clickable rows */
            .clickable-row { cursor: pointer; }
            
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

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Revenue Card -->
                <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm cursor-pointer hover:bg-sky-50 transition-all" 
                    onclick="showTotalRevenueBreakdown()">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-xs font-bold text-sky-500 uppercase tracking-widest">Pendapatan</p>
                        <i class="fas fa-wallet text-sky-200 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-sky-900" id="statRevenue">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-[10px] text-emerald-500 mt-2 font-bold italic underline">Klik untuk detail kategori</p>
                </div>

                <div class="bg-sky-600 p-6 rounded-3xl shadow-lg shadow-sky-200">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-xs font-bold text-sky-100 uppercase tracking-widest">Tiket Terjual</p>
                        <i class="fas fa-ticket-alt text-sky-300 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-white">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
                    <p class="text-[10px] text-sky-200 mt-2 font-bold uppercase italic">Volume Penjualan</p>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-xs font-bold text-sky-500 uppercase tracking-widest">Event Berjalan</p>
                        <i class="fas fa-calendar-check text-sky-200 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-sky-900">{{ $activeEvents }}</h3>
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
                    <span class="text-[10px] bg-sky-100 text-sky-600 px-3 py-1 rounded-full font-bold uppercase tracking-widest">Klik Baris: Pembeli | Klik Harga: Ringkasan</span>
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
                            @forelse($eventPerformance as $index => $event)
                            <tr class="hover:bg-sky-50/50 transition-colors cursor-pointer group">
                                <!-- Click here for Buyer Detail -->
                                <td class="px-6 py-5" onclick="showBuyers({{ $index }})">
                                    <div class="text-sm font-black text-sky-900 group-hover:text-sky-600">{{ $event['title'] }}</div>
                                    <div class="text-[10px] text-sky-500 font-bold uppercase mt-1">{{ $event['category_name'] }}</div>
                                </td>
                                <td class="px-6 py-5 text-center font-bold text-sky-800 text-sm" onclick="showBuyers({{ $index }})">
                                    {{ number_format($event['sold_count'], 0, ',', '.') }}
                                </td>
                                <!-- Click here for Revenue/Category Summary -->
                                <td class="px-6 py-5 text-right font-black text-sky-900 text-sm hover:bg-sky-100 transition-all rounded-r-2xl" 
                                    onclick="showRevenueDetail({{ $index }}); event.stopPropagation();">
                                    <span class="text-sky-700">Rp {{ number_format($event['revenue'], 0, ',', '.') }}</span>
                                    <div class="text-[9px] text-sky-400 font-bold italic">Lihat Detail ➔</div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-sky-400 italic font-bold">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            <!-- Modal 1: Buyer Details (Existing) -->
            <div id="buyerModal" class="fixed inset-0 z-50 hidden overflow-y-auto no-print">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('buyerModal')"></div>
                    <div class="relative bg-white rounded-3xl shadow-xl max-w-lg w-full overflow-hidden">
                        <div class="px-6 py-5 border-b border-sky-50 bg-sky-50/30 flex justify-between items-center">
                            <h3 class="text-lg font-black text-sky-900" id="modalTitle">Detail Pembeli</h3>
                            <button onclick="closeModal('buyerModal')" class="text-sky-400"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="px-6 py-4 max-h-[60vh] overflow-y-auto">
                            <table class="w-full text-left"><tbody id="buyerList" class="divide-y divide-slate-50"></tbody></table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal 2: Revenue Detail (New) -->
            <div id="revenueModal" class="fixed inset-0 z-50 hidden overflow-y-auto no-print">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-sky-900/40 backdrop-blur-sm" onclick="closeModal('revenueModal')"></div>
                    <div class="relative bg-white rounded-3xl shadow-xl max-w-sm w-full overflow-hidden border-t-4 border-sky-600">
                        <div class="px-8 py-10 text-center">
                            <div class="w-16 h-16 bg-sky-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-chart-line text-sky-600 text-2xl"></i>
                            </div>
                            <h3 class="text-xs uppercase tracking-widest font-black text-sky-400 mb-1" id="revCategory">Kategori</h3>
                            <h2 class="text-lg font-bold text-slate-800 mb-6" id="revEventTitle">Event Title</h2>
                            
                            <div class="bg-sky-50 rounded-2xl p-6">
                                <p class="text-[10px] font-bold text-sky-600 uppercase mb-1">Total Hasil</p>
                                <p class="text-3xl font-black text-sky-900" id="revAmount">Rp 0</p>
                            </div>

                            <button onclick="closeModal('revenueModal')" class="mt-8 w-full bg-slate-800 text-white py-3 rounded-xl font-bold hover:bg-slate-900 transition-all">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal: Total Revenue Breakdown -->
            <div id="totalRevenueModal" class="fixed inset-0 z-50 hidden overflow-y-auto no-print">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('totalRevenueModal')"></div>
                    <div class="relative bg-white rounded-3xl shadow-xl max-w-md w-full overflow-hidden border-t-4 border-emerald-500">
                        <div class="px-6 py-5 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                            <h3 class="text-lg font-black text-slate-800">Total Pendapatan Kategori</h3>
                            <button onclick="closeModal('totalRevenueModal')" class="text-slate-400 hover:text-slate-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        <div class="px-6 py-6">
                            <div id="categoryBreakdownList" class="space-y-4">
                                <!-- JS will inject breakdown here -->
                            </div>
                            <div class="mt-8 pt-4 border-t border-dashed border-slate-200 flex justify-between items-center">
                                <span class="font-bold text-slate-500">TOTAL AKHIR</span>
                                <span class="text-xl font-black text-emerald-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <script>
            // 1. Declare chart variables globally so they can be tracked/destroyed
            let sChart = null;
            let cChart = null;
            
            // 2. Data injected from Laravel
            const originalEventData = @json($eventPerformance);

            // --- NEW: TOTAL REVENUE BREAKDOWN (For the big Stat Card) ---
            function showTotalRevenueBreakdown() {
                const list = document.getElementById('categoryBreakdownList');
                if(!list) return; // Safety check
                
                list.innerHTML = '';
                const totals = {};

                // Sum up revenue by category name
                originalEventData.forEach(event => {
                    const cat = event.category_name || 'Lainnya';
                    const rev = parseInt(event.revenue) || 0;
                    totals[cat] = (totals[cat] || 0) + rev;
                });

                // Create the HTML for the list
                Object.keys(totals).forEach(catName => {
                    const amount = totals[catName];
                    list.innerHTML += `
                        <div class="flex justify-between items-center p-4 bg-sky-50/50 rounded-2xl border border-sky-100">
                            <div>
                                <p class="text-[10px] font-black text-sky-500 uppercase tracking-widest">${catName}</p>
                                <p class="text-sm font-bold text-slate-700">Total Pendapatan</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-sky-900">Rp ${amount.toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                    `;
                });

                document.getElementById('totalRevenueModal').classList.remove('hidden');
            }

            // --- MODAL: SHOW BUYERS (For Table Rows) ---
            function showBuyers(index) {
                const event = originalEventData[index];
                const list = document.getElementById('buyerList');
                document.getElementById('modalTitle').innerText = event.title;
                list.innerHTML = '';
                
                event.buyers.forEach(buyer => {
                    list.innerHTML += `
                        <tr class="text-sm">
                            <td class="py-4">
                                <div class="font-bold text-slate-700">${buyer.name}</div>
                                <div class="text-[10px] text-slate-400">${buyer.date}</div>
                            </td>
                            <td class="py-4 text-right font-black text-sky-600">
                                Rp ${parseInt(buyer.amount).toLocaleString('id-ID')}
                            </td>
                        </tr>`;
                });
                document.getElementById('buyerModal').classList.remove('hidden');
            }

            // --- MODAL: SHOW REVENUE DETAIL (For Table Price Column) ---
            function showRevenueDetail(index) {
                const event = originalEventData[index];
                document.getElementById('revEventTitle').innerText = event.title;
                document.getElementById('revCategory').innerText = event.category_name;
                document.getElementById('revAmount').innerText = 'Rp ' + parseInt(event.revenue).toLocaleString('id-ID');
                
                document.getElementById('revenueModal').classList.remove('hidden');
            }

            // --- MODAL: CLOSE LOGIC ---
            function closeModal(id) {
                document.getElementById(id).classList.add('hidden');
            }

            // --- CHART LOGIC ---
            function renderCharts(data) {
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

                const catCounts = {};
                data.forEach(e => { 
                    const count = parseInt(e.sold_count) || 0;
                    catCounts[e.category_name] = (catCounts[e.category_name] || 0) + count; 
                });

                const catCtx = document.getElementById('categoryChart').getContext('2d');
                if (cChart) cChart.destroy();
                
                cChart = new Chart(catCtx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(catCounts).length ? Object.keys(catCounts) : ['Empty'],
                        datasets: [{
                            label: 'Total Terjual',
                            data: Object.values(catCounts).length ? Object.values(catCounts) : [1],
                            backgroundColor: ['#0ea5e9', '#6366f1', '#38bdf8', '#f43f5e', '#8b5cf6', '#e2e8f0'],
                            borderWidth: 2,
                            hoverOffset: 4
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false, 
                        cutout: '70%',
                        plugins: { 
                            legend: { 
                                position: 'bottom', 
                                labels: { padding: 20, usePointStyle: true, font: { size: 11, weight: '600' } } 
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return ` ${context.label}: ${context.raw.toLocaleString()} Tiket`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Initialize everything
            window.onload = () => renderCharts(originalEventData);
        </script>
    </x-admin-layout>
