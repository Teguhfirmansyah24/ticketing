<x-admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-slate-800">Manajemen Event Admin</h2>
        <!-- Mungkin kamu butuh tombol tambah event di sini nantinya -->
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($events as $event)
            <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden flex flex-col">
                <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop' }}"
                    alt="{{ $event->title }}"
                    class="w-full h-40 object-cover">
                
                <div class="p-4 flex-grow">
                    <h2 class="font-bold text-lg mb-1">{{ $event->title }}</h2>
                    <p class="text-sm text-gray-500 mb-4">
                        {{ Str::limit($event->description, 100) }}
                    </p>
                </div>

                <!-- Bagian Aksi/Tombol dipindah ke sini (di dalam loop) -->
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex gap-2">
                    <!-- Sekarang $event->id sudah aman karena di dalam foreach -->
                    <a href="{{ route('admin.tickets.index', $event->id) }}" 
                       class="bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-600 hover:text-white transition flex items-center">
                       <i class="fas fa-ticket-alt mr-1.5"></i> Kelola Tiket
                    </a>
                    
                    <a href="{{ route('admin.events.edit', $event->id) }}" class="bg-amber-50 text-amber-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-amber-500 hover:text-white transition flex items-center">
                        <i class="fas fa-edit mr-1.5"></i> Edit
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $events->links() }}
    </div>
</x-admin-layout>