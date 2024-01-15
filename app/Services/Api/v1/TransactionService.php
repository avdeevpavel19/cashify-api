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
    public function show(User $user, int $transactionID): Transaction
    {
        return $this->findUserTransactionById($user, $transactionID);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function update(array $data, User $user, int $transactionID): Transaction
    {
        $transaction = $this->findUserTransactionById($user, $transactionID);

        $transaction->update($data);

        return $transaction;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function destroy(User $user, int $transactionID): bool
    {
        $transaction = $this->findUserTransactionById($user, $transactionID);

        $transaction->delete();

        return true;
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

    /**
     * @throws EntityNotFoundException
     */
    private function findUserTransactionById(User $user, int $transactionID): Transaction
    {
        $transaction = $user->transactions()->where('id', $transactionID)->first();

        if (!$transaction) {
            throw new EntityNotFoundException('Транзация не найдена');
        }

        return $transaction;
    }
}
