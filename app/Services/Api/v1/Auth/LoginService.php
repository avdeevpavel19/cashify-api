<?php

namespace App\Services\Api\v1\Auth;

use App\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * @throws InvalidCredentialsException
     */
    public function store(array $data): string
    {
        if (!\Auth::attempt($data)) {
            throw new InvalidCredentialsException('Неверные учетные данные');
        }

        $user = Auth::user();
        $token = $user->createToken('access_token')->plainTextToken;

        return $token;
    }
}
