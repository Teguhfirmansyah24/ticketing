<x-admin-layout>
    <style>
        @media print {
            /* Hide sidebar, navbar, and buttons */
            nav, aside, header, .sidebar, .navbar, .no-print {
                display: none !important;
            }
            
            /* Main content full width */
            .p-6, main, .content, [x-data] {
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            
            /* Remove shadows and borders */
            .card-shadow, .stat-card, .table-container {
                box-shadow: none !important;
                border: 1px solid #e0e0e0 !important;
                margin-bottom: 10px !important;
            }
            
            /* Optimize spacing for print */
            body, * {
                font-size: 11pt !important;
                line-height: 1.3 !important;
            }
            
            h1 { font-size: 16pt !important; }
            h5 { font-size: 12pt !important; }
            
            /* Ensure tables fit on page */
            table {
                width: 100% !important;
                font-size: 10pt !important;
            }
            
            th, td {
                padding: 6px 8px !important;
            }
            
            /* Hide charts on print to save space */
            .chart-on-screen {
                display: none !important;
            }
            
            /* Force page break control */
            .page-break-inside {
                page-break-inside: avoid;
            }

            /* Hide date filter on print */
            .date-filter-container {
                display: none !important;
            }
        }
        
        @media screen {
            .print-only {
                display: none;
            }
        }
        
        /* Screen styles */
        .card-shadow {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-shadow:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .progress-bar {
            transition: width 0.5s ease-in-out;
        }
        @media (max-width: 768px) {
            .stats-grid, .charts-row {
                flex-direction: column !important;
            }
            .filter-group {
                flex-direction: column !important;
                gap: 10px !important;
            }
        }

        .date-input {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13px;
            background: white;
        }

        .date-input:focus {
            outline: none;
            border-color: #4e73df;
            box-shadow: 0 0 0 2px rgba(78, 115, 223, 0.2);
        }

        .btn-primary {
            background: #4e73df;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #2e59d9;
        }

        .btn-secondary {
            background: #f8f9fc;
            color: #5a5c69;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: #e9ecef;
        }
    </style>

    <!-- Chart.js for screen display only -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div style="padding: 20px; background-color: #f5f7fb; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        
        <!-- Header with Date Filter -->
        <div class="mb-4 flex justify-between items-end no-print date-filter-container" style="flex-wrap: wrap; gap: 15px;">
            <div>
                <h1 class="text-xl font-bold text-sky-800" style="font-size: 1.3rem;">
                    <i class="fas fa-chart-line mr-2 text-sky-600"></i> Laporan Dashboard
                </h1>
                <p class="text-sky-600/70 text-xs">Analisis penjualan tiket dan performa event</p>
            </div>
            
            <div class="filter-group" style="display: flex; gap: 12px; align-items: center;">
                <div>
                    <label style="font-size: 11px; color: #666; display: block; margin-bottom: 4px;">Dari Tanggal</label>
                    <input type="date" id="dateFrom" class="date-input" value="{{ request('date_from', now()->startOfMonth()->format('Y-m-d')) }}">
                </div>
                <div>
                    <label style="font-size: 11px; color: #666; display: block; margin-bottom: 4px;">Sampai Tanggal</label>
                    <input type="date" id="dateTo" class="date-input" value="{{ request('date_to', now()->format('Y-m-d')) }}">
                </div>
                <button id="applyFilterBtn" class="btn-primary" style="margin-top: 18px;">
                    <i class="fas fa-filter mr-1"></i> Terapkan
                </button>
                <button id="resetFilterBtn" class="btn-secondary" style="margin-top: 18px;">
                    <i class="fas fa-undo-alt mr-1"></i> Reset
                </button>
                <button onclick="window.print()" class="btn-secondary" style="margin-top: 18px; background: #4e73df; color: white; border: none;">
                    <i class="fas fa-print mr-2"></i> Cetak Laporan
                </button>
            </div>
        </div>

        <!-- Print-only header with date info -->
        <div class="print-only" style="text-align: center; margin-bottom: 15px;">
            <h2 style="font-size: 18pt; margin: 0;">Laporan Dashboard Admin</h2>
            <p style="margin: 5px 0 0 0;">
                Periode: 
                <span id="printDateFrom">{{ request('date_from', now()->startOfMonth()->format('d/m/Y')) }}</span> 
                s/d 
                <span id="printDateTo">{{ request('date_to', now()->format('d/m/Y')) }}</span>
            </p>
            <p style="margin: 2px 0 0 0; font-size: 9pt;">Generate: {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Stats Row - Compact -->
        <div class="stats-grid" style="display: flex; gap: 15px; margin-bottom: 20px;">
            <div class="stat-card" style="flex: 1; padding: 15px; border-left: 4px solid #4e73df;">
                <div style="font-size: 11px; font-weight: bold; color: #4e73df; text-transform: uppercase;">Total Pendapatan</div>
                <div style="font-size: 20px; font-weight: bold;" id="statRevenue">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card" style="flex: 1; padding: 15px; border-left: 4px solid #1cc88a;">
                <div style="font-size: 11px; font-weight: bold; color: #1cc88a; text-transform: uppercase;">Tiket Terjual</div>
                <div style="font-size: 20px; font-weight: bold;" id="statTickets">{{ number_format($ticketsSold) }} <span style="font-size: 12px;">tiket</span></div>
            </div>
            <div class="stat-card" style="flex: 1; padding: 15px; border-left: 4px solid #f6c23e;">
                <div style="font-size: 11px; font-weight: bold; color: #f6c23e; text-transform: uppercase;">Event Aktif</div>
                <div style="font-size: 20px; font-weight: bold;" id="statEvents">{{ $activeEvents }} <span style="font-size: 12px;">event</span></div>
            </div>
            <div class="stat-card" style="flex: 1; padding: 15px; border-left: 4px solid #e74a3b;">
                <div style="font-size: 11px; font-weight: bold; color: #e74a3b; text-transform: uppercase;">Total Kapasitas</div>
                <div style="font-size: 20px; font-weight: bold;" id="statCapacity">{{ number_format($eventPerformance->sum('total_capacity')) }} <span style="font-size: 12px;">kursi</span></div>
            </div>
        </div>

        <!-- Charts Row - Visible only on screen -->
        <div class="charts-row no-print" style="display: flex; gap: 15px; margin-bottom: 20px;">
            <div class="card-shadow" style="flex: 1; background: white; border-radius: 12px; padding: 10px;">
                <canvas id="salesChart" style="height: 180px; width: 100%;"></canvas>
                <div style="text-align: center; font-size: 10px; color: #666;">Tren Penjualan Tiket per Event</div>
            </div>
            <div class="card-shadow" style="flex: 1; background: white; border-radius: 12px; padding: 10px;">
                <canvas id="categoryChart" style="height: 180px; width: 100%;"></canvas>
                <div style="text-align: center; font-size: 10px; color: #666;">Distribusi Kategori Event</div>
            </div>
        </div>

        <!-- Category Summary Table -->
        <div class="table-container" style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; page-break-inside: avoid;">
            <div style="padding: 12px 15px; background: #f8f9fc; border-bottom: 1px solid #e3e6f0;">
                <h5 style="margin: 0; color: #4e73df; font-size: 14px; font-weight: bold;">
                    <i class="fas fa-list-alt mr-2"></i> Ringkasan per Kategori Event
                </h5>
            </div>
            <div style="padding: 0; overflow-x: auto;">
                <table id="categoryTable" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                            <th style="padding: 10px 12px; text-align: left;">NAMA KATEGORI</th>
                            <th style="padding: 10px 12px; text-align: left;">SLUG / LINK</th>
                            <th style="padding: 10px 12px; text-align: center;">AKTIF</th>
                            <th style="padding: 10px 12px; text-align: center;">TOTAL EVENT</th>
                            <th style="padding: 10px 12px; text-align: center;">TIKET TERJUAL</th>
                            <th style="padding: 10px 12px; text-align: right;">PENDAPATAN</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTableBody">
                        <!-- Dynamic content -->
                    </tbody>
                    <tfoot style="background-color: #f8f9fc; border-top: 2px solid #e3e6f0; font-weight: bold;">
                        <tr id="categoryTableFooter">
                            <!-- Dynamic footer -->
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Event Performance Detail Table -->
        <div class="table-container" style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; margin-top: 20px; page-break-inside: avoid;">
            <div style="padding: 12px 15px; background: #f8f9fc; border-bottom: 1px solid #e3e6f0;">
                <h5 style="margin: 0; color: #4e73df; font-size: 14px; font-weight: bold;">
                    <i class="fas fa-ticket-alt mr-2"></i> Detail Penjualan per Event
                </h5>
            </div>
            <div style="padding: 0; overflow-x: auto;">
                <table id="eventTable" style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <thead>
                        <tr style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                            <th style="padding: 8px 10px; text-align: left;">Nama Event</th>
                            <th style="padding: 8px 10px; text-align: left;">Kategori</th>
                            <th style="padding: 8px 10px; text-align: center;">Tanggal Event</th>
                            <th style="padding: 8px 10px; text-align: center;">Terjual</th>
                            <th style="padding: 8px 10px; text-align: center;">Kapasitas</th>
                            <th style="padding: 8px 10px; text-align: center;">Okupansi</th>
                            <th style="padding: 8px 10px; text-align: right;">Pendapatan</th>
                            <th style="padding: 8px 10px; text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="eventTableBody">
                        <!-- Dynamic content -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center;">
            <div style="background: white; padding: 20px; border-radius: 12px;">
                <i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...
            </div>
        </div>

        <!-- Footer -->
        <div style="margin-top: 15px; text-align: center; padding: 10px; color: #858796; font-size: 9px; border-top: 1px solid #e3e6f0;">
            <p>Laporan digenerate: {{ now()->format('d/m/Y H:i:s') }} | © Sistem Manajemen Event</p>
        </div>
    </div>

    <script>
        
        const originalEventData = @json($eventPerformance);

        let salesChart = null;
        let categoryChart = null;

        // Format number to Indonesian Rupiah
        function formatRupiah(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        }

        function formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        // Filter data by date range
        function filterDataByDate(data, fromDate, toDate) {
            if (!fromDate && !toDate) return data;
            
            const from = fromDate ? new Date(fromDate) : null;
            const to = toDate ? new Date(toDate) : null;
            
            if (from) from.setHours(0, 0, 0, 0);
            if (to) to.setHours(23, 59, 59, 999);
            
            return data.filter(item => {
                const itemDate = new Date(item.event_date);
                if (from && to) return itemDate >= from && itemDate <= to;
                if (from) return itemDate >= from;
                if (to) return itemDate <= to;
                return true;
            });
        }

        // Group data by category
        function groupByCategory(data) {
            const grouped = {};
            data.forEach(event => {
                const catName = event.category_name;
                if (!grouped[catName]) {
                    grouped[catName] = {
                        name: catName,
                        slug: event.category_slug,
                        activeCount: 0,
                        totalEvents: 0,
                        totalTicketsSold: 0,
                        totalRevenue: 0
                    };
                }
                grouped[catName].totalEvents++;
                grouped[catName].totalTicketsSold += event.sold_count;
                grouped[catName].totalRevenue += event.revenue;
                if (event.is_active) grouped[catName].activeCount++;
            });
            return Object.values(grouped);
        }

        // Update all dashboard components
        function updateDashboard(filteredEvents) {
            // Calculate totals
            const totalRevenue = filteredEvents.reduce((sum, e) => sum + (e.revenue || 0), 0);
            const totalTicketsSold = filteredEvents.reduce((sum, e) => sum + (e.sold_count || 0), 0);
            const totalCapacity = filteredEvents.reduce((sum, e) => sum + (e.total_capacity || 0), 0);
            const totalActiveEvents = filteredEvents.filter(e => e.is_active).length;
            
            // Update stat cards
            document.getElementById('statRevenue').innerHTML = formatRupiah(totalRevenue);
            document.getElementById('statTickets').innerHTML = formatNumber(totalTicketsSold) + ' <span style="font-size: 12px;">tiket</span>';
            document.getElementById('statEvents').innerHTML = totalActiveEvents + ' <span style="font-size: 12px;">event</span>';
            document.getElementById('statCapacity').innerHTML = formatNumber(totalCapacity) + ' <span style="font-size: 12px;">kursi</span>';
            
            // Update category table
            const categories = groupByCategory(filteredEvents);
            const categoryTableBody = document.getElementById('categoryTableBody');
            categoryTableBody.innerHTML = '';
            categories.forEach(cat => {
                const row = document.createElement('tr');
                row.style.borderBottom = '1px solid #e3e6f0';
                row.innerHTML = `
                    <td style="padding: 10px 12px; font-weight: 500; color: #2c3e50;">${cat.name}</td>
                    <td style="padding: 10px 12px; color: #6c757d;">${cat.slug}</td>
                    <td style="padding: 10px 12px; text-align: center;">
                        <span style="color: #1cc88a;"><i class="fas fa-check-circle"></i> ${cat.activeCount}</span>
                    </td>
                    <td style="padding: 10px 12px; text-align: center; font-weight: 500;">${cat.totalEvents}</td>
                    <td style="padding: 10px 12px; text-align: center; font-weight: 500;">${formatNumber(cat.totalTicketsSold)}</td>
                    <td style="padding: 10px 12px; text-align: right; font-weight: 500;">${formatRupiah(cat.totalRevenue)}</td>
                `;
                categoryTableBody.appendChild(row);
            });
            
            // Update category table footer
            const footer = document.getElementById('categoryTableFooter');
            footer.innerHTML = `
                <td colspan="3" style="padding: 10px 12px; text-align: right;">TOTAL KESELURUHAN</td>
                <td style="padding: 10px 12px; text-align: center;">${filteredEvents.length}</td>
                <td style="padding: 10px 12px; text-align: center;">${formatNumber(totalTicketsSold)}</td>
                <td style="padding: 10px 12px; text-align: right;">${formatRupiah(totalRevenue)}</td>
            `;
            
            // Update event detail table
            const eventTableBody = document.getElementById('eventTableBody');
            eventTableBody.innerHTML = '';
            filteredEvents.sort((a, b) => b.sold_count - a.sold_count).forEach(event => {
                const occupancy = event.total_capacity > 0 ? Math.min(100, Math.round((event.sold_count / event.total_capacity) * 100)) : 0;
                const occupancyColor = occupancy >= 70 ? '#28a745' : (occupancy >= 40 ? '#f6c23e' : '#e74a3b');
                const eventDate = new Date(event.event_date);
                const formattedDate = eventDate.toLocaleDateString('id-ID');
                
                const row = document.createElement('tr');
                row.style.borderBottom = '1px solid #e3e6f0';
                row.innerHTML = `
                    <td style="padding: 8px 10px; font-weight: 500;">${event.name.length > 35 ? event.name.substring(0, 35) + '...' : event.name}</td>
                    <td style="padding: 8px 10px; color: #6c757d;">${event.category_name}</td>
                    <td style="padding: 8px 10px; text-align: center; font-size: 11px;">${formattedDate}</td>
                    <td style="padding: 8px 10px; text-align: center; font-weight: 500;">${formatNumber(event.sold_count)}</td>
                    <td style="padding: 8px 10px; text-align: center;">${formatNumber(event.total_capacity)}</td>
                    <td style="padding: 8px 10px; text-align: center;">
                        <span style="color: ${occupancyColor};">${occupancy}%</span>
                    </td>
                    <td style="padding: 8px 10px; text-align: right;">${formatRupiah(event.revenue)}</td>
                    <td style="padding: 8px 10px; text-align: center;">
                        <span style="padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: bold; background: ${event.is_active ? '#d1e7dd' : '#f8d7da'}; color: ${event.is_active ? '#0f5132' : '#842029'};">
                            ${event.is_active ? 'Aktif' : 'Draft'}
                        </span>
                    </td>
                `;
                eventTableBody.appendChild(row);
            });
            
            // Update charts
            updateCharts(filteredEvents);
            
            // Update print date display
            const fromDate = document.getElementById('dateFrom').value;
            const toDate = document.getElementById('dateTo').value;
            if (fromDate) {
                const fromParts = fromDate.split('-');
                document.getElementById('printDateFrom').innerText = `${fromParts[2]}/${fromParts[1]}/${fromParts[0]}`;
            }
            if (toDate) {
                const toParts = toDate.split('-');
                document.getElementById('printDateTo').innerText = `${toParts[2]}/${toParts[1]}/${toParts[0]}`;
            }
        }
        
        // Update charts
        function updateCharts(filteredEvents) {
            const topEvents = [...filteredEvents].sort((a, b) => b.sold_count - a.sold_count).slice(0, 8);
            const eventNames = topEvents.map(e => e.name.length > 20 ? e.name.substring(0, 18) + '...' : e.name);
            const ticketSold = topEvents.map(e => e.sold_count);
            
            // Update sales chart
            if (salesChart) salesChart.destroy();
            const salesCtx = document.getElementById('salesChart')?.getContext('2d');
            if (salesCtx) {
                salesChart = new Chart(salesCtx, {
                    type: 'bar',
                    data: {
                        labels: eventNames,
                        datasets: [{
                            label: 'Tiket Terjual',
                            data: ticketSold,
                            backgroundColor: 'rgba(78, 115, 223, 0.7)',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: { legend: { position: 'top', labels: { font: { size: 10 } } } },
                        scales: { y: { beginAtZero: true, ticks: { callback: v => v.toLocaleString() } } }
                    }
                });
            }
            
            // Update category chart
            const categories = {};
            filteredEvents.forEach(e => {
                categories[e.category_name] = (categories[e.category_name] || 0) + 1;
            });
            const categoryNames = Object.keys(categories);
            const categoryCounts = Object.values(categories);
            
            if (categoryChart) categoryChart.destroy();
            const catCtx = document.getElementById('categoryChart')?.getContext('2d');
            if (catCtx && categoryNames.length) {
                categoryChart = new Chart(catCtx, {
                    type: 'doughnut',
                    data: {
                        labels: categoryNames,
                        datasets: [{
                            data: categoryCounts,
                            backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b', '#36b9cc', '#858796', '#fd7e14', '#6f42c1']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: { legend: { position: 'bottom', labels: { font: { size: 9 } } } }
                    }
                });
            }
        }
        
        // Handle filter application
        function applyFilter() {
            const fromDate = document.getElementById('dateFrom').value;
            const toDate = document.getElementById('dateTo').value;
            
            // Show loading
            const loading = document.getElementById('loadingOverlay');
            loading.style.display = 'flex';
            
            // Simulate loading (or make actual AJAX call)
            setTimeout(() => {
                const filtered = filterDataByDate(originalEventData, fromDate, toDate);
                updateDashboard(filtered);
                loading.style.display = 'none';
            }, 300);
        }
        
        function resetFilter() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            document.getElementById('dateFrom').value = firstDay.toISOString().split('T')[0];
            document.getElementById('dateTo').value = today.toISOString().split('T')[0];
            applyFilter();
        }
        
        // Event listeners
        document.getElementById('applyFilterBtn').addEventListener('click', applyFilter);
        document.getElementById('resetFilterBtn').addEventListener('click', resetFilter);
        
        // Initialize dashboard on load
        document.addEventListener('DOMContentLoaded', function() {
            // Apply initial filter based on URL parameters or default dates
            const urlParams = new URLSearchParams(window.location.search);
            const urlFrom = urlParams.get('date_from');
            const urlTo = urlParams.get('date_to');
            
            if (urlFrom) document.getElementById('dateFrom').value = urlFrom;
            if (urlTo) document.getElementById('dateTo').value = urlTo;
            
            applyFilter();
        });
    </script>
</x-admin-layout>