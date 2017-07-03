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
        $buy_rates_list = $exchangeRateRepository->findFromIso('XBT');

        $buy_rate = $buy_rates_list->mapWithKeys(function(ExchangeRate $rate) use($fetcher) {
            $content = $fetcher->get($rate->getTrackerUrl());

            $parser   = '\BtcArbitrager\Parsers\\' . $rate->getParser();
            $parser   = new $parser($content, 200);
            $costRate = $parser->value();

            return [$rate->getId() => $costRate];
        });

        $sell_rates_list = $exchangeRateRepository->findToIso('XBT');

        $sell_rate = $sell_rates_list->mapWithKeys(function(ExchangeRate $rate) use($fetcher) {
            $content = $fetcher->get($rate->getTrackerUrl());

            $parser   = '\BtcArbitrager\Parsers\\' . $rate->getParser();
            $parser   = new $parser($content, 8);
            $costRate = $parser->value();

            return [$rate->getId() => $costRate];
        });
    }
}
