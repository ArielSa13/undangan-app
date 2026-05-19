<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;

class InvitationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->user_id || $user->isSuperAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isCustomer() || $user->isSuperAdmin();
    }

    public function update(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->user_id || $user->isSuperAdmin();
    }

    public function delete(User $user, Invitation $invitation): bool
    {
        return $user->id === $invitation->user_id || $user->isSuperAdmin();
    }
}
