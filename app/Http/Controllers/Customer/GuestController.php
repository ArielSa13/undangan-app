<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestController extends Controller
{
    public function index(Invitation $invitation): View
    {
        $this->authorize('view', $invitation);

        $guests = $invitation->guests()->latest()->paginate(20);
        $stats = $invitation->getRsvpStats();

        return view('customer.guests.index', compact('invitation', 'guests', 'stats'));
    }

    public function store(Request $request, Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'group' => ['nullable', 'string', 'max:100'],
            'max_pax' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $invitation->guests()->create($validated);

        return back()->with('success', 'Tamu berhasil ditambahkan.');
    }

    public function update(Request $request, Invitation $invitation, Guest $guest): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'group' => ['nullable', 'string', 'max:100'],
            'max_pax' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $guest->update($validated);

        return back()->with('success', 'Data tamu berhasil diperbarui.');
    }

    public function destroy(Invitation $invitation, Guest $guest): RedirectResponse
    {
        $this->authorize('update', $invitation);
        $guest->delete();

        return back()->with('success', 'Tamu berhasil dihapus.');
    }
}
