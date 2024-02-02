<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\InternalServerException;
use App\Exceptions\EmailAlreadyVerifiedException;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
    /**
     * @throws InternalServerException|EmailAlreadyVerifiedException
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
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws InternalServerException|EmailAlreadyVerifiedException
     */
    public function verify(): JsonResponse
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
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
