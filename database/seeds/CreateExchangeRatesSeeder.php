<?php

use Illuminate\Database\Seeder;

class CreateExchangeRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new \App\ExchangeRate())->fill([
            'exchange_id' => 1, //created by seed data, so sue me XD
            'from_iso'    => 'XBT',
            'to_iso'      => 'ZAR',
            'tracker_url' => 'https://api.mybitx.com/api/1/orderbook?pair=XBTZAR',
            'parser'      => 'LunoSaBuyJson',
        ])->save();

        (new \App\ExchangeRate())->fill([
            'exchange_id' => 1, //created by seed data, so sue me XD
            'from_iso'    => 'ZAR',
            'to_iso'      => 'XBT',
            'tracker_url' => 'https://api.mybitx.com/api/1/orderbook?pair=XBTZAR',
            'parser'      => 'LunoSaSellJson',
        ])->save();

        (new \App\ExchangeRate())->fill([
            'exchange_id' => 2, //created by seed data, so sue me XD
            'from_iso'    => 'XBT',
            'to_iso'      => 'ZAR',
            'tracker_url' => 'https://www.altcointrader.co.za/',
            'parser'      => 'AltCoinTraderBuyHtml',
        ])->save();

        (new \App\ExchangeRate())->fill([
            'exchange_id' => 2, //created by seed data, so sue me XD
            'from_iso'    => 'ZAR',
            'to_iso'      => 'XBT',
            'tracker_url' => 'https://www.altcointrader.co.za/',
            'parser'      => 'AltCoinTraderSellHtml',
        ])->save();

    }
}
