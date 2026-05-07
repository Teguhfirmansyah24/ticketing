<x-admin-layout>
    <div class="p-6 space-y-8 max-w-5xl mx-auto">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.pembayaran.index') }}" class="p-2.5 bg-white border border-sky-100 text-sky-600 rounded-xl hover:bg-sky-50 transition-all shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-extrabold text-sky-900">Detail Transaksi</h1>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()" class="px-4 py-2 bg-white border border-sky-200 text-sky-600 rounded-xl text-sm font-bold hover:bg-sky-50 transition-all">
                    <i class="fa-solid fa-print mr-2"></i> Cetak
                </button>
                @if($order->status == 'pending')
                <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST">
                    @csrf
                    <button class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">
                        Approve Sekarang
                    </button>
                </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded-[2rem] border border-sky-100 shadow-xl shadow-sky-100/50 overflow-hidden">
                    <div class="p-8 border-b border-dashed border-sky-100 bg-sky-50/30">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-sky-400">Order Reference</p>
                                <h2 class="text-3xl font-black text-sky-900 mt-1">#{{ $order->order_code }}</h2>
                            </div>
                            <div class="text-right">
                                <span class="px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest {{ $order->status == 'approved' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                    {{ $order->status }}
                                </span>
                                <p class="text-xs text-sky-500 mt-3 font-medium">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        <h3 class="text-xs font-black uppercase tracking-widest text-sky-900 mb-6 flex items-center">
                            <i class="fa-solid fa-ticket mr-2 text-sky-500"></i> Item Yang Dibeli
                        </h3>
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                            <div class="flex justify-between items-center p-4 rounded-2xl bg-sky-50/50 border border-sky-50">
                                <div>
                                    <p class="font-bold text-sky-900">{{ $item->ticketType->name }}</p>
                                    <p class="text-xs text-sky-500">{{ $order->event?->title }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-black text-sky-900">{{ $item->quantity }}x</p>
                                    <p class="text-xs text-sky-400">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-8 pt-8 border-t border-sky-100 space-y-3">
                            <div class="flex justify-between text-gray-500 text-sm">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500 text-sm">
                                <span>Pajak & Biaya Layanan</span>
                                <span class="text-emerald-500">Free</span>
                            </div>
                            <div class="flex justify-between items-center pt-4">
                                <span class="text-lg font-bold text-sky-900">Total Pembayaran</span>
                                <span class="text-2xl font-black text-sky-600 font-mono">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-[2rem] p-8 border border-sky-100 shadow-lg">
                    <h3 class="text-xs font-black uppercase tracking-widest text-sky-900 mb-6 flex items-center">
                        <i class="fa-solid fa-user-circle mr-2 text-sky-500 text-lg"></i> Informasi Pembeli
                    </h3>
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-bold text-sky-300 uppercase">Nama Lengkap</p>
                            <p class="font-bold text-gray-800">{{ $order->name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-sky-300 uppercase">Email Address</p>
                            <p class="font-bold text-gray-800">{{ $order->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-sky-300 uppercase">Nomor Identitas (NIK)</p>
                            <p class="font-bold text-gray-800 font-mono">{{ $order->id_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-sky-300 uppercase">WhatsApp / HP</p>
                            <p class="font-bold text-gray-800">{{ $order->phone }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-sky-50 text-center">
                        @if($order->user_id)
                            <div class="inline-flex items-center text-[10px] font-bold text-emerald-500 bg-emerald-50 px-3 py-1 rounded-full">
                                <i class="fa-solid fa-shield-check mr-1"></i> Akun Terdaftar
                            </div>
                        @else
                            <div class="inline-flex items-center text-[10px] font-bold text-gray-400 bg-gray-50 px-3 py-1 rounded-full">
                                <i class="fa-solid fa-user-secret mr-1"></i> Guest Checkout
                            </div>
                        @endif
                    </div>
                    <div class="mb-6">
                        <a href="{{ route('admin.pembayaran.index') }}" 
                        class="inline-flex items-center gap-3 px-5 py-2.5 bg-white border border-sky-100 text-sky-600 rounded-2xl font-bold text-sm shadow-sm hover:bg-sky-600 hover:text-white hover:border-sky-600 transition-all group">
                            <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                            <span>Kembali ke Daftar Transaksi</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>