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
        $zarToSpend = 200;
        //TODO, DRY this up, move it out of controller
        $buy_rates = $exchangeRateRepository->findFromIso('XBT')->map(function(ExchangeRate $exchangeRate) use($fetcher, $exchangeRateRepository, $zarToSpend) {
            $content = $fetcher->get($exchangeRate->getTrackerUrl());

            $parser   = '\BtcArbitrager\Parsers\\' . $exchangeRate->getParser();
            $parser   = new $parser($content, $zarToSpend);
            $rate = $parser->value();

            $exchangeRateRepository->addCurrentRate($exchangeRate, $rate);
            $exchangeRate->sort_rate = $rate;

            return $exchangeRate;
        });

        $btcToBuy = round($zarToSpend / $buy_rates->min('sort_rate'), 8);

        $sell_rates = $exchangeRateRepository->findToIso('XBT')->map(function(ExchangeRate $exchangeRate) use($fetcher, $exchangeRateRepository, $btcToBuy) {
            $content = $fetcher->get($exchangeRate->getTrackerUrl());

            $parser   = '\BtcArbitrager\Parsers\\' . $exchangeRate->getParser();
            $parser   = new $parser($content, $btcToBuy);
            $rate = $parser->value();

            $exchangeRateRepository->addCurrentRate($exchangeRate, $rate);
            $exchangeRate->sort_rate = $rate;

            return $exchangeRate;
        });

        //Arbitrage calc
        $diff = $sell_rates->max('sort_rate') - $buy_rates->min('sort_rate');
        $arbitrage = $diff / $sell_rates->max('sort_rate');

        if ($arbitrage >= 0.04) {
            Mail::to(env('MAIL_NOTIFICATION'))->send(new ArbitrageNotification($buy_rates, $sell_rates));
        }

        return view('emails.arbitrage-notification')
            ->with('buy', $buy_rates)
            ->with('sell', $sell_rates)
            ->with('arbitrage', $arbitrage);
    }
}
