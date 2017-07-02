<?php

namespace BtcArbitrager\ExchangeRates;

use App\ExchangeRate;
use Illuminate\Support\Collection;

interface ExchangeRateRepository
{
    /**
     * Find all exchange rates with the $from_iso
     *
     * @param string $from_iso
     * @return Collection|ExchangeRate[]
     */
    public function findFromIso(string $from_iso) : Collection;
}