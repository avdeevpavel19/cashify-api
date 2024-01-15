<?php

namespace App\Http\Controllers\Api\v1\Transaction;

use App\Exceptions\BaseException;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\InternalServerException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Transaction\StoreRequest;
use App\Http\Requests\Api\v1\Transaction\UpdateRequest;
use App\Http\Resources\Api\v1\TransactionCollection;
use App\Http\Resources\Api\v1\TransactionResource;
use App\Models\User;
use App\Services\Api\v1\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    protected TransactionService $service;
    protected User $user;

    public function __construct()
    {
        $this->service = new TransactionService;
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * @throws BaseException
     * @throws EntityNotFoundException
     */
    public function store(StoreRequest $request): TransactionResource
    {
        try {
            $validatedData = $request->validated();
            $translation = $this->service->store($validatedData, $this->user);

            return new TransactionResource($translation);
        } catch (EntityNotFoundException $e) {
            throw new EntityNotFoundException($e->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws BaseException
     */
    public function index(Request $request): TransactionCollection
    {
        try {
            $transactions = $this->service->index($this->user, $request);

            return new TransactionCollection($transactions);
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws EntityNotFoundException|BaseException
     */
    public function show(int $transactionID): TransactionResource
    {
        try {
            $transaction = $this->service->show($this->user, $transactionID);

            return new TransactionResource($transaction);
        } catch (EntityNotFoundException $notFoundException) {
            throw new EntityNotFoundException($notFoundException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws BaseException|EntityNotFoundException
     */
    public function update(UpdateRequest $request, int $transactionID): TransactionResource
    {
        try {
            $validatedData = $request->validated();
            $transaction = $this->service->update($validatedData, $this->user, $transactionID);

            return new TransactionResource($transaction);
        } catch (EntityNotFoundException $notFoundException) {
            throw new EntityNotFoundException($notFoundException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }

    /**
     * @throws InternalServerException|EntityNotFoundException|BaseException
     */
    public function destroy(int $transactionID): JsonResponse
    {
        try {
            $deletedTransaction = $this->service->destroy($this->user, $transactionID);

            if (!$deletedTransaction) {
                throw new InternalServerException('Во время удаления произошла ошибка. Повторите попытку позже');
            }

            return response()->json(['message' => 'Транзакция успешно удалена']);
        } catch (EntityNotFoundException $notFoundException) {
            throw new EntityNotFoundException($notFoundException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
