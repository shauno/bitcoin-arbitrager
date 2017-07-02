<?php

use Illuminate\Database\Seeder;

class CreateExchangesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new \App\Exchange())->fill([
            'name' => 'Luno South Africa'
        ])->save();

        (new \App\Exchange())->fill([
            'name' => 'Altcoin Trader South Africa'
        ])->save();
    }
}
