<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\BaseException;
use App\Exceptions\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\LoginUserRequest;
use App\Services\Api\v1\Auth\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    protected LoginService $service;

    public function __construct()
    {
        $this->service = new LoginService;
    }


    /**
     * @throws BaseException
     * @throws InvalidCredentialsException
     */
    public function store(LoginUserRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $accessToken = $this->service->store($validatedData);

            return response()->json([
                'access_token' => $accessToken,
                'type' => 'Bearer'
            ]);
        } catch (InvalidCredentialsException $credentialsException) {
            throw new InvalidCredentialsException($credentialsException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
