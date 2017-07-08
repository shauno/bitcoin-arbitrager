<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use App\Mail\ArbitrageNotification;
use BtcArbitrager\ExchangeRates\ExchangeRateFetcher;
use BtcArbitrager\ExchangeRates\ExchangeRateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ActionController extends Controller
{
    public function arbitrage(ExchangeRateFetcher $fetcher, ExchangeRateRepository $exchangeRateRepository)
    {
        //TODO, DRY this up, move it out of controller
        $buy_rates = $exchangeRateRepository->findFromIso('XBT')->map(function(ExchangeRate $exchangeRate) use($fetcher, $exchangeRateRepository) {
            $content = $fetcher->get($exchangeRate->getTrackerUrl());

            $parser   = '\BtcArbitrager\Parsers\\' . $exchangeRate->getParser();
            $parser   = new $parser($content, 200);
            $rate = $parser->value();

            $exchangeRateRepository->addCurrentRate($exchangeRate, $rate);
            $exchangeRate->sort_rate = $rate;

            return $exchangeRate;
        });

        $sell_rates = $exchangeRateRepository->findToIso('XBT')->map(function(ExchangeRate $exchangeRate) use($fetcher, $exchangeRateRepository) {
            $content = $fetcher->get($exchangeRate->getTrackerUrl());

            $parser   = '\BtcArbitrager\Parsers\\' . $exchangeRate->getParser();
            $parser   = new $parser($content, 0.05); //todo, calc the amount to actually buy
            $rate = $parser->value();

            $exchangeRateRepository->addCurrentRate($exchangeRate, $rate);
            $exchangeRate->sort_rate = $rate;

            return $exchangeRate;
        });

        //calculate the % difference between cheap (offshore) and expensive (local)
        $diff = $sell_rates->max('sort_rate') - $buy_rates->min('sort_rate');

        //return the % difference between the rates
        $arbitrage = $diff / $sell_rates->max('sort_rate');

        if ($arbitrage >= 0.004) {
            Mail::to(env('MAIL_NOTIFICATION'))->send(new ArbitrageNotification($buy_rates, $sell_rates));
        }
    }
}
