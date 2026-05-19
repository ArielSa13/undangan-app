<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class InvitationViewController extends Controller
{
    public function show(string $slug, Request $request): View
    {
        $invitation = Invitation::where('slug', $slug)
            ->published()
            ->with(['template', 'galleries', 'loveStories', 'guestbooks' => function ($q) {
                $q->approved()->latest()->take(50);
            }])
            ->firstOrFail();

        $invitation->incrementView();

        $guestName = $request->query('to');
        $guest = null;

        if ($guestName) {
            $guest = $invitation->guests()
                ->where('name', 'like', '%' . $guestName . '%')
                ->first();

            if ($guest) {
                $guest->markAsOpened();
            }
        }

        $templateView = 'templates.' . $invitation->template->blade_path;

        return view($templateView, compact('invitation', 'guestName', 'guest'));
    }

    public function submitRsvp(Request $request, string $slug): RedirectResponse
    {
        $invitation = Invitation::where('slug', $slug)->published()->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'rsvp_status' => ['required', 'in:attending,not_attending,maybe'],
            'attending_count' => ['nullable', 'integer', 'min:0', 'max:10'],
            'rsvp_note' => ['nullable', 'string', 'max:500'],
        ]);

        $guest = $invitation->guests()->where('name', $validated['name'])->first();

        if ($guest) {
            $guest->update([
                'rsvp_status' => $validated['rsvp_status'],
                'attending_count' => $validated['attending_count'] ?? 1,
                'rsvp_note' => $validated['rsvp_note'],
                'rsvp_at' => now(),
            ]);
        } else {
            $invitation->guests()->create([
                'name' => $validated['name'],
                'rsvp_status' => $validated['rsvp_status'],
                'attending_count' => $validated['attending_count'] ?? 1,
                'rsvp_note' => $validated['rsvp_note'],
                'rsvp_at' => now(),
            ]);
        }

        return back()->with('rsvp_success', 'Terima kasih telah mengkonfirmasi kehadiran!');
    }

    public function submitGuestbook(Request $request, string $slug): RedirectResponse
    {
        $invitation = Invitation::where('slug', $slug)->published()->firstOrFail();

        // Rate limit guestbook submissions
        $key = 'guestbook:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->withErrors(['guestbook' => 'Terlalu banyak pesan. Coba lagi nanti.']);
        }
        RateLimiter::hit($key, 60);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        Guestbook::create([
            'invitation_id' => $invitation->id,
            'name' => $validated['name'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'is_approved' => true, // Auto approve, admin can moderate later
        ]);

        return back()->with('guestbook_success', 'Ucapan berhasil dikirim!');
    }
}
