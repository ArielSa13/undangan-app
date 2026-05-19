<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Template;
use App\Services\InvitationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function __construct(
        private InvitationService $invitationService,
    ) {}

    public function index(Request $request): View
    {
        $invitations = $request->user()
            ->invitations()
            ->with('template')
            ->latest()
            ->paginate(10);

        return view('customer.invitations.index', compact('invitations'));
    }

    public function create(): View
    {
        $templates = Template::active()->get();
        return view('customer.invitations.create', compact('templates'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'template_id' => ['required', 'exists:templates,id'],
            'groom_name' => ['required', 'string', 'max:255'],
            'bride_name' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date', 'after:today'],
            'event_time_start' => ['required'],
            'event_venue' => ['required', 'string', 'max:255'],
            'groom_father' => ['nullable', 'string', 'max:255'],
            'groom_mother' => ['nullable', 'string', 'max:255'],
            'bride_father' => ['nullable', 'string', 'max:255'],
            'bride_mother' => ['nullable', 'string', 'max:255'],
            'event_address' => ['nullable', 'string'],
            'event_maps_url' => ['nullable', 'url'],
            'opening_text' => ['nullable', 'string'],
            'closing_text' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'max:5120'],
            'groom_photo' => ['nullable', 'image', 'max:2048'],
            'bride_photo' => ['nullable', 'image', 'max:2048'],
            'music_url' => ['nullable', 'file', 'mimes:mp3,wav', 'max:10240'],
        ]);

        $invitation = $this->invitationService->create($request->user(), $validated);

        return redirect()->route('customer.invitations.edit', $invitation)
            ->with('success', 'Undangan berhasil dibuat! Silakan lengkapi detail undangan.');
    }

    public function show(Invitation $invitation): View
    {
        $this->authorize('view', $invitation);
        $invitation->load(['template', 'guests', 'galleries', 'guestbooks', 'loveStories']);

        return view('customer.invitations.show', compact('invitation'));
    }

    public function edit(Invitation $invitation): View
    {
        $this->authorize('update', $invitation);
        $invitation->load(['template', 'galleries', 'loveStories']);
        $templates = Template::active()->get();

        return view('customer.invitations.edit', compact('invitation', 'templates'));
    }

    public function update(Request $request, Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $validated = $request->validate([
            'template_id' => ['sometimes', 'exists:templates,id'],
            'groom_name' => ['sometimes', 'required', 'string', 'max:255'],
            'bride_name' => ['sometimes', 'required', 'string', 'max:255'],
            'event_date' => ['sometimes', 'required', 'date'],
            'event_time_start' => ['sometimes', 'required'],
            'event_time_end' => ['nullable'],
            'event_venue' => ['sometimes', 'required', 'string', 'max:255'],
            'event_address' => ['nullable', 'string'],
            'event_maps_url' => ['nullable', 'url'],
            'groom_father' => ['nullable', 'string', 'max:255'],
            'groom_mother' => ['nullable', 'string', 'max:255'],
            'bride_father' => ['nullable', 'string', 'max:255'],
            'bride_mother' => ['nullable', 'string', 'max:255'],
            'groom_instagram' => ['nullable', 'string', 'max:255'],
            'bride_instagram' => ['nullable', 'string', 'max:255'],
            'reception_date' => ['nullable', 'date'],
            'reception_time_start' => ['nullable'],
            'reception_time_end' => ['nullable'],
            'reception_venue' => ['nullable', 'string', 'max:255'],
            'reception_address' => ['nullable', 'string'],
            'reception_maps_url' => ['nullable', 'url'],
            'opening_text' => ['nullable', 'string'],
            'closing_text' => ['nullable', 'string'],
            'dress_code' => ['nullable', 'string', 'max:255'],
            'gift_info' => ['nullable', 'string'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account' => ['nullable', 'string', 'max:255'],
            'bank_holder' => ['nullable', 'string', 'max:255'],
            'cover_image' => ['nullable', 'image', 'max:5120'],
            'groom_photo' => ['nullable', 'image', 'max:2048'],
            'bride_photo' => ['nullable', 'image', 'max:2048'],
            'qris_image' => ['nullable', 'image', 'max:2048'],
            'music_url' => ['nullable', 'file', 'mimes:mp3,wav', 'max:10240'],
            'music_autoplay' => ['nullable', 'boolean'],
            'primary_color' => ['nullable', 'string', 'max:7'],
            'secondary_color' => ['nullable', 'string', 'max:7'],
            'font_family' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:invitations,slug,' . $invitation->id],
            'is_rsvp_enabled' => ['nullable', 'boolean'],
            'is_guestbook_enabled' => ['nullable', 'boolean'],
            'is_gallery_enabled' => ['nullable', 'boolean'],
            'is_countdown_enabled' => ['nullable', 'boolean'],
            'is_music_enabled' => ['nullable', 'boolean'],
            'is_maps_enabled' => ['nullable', 'boolean'],
            'is_love_story_enabled' => ['nullable', 'boolean'],
            'is_gift_enabled' => ['nullable', 'boolean'],
        ]);

        $this->invitationService->update($invitation, $validated);

        return redirect()->route('customer.invitations.edit', $invitation)
            ->with('success', 'Undangan berhasil diperbarui!');
    }

    public function destroy(Invitation $invitation): RedirectResponse
    {
        $this->authorize('delete', $invitation);
        $this->invitationService->delete($invitation);

        return redirect()->route('customer.invitations.index')
            ->with('success', 'Undangan berhasil dihapus.');
    }

    public function publish(Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);
        $this->invitationService->publish($invitation);

        return back()->with('success', 'Undangan berhasil dipublish!');
    }

    public function pause(Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);
        $this->invitationService->pause($invitation);

        return back()->with('success', 'Undangan dijeda.');
    }

    public function duplicate(Invitation $invitation): RedirectResponse
    {
        $this->authorize('view', $invitation);
        $newInvitation = $this->invitationService->duplicate($invitation);

        return redirect()->route('customer.invitations.edit', $newInvitation)
            ->with('success', 'Undangan berhasil diduplikasi!');
    }
}
