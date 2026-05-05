<x-admin-layout>
    <div class="grid grid-cols-3 gap-6">
    @foreach ($events as $event)
       
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop' }}"
                alt="{{ $event->title }}"
                class="w-full h-40 object-cover">
            <div class="p-4">
                <h2 class="font-bold text-lg">{{ $event->title }}</h2>
                <p class="text-sm text-gray-500">
                    {{ Str::limit($event->description, 100) }}
                </p>
            </div>

        </div>
    @endforeach
     <div class="mt-6">
            {{ $events->links() }}
        </div>
</div>
</x-admin-layout>