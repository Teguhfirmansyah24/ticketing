<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaAksesController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Query team members
        $membersQuery = TeamMember::with('user')
            ->where('event_creator_id', $user->id);

        if ($request->filled('search')) {
            $membersQuery->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $membersQuery->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $membersQuery->where('status', $request->status);
        }

        $members = $membersQuery->paginate($request->per_page ?? 5)->withQueryString();

        // Query events
        $eventsQuery = Event::with(['category', 'ticketTypes'])
            ->where('user_id', $user->id);

        if ($request->filled('event_search')) {
            $eventsQuery->where('title', 'like', '%' . $request->event_search . '%');
        }

        if ($request->filled('event_status')) {
            match ($request->event_status) {
                'aktif'  => $eventsQuery->where('status', 'published')->where('end_date', '>=', now()),
                'draft'  => $eventsQuery->where('status', 'draft'),
                'lalu'   => $eventsQuery->where('end_date', '<', now()),
                default  => null,
            };
        }

        $events = $eventsQuery->latest()->paginate(5, ['*'], 'events_page')->withQueryString();

        return view('creator.kelolaakses.index', compact('members', 'events'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();

        $query = Event::with(['category', 'ticketTypes'])
            ->where('user_id', $user->id);

        // Search
        if ($request->filled('event_search')) {
            $query->where('title', 'like', '%' . $request->event_search . '%');
        }

        // Filter status
        if ($request->filled('event_status')) {
            match ($request->event_status) {
                'aktif' => $query->where('status', 'published')->where('end_date', '>=', now()),
                'draft' => $query->where('status', 'draft'),
                'lalu'  => $query->where('end_date', '<', now()),
                default => null,
            };
        }

        $events = $query->latest()->paginate(10)->withQueryString();

        return view('creator.kelolaakses.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role'  => 'required|in:check-in-crew,finance,operation,ticketing-kasir',
        ]);

        $user       = auth()->user();
        $invitedUser = User::where('email', $request->email)->first();

        // Cek apakah sudah ada
        $exists = TeamMember::where('event_creator_id', $user->id)
            ->where('user_id', $invitedUser->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['email' => 'Pengguna ini sudah menjadi anggota tim kamu.']);
        }

        // Tidak bisa undang diri sendiri
        if ($invitedUser->id === $user->id) {
            return back()->withErrors(['email' => 'Kamu tidak bisa mengundang dirimu sendiri.']);
        }

        TeamMember::create([
            'event_creator_id' => $user->id,
            'user_id'          => $invitedUser->id,
            'role'             => $request->role,
            'status'           => 'active',
        ]);

        return back()->with('success', 'Anggota tim berhasil diundang.');
    }

    public function destroy($id)
    {
        $member = TeamMember::where('event_creator_id', auth()->id())
            ->findOrFail($id);

        $member->delete();

        return back()->with('success', 'Anggota tim berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $member = TeamMember::where('event_creator_id', auth()->id())
            ->findOrFail($id);

        $member->update([
            'status' => $member->status === 'active' ? 'inactive' : 'active'
        ]);

        return back()->with('success', 'Status anggota berhasil diubah.');
    }
}
