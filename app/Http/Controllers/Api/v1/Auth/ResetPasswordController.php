<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\BaseException;
use App\Exceptions\InvalidResetTokenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\ResetPassword\ResetRequest;
use App\Http\Requests\Api\v1\Auth\ResetPassword\SendLinkRequest;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /**
     * @throws BaseException
     */
    public function sendLinkToEmail(SendLinkRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $email = $validatedData['email'];

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
                        'email' => $email,
                        'token' => $token,
                        'created_at' => now()
                    ]);
            }

            $resetLink = url('api/password/' . $token);
            Mail::to($email)->send(new ResetPasswordMail($resetLink));

            return response()->json(['message' => 'Ссылка для сброса пароля отправлена']);
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws BaseException
     */
    public function reset(ResetRequest $request)
    {
        try {
            $tokenFromURL = \Request::segment(3);

            $resetTokenRecord = \DB::table('password_reset_tokens')
                ->where('token', $tokenFromURL)
                ->first();

            if (!$resetTokenRecord) {
                throw new InvalidResetTokenException('Неверный токен для сброса');
            }

            User::where('email', $resetTokenRecord->email)
                ->update(['password' => \Hash::make($request->password)]);

            \DB::table('password_reset_tokens')
                ->where('email', $resetTokenRecord->email)
                ->delete();

            return response()->json(['message' => 'Пароль успешно сброшен']);
        } catch (InvalidResetTokenException $resetTokenException) {
            throw new InvalidResetTokenException($resetTokenException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
