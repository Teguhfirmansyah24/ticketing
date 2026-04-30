<x-user-layout>
    <div class="flex-1 flex flex-col min-h-screen bg-white transition-all duration-300">
        <div class="py-8 px-4 sm:px-10 lg:px-16 w-full max-w-[1600px] mx-auto">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 mb-8 bg-gray-100/50 self-start px-3 py-1 rounded-lg w-fit">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kamu di sini</span>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Pengaturan</span>
            </div>

            @include('profile.partials.delete-user-form')
        </div>
    </div>
    <div class="py-6 px-16 flex justify-end">
        <p class="text-[10px] font-medium text-gray-400 tracking-wide uppercase">
            © 2026 LOKET (PT Global Loket Sejahtera)
        </p>
    </div>
</x-user-layout>
