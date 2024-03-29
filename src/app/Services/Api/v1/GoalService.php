<?php

namespace App\Services\Api\v1;

use App\Exceptions\EntityNotFoundException;
use App\Models\Goal;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GoalService
{
    public function store(array $data, int $userID): Goal
    {
        return Goal::create([
            'title'    => $data['title'],
            'amount'   => $data['amount'],
            'deadline' => $data['deadline'],
            'user_id'  => $userID
        ]);
    }

    public function index(User $user): LengthAwarePaginator
    {
        return $user->goals()->paginate(25);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function show(User $user, int $goalID): Goal
    {
        $goal = $this->checkGoalOwner($goalID, $user);

        return $goal;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function update(array $data, int $goalID, User $user): Goal
    {
        $goal = $this->checkGoalOwner($goalID, $user);

        $goal->update($data);

        return $goal;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function destroy(User $user, int $goalID): bool
    {
        $goal = $this->checkGoalOwner($goalID, $user);

        $goal->delete();

        return true;
    }

    /**
     * @throws EntityNotFoundException
     */
    private function checkGoalOwner(int $goalID, User $user): Goal
    {
        $goal = $user->goals()->where('id', $goalID)->first();

        if (!$goal) {
            throw new EntityNotFoundException('Указанная цель не найдена');
        }

        return $goal;
    }
}
