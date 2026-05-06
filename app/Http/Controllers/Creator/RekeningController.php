<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    public function index()
    {
        $accounts = BankAccount::where('user_id', auth()->id())
            ->orderBy('is_primary', 'desc')
            ->latest()
            ->get();

        return view('creator.rekening.index', compact('accounts'));
    }

    public function create()
    {
        return view('creator.rekening.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name'      => 'required|string|max:100',
            'account_number' => 'required|string|max:30',
            'account_name'   => 'required|string|max:255',
            'branch'         => 'required|string|max:255',
            'city'           => 'required|string|max:100',
        ]);

        $isPrimary = BankAccount::where('user_id', auth()->id())->count() === 0;

        BankAccount::create([
            'user_id'        => auth()->id(),
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name'   => $request->account_name,
            'branch'         => $request->branch,
            'city'           => $request->city,
            'is_primary'     => $isPrimary,
        ]);

        return redirect()->route('creator.rekening.index')
            ->with('success', 'Rekening berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $account = BankAccount::where('user_id', auth()->id())->findOrFail($id);

        // Kalau primary dihapus, set rekening lain jadi primary
        if ($account->is_primary) {
            $next = BankAccount::where('user_id', auth()->id())
                ->where('id', '!=', $id)
                ->first();
            if ($next) $next->update(['is_primary' => true]);
        }

        $account->delete();

        return back()->with('success', 'Rekening berhasil dihapus.');
    }

    public function setPrimary($id)
    {
        // Reset semua
        BankAccount::where('user_id', auth()->id())
            ->update(['is_primary' => false]);

        // Set yang dipilih
        BankAccount::where('user_id', auth()->id())
            ->where('id', $id)
            ->update(['is_primary' => true]);

        return back()->with('success', 'Rekening utama berhasil diubah.');
    }
}
