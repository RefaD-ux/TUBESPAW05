<?php
// app/Policies/KosPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Kos;
use Illuminate\Auth\Access\Response;

class KosPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'pemilik';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Kos $kos): bool
    {
        return true; // Semua orang bisa melihat kos
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Kos $kos): bool
    {
        return $user->role === 'pemilik' && $user->id === $kos->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Kos $kos): bool
    {
        return $user->role === 'pemilik' && $user->id === $kos->user_id;
    }
}