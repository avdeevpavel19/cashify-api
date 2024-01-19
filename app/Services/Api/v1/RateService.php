<?php

namespace App\Services\Api\v1;

use App\Exceptions\ExchangeRateDataNotReceivedException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Uri;

class RateService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * @throws ExchangeRateDataNotReceivedException|GuzzleException
     */
    public function get($baseCurrency = "RUB"): array
    {
        $access_key = config('services.currency_api.key');

        $uri = new Uri('http://apilayer.net/api/live');
        $uri = Uri::withQueryValue($uri, 'access_key', $access_key);
        $uri = Uri::withQueryValue($uri, 'currencies', 'USD,EUR');
        $uri = Uri::withQueryValue($uri, 'source', $baseCurrency);
        $uri = Uri::withQueryValue($uri, 'format', 1);

        $response = $this->client->get((string)$uri);
        $contents = $response->getBody()->getContents();
        $decodedData = json_decode($contents, true);

        if (empty($decodedData['quotes'])) {
            throw new ExchangeRateDataNotReceivedException('Данные о курсах валют не получены');
        }

        $quotes = $decodedData['quotes'];

        $rubToUSD = 1 / $quotes['RUBUSD'];
        $rubToEUR = 1 / $quotes['RUBEUR'];

        $exchangeRates = [
            'USD' => $rubToUSD,
            'EUR' => $rubToEUR,
        ];

        foreach ($exchangeRates as &$rate) {
            $rate = round($rate, 1);
        }

        return $exchangeRates;
    }
}
