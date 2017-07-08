<?php
/**
 * @var \Illuminate\Support\Collection|\App\ExchangeRate $buy
 * @var \Illuminate\Support\Collection|\App\ExchangeRate $sell
 */
?>

<b>Best Buy:</b> {{ number_format($buy->min('sort_rate')) }}<br />
<b>Best Sell:</b> {{ number_format($sell->max('sort_rate')) }}<br />
<b>Arbitrage</b> {{ $arbitrage * 100 }}
<hr />

<h3>Buy Rates</h3>
<ul>
    @foreach ($buy->sortBy('sort_rate') as $exchangeRate)
        <li>{{ $exchangeRate->getExchange()->name }}: {{ $exchangeRate->getCurrentRate()->rate }}</li>
    @endforeach
</ul>

<h3>Sell Rates</h3>
<ul>
    @foreach ($sell->sortByDesc('sort_rate') as $exchangeRate)
        <li>{{ $exchangeRate->getExchange()->name }}: {{ $exchangeRate->getCurrentRate()->rate }}</li>
    @endforeach
</ul>