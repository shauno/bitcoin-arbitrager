<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use BtcArbitrager\ExchangeRates\ExchangeRateFetcher;
use BtcArbitrager\ExchangeRates\ExchangeRateRepository;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function arbitrage(ExchangeRateFetcher $fetcher, ExchangeRateRepository $exchangeRateRepository)
    {
        $buy_rates = $exchangeRateRepository->findFromIso('XBT');

        $rates = $buy_rates->mapWithKeys(function(ExchangeRate $rate) use($fetcher) {
            $content = $fetcher->get($rate->getTrackerUrl());

            $parser   = '\BtcArbitrager\Parsers\\' . $rate->getParser();
            $parser   = new $parser($content, 200);
            $costRate = $parser->value();

            return [$rate->getId() => $costRate];
        });

        dd($rates);
    }
}
