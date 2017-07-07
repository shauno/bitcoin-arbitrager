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

        $buy_rate = $buy_rates_list->mapWithKeys(function(ExchangeRate $exchangeRate) use($fetcher, $exchangeRateRepository) {
            $content = $fetcher->get($exchangeRate->getTrackerUrl());

            $parser   = '\BtcArbitrager\Parsers\\' . $exchangeRate->getParser();
            $parser   = new $parser($content, 200);
            $rate = $parser->value();

            $exchangeRateRepository->addCurrentRate($exchangeRate, $rate);

            return [$exchangeRate->getId() => $rate];
        });

        $sell_rates_list = $exchangeRateRepository->findToIso('XBT');

        $sell_rate = $sell_rates_list->mapWithKeys(function(ExchangeRate $exchangeRate) use($fetcher, $exchangeRateRepository) {
            $content = $fetcher->get($exchangeRate->getTrackerUrl());

            $parser   = '\BtcArbitrager\Parsers\\' . $exchangeRate->getParser();
            $parser   = new $parser($content, 0.05); //todo, calc the amount to actually buy
            $rate = $parser->value();

            $exchangeRateRepository->addCurrentRate($exchangeRate, $rate);

            return [$exchangeRate->getId() => $rate];
        });
        
        //calculate the % difference between cheap (offshore) and expensive (local)
        $diff = $sell_rate->max() - $buy_rate->min();

        //return the % difference between the rates
        $arbitrage = $diff / $sell_rate->max();

        dd($arbitrage);
    }
}
