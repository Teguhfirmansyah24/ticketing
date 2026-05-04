<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran - LOKÉT</title>
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

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center">
            <a href="{{ route('home') }}" class="font-black text-2xl tracking-tighter text-black">LOKÉT</a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto py-10 px-4 space-y-6">

        {{-- Status --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center space-y-4 shadow-sm">
            {{-- Status --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-8 space-y-4 shadow-sm relative">
                <!-- Badge Dinamis -->
                <div class="absolute top-6 right-6">
                    <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm text-white 
                        {{ $order->status === 'approved' ? 'bg-emerald-500' : 'bg-amber-400' }}">
                        {{ $order->status }}
                    </span>
                </div>

                @if($order->status === 'approved')
                    {{-- Tampilan jika SUDAH Bayar --}}
                    <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto border border-emerald-100">
                        <i class="fas fa-check-circle text-emerald-500 text-2xl"></i>
                    </div>
                    <div class="text-center">
                        <h2 class="text-xl font-black text-slate-800">Pembayaran Berhasil</h2>
                        <p class="text-sm text-slate-500 mt-1">E-tiket kamu sudah aktif dan siap digunakan</p>
                    </div>
                @else
                    {{-- Tampilan jika BELUM Bayar (Menunggu) --}}
                    <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto border border-amber-100">
                        <i class="fas fa-clock text-amber-500 text-2xl"></i>
                    </div>
                    <div class="text-center">
                        <h2 class="text-xl font-black text-slate-800">Menunggu Pembayaran</h2>
                        <p class="text-sm text-slate-500 mt-1">Selesaikan pembayaran sebelum pesanan kamu kedaluwarsa</p>
                    </div>
                @endif
                
                {{-- Sisanya tetap sama (Countdown, Detail Order, dll) --}}
            </div>

            {{-- Countdown --}}
            <div class="bg-slate-50 rounded-xl px-6 py-4 border border-slate-100 inline-block">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Berakhir dalam</p>
                <p class="text-2xl font-black text-red-500 font-mono" id="countdown">15:00</p>
            </div>

            <div class="text-left space-y-2">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500">Kode Order</span>
                    <span class="font-black text-slate-800 font-mono">{{ $order->order_code }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500">Kode Pembayaran</span>
                    <span class="font-black text-slate-800 font-mono">{{ $order->payment->payment_code }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500">Total Pembayaran</span>
                    <span
                        class="font-black text-blue-700 text-base">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Instruksi --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-black text-slate-800">Instruksi Pembayaran</h3>
                <p class="text-sm text-slate-400 mt-1">Transfer ke rekening berikut</p>
            </div>

            @if ($paymentMethod)
                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-4 bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <div
                            class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
                            @if ($paymentMethod->logo)
                                <img src="{{ asset('storage/' . $paymentMethod->logo) }}"
                                    class="w-10 h-10 object-contain">
                            @else
                                <i class="fas fa-university text-slate-400 text-lg"></i>
                            @endif
                        </div>
                        <div>
                            <p class="font-black text-slate-800">{{ $paymentMethod->name }}</p>
                            @if ($paymentMethod->account_number)
                                <p class="text-sm text-slate-500">{{ $paymentMethod->account_name }}</p>
                                <p class="text-lg font-black text-blue-700 font-mono mt-1">
                                    {{ $paymentMethod->account_number }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <p class="text-xs font-black text-blue-700 mb-1">Jumlah yang harus ditransfer:</p>
                        <p class="text-2xl font-black text-blue-700">
                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                        </p>
                        <p class="text-[10px] text-blue-500 mt-1">Transfer tepat sesuai nominal di atas</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Upload Bukti --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-black text-slate-800">Upload Bukti Pembayaran</h3>
                <p class="text-sm text-slate-400 mt-1">Upload screenshot atau foto bukti transfer kamu</p>
            </div>
            <form action="{{ route('orders.upload', $order->id) }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-4">
                @csrf

                <div class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center cursor-pointer hover:border-blue-400 transition-colors"
                    onclick="document.getElementById('proofInput').click()">
                    <input type="file" id="proofInput" name="payment_proof" accept="image/*" class="hidden"
                        onchange="document.getElementById('proofName').textContent = this.files[0]?.name || 'Belum ada file dipilih'">
                    <i class="fas fa-cloud-upload-alt text-3xl text-slate-300 mb-3 block"></i>
                    <p class="text-sm font-bold text-slate-500">Klik untuk upload bukti pembayaran</p>
                    <p class="text-xs text-slate-400 mt-1" id="proofName">PNG, JPG — Maks. 2MB</p>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-bold text-sm uppercase tracking-widest transition-all shadow-lg shadow-blue-100">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Bukti Pembayaran
                </button>
            </form>
        </div>

        {{-- Detail Pesanan --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-black text-slate-800">Detail Pesanan</h3>
            </div>
            <div class="p-6 space-y-3">
                @foreach ($order->orderItems as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-ticket-alt text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">{{ $item->ticketType->name }}</p>
                                <p class="text-xs text-slate-400">{{ $item->quantity }} tiket</p>
                            </div>
                        </div>
                        <p class="text-sm font-black text-slate-800">
                            Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

    </main>

    <script>
        // Countdown timer
        const expiredAt = new Date('{{ $order->expired_at }}');
        const countdown = document.getElementById('countdown');

        function updateCountdown() {
            const now = new Date();
            const diff = Math.max(0, Math.floor((expiredAt - now) / 1000));
            const min = Math.floor(diff / 60).toString().padStart(2, '0');
            const sec = (diff % 60).toString().padStart(2, '0');
            countdown.textContent = `${min}:${sec}`;
            if (diff === 0) {
                countdown.textContent = 'KEDALUWARSA';
                countdown.classList.remove('text-red-500');
                countdown.classList.add('text-slate-400');
            }
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>

</body>

</html>
