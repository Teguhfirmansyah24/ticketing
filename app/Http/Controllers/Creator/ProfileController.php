<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user   = auth()->user();
        $events = Event::where('user_id', $user->id)
            ->where('status', 'published')
            ->latest()
            ->get();

        return view('creator.profile.index', compact('user', 'events'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'              => 'required|string|max:255',
            'phone'             => 'nullable|string|max:20',
            'address'           => 'nullable|string|max:150',
            'about'             => 'nullable|string|max:250',
            'twitter'           => 'nullable|string|max:100',
            'instagram'         => 'nullable|string|max:100',
            'facebook'          => 'nullable|url|max:255',
            'featured_event_id' => 'nullable|exists:events,id',
            'avatar'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'banner'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // Upload banner
        if ($request->hasFile('banner')) {
            if ($user->banner) {
                Storage::disk('public')->delete($user->banner);
            }
            $user->banner = $request->file('banner')->store('banners/creator', 'public');
        }

        $user->update([
            'name'              => $request->name,
            'phone'             => $request->phone,
            'address'           => $request->address,
            'about'             => $request->about,
            'twitter'           => $request->twitter,
            'instagram'         => $request->instagram,
            'facebook'          => $request->facebook,
            'featured_event_id' => $request->featured_event_id,
            'avatar'            => $user->avatar,
            'banner'            => $user->banner,
        ]);

        return back()->with('success', 'Profil creator berhasil diperbarui.');
    }
}
