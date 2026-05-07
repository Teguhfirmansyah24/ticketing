<x-admin-layout>
    <div class="p-6 space-y-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pembayaran.index') }}" class="p-2.5 bg-white border border-sky-100 text-sky-600 rounded-xl hover:bg-sky-50 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-sky-900">Edit Transaksi</h1>
                <p class="text-sky-600 text-sm">Update data pesanan #{{ $order->order_code }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="bg-white rounded-3xl shadow-xl shadow-sky-100/50 border border-sky-100 overflow-hidden">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-black uppercase tracking-widest text-sky-900 ml-1">Nama Pelanggan</label>
                                <input type="text" name="name" value="{{ old('name', $order->name) }}" 
                                    class="w-full px-5 py-3.5 rounded-2xl border border-sky-100 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all bg-sky-50/30">
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-black uppercase tracking-widest text-sky-900 ml-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $order->email) }}" 
                                    class="w-full px-5 py-3.5 rounded-2xl border border-sky-100 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all bg-sky-50/30">
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-black uppercase tracking-widest text-sky-900 ml-1">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $order->phone) }}" 
                                    class="w-full px-5 py-3.5 rounded-2xl border border-sky-100 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all bg-sky-50/30">
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-black uppercase tracking-widest text-sky-900 ml-1">Status Pembayaran</label>
                                <select name="status" class="w-full px-5 py-3.5 rounded-2xl border border-sky-100 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition-all bg-sky-50/30 font-bold text-sky-900">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>PENDING</option>
                                    <option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>APPROVED</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-widest text-sky-900 ml-1">Total Pembayaran (IDR)</label>
                            <input type="number" name="total_amount" value="{{ $order->total_amount }}" 
                                class="w-full px-5 py-3.5 rounded-2xl border border-sky-100 bg-gray-50 text-gray-500 cursor-not-allowed font-black" readonly>
                        </div>
                    </div>

                    <div class="p-6 bg-sky-50/30 border-t border-sky-50 flex justify-end gap-3">
                        <a href="{{ route('admin.pembayaran.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-sky-600 hover:bg-sky-100 transition-all">Batal</a>
                        <button type="submit" class="px-8 py-3 bg-sky-600 text-white rounded-xl text-sm font-black shadow-lg shadow-sky-200 hover:bg-sky-700 transition-all">
                            SIMPAN PERUBAHAN
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div class="bg-gradient-to-br from-sky-600 to-sky-800 rounded-3xl p-6 text-white shadow-xl shadow-sky-200">
                    <h3 class="font-black text-lg mb-4 italic uppercase tracking-wider">Ringkasan Tiket</h3>
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                        <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-sm border border-white/10">
                            <div class="text-[10px] font-bold text-sky-200 uppercase tracking-widest">{{ $item->ticketType->name }}</div>
                            <div class="text-lg font-black">{{ $item->quantity }}x <span class="text-sm font-normal">Tiket</span></div>
                            <div class="text-sm text-sky-100 mt-2 border-t border-white/10 pt-2 font-mono">
                                Rp {{ number_format($item->price, 0, ',', '.') }} / item
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-sky-100 shadow-sm">
                    <h3 class="font-bold text-sky-900 mb-4">Informasi Tambahan</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Dibuat Pada:</span>
                            <span class="font-semibold text-gray-700">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">ID Number:</span>
                            <span class="font-semibold text-gray-700">{{ $order->id_number ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>