<x-user-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-50 py-12 px-4">
        <div class="max-w-md w-full">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('member.tiket.index') }}" class="flex items-center text-gray-500 hover:text-blue-600 transition-colors mb-6 group">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                <span class="text-sm font-bold">Kembali ke Tiket Saya</span>
            </a>

            {{-- Kartu Tiket --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                
                {{-- Header Event --}}
                <div class="bg-blue-600 p-6 text-white text-center">
                    <h2 class="text-xl font-black leading-tight">{{ $ticket->event->title }}</h2>
                    <p class="text-blue-100 text-xs mt-2 uppercase tracking-widest font-bold">
                        E-Ticket Resmi
                    </p>
                </div>

                <div class="p-8 flex flex-col items-center">
                    
                    {{-- Container QR Code --}}
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                        
                        <div class="relative bg-white p-4 rounded-2xl shadow-inner border border-gray-100">
                            {{-- Menggunakan QuickChart API (Lebih stabil untuk local) --}}
                            @if($ticket->ticket_code)
                                <img src="https://quickchart.io/qr?text={{ urlencode($ticket->ticket_code) }}&size=250&margin=1" 
                                     alt="QR Code Tiket"
                                     class="w-48 h-48 md:w-56 md:h-56 object-contain"
                                     onload="this.style.opacity='1'"
                                     style="opacity: 0; transition: opacity 0.5s;">
                            @else
                                <div class="w-48 h-48 flex items-center justify-center bg-gray-50 text-red-500 text-xs text-center p-4">
                                    Kode tiket tidak ditemukan
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Kode Tiket di Bawah Barcode --}}
                    <div class="mt-6 text-center">
                        <span class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-black">Ticket Code</span>
                        <p class="font-mono text-xl font-black text-slate-800 tracking-wider">
                            {{ $ticket->ticket_code }}
                        </p>
                    </div>

                    {{-- Garis Putus-putus (Efek Tiket) --}}
                    <div class="relative w-full my-8">
                        <div class="absolute -left-12 -top-3 w-8 h-8 bg-gray-50 rounded-full border-r border-gray-100"></div>
                        <div class="border-t-2 border-dashed border-gray-100 w-full"></div>
                        <div class="absolute -right-12 -top-3 w-8 h-8 bg-gray-50 rounded-full border-l border-gray-100"></div>
                    </div>

                    {{-- Detail Informasi --}}
                    <div class="w-full space-y-4">
                        <div class="flex justify-between items-end border-b border-gray-50 pb-2">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-black">Nama Pemilik</p>
                                <p class="font-bold text-slate-700">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 uppercase font-black">Tipe Tiket</p>
                                <p class="font-bold text-blue-600">{{ $ticket->ticketType->name }}</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-black">Lokasi</p>
                                <p class="text-sm font-bold text-slate-700">{{ $ticket->event->location }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 uppercase font-black">Waktu</p>
                                <p class="text-sm font-bold text-slate-700">
                                    {{ \Carbon\Carbon::parse($ticket->event->start_date)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer Tiket --}}
                <div class="bg-slate-50 p-4 border-t border-gray-100">
                    <p class="text-center text-[9px] text-gray-400 leading-relaxed uppercase tracking-widest font-medium">
                        Harap tunjukkan QR Code ini kepada petugas di lokasi event untuk melakukan Check-in.
                    </p>
                </div>
            </div>

            {{-- Tombol Download/Cetak (Optional) --}}
            <button onclick="window.print()" class="w-full mt-6 bg-white border-2 border-slate-200 text-slate-600 font-bold py-3 rounded-xl hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                <i class="fas fa-print"></i>
                Cetak Tiket
            </button>
        </div>
    </div>

    <style>
        @media print {
            body * { visibility: hidden; }
            .max-w-md, .max-w-md * { visibility: visible; }
            .max-w-md { position: absolute; left: 0; top: 0; width: 100%; }
            button, a { display: none !important; }
        }
    </style>
</x-user-layout>