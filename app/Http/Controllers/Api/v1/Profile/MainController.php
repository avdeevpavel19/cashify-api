<?php

namespace App\Http\Controllers\Api\v1\Profile;

use App\Exceptions\AvatarAlreadyUploadedException;
use App\Exceptions\UploadException;
use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Profile\StoreRequest;
use App\Http\Requests\Api\v1\Profile\UploadAvatarRequest;
use App\Http\Resources\Api\v1\ProfileResource;
use App\Services\Api\v1\Profile\MainService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    protected MainService $service;
    protected int $userID;

    public function __construct()
    {
        $this->service = new MainService;
        $this->middleware(function ($request, $next) {
            $this->userID = Auth::id();
            return $next($request);
        });
    }

    /**
     * @throws BaseException
     */
    public function store(StoreRequest $request): ProfileResource
    {
        try {
            $validatedData = $request->validated();
            $profile = $this->service->store($validatedData, $this->userID);

            return new ProfileResource($profile);
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }


    /**
     * @throws UploadException
     * @throws BaseException
     * @throws AvatarAlreadyUploadedException
     */
    public function uploadAvatar(UploadAvatarRequest $request): JsonResponse
    {
        try {
            $avatar = $request->file('avatar');
            $user = Auth::user();
            $uploaded = $this->service->upload($avatar, $user);

            if (!$uploaded) {
                throw new UploadException('Во время загрузки аватара произошла ошибка. Повторите попытку позже');
            }

            return response()->json(['message' => 'Аватар успешно загружен']);
        } catch (AvatarAlreadyUploadedException $alreadyUploadedException) {
            throw new AvatarAlreadyUploadedException($alreadyUploadedException->getMessage());
        } catch (UploadException $avatarUploadException) {
            throw new UploadException($avatarUploadException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
