@if ($status === 'pending')
    <span
        class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-black uppercase rounded-lg border border-amber-100">
        Menunggu Verifikasi
    </span>
@elseif ($status === 'verified')
    <span
        class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase rounded-lg border border-emerald-100">
        Terverifikasi
    </span>
@else
    <span class="px-3 py-1 bg-red-50 text-red-500 text-[10px] font-black uppercase rounded-lg border border-red-100">
        Ditolak
    </span>
@endif
