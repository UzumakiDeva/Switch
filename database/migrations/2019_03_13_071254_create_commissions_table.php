<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('source')->nullable();
            $table->double('withdraw')->nullable();
            $table->double('buy_trade')->nullable();
            $table->double('sell_trade')->nullable();
            $table->enum('type', ['fiat','coin','token','stock']);
            $table->enum('com_type', ['Percentage','Fixed'])->nullable();
            $table->string('coinname')->nullable();
            $table->double('netfee')->nullable();
            $table->integer('point_value')->nullable();
            $table->integer('decimal_value')->nullable();
            $table->double('min_deposit')->nullable();
            $table->double('min_withdraw')->nullable();
            $table->double('perday_withdraw')->nullable();
            $table->double('min_trade_price')->nullable();
            $table->integer('is_deposit')->nullable();
            $table->integer('is_withdraw')->nullable();
            $table->text('url')->nullable();
            $table->text('contractaddress')->nullable();
            $table->text('abiarray')->nullable();
            $table->text('image')->nullable();
            $table->integer('status')->nullable();
            $table->tinyInteger('shown')->nullable();
            $table->tinyInteger('orderlist')->nullable();
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
        Schema::dropIfExists('commissions');

    }
}
