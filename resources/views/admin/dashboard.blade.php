<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Ringkasan Statistik</h1>
    </div>

    <!-- Container Chart Berjejer -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Chart Pertama: Bar -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold mb-4">Laporan Bulanan</h3>
            <div class="h-64">
                <canvas id="chartSatu"></canvas>
            </div>
        </div>

        <!-- Chart Kedua: Line -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold mb-4">Tren Penyelesaian</h3>
            <div class="h-64">
                <canvas id="chartDua"></canvas>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            // Data dari Chart Satu
            const ctx1 = document.getElementById('chartSatu').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Data Masuk',
                        data: [12, 19, 8, 15, 10, 22],
                        backgroundColor: '#4F46E5', // Warna Indigo Tailwind
                        borderRadius: 8
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true
                }
            });

            // Data dari Chart Dua
            const ctx2 = document.getElementById('chartDua').getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Selesai',
                        data: [5, 12, 10, 18, 14, 25],
                        borderColor: '#10B981', // Warna Green Tailwind
                        tension: 0.3,
                        fill: true,
                        backgroundColor: 'rgba(16, 185, 129, 0.1)'
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true
                }
            });
        </script>
    @endpush
</x-admin-layout>
