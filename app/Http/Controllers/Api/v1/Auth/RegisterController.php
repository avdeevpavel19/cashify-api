<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\CreateUserRequest;
use App\Services\Api\v1\Auth\RegisterService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    protected RegisterService $service;

    public function __construct()
    {
        $this->service = new RegisterService;
    }

    /**
     * @throws BaseException
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        try {
            $validationData = $request->validated();
            $user = $this->service->store($validationData);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'type' => 'Bearer'
            ]);
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
