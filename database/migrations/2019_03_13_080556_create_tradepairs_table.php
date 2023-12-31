<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('tradepairs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coinone')->nullable();
            $table->string('cointwo')->nullable();
            $table->string('symbol');
            $table->double('min_buy_price')->default(0);
            $table->double('min_buy_amount')->default(0);
            $table->double('min_sell_price')->default(0);
            $table->double('min_sell_amount')->default(0);
            $table->double('buy_trade')->default(0);
            $table->double('sell_trade')->default(0);
            $table->double('live_price')->default(0);
            $table->double('open')->nullable();
            $table->double('low')->nullable();
            $table->double('high')->nullable();
            $table->double('close')->nullable();
            $table->double('hrchange')->nullable();
            $table->double('hrvolume')->nullable();
            $table->double('minprice')->nullable();
            $table->double('maxprice')->nullable();
            $table->double('ticksize')->nullable();
            $table->double('minqty')->nullable();
            $table->double('maxqty')->nullable();
            $table->double('stepsize')->nullable();
            $table->double('minnotional')->nullable();
            $table->integer('coinone_decimal')->default(8);
            $table->integer('cointwo_decimal')->default(8);
            $table->integer('active')->nullable();
            $table->integer('orderlist')->nullable();
            $table->integer('type')->default(0);
            $table->integer('is_spot')->nullable();
            $table->integer('is_dust')->nullable();
            $table->integer('is_market')->nullable();
            $table->integer('start_price')->nullable();
            $table->integer('end_price')->nullable();
            $table->integer('start_volume')->nullable();
            $table->integer('end_volume')->nullable();
            $table->integer('is_bot')->nullable();
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
        Schema::dropIfExists('tradepairs');
    }
}
