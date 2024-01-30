<?php

namespace App\Services\Api\v1;

use App\Exceptions\EntityNotFoundException;
use App\Filters\TransactionFilter;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class TransactionService
{
    /**
     * @throws EntityNotFoundException
     */
    public function store(array $data, User $user): Transaction
    {
        $this->validateCategoryExists($user, $data['category_id']);

        $data['user_id'] = $user->id;

        return Transaction::create($data);
    }

    public function index(User $user, Request $request): LengthAwarePaginator
    {
        $transactions = $user->transactions();
        $filter       = new TransactionFilter($transactions);
        $filter->apply($request);

        return $transactions->paginate(25);
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

    public function analyzeByCategories(User $user): Collection
    {
        $analysis = $user->transactions()
            ->with('category')
            ->get()
            ->groupBy('category.id')
            ->map(function ($transactions) {
                $category     = $transactions->first()->category;
                $totalIncome  = $transactions->where('category.belongs_to', 'income')->sum('amount');
                $totalExpense = $transactions->where('category.belongs_to', 'expense')->sum('amount');

                return [
                    'category_name' => $category->name,
                    'total_income'  => $totalIncome,
                    'total_expense' => $totalExpense
                ];
            })->sortBy('category.id')->values();

        return $analysis;
    }

    /**
     * @throws EntityNotFoundException
     */
    private function validateCategoryExists(User $user, string $categoryID): void
    {
        $userCategories    = $user->categories()->where('id', $categoryID)->exists();
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
