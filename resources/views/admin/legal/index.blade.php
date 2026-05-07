<x-admin-layout>
    <div class="p-6">
        <!-- Header Halaman -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-sky-800">Kelola Akses</h1>
            <p class="text-sky-600/70 text-sm">Manajemen izin akses pengguna dan konfigurasi sistem.</p>
        </div>

        <!-- Card Container -->
        <div class="bg-white rounded-xl shadow-md border border-sky-100 overflow-hidden">
            <!-- Table Action (Optional: Tombol Tambah dsb) -->
            <div class="bg-sky-50/50 p-4 border-b border-sky-100 flex justify-between items-center">
                <span class="font-semibold text-sky-900">Daftar yang memiliki akses terhadap web ini</span>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <form  method="post">
                    @csrf
                    @method('post')
                <table class="w-full text-left border-collapse">
                    <thead class="bg-sky-600 text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            Nama User
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            User ID
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            Type
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            Status
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            KTP Number
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            KTP File
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            KTP Name
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            KTP Address
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            NPWP Number
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            NPWP File
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            NPWP Name
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            NPWP Address
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            Deed Number
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            Deed File
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            Deed Name
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            Deed Address
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            Notes
        </th>

        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">
            Verified At
        </th>
        <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sky-100">
                        @foreach ($users as $user)
                        <tr class="hover:bg-sky-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-700 font-medium">{{ $user->name ?? '-' }}</td>

<td class="px-6 py-4 text-sky-600">{{ $user->legalDocuments?->user_id ?? '-' }}</td>

<td class="px-6 py-4 text-sky-600">{{ $user->legalDocuments?->type ?? '-' }}</td>

<td class="px-6 py-4 text-sky-600">{{ $user->legalDocuments?->status ?? '-' }}</td>

<td class="px-6 py-4 text-sky-600">{{ $user->legalDocuments?->ktp_number ?? '-' }}</td>

<td class="px-6 py-4 text-sky-600">
    @if ($user->legalDocuments?->ktp_file)

    <img src="{{ asset('storage/' . $user->legalDocuments->ktp_file) }}"
         alt="KTP"
         class="w-40 rounded-2xl border border-sky-100 shadow">

@else

    <div class="w-40 h-28 rounded-2xl border border-dashed border-sky-200 flex items-center justify-center text-xs text-sky-400">
        Belum ada file
    </div>

@endif
</td>

<td class="px-6 py-4 text-sky-600">
    {{ $user->legalDocuments?->ktp_name ?? '-' }}
</td>

<td class="px-6 py-4 text-sky-600">
    {{ $user->legalDocuments?->ktp_address ?? '-' }}
</td>

<td class="px-6 py-4 text-sky-600">
    {{ $user->legalDocuments?->npwp_number ?? '-' }}
</td>

<td class="px-6 py-4 text-sky-600">
    {{ $user->legalDocuments?->npwp_file ?? '-' }}
</td>

<td class="px-6 py-4 text-sky-600">
    {{ $user->legalDocuments?->npwp_name ?? '-' }}
</td>

<td class="px-6 py-4 text-sky-600">
    {{ $user->legalDocuments?->npwp_address ?? '-' }}
</td>

<td class="px-6 py-4 text-sky-600">
    {{ $user->legalDocuments?->deed_number ?? '-' }}
</td>

<td class="px-6 py-4 text-sky-600">
    {{ $user->legalDocuments?->deed_file ?? '-' }}
</td>

<td class="px-6 py-4 text-sky-600">
    {{ $user->legalDocuments?->deed_name ?? '-' }}
</td>

<td class="px-6 py-4 text-sky-600">
    {{ $user->legalDocuments?->deed_address ?? '-' }}
</td>

<td class="px-6 py-4 text-sky-600">
    {{ $user->legalDocuments?->notes ?? '-' }}
</td>

<td class="px-6 py-4 text-sky-600">
    {{ $user->legalDocuments?->verified_at ?? '-' }}
</td>
                         <td class="px-6 py-4">
                            
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('admin.legal.edit', $user->id) }}" 
                                class="text-sky-600 hover:text-sky-900 bg-sky-50 hover:bg-sky-100 p-2 rounded-lg transition-colors"
                                title="Edit User">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </div>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>
            </div>
            
            <div class="p-4 bg-gray-50 border-t border-sky-100 text-xs text-gray-500">
                Menampilkan 3 data akses terbaru.
            </div>
        </div>
    </div>
</x-admin-layout>