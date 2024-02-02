<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\InternalServerException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\CreateUserRequest;
use App\Services\Api\v1\Auth\RegisterService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    protected RegisterService $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws InternalServerException
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $user          = $this->service->store($validatedData);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'type'         => 'Bearer'
            ]);
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
