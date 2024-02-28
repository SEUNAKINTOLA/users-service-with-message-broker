<?php

namespace App\Domain\Repositories;
use App\Jobs\ProcessUserCreation;

use App\Domain\Models\User;
use Exception;

class UserRepository
{
    public function save(User $user): User
    {
        $user->save();

        try{
            ProcessUserCreation::dispatch($user);
        }catch(Exception $e){

        }
        return $user;
    }
}
