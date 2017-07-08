<?php

namespace BtcArbitrager\ExchangeRates;

use App\CurrentRate;
use App\ExchangeRate;
use Illuminate\Support\Collection;

class ExchangeRateRepositoryEloquent implements ExchangeRateRepository
{
    /**
     * @inheritdoc
     */
    public function findFromIso(string $from_iso) : Collection
    {
        return (new ExchangeRate())
            ->where('from_iso', $from_iso)
            ->get();
    }

    /**
     * @inheritdoc
     */
    public function findToIso(string $to_iso): Collection
    {
        return (new ExchangeRate())
            ->where('to_iso', $to_iso)
            ->get();
    }

    /**
     * @inheritdoc
     */
    public function addCurrentRate(ExchangeRate $exchangeRate, float $rate) : CurrentRate
    {
        return $exchangeRate->currentRate()->create([
            'rate' => $rate,
        ]);
    }
}