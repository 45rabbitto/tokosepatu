<?php

namespace App\Policies;

use App\Models\Umkm;
use App\Models\User;

class UmkmPolicy
{
    /**
     * Determine whether the user can view any UMKMs
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the UMKM
     */
    public function view(User $user, Umkm $umkm): bool
    {
        return $user->isAdmin() || $umkm->user_id === $user->id;
    }

    /**
     * Determine whether the user can create UMKMs
     */
    public function create(User $user): bool
    {
        // Admin can create, UMKM owner can only create if they don't have one
        return $user->isAdmin() || ($user->isUmkmOwner() && !$user->umkm);
    }

    /**
     * Determine whether the user can update the UMKM
     */
    public function update(User $user, Umkm $umkm): bool
    {
        return $user->isAdmin() || $umkm->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the UMKM
     */
    public function delete(User $user, Umkm $umkm): bool
    {
        return $user->isAdmin() || $umkm->user_id === $user->id;
    }
}
