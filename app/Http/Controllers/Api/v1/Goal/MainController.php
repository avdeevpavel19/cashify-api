<?php

namespace App\Http\Controllers\Api\v1\Goal;

use App\Exceptions\BaseException;
use App\Exceptions\EntityNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Goal\StoreRequest;
use App\Http\Requests\Api\v1\Goal\UpdateRequest;
use App\Http\Resources\Api\v1\GoalCollection;
use App\Http\Resources\Api\v1\GoalResource;
use App\Models\User;
use App\Services\Api\v1\GoalService;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    protected GoalService $service;
    protected User $user;

    public function __construct()
    {
        $this->service = new GoalService;
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * @throws BaseException
     */
    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $goal = $this->service->store($validatedData, $this->user->id);
            return new GoalResource($goal);
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws BaseException
     */
    public function index()
    {
        try {
            $goals = $this->service->index($this->user);

            return new GoalCollection($goals);
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws BaseException
     */
    public function show(int $goalID)
    {
        try {
            $goal = $this->service->show($this->user, $goalID);
            return new GoalResource($goal);
        } catch (EntityNotFoundException $notFoundException) {
            throw new EntityNotFoundException($notFoundException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws BaseException|EntityNotFoundException
     */
    public function update(UpdateRequest $request, int $goalID)
    {
        try {
            $validatedData = $request->validated();
            $goal = $this->service->update($validatedData, $goalID, $this->user);
            return new GoalResource($goal);
        } catch (EntityNotFoundException $notFoundException) {
            throw new EntityNotFoundException($notFoundException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws BaseException|EntityNotFoundException
     */
    public function destroy(int $goalID)
    {
        try {
            $this->service->destroy($this->user, $goalID);

            return response()->json(['message' => 'Цель успешно удалена']);
        } catch (EntityNotFoundException $notFoundException) {
            throw new EntityNotFoundException($notFoundException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
