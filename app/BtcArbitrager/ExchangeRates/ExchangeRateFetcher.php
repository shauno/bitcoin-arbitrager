<?php

namespace BtcArbitrager\ExchangeRates;

use GuzzleHttp\Client;

class ExchangeRateFetcher
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * ExchangeRateFetcher constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the simple response string from a GET request to URL. Only allows 200 returns
     * @param string $url
     * @return null|string
     * @throws \Exception
     */
    public function get(string $url) :? string
    {
        $response = $this->client->get($url);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Invalid response code returned for '.$url.': '.$response->getStatusCode());
        }

        return $response->getBody()->getContents();
    }
}