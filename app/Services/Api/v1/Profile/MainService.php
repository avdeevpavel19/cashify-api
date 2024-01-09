<?php

namespace App\Services\Api\v1\Profile;

use App\Models\Profile;

class MainService
{
    public function store(array $data, int $userID): Profile
    {
        $profile = Profile::where('user_id', $userID)->firstOrFail();

        $profile->update($data);

        return $profile;
    }
}
