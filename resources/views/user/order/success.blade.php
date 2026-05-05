<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - LOKÉT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7fa;
        }
    </style>
</head>

<body class="antialiased">

    {{-- Navbar Sederhana --}}
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center">
            <a href="{{ route('home') }}" class="font-black text-2xl tracking-tighter text-black">LOKÉT</a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto py-16 px-4">
        
        <div class="bg-white border border-slate-200 rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden text-center p-10 space-y-6">
            
            {{-- Icon Berhasil --}}
            <div class="w-24 h-24 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto border-4 border-emerald-100 mb-2">
                <i class="fas fa-check-circle text-5xl"></i>
            </div>

            <div class="space-y-2">
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Pembayaran Berhasil!</h1>
                <p class="text-slate-500">
                    Halo <span class="font-bold text-slate-700">{{ $order->name }}</span>, pesanan kamu telah kami terima dan status pembayaran sudah diperbarui menjadi 
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-emerald-500 text-white ml-1">APPROVED</span>.
                </p>
            </div>

            {{-- Detail Box --}}
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 inline-block w-full max-w-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Pesanan</p>
                <h4 class="text-xl font-black text-slate-800 font-mono tracking-tighter">{{ $order->order_code }}</h4>
            </div>

            <div class="max-w-md mx-auto text-sm text-slate-500 leading-relaxed">
                Tiket elektronik kamu sudah tersedia di halaman <span class="font-bold text-slate-700">"Tiket Saya"</span>. Silakan tunjukkan tiket tersebut saat memasuki area event.
            </div>

            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('orders.confirm', $order->id) }}" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-bold text-sm uppercase tracking-widest transition-all shadow-lg shadow-blue-100 flex items-center justify-center">
                    <i class="fas fa-ticket-alt mr-2"></i>
                    Lihat Tiket Saya
                </a>
                <a href="{{ url('/') }}" 
                    class="bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 px-8 py-4 rounded-xl font-bold text-sm uppercase tracking-widest transition-all flex items-center justify-center">
                    Beranda
                </a>
            </div>

        </div>

        {{-- Footer Sederhana --}}
        <div class="text-center mt-10">
            <p class="text-xs text-slate-400 font-medium tracking-wide uppercase">© 2026 LOKÉT — Platform Tiket No. 1</p>
        </div>

    </main>

</body>
</html>