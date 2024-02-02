<?php

namespace App\Services\Api\v1\Auth;

use App\Exceptions\InvalidResetTokenException;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordService
{
    public function sendLinkToEmail(array $data): bool
    {
        $email = $data['email'];

        $token = Str::random(64);

        $existingToken = \DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if ($existingToken) {
            \DB::table('password_reset_tokens')
                ->where('email', $email)
                ->update(['token' => $token]);
        } else {
            \DB::table('password_reset_tokens')
                ->where('email', $email)
                ->insert([
                    'email'      => $email,
                    'token'      => $token,
                    'created_at' => now()
                ]);
        }

        $resetLink = url('api/password/' . $token);
        Mail::to($email)->send(new ResetPasswordMail($resetLink));

        return true;
    }

    /**
     * @throws InvalidResetTokenException
     */
    public function reset(string $token, string $password): bool
    {
        $resetTokenRecord = \DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$resetTokenRecord) {
            throw new InvalidResetTokenException('Неверный токен для сброса');
        }

        User::where('email', $resetTokenRecord->email)
            ->update(['password' => \Hash::make($password)]);

        \DB::table('password_reset_tokens')
            ->where('email', $resetTokenRecord->email)
            ->delete();

        return true;
    }
}
