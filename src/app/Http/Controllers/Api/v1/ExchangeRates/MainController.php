<?php

namespace App\Http\Controllers\Api\v1\ExchangeRates;

use App\Exceptions\InternalServerException;
use App\Exceptions\ExchangeRateDataNotReceivedException;
use App\Exceptions\InvalidRateApiTokenException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\RateResource;
use App\Services\Api\v1\RateService;
use GuzzleHttp\Exception\GuzzleException;

class MainController extends Controller
{
    protected RateService $service;

    public function __construct(RateService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws GuzzleException
     * @throws InvalidRateApiTokenException|ExchangeRateDataNotReceivedException|InternalServerException
     */
    public function get(): RateResource
    {
        try {
            $rates = $this->service->get();

            return new RateResource($rates);
        } catch (InvalidRateApiTokenException $apiRateTokenException) {
            throw new InvalidRateApiTokenException($apiRateTokenException->getMessage());
        } catch (ExchangeRateDataNotReceivedException $dataNotReceivedException) {
            throw new ExchangeRateDataNotReceivedException($dataNotReceivedException->getMessage());
        } catch (InternalServerException) {
            throw new InternalServerException('На сервере что-то случилось.Повторите попытку позже');
        }
    }
}
