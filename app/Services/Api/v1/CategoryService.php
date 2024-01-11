<?php

namespace App\Services\Api\v1;

use App\Exceptions\EntityAlreadyExistsException;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * @throws EntityAlreadyExistsException
     */
    public function store(array $data, User $user): Category
    {
        $categoryExists = $user->categories()->where('name', $data['name'])->exists();

        if ($categoryExists) {
            throw new EntityAlreadyExistsException('У вас уже есть категория с таким названием');
        }

        return Category::create([
            'belongs_to' => $data['belongs_to'],
            'name' => $data['name'],
            'user_id' => $user->id ?? NULL,
        ]);
    }

    public function index(User $user): Collection
    {
        $defaultCategories = Category::whereNull('user_id')->paginate(25, ['belongs_to', 'name']);
        $userCategories = $user->categories()->paginate(25);

        return $defaultCategories->concat($userCategories);
    }
}
