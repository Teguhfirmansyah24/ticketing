<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Event - Lokét</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-[#F0F4F8] font-sans antialiased text-slate-900">

    {{-- Navbar --}}
    <nav class="bg-[#0A1628] sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="text-white font-black text-2xl tracking-tighter">LOKÉT</span>
            </a>
            <div class="flex items-center gap-6">
                <a href="{{ route('help.index') }}"
                    class="text-slate-300 hover:text-white text-sm font-semibold transition-colors flex items-center gap-2">
                    <i class="fas fa-question-circle"></i>
                    Bantuan
                </a>
                <div class="flex items-center gap-2 text-slate-300 text-sm font-semibold">
                    <div
                        class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    {{ auth()->user()->name }}
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8 pb-32" x-data="{
        activeTab: 'tiket',
        tickets: [],
    
        addTicket(type) {
            this.tickets.push({
                id: Date.now(),
                name: type === 'gratis' ? 'Tiket Gratis' : type === 'berbayar' ? 'Tiket Berbayar' : 'Tiket Sesukamu',
                price: type === 'gratis' ? 0 : '',
                quota: '',
                description: '',
                type: type
            });
            this.activeTab = 'tiket';
        },
    
        removeTicket(id) {
            this.tickets = this.tickets.filter(t => t.id !== id);
        }
    }">

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-5 flex gap-4">
                <i class="fas fa-exclamation-circle text-red-500 text-xl mt-0.5 flex-shrink-0"></i>
                <div>
                    <p class="font-bold text-red-700 mb-2">Terdapat kesalahan pada form:</p>
                    <ul class="list-disc pl-4 text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-2xl p-5 flex gap-4">
                <i class="fas fa-check-circle text-green-500 text-xl mt-0.5"></i>
                <p class="font-bold text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('creator.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Section 1: Banner --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="px-8 py-5 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
                        <i class="fas fa-image text-white text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-slate-800">Banner Event</h2>
                        <p class="text-xs text-slate-400">Upload poster atau banner event kamu</p>
                    </div>
                </div>

                <div class="relative bg-slate-50 h-72 flex flex-col items-center justify-center cursor-pointer group transition-all border-b border-gray-100"
                    onclick="document.getElementById('imageInput').click()">
                    <input type="file" name="banner_image" class="hidden" id="imageInput" accept="image/*">
                    <div id="placeholderContent" class="text-center space-y-3">
                        <div
                            class="w-14 h-14 rounded-2xl bg-blue-50 border-2 border-dashed border-blue-200 flex items-center justify-center mx-auto group-hover:border-blue-500 group-hover:bg-blue-100 transition-all">
                            <i class="fas fa-cloud-upload-alt text-xl text-blue-400 group-hover:text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-700 group-hover:text-blue-600 transition-colors">Klik untuk
                                upload gambar</p>
                            <p class="text-xs text-slate-400 mt-1">PNG, JPG, WEBP — Maks. 2MB — Rekomendasi 724×340px
                            </p>
                        </div>
                    </div>
                    <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden rounded-none">
                    <div id="changeOverlay"
                        class="absolute inset-0 bg-black/50 hidden items-center justify-center rounded-none">
                        <div class="text-center text-white">
                            <i class="fas fa-camera text-2xl mb-2 block"></i>
                            <p class="text-sm font-bold">Ganti Gambar</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Info Dasar --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="px-8 py-5 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-600 flex items-center justify-center">
                        <i class="fas fa-info-circle text-white text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-slate-800">Informasi Dasar</h2>
                        <p class="text-xs text-slate-400">Nama, kategori, dan detail utama event</p>
                    </div>
                </div>

                <div class="p-8 space-y-6">

                    {{-- Judul --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-widest">
                            Nama Event <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            placeholder="Contoh: Workshop UI/UX Design 2026"
                            class="w-full text-2xl font-bold outline-none border-b-2 border-gray-200 focus:border-blue-500 pb-3 bg-transparent placeholder-slate-300 transition-colors"
                            required>
                    </div>

                    {{-- Kategori --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-widest">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="event_category_id"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-slate-700 font-semibold outline-none focus:border-blue-500 transition-colors bg-white cursor-pointer"
                            required>
                            <option value="" disabled selected class="text-slate-300">Pilih kategori event
                            </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('event_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Grid Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">

                        {{-- Creator --}}
                        <div class="space-y-3">
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-widest">
                                Diselenggarakan Oleh
                            </label>
                            <div
                                class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3 border border-slate-200">
                                <div
                                    class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span
                                    class="font-bold text-sm text-slate-700 truncate">{{ auth()->user()->name }}</span>
                            </div>
                        </div>

                        {{-- Tanggal & Waktu --}}
                        <div class="space-y-3">
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-widest">
                                Tanggal & Waktu <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <div
                                    class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3 border border-slate-200 focus-within:border-blue-500 transition-colors">
                                    <i class="far fa-calendar-alt text-blue-500 flex-shrink-0"></i>
                                    <div class="w-full space-y-1">
                                        <input type="date" name="start_date" value="{{ old('start_date') }}"
                                            class="bg-transparent outline-none text-sm font-bold text-slate-700 w-full cursor-pointer"
                                            required>
                                        <input type="date" name="end_date" value="{{ old('end_date') }}"
                                            class="bg-transparent outline-none text-sm font-bold text-slate-700 w-full cursor-pointer">
                                    </div>
                                </div>
                                <div
                                    class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3 border border-slate-200 focus-within:border-blue-500 transition-colors">
                                    <i class="far fa-clock text-blue-500 flex-shrink-0"></i>
                                    <div class="flex items-center gap-2 w-full">
                                        <input type="time" name="start_time" value="{{ old('start_time') }}"
                                            class="bg-transparent outline-none text-sm font-bold text-slate-700 cursor-pointer"
                                            required>
                                        <span class="text-slate-300 font-bold">—</span>
                                        <input type="time" name="end_time" value="{{ old('end_time') }}"
                                            class="bg-transparent outline-none text-sm text-slate-500 cursor-pointer">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        <div class="space-y-3">
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-widest">
                                Lokasi <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <div
                                    class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3 border border-slate-200 focus-within:border-blue-500 transition-colors">
                                    <i class="fas fa-map-marker-alt text-blue-500 flex-shrink-0"></i>
                                    <input type="text" name="venue" value="{{ old('venue') }}"
                                        placeholder="Nama venue / gedung"
                                        class="bg-transparent outline-none text-sm font-bold text-slate-700 w-full placeholder-slate-300"
                                        required>
                                </div>
                                <div
                                    class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3 border border-slate-200 focus-within:border-blue-500 transition-colors">
                                    <i class="fas fa-city text-blue-500 flex-shrink-0"></i>
                                    <input type="text" name="location" value="{{ old('location') }}"
                                        placeholder="Kota / daerah"
                                        class="bg-transparent outline-none text-sm text-slate-700 w-full placeholder-slate-300"
                                        required>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Section 3: Tiket & Deskripsi --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="flex border-b border-gray-200">
                    <button type="button" @click="activeTab = 'tiket'"
                        :class="activeTab === 'tiket'
                            ?
                            'border-blue-600 text-blue-600 bg-blue-50/50' :
                            'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                        class="flex-1 py-4 text-sm font-bold border-b-2 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-ticket-alt text-sm"></i>
                        KATEGORI TIKET
                    </button>
                    <button type="button" @click="activeTab = 'deskripsi'"
                        :class="activeTab === 'deskripsi'
                            ?
                            'border-blue-600 text-blue-600 bg-blue-50/50' :
                            'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                        class="flex-1 py-4 text-sm font-bold border-b-2 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-align-left text-sm"></i>
                        DESKRIPSI EVENT
                    </button>
                </div>

                <div class="p-8">

                    {{-- Tab Tiket --}}
                    <div x-show="activeTab === 'tiket'" class="space-y-6">

                        <p class="text-sm text-slate-500 font-medium">Pilih tipe tiket yang ingin kamu buat:</p>

                        {{-- Pilih tipe tiket --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach ([['key' => 'berbayar', 'label' => 'Berbayar', 'icon' => 'fas fa-money-bill-wave', 'color' => 'blue', 'desc' => 'Tetapkan harga tiket'], ['key' => 'sesukamu', 'label' => 'Bayar Sesukamu', 'icon' => 'fas fa-heart', 'color' => 'purple', 'desc' => 'Pembeli tentukan harga'], ['key' => 'gratis', 'label' => 'Gratis', 'icon' => 'fas fa-gift', 'color' => 'green', 'desc' => 'Tiket tanpa biaya']] as $type)
                                <button type="button" @click="addTicket('{{ $type['key'] }}')"
                                    class="group border-2 border-dashed border-gray-200 rounded-2xl p-5 flex items-center gap-4 hover:border-{{ $type['color'] }}-500 hover:bg-{{ $type['color'] }}-50 transition-all text-left">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-{{ $type['color'] }}-100 flex items-center justify-center flex-shrink-0 group-hover:bg-{{ $type['color'] }}-200 transition-colors">
                                        <i class="{{ $type['icon'] }} text-{{ $type['color'] }}-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">{{ $type['label'] }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $type['desc'] }}</p>
                                    </div>
                                </button>
                            @endforeach
                        </div>

                        {{-- List tiket --}}
                        <template x-for="(ticket, index) in tickets" :key="ticket.id">
                            <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden">
                                {{-- Header tiket --}}
                                <div
                                    class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-white">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                            :class="{
                                                'bg-blue-100': ticket.type === 'berbayar',
                                                'bg-purple-100': ticket.type === 'sesukamu',
                                                'bg-green-100': ticket.type === 'gratis'
                                            }">
                                            <i class="fas fa-ticket-alt text-sm rotate-45"
                                                :class="{
                                                    'text-blue-600': ticket.type === 'berbayar',
                                                    'text-purple-600': ticket.type === 'sesukamu',
                                                    'text-green-600': ticket.type === 'gratis'
                                                }">
                                            </i>
                                        </div>
                                        <span class="text-xs font-black uppercase tracking-widest text-slate-500"
                                            x-text="ticket.type === 'gratis' ? 'Tiket Gratis' : ticket.type === 'berbayar' ? 'Tiket Berbayar' : 'Bayar Sesukamu'">
                                        </span>
                                    </div>
                                    <button type="button" @click="removeTicket(ticket.id)"
                                        class="text-slate-400 hover:text-red-500 transition-colors text-sm flex items-center gap-1.5 font-medium">
                                        <i class="fas fa-trash-alt"></i>
                                        Hapus
                                    </button>
                                </div>

                                <div class="p-6 space-y-4">
                                    <div>
                                        <label
                                            class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">
                                            Nama Tiket
                                        </label>
                                        <input type="text" x-model="ticket.name"
                                            :name="'tickets[' + index + '][name]'"
                                            placeholder="Contoh: VIP, Regular, Early Bird"
                                            class="w-full bg-white border-2 border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:border-blue-500 transition-colors placeholder-slate-300">
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label
                                                class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">
                                                Harga (IDR)
                                            </label>
                                            <div class="relative">
                                                <span
                                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">Rp</span>
                                                <input type="number" x-model="ticket.price"
                                                    :name="'tickets[' + index + '][price]'"
                                                    :readonly="ticket.type === 'gratis'"
                                                    :class="ticket.type === 'gratis' ?
                                                        'bg-slate-100 text-slate-400 cursor-not-allowed' :
                                                        'bg-white text-slate-700'"
                                                    placeholder="0" min="0"
                                                    class="w-full border-2 border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm font-bold outline-none focus:border-blue-500 transition-colors">
                                            </div>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">
                                                Kuota Tiket
                                            </label>
                                            <div class="relative">
                                                <input type="number" x-model="ticket.quota"
                                                    :name="'tickets[' + index + '][quota]'" placeholder="100"
                                                    min="1"
                                                    class="w-full bg-white border-2 border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:border-blue-500 transition-colors">
                                                <span
                                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400">tiket</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">
                                            Deskripsi Tiket <span
                                                class="text-slate-300 normal-case font-medium">(opsional)</span>
                                        </label>
                                        <textarea x-model="ticket.description" :name="'tickets[' + index + '][description]'"
                                            placeholder="Fasilitas atau keterangan tiket ini..." rows="2"
                                            class="w-full bg-white border-2 border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 outline-none focus:border-blue-500 transition-colors resize-none placeholder-slate-300">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- Empty state --}}
                        <div x-show="tickets.length === 0"
                            class="border-2 border-dashed border-slate-200 rounded-2xl py-16 text-center">
                            <i class="fas fa-ticket-alt text-5xl text-slate-200 mb-4 block rotate-45"></i>
                            <p class="font-bold text-slate-400">Belum ada tiket ditambahkan</p>
                            <p class="text-sm text-slate-300 mt-1">Pilih tipe tiket di atas untuk mulai</p>
                        </div>

                    </div>

                    {{-- Tab Deskripsi --}}
                    <div x-show="activeTab === 'deskripsi'" class="space-y-4">
                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-widest">
                                Deskripsi Event
                            </label>
                            <textarea name="description" rows="10"
                                placeholder="Ceritakan event kamu — siapa yang tampil, apa yang akan terjadi, mengapa orang harus hadir..."
                                class="w-full border-2 border-gray-200 rounded-2xl px-5 py-4 outline-none focus:border-blue-500 transition-colors text-slate-700 placeholder-slate-300 font-medium resize-none leading-relaxed">{{ old('description') }}</textarea>
                            <p class="text-xs text-slate-400">Deskripsi yang baik membantu calon pembeli memahami event
                                kamu.</p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Section 4: Kontak & Pengaturan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="px-8 py-5 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-orange-500 flex items-center justify-center">
                        <i class="fas fa-cog text-white text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-slate-800">Kontak & Pengaturan</h2>
                        <p class="text-xs text-slate-400">Informasi narahubung dan aturan pembelian tiket</p>
                    </div>
                </div>

                <div class="p-8 space-y-8">

                    {{-- Kontak --}}
                    <div class="space-y-5">
                        <h3 class="text-sm font-black text-slate-700 uppercase tracking-widest">Narahubung</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-600">
                                    Nama Narahubung <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="contact_name" value="{{ old('contact_name') }}"
                                    placeholder="Nama lengkap"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500 transition-colors text-slate-700 font-medium placeholder-slate-300"
                                    required>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-600">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="contact_email"
                                    value="{{ old('contact_email', auth()->user()->email) }}"
                                    placeholder="email@example.com"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500 transition-colors text-slate-700 font-medium placeholder-slate-300"
                                    required>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-600">
                                    No. Ponsel <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-3">
                                    <div
                                        class="flex items-center gap-2 border-2 border-gray-200 rounded-xl px-4 py-3 bg-slate-50 flex-shrink-0">
                                        <img src="https://flagcdn.com/w20/id.png" width="20" alt="ID">
                                        <span class="text-sm font-bold text-slate-700">+62</span>
                                    </div>
                                    <input type="tel" name="contact_phone" value="{{ old('contact_phone') }}"
                                        placeholder="8123456789"
                                        class="flex-1 border-2 border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500 transition-colors text-slate-700 font-medium placeholder-slate-300"
                                        required>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-600">
                                    Maks. Tiket Per Transaksi
                                </label>
                                <select name="max_tickets_per_transaction"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500 transition-colors text-slate-700 font-medium bg-white cursor-pointer">
                                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10] as $num)
                                        <option value="{{ $num }}"
                                            {{ old('max_tickets_per_transaction', 5) == $num ? 'selected' : '' }}>
                                            {{ $num }} Tiket
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Pengaturan Toggle --}}
                    <div class="space-y-4 pt-4 border-t border-gray-100">
                        <h3 class="text-sm font-black text-slate-700 uppercase tracking-widest">Pengaturan Pembelian
                        </h3>

                        <div class="space-y-3">
                            <div
                                class="flex items-center justify-between bg-slate-50 rounded-xl px-5 py-4 border border-slate-200">
                                <div>
                                    <p class="text-sm font-bold text-slate-700">1 akun email — 1 kali transaksi</p>
                                    <p class="text-xs text-slate-400 mt-0.5">1 akun email hanya dapat melakukan 1 kali
                                        pembelian tiket.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 ml-4">
                                    <input type="checkbox" name="one_email_one_transaction" value="1"
                                        class="sr-only peer" {{ old('one_email_one_transaction') ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all">
                                    </div>
                                </label>
                            </div>

                            <div
                                class="flex items-center justify-between bg-slate-50 rounded-xl px-5 py-4 border border-slate-200">
                                <div>
                                    <p class="text-sm font-bold text-slate-700">1 tiket — 1 data pemesan</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Setiap tiket wajib menggunakan data
                                        pemesan yang berbeda.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 ml-4">
                                    <input type="checkbox" name="one_ticket_one_buyer" value="1"
                                        class="sr-only peer" {{ old('one_ticket_one_buyer') ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Fixed Bottom Bar --}}
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 py-4 shadow-xl z-50">
                <div class="max-w-4xl mx-auto px-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-check text-green-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800">Siap dipublish!</p>
                            <p class="text-xs text-slate-400">Simpan sebagai draf atau publish sekarang</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="submit" name="status" value="draft"
                            class="px-6 py-3 rounded-xl border-2 border-slate-300 text-slate-600 font-bold text-sm hover:border-slate-400 hover:bg-slate-50 transition-all flex items-center gap-2">
                            <i class="fas fa-save text-sm"></i>
                            Simpan Draf
                        </button>
                        <button type="submit" name="status" value="published"
                            class="px-6 py-3 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all flex items-center gap-2">
                            <i class="fas fa-rocket text-sm"></i>
                            Publish Event
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <script>
        const imageInput = document.getElementById('imageInput');
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholderContent');
        const overlay = document.getElementById('changeOverlay');

        imageInput.onchange = function() {
            const [file] = this.files;
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
            }
        };
    </script>

</body>

</html>
