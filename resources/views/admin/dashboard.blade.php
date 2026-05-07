<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Ringkasan Statistik</h1>
        <p class="text-sm text-gray-500">Pantau performa pembayaran dan transaksi Anda hari ini.</p>
    </div>

    <!-- Section 1: Stats Cards (Dipindah ke atas agar informatif) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Transaksi -->
        <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <p class="text-xs font-bold text-sky-500 uppercase tracking-widest">Total Transaksi</p>
                <i class="fas fa-credit-card text-sky-200 text-xl"></i>
            </div>
            <h3 class="text-2xl font-black text-sky-900">1,284</h3>
            <p class="text-[10px] text-emerald-500 mt-2 font-bold">
                <i class="fa-solid fa-arrow-up mr-1"></i> 12% dari bulan lalu
            </p>
        </div>

        <!-- Pendapatan -->
        <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <p class="text-xs font-bold text-sky-500 uppercase tracking-widest">Pendapatan</p>
                <i class="fas fa-wallet text-sky-200 text-xl"></i>
            </div>
            <h3 class="text-2xl font-black text-sky-900">Rp 45.2M</h3>
            <p class="text-[10px] text-emerald-500 mt-2 font-bold">
                <i class="fa-solid fa-arrow-up mr-1"></i> 8.4% dari bulan lalu
            </p>
        </div>

        <!-- Perlu Diproses -->
        <div class="bg-sky-600 p-6 rounded-3xl shadow-lg shadow-sky-200">
            <div class="flex justify-between items-start mb-4">
                <p class="text-xs font-bold text-sky-100 uppercase tracking-widest">Perlu Diproses</p>
                <i class="fas fa-clock text-sky-300 text-xl"></i>
            </div>
            <h3 class="text-2xl font-black text-white">24</h3>
            <p class="text-[10px] text-sky-200 mt-2 font-bold">Segera cek pesanan baru</p>
        </div>

        <!-- Gagal/Dibatalkan -->
        <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <p class="text-xs font-bold text-sky-500 uppercase tracking-widest">Gagal/Dibatalkan</p>
                <i class="fas fa-file-invoice-dollar text-sky-200 text-xl"></i>
            </div>
            <h3 class="text-2xl font-black text-sky-900">7</h3>
            <p class="text-[10px] text-red-400 mt-2 font-bold">Menurun 2%</p>
        </div>
    </div>

    <!-- Section 2: Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart Pertama: Bar -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Laporan Bulanan</h3>
                <span class="text-xs text-gray-400">Jan - Jun 2026</span>
            </div>
            <div class="h-72">
                <canvas id="chartSatu"></canvas>
            </div>
        </div>

        <!-- Chart Kedua: Line -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Tren Penyelesaian</h3>
                <span class="text-xs text-gray-400">Jan - Jun 2026</span>
            </div>
            <div class="h-72">
                <canvas id="chartDua"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx1 = document.getElementById('chartSatu').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Transaksi Masuk',
                    data: [12, 19, 8, 15, 10, 22],
                    backgroundColor: '#0ea5e9', // Sky 500
                    borderRadius: 12,
                    barThickness: 25,
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false } }
                }
            }
        });

        const ctx2 = document.getElementById('chartDua').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Selesai',
                    data: [5, 12, 10, 18, 14, 25],
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
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { borderDash: [5, 5] } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
    @endpush
</x-admin-layout>