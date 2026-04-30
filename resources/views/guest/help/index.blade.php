<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOKET - Help Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #1A2C50 0%, #111D35 100%);
            position: relative;
        }

        /* Efek gelombang halus di background */
        .wave-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://www.transparenttextures.com/patterns/cubes.png');
            opacity: 0.05;
            pointer-events: none;
        }

        .tab-active {
            color: #2563eb;
            /* Blue-600 */
            border-bottom: 4px solid #2563eb;
        }

        .tab-inactive {
            color: #94a3b8;
            /* Slate-400 */
            border-bottom: 4px solid transparent;
        }
    </style>
</head>

<body class="bg-gray-50">

    <nav class="bg-white border-b border-gray-100 py-3 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">

            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="text-[#1A2C50] font-black text-2xl tracking-tighter">LOKÉT</span>
                    <div
                        class="ml-2 bg-[#FF7A30] text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1">
                        <span>12</span>
                        <span class="uppercase">Tahun</span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-4">
                <div
                    class="flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-full border border-gray-200 cursor-pointer hover:bg-gray-100 transition-all">
                    <img src="https://flagcdn.com/w40/id.png" alt="ID" class="w-4 h-3 object-cover rounded-sm">
                    <span class="text-xs font-bold text-slate-700">ID</span>
                    <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
                </div>
            </div>

        </div>
    </nav>

    <section class="hero-gradient overflow-hidden relative min-h-[400px] flex items-center">
        <div class="wave-overlay"></div>

        <div class="max-w-7xl mx-auto px-4 w-full relative z-10 py-16 lg:py-0">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">

                <div class="lg:w-1/2 text-center lg:text-left">
                    <h1 class="text-white text-3xl md:text-5xl font-black leading-tight">
                        Hai kamu, ada yang bisa kami bantu?
                    </h1>
                </div>

                <div class="lg:w-1/2 flex justify-center lg:justify-end">
                    <div class="relative w-full max-w-[550px] transform translate-y-8 lg:translate-y-12">
                        <img src="{{ asset('assets/images/Auth.png') }}" alt="LOKET Support Illustration"
                            class="w-full h-auto drop-shadow-2xl"
                            onerror="this.src='https://placehold.co/600x400/1A2C50/FFFFFF?text=Ilustrasi+Maskot+LOKET'">
                    </div>
                </div>

            </div>
        </div>

        <div class="absolute bottom-0 left-0 w-full leading-[0] opacity-10">
            <svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                <path fill="#ffffff"
                    d="M0,160L80,176C160,192,320,224,480,213.3C640,203,800,149,960,149.3C1120,149,1280,203,1360,218.7L1440,235L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z">
                </path>
            </svg>
        </div>
    </section>

    <div class="max-w-4xl mx-auto mt-12 px-4">
        <div class="flex justify-center border-b border-gray-100">
            <button onclick="switchTab('pembeli')" id="btn-pembeli"
                class="flex items-center gap-2 px-8 py-4 font-bold transition-all duration-300 tab-active">
                <i class="far fa-user"></i>
                Pembeli Tiket
            </button>
            <button onclick="switchTab('pembuat')" id="btn-pembuat"
                class="flex items-center gap-2 px-8 py-4 font-bold transition-all duration-300 tab-inactive">
                <i class="fas fa-ticket-alt"></i>
                Pembuat Event
            </button>
        </div>

        <div class="py-10 relative">
            <div class="hidden md:block absolute left-[-100px] top-10 animate-bounce">
                <img src="https://assets.loket.com/images/help-center-bubble.png" class="w-16 opacity-50"
                    onerror="this.src='https://placehold.co/60/DAE9FF/1A2C50?text=?'">
            </div>

            <div id="content-pembeli" class="space-y-4 block">
                <div
                    class="group border border-gray-200 rounded-xl p-5 hover:shadow-md cursor-pointer transition-all flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="text-xl font-bold text-gray-400">+</span>
                        <span class="font-bold text-slate-700">Pembelian Tiket</span>
                    </div>
                </div>
                <div
                    class="group border border-gray-200 rounded-xl p-5 hover:shadow-md cursor-pointer transition-all flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="text-xl font-bold text-gray-400">+</span>
                        <span class="font-bold text-slate-700">Bantuan Akun & Loket X</span>
                    </div>
                </div>
                <div
                    class="group border border-gray-200 rounded-xl p-5 hover:shadow-md cursor-pointer transition-all flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="text-xl font-bold text-gray-400">+</span>
                        <span class="font-bold text-slate-700">Refund</span>
                    </div>
                </div>
            </div>

            <div id="content-pembuat" class="space-y-4 hidden">
                <div
                    class="group border border-gray-200 rounded-xl p-5 hover:shadow-md cursor-pointer transition-all flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="text-xl font-bold text-gray-400">+</span>
                        <span class="font-bold text-slate-700">Cara Membuat Event</span>
                    </div>
                </div>
                <div
                    class="group border border-gray-200 rounded-xl p-5 hover:shadow-md cursor-pointer transition-all flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="text-xl font-bold text-gray-400">+</span>
                        <span class="font-bold text-slate-700">Distribusi & Pembayaran Sales</span>
                    </div>
                </div>
                <div
                    class="group border border-gray-200 rounded-xl p-5 hover:shadow-md cursor-pointer transition-all flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="text-xl font-bold text-gray-400">+</span>
                        <span class="font-bold text-slate-700">Laporan Penjualan</span>
                    </div>
                </div>
            </div>

            <div class="hidden md:block absolute right-[-100px] top-24 animate-pulse">
                <img src="https://assets.loket.com/images/help-center-bubble.png" class="w-16 opacity-50"
                    onerror="this.src='https://placehold.co/60/DAE9FF/1A2C50?text=?'">
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">

                <div class="space-y-4">
                    <div class="flex items-center">
                        <span class="text-[#1A2C50] font-black text-2xl tracking-tighter">LOKÉT</span>
                    </div>
                    <p class="text-slate-400 text-xs">
                        © 2026 LOKÉT. All right reserved
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-slate-800 text-sm mb-4 uppercase tracking-wider">helpdesk</h4>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-slate-500 text-sm hover:text-blue-600 transition-colors">Syarat dan
                                Ketentuan</a></li>
                        <li><a href="#"
                                class="text-slate-500 text-sm hover:text-blue-600 transition-colors">Kebijakan
                                Privasi</a></li>
                        <li><a href="#"
                                class="text-slate-500 text-sm hover:text-blue-600 transition-colors">Kebijakan
                                Cookie</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-800 text-sm mb-4 uppercase tracking-wider">Customer Support</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-slate-500 text-sm">
                            <i class="fas fa-phone-alt text-blue-600"></i>
                            <span>+62 21 3000 3160</span>
                        </li>
                        <li class="flex items-center gap-3 text-slate-500 text-sm">
                            <i class="fas fa-envelope text-blue-600"></i>
                            <a href="mailto:support@loket.com"
                                class="hover:text-blue-600 transition-colors">support@loket.com</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-800 text-sm mb-4 uppercase tracking-wider">Akses Tiket Lebih Mudah
                    </h4>
                    <div class="flex flex-col gap-3">
                        <a href="#" class="inline-block transition-transform hover:scale-105">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                                alt="Google Play" class="h-10">
                        </a>
                        <a href="#" class="inline-block transition-transform hover:scale-105">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg"
                                alt="App Store" class="h-10">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function switchTab(type) {
            // Konten
            const contentPembeli = document.getElementById('content-pembeli');
            const contentPembuat = document.getElementById('content-pembuat');
            // Tombol
            const btnPembeli = document.getElementById('btn-pembeli');
            const btnPembuat = document.getElementById('btn-pembuat');

            if (type === 'pembeli') {
                // Show Pembeli
                contentPembeli.classList.remove('hidden');
                contentPembeli.classList.add('block');
                contentPembuat.classList.add('hidden');

                // Style Button
                btnPembeli.classList.add('tab-active');
                btnPembeli.classList.remove('tab-inactive');
                btnPembuat.classList.add('tab-inactive');
                btnPembuat.classList.remove('tab-active');
            } else {
                // Show Pembuat
                contentPembuat.classList.remove('hidden');
                contentPembuat.classList.add('block');
                contentPembeli.classList.add('hidden');

                // Style Button
                btnPembuat.classList.add('tab-active');
                btnPembuat.classList.remove('tab-inactive');
                btnPembeli.classList.add('tab-inactive');
                btnPembeli.classList.remove('tab-active');
            }
        }
    </script>

</body>

</html>
