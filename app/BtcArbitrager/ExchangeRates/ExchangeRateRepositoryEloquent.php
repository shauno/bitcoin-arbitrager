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
    public function findFromIso(string $fromIso) : Collection
    {
        return (new ExchangeRate())
            ->where('from_iso', $fromIso)
            ->get();
    }

    /**
     * @inheritdoc
     */
    public function findToIso(string $toIso): Collection
    {
        return (new ExchangeRate())
            ->where('to_iso', $toIso)
            ->get();
    }

    /**
     * @inheritdoc
     */
    public function findFromDate(\DateTime $from)
    {
        return (new ExchangeRate())
            ->with(['CurrentRate' => function($query) use ($from) {
                $query->where('created_at', '>=', $from->format('Y-m-d H:i:s'));
            }])
            ->with('Exchange')
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