<?php

namespace App\Http\Controllers\Api\v1\FinancialReport;

use App\Exceptions\InternalServerException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\FinancialReport\GenerateRequest;
use App\Models\User;
use App\Services\Api\v1\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    protected ReportService $service;
    protected User          $user;

    public function __construct(ReportService $service)
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
    public function generate(GenerateRequest $request): JsonResponse
    {
        try {
            $startDate = $request->validated()["start_date"];
            $endDate   = $request->validated()["end_date"];

            $report = $this->service->generate($startDate, $endDate, $this->user);

            return response()->json(['report' => $report]);
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
