<?php

namespace App\Http\Controllers\Api\v1\Goal;

use App\Exceptions\InternalServerException;
use App\Exceptions\EntityNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Goal\StoreRequest;
use App\Http\Requests\Api\v1\Goal\UpdateRequest;
use App\Http\Resources\Api\v1\GoalCollection;
use App\Http\Resources\Api\v1\GoalResource;
use App\Models\User;
use App\Services\Api\v1\GoalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    protected GoalService $service;
    protected User        $user;

    public function __construct(GoalService $service)
    {
        $this->service = $service;

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * @throws InternalServerException
     */
    public function store(StoreRequest $request): GoalResource
    {
        try {
            $validatedData = $request->validated();
            $goal          = $this->service->store($validatedData, $this->user->id);

            return new GoalResource($goal);
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws InternalServerException
     */
    public function index(): GoalCollection
    {
        try {
            $goals = $this->service->index($this->user);

            return new GoalCollection($goals);
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws InternalServerException
     */
    public function show(int $goalID): GoalResource
    {
        try {
            $goal = $this->service->show($this->user, $goalID);

            return new GoalResource($goal);
        } catch (EntityNotFoundException $notFoundException) {
            throw new EntityNotFoundException($notFoundException->getMessage());
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws InternalServerException|EntityNotFoundException
     */
    public function update(UpdateRequest $request, int $goalID): GoalResource
    {
        try {
            $validatedData = $request->validated();
            $goal          = $this->service->update($validatedData, $goalID, $this->user);

            return new GoalResource($goal);
        } catch (EntityNotFoundException $notFoundException) {
            throw new EntityNotFoundException($notFoundException->getMessage());
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws InternalServerException|EntityNotFoundException
     */
    public function destroy(int $goalID): JsonResponse
    {
        try {
            $this->service->destroy($this->user, $goalID);

            return response()->json(['message' => 'Цель успешно удалена']);
        } catch (EntityNotFoundException $notFoundException) {
            throw new EntityNotFoundException($notFoundException->getMessage());
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
