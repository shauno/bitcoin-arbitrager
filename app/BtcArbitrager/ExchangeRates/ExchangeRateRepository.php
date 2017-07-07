<?php

namespace BtcArbitrager\ExchangeRates;

use App\CurrentRate;
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

    /**
     * Find all exchange rates with the $to_iso
     *
     * @param string $to_iso
     * @return Collection|ExchangeRate[]
     */
    public function findToIso(string $to_iso) : Collection;

    /**
     * @param ExchangeRate $exchangeRate
     * @param float $rate
     * @return CurrentRate
     */
    public function addCurrentRate(ExchangeRate $exchangeRate, float $rate) : CurrentRate;
}