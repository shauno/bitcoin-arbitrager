<?php

namespace BtcArbitrager\ExchangeRates;

use App\ExchangeRate;
use Illuminate\Support\Collection;

class ExchangeRateRepositoryEloquent implements ExchangeRateRepository
{
    /**
     * Find all exchange rates with the $from_iso
     *
     * @param string $from_iso
     * @return Collection|ExchangeRate[]
     */
    public function findFromIso(string $from_iso) : Collection
    {
        return (new ExchangeRate())
            ->where('from_iso', $from_iso)
            ->get();
    }
}