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

        {{-- Header --}}
        <div class="text-center space-y-3">
            <div
                class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mx-auto border border-emerald-100">
                <i class="fas fa-check-double text-2xl"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800">Konfirmasi Pesanan</h2>
            <p class="text-sm text-slate-500">Periksa kembali detail pesanan sebelum melakukan pembayaran.</p>
        </div>

        {{-- Detail Pesanan --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

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
                                    <p class="text-sm font-black text-slate-800 uppercase">{{ $item['name'] }}</p>
                                    <p class="text-xs text-slate-400">{{ $item['quantity'] }} Tiket</p>
                                </div>
                            </div>
                            <p class="text-base font-black text-slate-800">
                                Rp{{ number_format($item['subtotal'], 0, ',', '.') }}
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
                    <a href="{{ route('orders.create', $orderData['event_id']) }}"
                        class="text-[10px] font-bold text-blue-600 uppercase hover:underline">
                        Ubah Data
                    </a>
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

            {{-- Pilih Metode Pembayaran --}}
            <form action="{{ route('orders.pay') }}" method="POST">
                @csrf
                <div class="p-8 border-b border-slate-100 space-y-5">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Metode Pembayaran</h4>

                    <div class="space-y-4">
                        @foreach ($paymentMethods as $type => $methods)
                            <div>
                                <p class="text-xs font-bold text-slate-500 mb-2 uppercase">
                                    {{ $type === 'bank_transfer' ? 'Transfer Bank' : ($type === 'e-wallet' ? 'E-Wallet' : 'QRIS') }}
                                </p>
                                <div class="space-y-2">
                                    @foreach ($methods as $method)
                                        <label
                                            class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 border-slate-200 hover:border-slate-300">
                                            <input type="radio" name="payment_method_id" value="{{ $method->id }}"
                                                class="text-blue-600 focus:ring-blue-500 w-4 h-4"
                                                {{ $loop->first && $loop->parent->first ? 'checked' : '' }}>
                                            <div class="flex items-center gap-3 flex-1">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                                                    @if ($method->logo)
                                                        <img src="{{ asset('storage/' . $method->logo) }}"
                                                            class="w-8 h-8 object-contain">
                                                    @else
                                                        <i
                                                            class="fas {{ $type === 'bank_transfer' ? 'fa-university' : ($type === 'e-wallet' ? 'fa-wallet' : 'fa-qrcode') }} text-slate-400"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-700">{{ $method->name }}</p>
                                                    @if ($method->account_number)
                                                        <p class="text-xs text-slate-400">{{ $method->account_number }}
                                                            — {{ $method->account_name }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Total & Bayar --}}
                <div class="p-8 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Pembayaran
                        </p>
                        <p class="text-3xl font-black text-blue-700">
                            Rp{{ number_format($orderData['total_amount'], 0, ',', '.') }}
                        </p>
                    </div>
                    <button type="submit"
                        class="w-full md:w-auto md:px-12 bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-blue-100 flex items-center justify-center gap-3">
                        Bayar Sekarang
                        <i class="fas fa-external-link-alt text-[10px]"></i>
                    </button>
                </div>

            </form>
        </div>

        <div class="flex items-start gap-3 px-4 text-slate-400">
            <i class="fas fa-info-circle mt-0.5 text-sm flex-shrink-0"></i>
            <p class="text-xs leading-relaxed font-medium">
                Dengan menekan tombol "Bayar Sekarang", pesanan kamu akan dibuat dan kamu perlu mengupload bukti
                pembayaran dalam waktu
                <span class="text-slate-600 font-bold">15 menit</span> untuk mengamankan tiket.
            </p>
        </div>

    </main>

</body>

</html>
