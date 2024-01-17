<?php

namespace App\Services\Api\v1;

use App\Models\Goal;
use App\Models\User;

class GoalService
{
    public function store(array $data, int $userID): Goal
    {
        return Goal::create([
            'title' => $data['title'],
            'amount' => $data['amount'],
            'deadline' => $data['deadline'],
            'user_id' => $userID
        ]);
    }

    public function index(User $user)
    {
        return $user->goals()->paginate(25);
    }
}
