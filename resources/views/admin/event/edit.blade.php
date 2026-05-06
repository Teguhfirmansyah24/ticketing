<x-admin-layout>
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 max-w-2xl mx-auto">
    <h3 class="text-lg font-bold mb-4">Edit Event: {{ $event->title }}</h3>

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Judul Event</label>
            <input type="text" name="title" value="{{ old('title', $event->title) }}" 
                class="w-full rounded-xl border-gray-200 mt-1 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Lokasi</label>
            <input type="text" name="location" value="{{ old('location', $event->location) }}" 
                class="w-full rounded-xl border-gray-200 mt-1">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" rows="4" 
                class="w-full rounded-xl border-gray-200 mt-1">{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.event-admin') }}" class="px-4 py-2 text-sm font-bold text-gray-500">Batal</a>
            <button type="submit" class="bg-blue-600 text-white rounded-xl px-6 py-2 text-sm font-bold hover:bg-blue-700">
                Update Event
            </button>
        </div>
    </form>
</div>
</x-admin-layout>