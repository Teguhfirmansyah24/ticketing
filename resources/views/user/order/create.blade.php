<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli Tiket {{ $event->title }} - LOKÉT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7fa;
        }
    </style>
</head>

<body class="antialiased">

    <div x-data="{
        step: 1,
        tickets: @js(
    $event->ticketTypes->map(
        fn($t) => [
            'id' => $t->id,
            'name' => $t->name,
            'price' => $t->price,
            'available' => $t->quota - $t->sold,
            'qty' => 0,
        ],
    ),
),
    
        get totalQty() {
            return this.tickets.reduce((s, t) => s + t.qty, 0);
        },
    
        get totalPrice() {
            return this.tickets.reduce((s, t) => s + (t.qty * t.price), 0);
        },
    
        get hasSelected() {
            return this.totalQty > 0;
        },
    
        formatRupiah(val) {
            return 'Rp ' + Number(val).toLocaleString('id-ID');
        },
    
        increment(index) {
            const t = this.tickets[index];
            const max = Math.min(t.available, {{ $event->max_tickets_per_transaction ?? 5 }});
            if (t.qty < max) t.qty++;
        },
    
        decrement(index) {
            if (this.tickets[index].qty > 0) this.tickets[index].qty--;
        }
    }">

        {{-- Navbar --}}
        <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-black font-black text-2xl tracking-tighter">LOKÉT</span>
                </a>

                {{-- Steps --}}
                <div class="hidden md:flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span :class="step >= 1 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500'"
                            class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold transition-colors">1</span>
                        <span :class="step >= 1 ? 'text-slate-900 font-bold' : 'text-slate-400'"
                            class="text-[11px] uppercase tracking-wider">Pilih Tiket</span>
                    </div>
                    <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
                    <div class="flex items-center gap-2">
                        <span :class="step >= 2 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500'"
                            class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold transition-colors">2</span>
                        <span :class="step >= 2 ? 'text-slate-900 font-bold' : 'text-slate-400'"
                            class="text-[11px] uppercase tracking-wider">Informasi Personal</span>
                    </div>
                    <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
                    <div class="flex items-center gap-2">
                        <span :class="step >= 3 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500'"
                            class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold transition-colors">3</span>
                        <span :class="step >= 3 ? 'text-slate-900 font-bold' : 'text-slate-400'"
                            class="text-[11px] uppercase tracking-wider">Konfirmasi</span>
                    </div>
                </div>

                <a href="{{ route('event.show', $event->id) }}"
                    class="text-slate-400 hover:text-slate-600 text-sm font-medium flex items-center gap-2">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </nav>

        <main class="max-w-6xl mx-auto py-8 px-4">

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-5 flex gap-4">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mt-0.5 flex-shrink-0"></i>
                    <div>
                        <p class="font-bold text-red-700 mb-1">Terjadi kesalahan:</p>
                        <ul class="list-disc pl-4 text-sm text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                @csrf

                {{-- ===== STEP 1: Pilih Tiket ===== --}}
                <div x-show="step === 1" class="space-y-6">

                    {{-- Hero Event --}}
                    <div class="bg-[#0A1628] rounded-2xl overflow-hidden shadow-xl relative">
                        @if ($event->banner_image)
                            <img src="{{ asset('storage/' . $event->banner_image) }}"
                                class="w-full h-48 object-cover opacity-50">
                        @else
                            <div class="w-full h-48 bg-gradient-to-r from-blue-900 to-indigo-900"></div>
                        @endif
                        <div class="p-6 text-center -mt-20 relative z-10">
                            <span
                                class="inline-block bg-blue-600/30 backdrop-blur text-blue-300 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest mb-3">
                                {{ $event->category->name ?? 'Event' }}
                            </span>
                            <h1 class="text-white text-2xl font-black tracking-tight uppercase mb-2">
                                {{ $event->title }}
                            </h1>
                            <p class="text-slate-400 text-xs font-medium">
                                <i class="far fa-calendar-alt mr-2"></i>
                                {{ $event->start_date->translatedFormat('j M Y, H:i') }} WIB
                                &nbsp;|&nbsp;
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $event->venue }}, {{ $event->location }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        {{-- List Tiket --}}
                        <div class="lg:col-span-2 space-y-4">
                            <h2 class="text-xs font-black text-slate-500 uppercase tracking-widest">Pilih Kategori Tiket
                            </h2>

                            <template x-for="(ticket, index) in tickets" :key="ticket.id">
                                <div class="bg-white border-2 rounded-2xl overflow-hidden transition-all duration-200"
                                    :class="ticket.qty > 0 ? 'border-blue-500 shadow-md shadow-blue-50' : 'border-slate-100'">

                                    <div class="p-5 flex justify-between items-start">
                                        <div class="space-y-1.5">
                                            <h3 class="font-black text-slate-800 text-base" x-text="ticket.name"></h3>
                                            <p class="text-xs text-slate-400"
                                                x-text="ticket.available > 0 ? ticket.available + ' tiket tersisa' : 'Habis'">
                                            </p>
                                            <p class="text-xs font-bold"
                                                :class="ticket.available <= 10 && ticket.available > 0 ? 'text-orange-500' :
                                                    'text-slate-300'">
                                                <i class="fas fa-clock mr-1"></i>
                                                Berakhir {{ $event->start_date->translatedFormat('j M Y') }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-[10px] text-slate-400 block mb-1" x-show="ticket.qty > 0">
                                                Subtotal
                                            </span>
                                            <span class="text-sm font-black text-blue-700" x-show="ticket.qty > 0"
                                                x-text="formatRupiah(ticket.qty * ticket.price)">
                                            </span>
                                        </div>
                                    </div>

                                    <div
                                        class="bg-slate-50 px-5 py-3 border-t border-slate-100 flex justify-between items-center">
                                        <span class="text-xl font-black text-slate-900"
                                            x-text="ticket.price > 0 ? formatRupiah(ticket.price) : 'Gratis'"></span>

                                        <div x-show="ticket.available > 0" class="flex items-center gap-3">
                                            <button type="button" @click="decrement(index)"
                                                :class="ticket.qty === 0 ? 'opacity-30 cursor-not-allowed' :
                                                    'hover:bg-blue-600 hover:text-white hover:border-blue-600'"
                                                class="w-9 h-9 rounded-xl border-2 border-slate-200 flex items-center justify-center font-bold text-slate-500 transition-all">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <span class="w-6 text-center font-black text-slate-800 text-lg"
                                                x-text="ticket.qty"></span>
                                            <button type="button" @click="increment(index)"
                                                :class="ticket.qty >= ticket.available ? 'opacity-30 cursor-not-allowed' :
                                                    'hover:bg-blue-600 hover:text-white hover:border-blue-600'"
                                                class="w-9 h-9 rounded-xl border-2 border-slate-200 flex items-center justify-center font-bold text-slate-500 transition-all">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>

                                        <div x-show="ticket.available <= 0">
                                            <span
                                                class="px-4 py-1.5 rounded-full bg-red-50 text-red-500 text-xs font-bold border border-red-100 uppercase">
                                                Habis
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Ringkasan --}}
                        <div class="lg:col-span-1">
                            <div
                                class="bg-white border border-slate-100 rounded-2xl p-6 sticky top-24 shadow-sm space-y-6">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ringkasan
                                    Pesanan</h3>

                                <div x-show="!hasSelected" class="text-center py-6">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-ticket-alt text-slate-300 text-lg"></i>
                                    </div>
                                    <p class="text-xs text-slate-400 font-medium">Belum ada tiket dipilih</p>
                                </div>

                                <div x-show="hasSelected" class="space-y-3">
                                    <template x-for="ticket in tickets.filter(t => t.qty > 0)">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-slate-600 font-medium"
                                                x-text="ticket.name + ' x' + ticket.qty"></span>
                                            <span class="font-bold text-slate-800"
                                                x-text="formatRupiah(ticket.qty * ticket.price)"></span>
                                        </div>
                                    </template>
                                    <div class="border-t border-slate-100 pt-3 flex justify-between items-center">
                                        <span class="text-xs font-black text-slate-500 uppercase">Total</span>
                                        <span class="text-xl font-black text-blue-700"
                                            x-text="formatRupiah(totalPrice)"></span>
                                    </div>
                                </div>

                                <button type="button" @click="hasSelected ? step = 2 : null"
                                    :class="hasSelected ?
                                        'bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-100 cursor-pointer' :
                                        'bg-slate-200 cursor-not-allowed'"
                                    class="w-full text-white py-4 rounded-xl font-bold text-xs uppercase tracking-widest transition-all">
                                    Pesan Sekarang
                                    <i class="fas fa-chevron-right ml-2 text-[10px]"></i>
                                </button>

                                <p class="text-[10px] text-slate-400 text-center">
                                    <i class="fas fa-shield-alt text-green-500 mr-1"></i>
                                    Transaksi dijamin aman oleh LOKÉT
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ===== STEP 2: Informasi Personal ===== --}}
                <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                        {{-- Form --}}
                        <div class="lg:col-span-2">
                            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                                <div class="p-8 space-y-8">

                                    <div class="flex items-center justify-between border-b border-slate-100 pb-6">
                                        <div class="flex items-center gap-4">
                                            <button type="button" @click="step = 1"
                                                class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all">
                                                <i class="fas fa-arrow-left text-sm"></i>
                                            </button>
                                            <div>
                                                <h2 class="text-xl font-black text-slate-800">Informasi Personal</h2>
                                                <p class="text-xs text-slate-400 mt-0.5">Data ini akan digunakan untuk
                                                    pengiriman E-Tiket</p>
                                            </div>
                                        </div>
                                        <span
                                            class="text-[10px] font-black text-emerald-500 bg-emerald-50 px-3 py-1.5 rounded-full uppercase tracking-widest border border-emerald-100">
                                            <i class="fas fa-lock mr-1"></i> Sesi Aman
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                        <div class="space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                Nama Lengkap (Sesuai KTP) <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="name"
                                                value="{{ old('name', auth()->user()->name) }}"
                                                placeholder="Masukkan nama lengkap"
                                                class="w-full border-b-2 border-slate-200 py-3 outline-none focus:border-blue-600 transition-colors font-semibold text-slate-700 placeholder:text-slate-300 placeholder:font-normal bg-transparent"
                                                required>
                                        </div>

                                        <div class="space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                Nomor Ponsel <span class="text-red-500">*</span>
                                            </label>
                                            <div
                                                class="flex items-center gap-2 border-b-2 border-slate-200 focus-within:border-blue-600 transition-colors">
                                                <span class="text-sm font-bold text-slate-400 py-3">+62</span>
                                                <input type="tel" name="phone" value="{{ old('phone') }}"
                                                    placeholder="812xxxx"
                                                    class="w-full py-3 outline-none font-semibold text-slate-700 placeholder:text-slate-300 placeholder:font-normal bg-transparent"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="space-y-2 md:col-span-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                Alamat Email <span class="text-red-500">*</span>
                                            </label>
                                            <input type="email" name="email"
                                                value="{{ old('email', auth()->user()->email) }}"
                                                placeholder="contoh@email.com"
                                                class="w-full border-b-2 border-slate-200 py-3 outline-none focus:border-blue-600 transition-colors font-semibold text-slate-700 placeholder:text-slate-300 bg-transparent"
                                                required>
                                            <p class="text-[10px] text-slate-400 italic">E-Tiket akan dikirimkan ke
                                                email ini.</p>
                                        </div>

                                        <div class="space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                Nomor KTP / NIK <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="id_number" value="{{ old('id_number') }}"
                                                placeholder="16 digit nomor NIK" maxlength="16"
                                                class="w-full border-b-2 border-slate-200 py-3 outline-none focus:border-blue-600 transition-colors font-semibold text-slate-700 placeholder:text-slate-300 bg-transparent"
                                                required>
                                        </div>

                                        <div class="space-y-2">
                                            <label
                                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                Tanggal Lahir <span class="text-red-500">*</span>
                                            </label>
                                            <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                                                class="w-full border-b-2 border-slate-200 py-3 outline-none focus:border-blue-600 transition-colors font-semibold text-slate-700 bg-transparent"
                                                required>
                                        </div>

                                    </div>

                                    {{-- Hidden inputs untuk tiket --}}
                                    <template x-for="(ticket, index) in tickets.filter(t => t.qty > 0)"
                                        :key="ticket.id">
                                        <div>
                                            <input type="hidden" :name="'tickets[' + index + '][id]'"
                                                :value="ticket.id">
                                            <input type="hidden" :name="'tickets[' + index + '][qty]'"
                                                :value="ticket.qty">
                                        </div>
                                    </template>
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                                    {{-- Syarat & Ketentuan --}}
                                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                                        <label class="flex gap-4 cursor-pointer">
                                            <input type="checkbox" name="agree" value="1"
                                                class="mt-0.5 w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 flex-shrink-0"
                                                required>
                                            <span class="text-xs text-slate-500 leading-relaxed font-medium">
                                                Saya setuju dengan
                                                <a href="#" class="text-blue-600 font-bold underline">Syarat &
                                                    Ketentuan</a>
                                                yang berlaku serta memastikan data identitas yang saya masukkan sudah
                                                benar dan sesuai kartu identitas asli.
                                            </span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Sidebar ringkasan step 2 --}}
                        <div class="lg:col-span-1">
                            <div
                                class="bg-white border border-slate-100 rounded-2xl p-6 sticky top-24 shadow-sm space-y-6">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail
                                    Pesanan</h3>

                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                        @if ($event->banner_image)
                                            <img src="{{ asset('storage/' . $event->banner_image) }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-blue-600 flex items-center justify-center">
                                                <i class="fas fa-music text-white text-sm"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800 line-clamp-2 uppercase">
                                            {{ $event->title }}</p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $event->venue }}</p>
                                    </div>
                                </div>

                                <div class="space-y-2 border-y border-slate-50 py-4">
                                    <template x-for="ticket in tickets.filter(t => t.qty > 0)">
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-slate-500 font-medium"
                                                x-text="ticket.name + ' (x' + ticket.qty + ')'"></span>
                                            <span class="font-bold text-slate-800"
                                                x-text="formatRupiah(ticket.qty * ticket.price)"></span>
                                        </div>
                                    </template>
                                    <div class="flex justify-between items-center text-[10px] text-slate-400">
                                        <span>Pajak & Biaya Layanan</span>
                                        <span>Sudah termasuk</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-black text-slate-800 uppercase">Total Bayar</span>
                                    <span class="text-xl font-black text-blue-700"
                                        x-text="formatRupiah(totalPrice)"></span>
                                </div>

                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-bold text-xs uppercase tracking-widest transition-all shadow-lg shadow-blue-100 flex items-center justify-center gap-2">
                                    Lanjut ke Konfirmasi
                                    <i class="fas fa-chevron-right text-[10px]"></i>
                                </button>

                                <p class="text-[10px] text-slate-400 text-center">
                                    <i class="fas fa-shield-alt text-green-500 mr-1"></i>
                                    Transaksi dijamin aman oleh LOKÉT
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </form>
        </main>

    </div>

</body>

</html>
