<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\LegalDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegalController extends Controller
{
    public function index()
    {
        $documents = LegalDocument::where('user_id', auth()->id())
            ->latest()
            ->get();

        $latest = $documents->first();

        return view('creator.legal.index', compact('documents', 'latest'));
    }

    public function create()
    {
        // Cek apakah sudah ada dokumen pending/verified
        $existing = LegalDocument::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'verified'])
            ->first();

        return view('creator.legal.create', compact('existing'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_legal' => 'required|in:individu,badan_hukum',
            'agree'      => 'required|accepted',

            // Individu
            'ktp_number'  => 'required_if:tipe_legal,individu|nullable|digits:16',
            'file_ktp'    => 'required_if:tipe_legal,individu|nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_name'    => 'required_if:tipe_legal,individu|nullable|string|max:255',
            'ktp_address' => 'required_if:tipe_legal,individu|nullable|string',

            // NPWP
            'npwp_number' => 'nullable|string|max:20',
            'file_npwp'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'npwp_name'   => 'nullable|string|max:255',
            'npwp_address' => 'nullable|string',

            // NPWP
            'individu_npwp_number' => 'nullable|string|max:20',
            'individu_file_npwp'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'individu_npwp_name'   => 'nullable|string|max:255',
            'individu_npwp_address' => 'nullable|string',

            // Badan Hukum
            'deed_number' => 'required_if:tipe_legal,badan_hukum|nullable|string|max:100',
            'file_deed'   => 'required_if:tipe_legal,badan_hukum|nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'deed_name'   => 'required_if:tipe_legal,badan_hukum|nullable|string|max:255',
            'deed_address' => 'required_if:tipe_legal,badan_hukum|nullable|string',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'type'    => $request->tipe_legal,
            'status'  => 'pending',
        ];

        // Upload KTP
        if ($request->hasFile('file_ktp')) {
            $data['ktp_file'] = $request->file('file_ktp')->store('legal/ktp', 'public');
        }

        if ($request->tipe_legal === 'individu') {
            // Data KTP
            $data['ktp_number']  = $request->ktp_number;
            $data['ktp_name']    = $request->ktp_name;
            $data['ktp_address'] = $request->ktp_address;

            // NPWP individu — pakai prefix individu_
            $data['npwp_number']  = $request->individu_npwp_number;
            $data['npwp_name']    = $request->individu_npwp_name;
            $data['npwp_address'] = $request->individu_npwp_address;

            if ($request->hasFile('individu_file_npwp')) {
                $data['npwp_file'] = $request->file('individu_file_npwp')->store('legal/npwp', 'public');
            }
        } else {
            // Badan Hukum
            $data['npwp_number']  = $request->npwp_number;
            $data['npwp_name']    = $request->npwp_name;
            $data['npwp_address'] = $request->npwp_address;
            $data['deed_number']  = $request->deed_number;
            $data['deed_name']    = $request->deed_name;
            $data['deed_address'] = $request->deed_address;

            if ($request->hasFile('file_npwp')) {
                $data['npwp_file'] = $request->file('file_npwp')->store('legal/npwp', 'public');
            }

            if ($request->hasFile('file_deed')) {
                $data['deed_file'] = $request->file('file_deed')->store('legal/deed', 'public');
            }
        }

        LegalDocument::create($data);

        return redirect()->route('creator.legal.index')
            ->with('success', 'Informasi legal berhasil dikirim. Menunggu verifikasi admin.');
    }
}
