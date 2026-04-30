<x-app-layout>
    <section class="relative bg-[#0A2540] py-20 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Adi" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Sukseskan Event Kamu Bersama LOKET</h1>
            <p class="text-blue-100 text-lg">Beragam paket berlangganan untuk event creator</p>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-black text-[#1A2C50] mb-8">Biaya Penjualan Tiket</h2>

            <div class="flex flex-col lg:flex-row gap-12">
                <div class="flex-1 bg-[#F8F9FA] rounded-2xl border border-gray-100 p-8 shadow-sm">
                    <div class="space-y-8">
                        <div class="flex justify-between items-start border-b border-gray-200 pb-6">
                            <div class="max-w-md">
                                <p class="font-black text-slate-800 text-lg leading-tight">
                                    GoPay, GoPay Later, ShopeePay, Shopee PayLater, LinkAja, dan Kartu Kredit
                                </p>
                            </div>
                            <p class="text-slate-500 font-bold whitespace-nowrap">3,5% x Total Penjualan</p>
                        </div>

                        <div class="flex justify-between items-start">
                            <div class="max-w-md">
                                <p class="font-black text-slate-800 text-lg leading-tight">
                                    VA BCA, Indomaret, Bank Transfer, And Other
                                </p>
                            </div>
                            <p class="text-slate-500 font-bold whitespace-nowrap">3,5% x Total Penjualan</p>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/3 bg-[#F4F7FA] rounded-xl p-6 h-fit border-l-4 border-blue-600">
                    <ul class="space-y-3 text-slate-600 text-sm font-medium">
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600">•</span>
                            Total Sales = Total Tiket Terjual x Harga Tiket
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600">•</span>
                            Biaya sudah termasuk PPN
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600">•</span>
                            PB1 (pajak hiburan) menjadi tanggung jawab event creator
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-[#F9FBFF]">
        <div class="max-w-7xl mx-auto px-4">
            <div class="mb-10">
                <h2 class="text-2xl font-black text-[#1A2C50]">Kalkulator Pendapatan Event</h2>
                <p class="text-slate-500 text-sm">Hitung pendapatan event dan biaya komisi secara instan</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-8" x-data="{
                tikets: [{ nama: 'General Admission', harga: 50000, jumlah: 100 }],
                komisi: 0.035,
                model: 'creator',
            
                tambahTiket() {
                    this.tikets.push({ nama: 'Tiket Baru', harga: 0, jumlah: 0 });
                },
            
                hapusTiket(index) {
                    if (this.tikets.length > 1) this.tikets.splice(index, 1);
                },
            
                get totalKategori() {
                    return this.tikets.length;
                },
            
                get totalJumlah() {
                    return this.tikets.reduce((sum, t) => sum + Number(t.jumlah), 0);
                },
            
                get totalSales() {
                    return this.tikets.reduce((sum, t) => sum + (Number(t.harga) * Number(t.jumlah)), 0);
                },
            
                get biayaTiket() {
                    return this.totalSales * this.komisi;
                },
            
                get totalTerima() {
                    return this.model === 'creator' ?
                        this.totalSales - this.biayaTiket :
                        this.totalSales;
                },
            
                get totalPembeli() {
                    return this.model === 'customer' ?
                        this.totalSales + this.biayaTiket :
                        this.totalSales;
                },
            
                formatRupiah(val) {
                    return 'Rp ' + Number(val).toLocaleString('id-ID');
                }
            }">

                <div class="flex flex-col lg:flex-row gap-12">

                    {{-- Kiri --}}
                    <div class="flex-1 space-y-8">

                        {{-- Kategori Tiket --}}
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="bg-blue-50 p-2 rounded-lg">
                                        <i class="fas fa-ticket-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm">Kategori Tiket</h4>
                                        <p class="text-[10px] text-slate-400">Tambah atau hapus kategori tiket</p>
                                    </div>
                                </div>
                                <button @click="tambahTiket()"
                                    class="text-blue-600 border border-blue-200 px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-50 transition">
                                    + Tambah
                                </button>
                            </div>

                            {{-- List Tiket --}}
                            <template x-for="(tiket, index) in tikets" :key="index">
                                <div class="bg-slate-50 rounded-xl p-6 border border-slate-100 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <input type="text" x-model="tiket.nama"
                                            class="w-full bg-white border border-slate-200 rounded-lg px-4 py-2 text-sm outline-none focus:border-blue-400 mr-3"
                                            placeholder="Nama tiket">
                                        <button @click="hapusTiket(index)" x-show="tikets.length > 1"
                                            class="text-red-400 hover:text-red-600 transition text-sm flex-shrink-0">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">
                                                Harga (IDR)
                                            </label>
                                            <input type="number" x-model="tiket.harga" min="0"
                                                class="w-full bg-white border border-slate-200 rounded-lg px-4 py-2 text-sm outline-none focus:border-blue-400"
                                                placeholder="0">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">
                                                Jumlah
                                            </label>
                                            <input type="number" x-model="tiket.jumlah" min="0"
                                                class="w-full bg-white border border-slate-200 rounded-lg px-4 py-2 text-sm outline-none focus:border-blue-400"
                                                placeholder="0">
                                        </div>
                                    </div>

                                    {{-- Subtotal per tiket --}}
                                    <div class="flex justify-between items-center pt-2 border-t border-slate-200">
                                        <span class="text-[10px] font-bold text-slate-400">Subtotal</span>
                                        <span class="text-sm font-black text-slate-700"
                                            x-text="formatRupiah(tiket.harga * tiket.jumlah)">
                                        </span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Model Komisi --}}
                        <div class="bg-slate-50 rounded-xl p-6 border border-slate-100">
                            <h4 class="font-bold text-slate-800 text-sm mb-2">Model Komisi</h4>
                            <p class="text-[10px] text-slate-400 mb-4 leading-relaxed">
                                Untuk menggunakan model komisi dibayarkan ke pembeli pada pengaturan event,
                                silakan hubungi tim support kami di
                                <span class="text-blue-600">support@loket.com</span>
                            </p>

                            <div class="space-y-3">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="radio" name="model" value="creator" x-model="model"
                                        class="mt-1 accent-blue-600">
                                    <div>
                                        <p class="text-xs font-bold text-slate-700">Dibayar oleh event creator</p>
                                        <p class="text-[10px] text-slate-400">
                                            Komisi 3,5% akan dikurangi dari pendapatan
                                        </p>
                                    </div>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="radio" name="model" value="customer" x-model="model"
                                        class="mt-1 accent-blue-600">
                                    <div>
                                        <p class="text-xs font-bold text-slate-700">Dibayar oleh pelanggan</p>
                                        <p class="text-[10px] text-slate-400">
                                            Komisi 3,5% akan ditambahkan saat pembelian tiket
                                        </p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Kanan - Rincian --}}
                    <div class="lg:w-[400px] space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-50 p-2 rounded-lg">
                                <i class="fas fa-wallet text-green-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Rincian Pendapatan</h4>
                                <p class="text-[10px] text-slate-400">Rangkuman penjualan, biaya, dan pendapatan</p>
                            </div>
                        </div>

                        <div class="bg-slate-50/50 rounded-xl border border-slate-100 overflow-hidden">

                            <div class="p-6 space-y-5">
                                {{-- Per tiket breakdown --}}
                                <template x-for="(tiket, index) in tikets" :key="index">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-slate-500 font-medium truncate max-w-[180px]"
                                            x-text="tiket.nama"></span>
                                        <span class="font-bold text-slate-700"
                                            x-text="formatRupiah(tiket.harga * tiket.jumlah)"></span>
                                    </div>
                                </template>

                                <div class="border-t border-slate-200 pt-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <p class="text-[10px] font-bold text-slate-400">Total Penjualan Tiket</p>
                                        <p class="text-lg font-black text-slate-800"
                                            x-text="formatRupiah(totalSales)"></p>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400">Biaya Platform (3,5%)</p>
                                            <p class="text-[10px] text-slate-400 italic"
                                                x-text="model === 'creator' ? 'Ditanggung creator' : 'Ditanggung pembeli'">
                                            </p>
                                        </div>
                                        <p class="text-base font-black text-red-500"
                                            x-text="'-' + formatRupiah(biayaTiket)"></p>
                                    </div>
                                </div>

                                {{-- Jika model customer --}}
                                <div x-show="model === 'customer'"
                                    class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                                    <p class="text-[10px] font-bold text-blue-600 mb-1">Harga yang dibayar pembeli</p>
                                    <p class="text-sm font-black text-blue-800"
                                        x-text="formatRupiah(totalPembeli / (tikets.reduce((s,t) => s + Number(t.jumlah), 0) || 1)) + ' / tiket (rata-rata)'">
                                    </p>
                                </div>
                            </div>

                            {{-- Total terima --}}
                            <div class="bg-green-50 px-6 py-5 border-t border-green-100">
                                <p class="text-[10px] font-bold text-green-700 mb-1">Total yang kamu terima</p>
                                <p class="text-2xl font-black text-green-700" x-text="formatRupiah(totalTerima)"></p>
                                <p class="text-[10px] text-green-600 mt-1 italic">
                                    Perkiraan total setelah biaya penjualan tiket
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Statistik bawah — letakkan di DALAM x-data yang sama --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                <div class="bg-purple-50 p-6 rounded-xl border border-purple-100">
                    <p class="text-xs font-bold text-slate-500 mb-2">Kategori Tiket</p>
                    <p class="text-2xl font-black text-slate-800" x-text="totalKategori"></p>
                </div>
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                    <p class="text-xs font-bold text-slate-500 mb-2">Total Jumlah Tiket</p>
                    <p class="text-2xl font-black text-slate-800" x-text="totalJumlah"></p>
                </div>
                <div class="bg-red-50 p-6 rounded-xl border border-red-100">
                    <p class="text-xs font-bold text-slate-500 mb-2">Biaya Penjualan Tiket</p>
                    <p class="text-2xl font-black text-slate-800">3,5%</p>
                </div>
            </div>
        </div>
        </div>
    </section>
</x-app-layout>
