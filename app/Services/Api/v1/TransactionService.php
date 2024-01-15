<?php

namespace App\Services\Api\v1;

use App\Exceptions\EntityNotFoundException;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionService
{
    /**
     * @throws EntityNotFoundException
     */
    public function store(array $data, User $user): Transaction
    {
        $this->validateCategoryExists($user, $data['category_id']);

        return Transaction::create([
            "user_id" => $user->id,
            "amount" => $data["amount"],
            "category_id" => $data["category_id"],
            "date" => $data["date"],
            "description" => $data["description"]
        ]);
    }

    public function index(User $user): LengthAwarePaginator
    {
        return $user->transactions()->paginate(25);
    }

    /**
     * @throws EntityNotFoundException
     */
    private function validateCategoryExists(User $user, string $categoryID): void
    {
        $userCategories = $user->categories()->where('id', $categoryID)->exists();
        $defaultCategories = Category::whereNull('user_id')
            ->where('id', $categoryID)
            ->exists();

        if (!$userCategories && !$defaultCategories) {
            throw new EntityNotFoundException('Указанная категория не найдена');
        }
    }
}
