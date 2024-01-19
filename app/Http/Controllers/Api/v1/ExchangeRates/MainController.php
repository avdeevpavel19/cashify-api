<?php

namespace App\Http\Controllers\Api\v1\ExchangeRates;

use App\Exceptions\BaseException;
use App\Exceptions\ExchangeRateDataNotReceivedException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\RateResource;
use App\Services\Api\v1\RateService;
use GuzzleHttp\Exception\GuzzleException;

class MainController extends Controller
{
    protected RateService $service;

    public function __construct()
    {
        $this->service = new RateService;
    }

    /**
     * @throws GuzzleException
     * @throws BaseException|ExchangeRateDataNotReceivedException
     */
    public function get(): RateResource
    {
        try {
            $rates = $this->service->get();

            return new RateResource($rates);
        } catch (ExchangeRateDataNotReceivedException $dataNotReceivedException) {
            throw new BaseException($dataNotReceivedException->getMessage());
        } catch (BaseException) {
            throw new BaseException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
