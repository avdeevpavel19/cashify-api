<?php

namespace App\Services\Api\v1\Auth;

use App\Models\Profile;
use App\Models\User;

class RegisterService
{
    public function store(array $data): User
    {
        $user = User::create($data);

        Profile::create([
            'user_id' => $user->id
        ]);

        return $user;
    }
}
