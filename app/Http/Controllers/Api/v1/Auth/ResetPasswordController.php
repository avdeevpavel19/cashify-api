<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\BaseException;
use App\Exceptions\InvalidResetTokenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\ResetPassword\ResetRequest;
use App\Http\Requests\Api\v1\Auth\ResetPassword\SendLinkRequest;
use App\Services\Api\v1\Auth\ResetPasswordService;
use App\Models\User;

class ResetPasswordController extends Controller
{
    protected ResetPasswordService $service;

    public function __construct()
    {
        $this->service = new  ResetPasswordService;
    }

    /**
     * @throws BaseException
     */
    public function sendLinkToEmail(SendLinkRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $resetLink = $this->service->sendLinkToEmail($validatedData);

            if ($resetLink) {
                return response()->json(['message' => 'Ссылка для сброса пароля отправлена']);
            }
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
            $newPassword = $request->validated()['password'];

            $reset = $this->service->reset($tokenFromURL, $newPassword);

            if ($reset) {
                return response()->json(['message' => 'Пароль успешно сброшен']);
            }
        } catch (InvalidResetTokenException $resetTokenException) {
            throw new InvalidResetTokenException($resetTokenException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
