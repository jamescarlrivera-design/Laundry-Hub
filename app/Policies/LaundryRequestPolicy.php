<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LaundryRequest;

class LaundryRequestPolicy
{
    public function view(User $user, LaundryRequest $laundryRequest): bool
    {
        return $user->role === 'staff'
            && $user->branches()
                ->where('branches.id', $laundryRequest->branch_id)
                ->exists();
    }

    public function updateStatus(User $user, LaundryRequest $laundryRequest): bool
    {
        return $user->role === 'staff'
            && $user->branches()
                ->where('branches.id', $laundryRequest->branch_id)
                ->exists();
    }
}
