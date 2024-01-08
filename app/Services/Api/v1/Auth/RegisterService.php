<?php

namespace App\Services\Api\v1\Auth;

use App\Models\User;

class RegisterService
{
    public function store(array $data): User
    {
        return User::create($data);
    }
}
