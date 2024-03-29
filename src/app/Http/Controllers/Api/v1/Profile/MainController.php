<?php

namespace App\Http\Controllers\Api\v1\Profile;

use App\Exceptions\AvatarAlreadyUploadedException;
use App\Exceptions\InternalServerException;
use App\Exceptions\NewPasswordSameAsCurrentException;
use App\Exceptions\PasswordMismatchException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Profile\ChangeCurrencyRequest;
use App\Http\Requests\Api\v1\Profile\ChangePasswordRequest;
use App\Http\Requests\Api\v1\Profile\StoreRequest;
use App\Http\Requests\Api\v1\Profile\UploadAvatarRequest;
use App\Http\Resources\Api\v1\CurrencyResource;
use App\Http\Resources\Api\v1\ProfileResource;
use App\Models\User;
use App\Services\Api\v1\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    protected ProfileService $service;
    protected int            $userID;
    protected User           $user;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;

        $this->middleware(function ($request, $next) {
            $this->userID = Auth::id();
            $this->user   = Auth::user();

            return $next($request);
        });
    }

    /**
     * @throws InternalServerException
     */
    public function store(StoreRequest $request): ProfileResource
    {
        try {
            $validatedData = $request->validated();
            $profile       = $this->service->store($validatedData, $this->user);

            return new ProfileResource($profile);
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws InternalServerException|AvatarAlreadyUploadedException
     */
    public function uploadAvatar(UploadAvatarRequest $request): JsonResponse
    {
        try {
            $avatar   = $request->file('avatar');
            $uploaded = $this->service->upload($avatar, $this->user);

            if (!$uploaded) {
                throw new InternalServerException('Во время загрузки аватара произошла ошибка. Повторите попытку позже');
            }

            return response()->json(['message' => 'Аватар успешно загружен']);
        } catch (AvatarAlreadyUploadedException $alreadyUploadedException) {
            throw new AvatarAlreadyUploadedException($alreadyUploadedException->getMessage());
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws InternalServerException
     */
    public function index(): ProfileResource
    {
        try {
            $profileData = $this->user->profile()->first();

            return new ProfileResource($profileData);
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws InternalServerException|InternalServerException|NewPasswordSameAsCurrentException|PasswordMismatchException
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $changed       = $this->service->changePassword($validatedData, $this->user);

            if (!$changed) {
                throw new InternalServerException('Произошла ошибка. Повторите попытку позже');
            }

            return response()->json(['message' => 'Пароль успешно изменен']);
        } catch (PasswordMismatchException $mismatchException) {
            throw new PasswordMismatchException($mismatchException->getMessage());
        } catch (NewPasswordSameAsCurrentException $sameAsCurrentException) {
            throw new NewPasswordSameAsCurrentException($sameAsCurrentException->getMessage());
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws InternalServerException
     */
    public function changeCurrency(ChangeCurrencyRequest $request): CurrencyResource
    {
        try {
            $currency = $this->service->changeCurrency($this->user, $request->validated()['currency_id']);

            return new CurrencyResource($currency);
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
