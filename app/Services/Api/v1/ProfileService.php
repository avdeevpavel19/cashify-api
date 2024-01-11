<?php

namespace App\Services\Api\v1;

use App\Exceptions\AvatarAlreadyUploadedException;
use App\Exceptions\NewPasswordSameAsCurrentException;
use App\Exceptions\PasswordMismatchException;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public function store(array $data, int $userID): Profile
    {
        $profile = Profile::where('user_id', $userID)->firstOrFail();

        $profile->update($data);

        return $profile;
    }

    /**
     * @throws AvatarAlreadyUploadedException
     */
    public function upload(object $avatar, User $user): bool
    {
        $avatarName = $avatar->getClientOriginalName();
        $avatarPath = $avatar->storeAs('avatars', $avatarName, 'public');
        $checkAvatarExists = $user->profile()->where('avatar', $avatarPath)->exists();

        if ($checkAvatarExists) {
            throw new AvatarAlreadyUploadedException('Данный аватар уже загружен');
        }

        $user->profile->update(['avatar' => $avatarPath]);

        return true;
    }

    /**
     * @throws PasswordMismatchException|NewPasswordSameAsCurrentException
     */
    public function changePassword(array $data, User $user): bool
    {
        $currentPassword = $data['current_password'];
        $newPassword = $data['new_password'];

        if (!Hash::check($currentPassword, $user->password)) {
            throw new PasswordMismatchException('Введенный пароль не совпадает с текущим');
        }

        if ($currentPassword === $newPassword) {
            throw new NewPasswordSameAsCurrentException('Новый пароль не может быть равен текущему');
        }

        $user->update(['password' => \Hash::make($newPassword)]);

        return true;
    }
}
