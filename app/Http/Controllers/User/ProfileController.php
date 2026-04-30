<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'       => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender'     => 'nullable|in:L,P',
            'avatar'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        // Upload avatar hanya untuk user yang login
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // Update email verification jika email berubah
        if ($user->email !== $request->email) {
            $user->email_verified_at = null;
        }

        $user->update([
            'name'       => $request->name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'birth_date' => $request->birth_date ?? null,
            'gender'     => $request->gender,
            'avatar'     => $user->avatar,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
