<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\InternalServerException;
use App\Exceptions\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\LoginUserRequest;
use App\Services\Api\v1\Auth\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected LoginService $service;

    public function __construct(LoginService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws InternalServerException|InvalidCredentialsException
     */
    public function store(LoginUserRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $accessToken = $this->service->store($validatedData);

            return response()->json([
                'access_token' => $accessToken,
                'type'         => 'Bearer'
            ]);
        } catch (InvalidCredentialsException $credentialsException) {
            throw new InvalidCredentialsException($credentialsException->getMessage());
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws InternalServerException
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Вы вышли из системы.']);
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
