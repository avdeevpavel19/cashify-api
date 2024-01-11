<?php

namespace App\Services\Api\v1\Profile;

use App\Exceptions\AvatarAlreadyUploadedException;
use App\Models\Profile;
use App\Models\User;

class MainService
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
}
