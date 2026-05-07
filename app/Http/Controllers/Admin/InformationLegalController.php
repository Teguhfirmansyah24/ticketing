<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformationLegalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $users = User::with('legalDocuments')->get();

        return view('admin.legal.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('legalDocuments')->findOrFail($id);

        return view('admin.legal.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::with('legalDocuments')->findOrFail($id);

    $validated = $request->validate([
        'type' => 'nullable|string|max:255',
        'status' => 'nullable|string|max:255',

        'ktp_number' => 'nullable|string|max:255',
        'ktp_name' => 'nullable|string|max:255',
        'ktp_address' => 'nullable|string',

        'npwp_number' => 'nullable|string|max:255',
        'npwp_name' => 'nullable|string|max:255',
        'npwp_address' => 'nullable|string',

        'deed_number' => 'nullable|string|max:255',
        'deed_name' => 'nullable|string|max:255',
        'deed_address' => 'nullable|string',

        'notes' => 'nullable|string',

        'ktp_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'npwp_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'deed_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $legal = $user->legalDocuments;

    if (!$legal) {
        $legal = new LegalDocument();
        $legal->user_id = $user->id;
    }

    // Upload File KTP
    if ($request->hasFile('ktp_file')) {

        if ($legal->ktp_file && Storage::disk('public')->exists($legal->ktp_file)) {
            Storage::disk('public')->delete($legal->ktp_file);
        }

        $validated['ktp_file'] = $request->file('ktp_file')
            ->store('legal/ktp', 'public');
    }

    // Upload File NPWP
    if ($request->hasFile('npwp_file')) {

        if ($legal->npwp_file && Storage::disk('public')->exists($legal->npwp_file)) {
            Storage::disk('public')->delete($legal->npwp_file);
        }

        $validated['npwp_file'] = $request->file('npwp_file')
            ->store('legal/npwp', 'public');
    }

    // Upload File Deed
    if ($request->hasFile('deed_file')) {

        if ($legal->deed_file && Storage::disk('public')->exists($legal->deed_file)) {
            Storage::disk('public')->delete($legal->deed_file);
        }

        $validated['deed_file'] = $request->file('deed_file')
            ->store('legal/deed', 'public');
    }

    $legal->fill($validated);

    $legal->save();

    return redirect()
        ->route('admin.legal.index')
        ->with('success', 'Data legal berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
