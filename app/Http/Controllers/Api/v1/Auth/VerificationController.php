<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\BaseException;
use App\Exceptions\EmailAlreadyVerifiedException;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
    /**
     * @throws BaseException
     * @throws EmailAlreadyVerifiedException
     */
    public function resend(): JsonResponse
    {
        try {
            $user = \Auth::user();

            if ($user->hasVerifiedEmail()) {
                throw new EmailAlreadyVerifiedException('Почта уже верифицирована');
            }

            $user->sendEmailVerificationNotification();

            return response()->json(['message' => 'Вам на почту отправлено письмо для верификации аккаунта']);
        } catch (EmailAlreadyVerifiedException $verifiedException) {
            throw new EmailAlreadyVerifiedException($verifiedException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws BaseException
     * @throws EmailAlreadyVerifiedException
     */
    public function verify()
    {
        try {
            $user = \Auth::user();

            if ($user->hasVerifiedEmail()) {
                throw new EmailAlreadyVerifiedException('Почта уже верифицирована');
            }

            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }

            return response()->json(['message' => 'Аккаунт успешно верифицирован']);
        } catch (EmailAlreadyVerifiedException $verifiedException) {
            throw new EmailAlreadyVerifiedException($verifiedException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
