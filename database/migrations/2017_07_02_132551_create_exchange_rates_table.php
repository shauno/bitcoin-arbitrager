<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exchange_id')->unsigned();
            $table->foreign('exchange_id')->references('id')->on('exchanges');
            $table->string('from_iso', 3);
            $table->string('to_iso', 3);
            $table->string('tracker_url');
            $table->string('parser')->comment('Class used to parse response from tracker_url');
            $table->timestamps();

            $table->unique(['exchange_id', 'from_iso', 'to_iso']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_rates');
    }
}
