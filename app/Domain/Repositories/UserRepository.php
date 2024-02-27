<?php

namespace App\Domain\Repositories;
use App\Jobs\ProcessUserCreation;

use App\Domain\Models\User;

class UserRepository
{
    public function save(User $user): User
    {
        $user->save();
        ProcessUserCreation::dispatch($user);
        return $user;
    }
}
