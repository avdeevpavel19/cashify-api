<?php

namespace App\Http\Controllers\Api\v1\Category;

use App\Exceptions\BaseException;
use App\Exceptions\EntityAlreadyExistsException;
use App\Exceptions\EntityNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Category\StoreRequest;
use App\Http\Resources\Api\v1\CategoryCollection;
use App\Http\Resources\Api\v1\CategoryResource;
use App\Models\Category;
use App\Models\User;
use App\Services\Api\v1\CategoryService;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    protected CategoryService $service;
    protected User $user;

    public function __construct()
    {
        $this->service = new CategoryService;
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * @throws BaseException
     */
    public function store(StoreRequest $request): CategoryResource
    {
        try {
            $validatedData = $request->validated();
            $category = $this->service->store($validatedData, $this->user);

            return new CategoryResource($category);
        } catch (EntityAlreadyExistsException $alreadyExistsException) {
            throw new EntityAlreadyExistsException($alreadyExistsException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws BaseException
     */
    public function index(): CategoryCollection
    {
        try {
            $categories = $this->service->index($this->user);

            return new CategoryCollection($categories);
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws BaseException|EntityNotFoundException
     */
    public function show(int $categoryID)
    {
        try {
            $category = $this->service->show($categoryID, $this->user);

            return new CategoryResource($category);
        } catch (EntityNotFoundException $notFoundException) {
            throw new EntityNotFoundException($notFoundException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
