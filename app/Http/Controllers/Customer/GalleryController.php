<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Invitation;
use App\Services\InvitationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __construct(
        private InvitationService $invitationService,
    ) {}

    public function index(Invitation $invitation): View
    {
        $this->authorize('view', $invitation);
        $galleries = $invitation->galleries()->ordered()->get();

        return view('customer.galleries.index', compact('invitation', 'galleries'));
    }

    public function store(Request $request, Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'max:5120'],
        ]);

        foreach ($request->file('images') as $image) {
            $this->invitationService->uploadGalleryImage($invitation, $image);
        }

        return back()->with('success', 'Foto berhasil diupload.');
    }

    public function destroy(Invitation $invitation, Gallery $gallery): RedirectResponse
    {
        $this->authorize('update', $invitation);

        Storage::disk('public')->delete($gallery->image_path);
        if ($gallery->thumbnail_path) {
            Storage::disk('public')->delete($gallery->thumbnail_path);
        }
        $gallery->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function reorder(Request $request, Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:galleries,id'],
        ]);

        foreach ($request->order as $index => $id) {
            Gallery::where('id', $id)
                ->where('invitation_id', $invitation->id)
                ->update(['sort_order' => $index]);
        }

        return back()->with('success', 'Urutan foto diperbarui.');
    }
}
