<x-admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-slate-800">Manajemen Event Admin</h2>
        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Event
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($events as $event)
            <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                <div class="relative">
                    <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop' }}"
                        alt="{{ $event->title }}"
                        class="w-full h-40 object-cover">
                    <div class="absolute top-2 right-2">
                        <span class="bg-white/90 backdrop-blur px-2 py-1 rounded text-[10px] font-bold uppercase shadow-sm">
                            {{ $event->category->name ?? 'No Category' }}
                        </span>
                    </div>
                </div>
                
                <div class="p-4 flex-grow">
                    <h2 class="font-bold text-lg mb-1">{{ $event->title }}</h2>
                    <p class="text-xs text-gray-400 mb-3 flex items-center">
                        <i class="far fa-calendar-alt mr-1"></i> {{ $event->start_date->format('d M Y') }}
                    </p>

                    {{-- ===== BAGIAN STATISTIK TIKET (SINKRONISASI STOK) ===== --}}
                    <div class="space-y-2 mb-4 bg-slate-50 p-3 rounded-lg border border-slate-100">
                        @foreach($event->ticketTypes as $ticket)
                            @php
                                $remaining = $ticket->quota - $ticket->sold; // Logika pengurangan stok
                                $percentage = $ticket->quota > 0 ? ($ticket->sold / $ticket->quota) * 100 : 0;
                            @endphp
                            <div class="space-y-1">
                                <div class="flex justify-between text-[10px] font-bold uppercase text-slate-500">
                                    <span>{{ $ticket->name }}</span>
                                    <span class="{{ $remaining <= 5 ? 'text-red-500' : 'text-blue-600' }}">
                                        {{ $ticket->sold }} / {{ $ticket->quota }} Terjual
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                        @if($event->ticketTypes->isEmpty())
                            <p class="text-[10px] text-gray-400 italic text-center">Belum ada kategori tiket</p>
                        @endif
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex gap-2">
                    <a href="{{ route('admin.tickets.index', $event->id) }}" 
                       class="flex-1 bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-600 hover:text-white transition flex items-center justify-center">
                       <i class="fas fa-ticket-alt mr-1.5"></i> Tiket
                    </a>
                    
                    <a href="{{ route('admin.events.edit', $event->id) }}" 
                       class="bg-amber-50 text-amber-600 p-1.5 rounded-lg text-xs font-bold hover:bg-amber-500 hover:text-white transition flex items-center justify-center">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $events->links() }}
    </div>
</x-admin-layout>