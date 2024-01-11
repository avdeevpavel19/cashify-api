<?php

namespace App\Services\Api\v1;

use App\Exceptions\CannotEditDefaultCategoryException;
use App\Exceptions\EntityAlreadyExistsException;
use App\Exceptions\EntityNotFoundException;
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

    /**
     * @throws EntityNotFoundException
     */
    public function show(int $categoryID, User $user): Category
    {
        $category = $this->checkCategoryOwner($categoryID, $user);

        return $category;
    }

    /**
     * @throws EntityNotFoundException|CannotEditDefaultCategoryException
     */
    public function update(array $data, int $categoryID, User $user): Category
    {
        $category = $this->checkCategoryOwner($categoryID, $user);

        $category->update([
            'belongs_to' => $data['belongs_to'],
            'name' => $data['name']
        ]);

        return $category;
    }

    /**
     * @throws CannotEditDefaultCategoryException|EntityNotFoundException
     */
    public function destroy(int $categoryID, User $user): bool
    {
        $this->checkCategoryOwner($categoryID, $user);

        $category = $user->categories()->where('id', $categoryID)->first();
        $category->delete();

        return true;
    }

    /**
     * @throws CannotEditDefaultCategoryException|EntityNotFoundException
     */
    private function checkCategoryOwner(int $categoryID, User $user): Category
    {
        $category = Category::where('id', $categoryID)
            ->whereNull('user_id')
            ->first();

        if ($category) {
            throw new CannotEditDefaultCategoryException('Категории по умолчанию можно только получать');
        }

        $category = $user->categories()->where('id', $categoryID)->first();

        if (!$category) {
            throw new EntityNotFoundException('Категория не найдена');
        }

        return $category;
    }
}
