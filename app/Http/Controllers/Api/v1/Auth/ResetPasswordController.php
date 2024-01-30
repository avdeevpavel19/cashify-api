<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\InternalServerException;
use App\Exceptions\InvalidResetTokenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\ResetPassword\ResetRequest;
use App\Http\Requests\Api\v1\Auth\ResetPassword\SendLinkRequest;
use App\Services\Api\v1\Auth\ResetPasswordService;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
    protected ResetPasswordService $service;

    public function __construct(ResetPasswordService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws InternalServerException
     */
    public function sendLinkToEmail(SendLinkRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $resetLink     = $this->service->sendLinkToEmail($validatedData);

            if ($resetLink) {
                return response()->json(['message' => 'Ссылка для сброса пароля отправлена']);
            }
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws InternalServerException|InvalidResetTokenException
     */
    public function reset(ResetRequest $request): JsonResponse
    {
        try {
            $tokenFromURL = \Request::segment(3);
            $newPassword  = $request->validated()['password'];

            $reset = $this->service->reset($tokenFromURL, $newPassword);

            if ($reset) {
                return response()->json(['message' => 'Пароль успешно сброшен']);
            }
        } catch (InvalidResetTokenException $resetTokenException) {
            throw new InvalidResetTokenException($resetTokenException->getMessage());
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
