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
     * @param string $fromIso
     *
     * @return Collection|ExchangeRate[]
     */
    public function findFromIso(string $fromIso) : Collection;

    /**
     * Find all exchange rates with the $to_iso
     *
     * @param string $toIso
     *
     * @return Collection|ExchangeRate[]
     */
    public function findToIso(string $toIso) : Collection;

    /**
     * Return all Exchange Rates with related Current Rate models created since $from
     *
     * @param \DateTime $from
     * @return Collection|ExchangeRate[]
     */
    public function findFromDate(\DateTime $from);

    /**
     * @param ExchangeRate $exchangeRate
     * @param float $rate
     * @return CurrentRate
     */
    public function addCurrentRate(ExchangeRate $exchangeRate, float $rate) : CurrentRate;
}