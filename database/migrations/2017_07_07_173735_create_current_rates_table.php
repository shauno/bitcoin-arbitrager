<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exchange_rate_id')->unsigned();
            $table->foreign('exchange_rate_id')->references('id')->on('exchange_rates');
            $table->decimal('rate', 16,8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('current_rates');
    }
}
