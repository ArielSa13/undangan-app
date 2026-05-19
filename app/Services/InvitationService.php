<?php

namespace App\Services;

use App\Enums\InvitationStatus;
use App\Models\Gallery;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class InvitationService
{
    public function create(User $user, array $data): Invitation
    {
        $data['user_id'] = $user->id;
        $data['status'] = InvitationStatus::DRAFT;

        if (isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {
            $data['cover_image'] = $this->uploadImage($data['cover_image'], 'covers');
        }

        if (isset($data['groom_photo']) && $data['groom_photo'] instanceof UploadedFile) {
            $data['groom_photo'] = $this->uploadImage($data['groom_photo'], 'profiles');
        }

        if (isset($data['bride_photo']) && $data['bride_photo'] instanceof UploadedFile) {
            $data['bride_photo'] = $this->uploadImage($data['bride_photo'], 'profiles');
        }

        if (isset($data['qris_image']) && $data['qris_image'] instanceof UploadedFile) {
            $data['qris_image'] = $this->uploadImage($data['qris_image'], 'qris');
        }

        if (isset($data['music_url']) && $data['music_url'] instanceof UploadedFile) {
            $data['music_url'] = $data['music_url']->store('music', 'public');
        }

        return Invitation::create($data);
    }

    public function update(Invitation $invitation, array $data): Invitation
    {
        if (isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {
            $this->deleteImage($invitation->cover_image);
            $data['cover_image'] = $this->uploadImage($data['cover_image'], 'covers');
        }

        if (isset($data['groom_photo']) && $data['groom_photo'] instanceof UploadedFile) {
            $this->deleteImage($invitation->groom_photo);
            $data['groom_photo'] = $this->uploadImage($data['groom_photo'], 'profiles');
        }

        if (isset($data['bride_photo']) && $data['bride_photo'] instanceof UploadedFile) {
            $this->deleteImage($invitation->bride_photo);
            $data['bride_photo'] = $this->uploadImage($data['bride_photo'], 'profiles');
        }

        if (isset($data['qris_image']) && $data['qris_image'] instanceof UploadedFile) {
            $this->deleteImage($invitation->qris_image);
            $data['qris_image'] = $this->uploadImage($data['qris_image'], 'qris');
        }

        if (isset($data['music_url']) && $data['music_url'] instanceof UploadedFile) {
            $this->deleteImage($invitation->music_url);
            $data['music_url'] = $data['music_url']->store('music', 'public');
        }

        $invitation->update($data);
        return $invitation->fresh();
    }

    public function publish(Invitation $invitation): Invitation
    {
        $invitation->update([
            'status' => InvitationStatus::PUBLISHED,
            'published_at' => now(),
        ]);

        return $invitation;
    }

    public function pause(Invitation $invitation): Invitation
    {
        $invitation->update(['status' => InvitationStatus::PAUSED]);
        return $invitation;
    }

    public function duplicate(Invitation $invitation): Invitation
    {
        $newInvitation = $invitation->replicate();
        $newInvitation->slug = Invitation::generateSlug($invitation->groom_name, $invitation->bride_name);
        $newInvitation->status = InvitationStatus::DRAFT;
        $newInvitation->view_count = 0;
        $newInvitation->published_at = null;
        $newInvitation->save();

        // Duplicate galleries
        foreach ($invitation->galleries as $gallery) {
            $newGallery = $gallery->replicate();
            $newGallery->invitation_id = $newInvitation->id;
            $newGallery->save();
        }

        // Duplicate love stories
        foreach ($invitation->loveStories as $story) {
            $newStory = $story->replicate();
            $newStory->invitation_id = $newInvitation->id;
            $newStory->save();
        }

        return $newInvitation;
    }

    public function delete(Invitation $invitation): void
    {
        // Delete associated files
        $this->deleteImage($invitation->cover_image);
        $this->deleteImage($invitation->groom_photo);
        $this->deleteImage($invitation->bride_photo);
        $this->deleteImage($invitation->qris_image);
        $this->deleteImage($invitation->music_url);

        foreach ($invitation->galleries as $gallery) {
            $this->deleteImage($gallery->image_path);
            $this->deleteImage($gallery->thumbnail_path);
        }

        $invitation->delete();
    }

    public function uploadGalleryImage(Invitation $invitation, UploadedFile $file, ?string $caption = null): Gallery
    {
        $imagePath = $this->uploadImage($file, 'galleries/' . $invitation->id);

        return Gallery::create([
            'invitation_id' => $invitation->id,
            'image_path' => $imagePath,
            'caption' => $caption,
            'file_size' => $file->getSize(),
            'sort_order' => $invitation->galleries()->count(),
        ]);
    }

    private function uploadImage(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, 'public');
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
