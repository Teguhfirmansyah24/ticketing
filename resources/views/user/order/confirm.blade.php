<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - LOKÉT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7fa;
        }
    </style>
</head>

<body class="antialiased">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-black text-2xl tracking-tighter text-black">LOKÉT</a>
            <div class="hidden md:flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <span
                        class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold">1</span>
                    <span class="text-[11px] uppercase tracking-wider text-slate-400">Pilih Tiket</span>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
                <div class="flex items-center gap-2">
                    <span
                        class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold">2</span>
                    <span class="text-[11px] uppercase tracking-wider text-slate-400">Informasi Personal</span>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
                <div class="flex items-center gap-2">
                    <span
                        class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold">3</span>
                    <span class="text-[11px] uppercase tracking-wider font-bold text-slate-900">Konfirmasi</span>
                </div>
            </div>
            <div class="w-20"></div>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto py-10 px-4 space-y-8">

        {{-- Header Icon & Title --}}
        <div class="text-center space-y-3">
            <div
                class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto border 
                {{ $order->status === 'approved' ? 'bg-emerald-50 border-emerald-100 text-emerald-500' : 'bg-amber-50 border-amber-100 text-amber-500' }}">
                <i class="fas {{ $order->status === 'approved' ? 'fa-check-double' : 'fa-clock' }} text-2xl"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800">
                {{ $order->status === 'approved' ? 'Pesanan Selesai' : 'Konfirmasi Pesanan' }}
            </h2>
            <p class="text-sm text-slate-500">
                {{ $order->status === 'approved' ? 'Terima kasih! Pembayaran kamu telah berhasil diverifikasi.' : 'Periksa kembali detail pesanan sebelum melakukan pembayaran.' }}
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden relative">

            {{-- Badge Status di Pojok Kanan Atas --}}
            <div class="absolute top-8 right-8">
                <span
                    class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm text-white 
                    {{ $order->status === 'approved' ? 'bg-emerald-500' : 'bg-amber-400' }}">
                    {{ $order->status }}
                </span>
            </div>

            {{-- Tiket --}}
            <div class="p-8 border-b border-slate-100">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-5">Tiket Yang Dipesan</h4>
                <div class="space-y-4">
                    @foreach ($orderData['items'] as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-ticket-alt text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800 uppercase">
                                        {{ $item->ticketType->name }}
                                    </p>
                                    <p class="text-xs text-slate-400">{{ $item->quantity }} Tiket</p>
                                </div>
                            </div>
                            <p class="text-base font-black text-slate-800">
                                Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                    <div class="flex justify-between items-center text-xs text-slate-400 pt-2 border-t border-slate-50">
                        <span>Pajak & Biaya Layanan</span>
                        <span>Sudah termasuk</span>
                    </div>
                </div>
            </div>

            {{-- Info Pemesan --}}
            <div class="p-8 bg-slate-50/50 border-b border-slate-100 space-y-5">
                <div class="flex items-center justify-between">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Informasi Pemesan</h4>
                    @if ($order->status !== 'approved')
                        <a href="{{ route('orders.create', $orderData['event_id']) }}"
                            class="text-[10px] font-bold text-blue-600 uppercase hover:underline">
                            Ubah Data
                        </a>
                    @endif
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase mb-1">Nama Lengkap</p>
                        <p class="text-sm font-bold text-slate-700">{{ $orderData['name'] }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase mb-1">Email</p>
                        <p class="text-sm font-bold text-slate-700">{{ $orderData['email'] }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase mb-1">Nomor KTP</p>
                        <p class="text-sm font-bold text-slate-700 font-mono">
                            {{ substr($orderData['id_number'], 0, 4) . str_repeat('*', strlen($orderData['id_number']) - 4) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase mb-1">Nomor Ponsel</p>
                        <p class="text-sm font-bold text-slate-700">+62{{ $orderData['phone'] }}</p>
                    </div>
                </div>
            </div>

           @if ($order->status !== 'approved' && $order->status !== 'cancelled')
    {{-- Tombol Bayar --}}
    <div class="p-8 pb-0">
        <button id="pay-button"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-bold text-sm uppercase tracking-widest transition-all shadow-lg shadow-blue-100 flex items-center justify-center">
            <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
        </button>
    </div>

    {{-- Tombol Cancel & Kembali Sejajar --}}
    <div class="p-8 pt-4">
        <div class="flex flex-col sm:flex-row gap-3 justify-between items-center">
            {{-- Tombol Kembali (KIRI) --}}
            <a href="{{ route('member.tiket.index') }}"
                class="w-full sm:w-1/2 bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-xl text-center font-semibold text-sm uppercase tracking-widest transition-all shadow-sm flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            {{-- Tombol Batalkan Pesanan (KANAN) --}}
            <form action="{{ route('order.cancel', $order->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin membatalkan pesanan?')" class="w-full sm:w-1/2">
                @csrf
                @method('PATCH')
                <button type="submit"
                    class="w-full bg-white border-2 border-red-300 text-red-500 hover:bg-red-50 hover:border-red-400 px-6 py-3 rounded-xl font-semibold text-sm uppercase tracking-widest transition-all shadow-sm flex items-center justify-center gap-2">
                    <i class="fas fa-times-circle"></i> Batalkan Pesanan
                </button>
            </form>
        </div>
    </div>
@elseif($order->status === 'cancelled')
    <div class="p-8">
        <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-xl text-center text-sm font-medium">
            <i class="fas fa-info-circle mr-2"></i> Pesanan ini telah dibatalkan.
        </div>
        <a href="{{ route('home') }}"
            class="block bg-emerald-500 hover:bg-emerald-600 text-white py-4 rounded-xl text-center font-medium text-[16px] transition-colors mt-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
        </a>
    </div>
@else
    <div class="p-8">
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 p-4 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle text-xl"></i>
            <div>
                <p class="font-bold text-sm">Pembayaran Berhasil!</p>
                <p class="text-xs opacity-80">Tiket Anda sudah aktif dan dapat digunakan.</p>
            </div>
        </div>
        <a href="{{ route('member.tiket.index') }}"
            class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-4 rounded-xl text-center font-bold text-sm uppercase tracking-widest transition-all shadow-lg shadow-emerald-100 flex items-center justify-center gap-2 mt-4">
            <i class="fas fa-ticket-alt"></i> Lihat Tiket Saya
        </a>
    </div>
@endif
        </div>

        @if ($order->status !== 'approved')
            <div class="flex items-start gap-3 px-4 text-slate-400">
                <i class="fas fa-info-circle mt-0.5 text-sm flex-shrink-0"></i>
                <p class="text-xs leading-relaxed font-medium">
                    Dengan menekan tombol <span class="font-bold">"Bayar Sekarang"</span>, pesanan kamu akan dibuat dan
                    kamu perlu menyelesaikan pembayaran dalam waktu
                    <span class="text-red-500 font-bold">15 menit</span> untuk mengamankan tiket.
                </p>
            </div>
        @endif
    </main>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');

        if (payButton) {
            payButton.addEventListener('click', function() {
                // 1. Set Loading State
                payButton.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Memproses...';
                payButton.disabled = true;

                // 2. Fetch Token with Error Handling
                fetch("{{ route('orders.token', $order->id) }}")
                    .then(response => {
                        if (!response.ok) {
                            // This catches the 500 Internal Server Error
                            return response.json().then(err => {
                                throw new Error(err.error || 'Server Error')
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.token) {
                            window.snap.pay(data.token, {
                                onSuccess: function(result) {
                                    window.location.href = "/orders/success/{{ $orderId }}";
                                },
                                onPending: function(result) {
                                    window.location.reload();
                                },
                                onError: function(result) {
                                    alert("Pembayaran Gagal!");
                                    resetButton();
                                },
                                onClose: function() {
                                    resetButton();
                                }
                            });
                        } else {
                            alert("Token tidak ditemukan!");
                            resetButton();
                        }
                    })
                    .catch(error => {
                        // This handles the "Unexpected token <" or 500 errors
                        console.error('Error:', error);
                        alert("Gagal memproses: " + error.message);
                        resetButton();
                    });
            });
        }

        // Helper function to bring button back to life
        function resetButton() {
            payButton.disabled = false;
            payButton.innerHTML = '<i class="fas fa-credit-card mr-2"></i> Bayar Sekarang';
        }
    </script>
</body>

</html>
