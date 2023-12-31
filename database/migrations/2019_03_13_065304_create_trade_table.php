<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uid');
            $table->foreign('uid')->references('id')->on('users');
            $table->enum('trade_type', ['Buy', 'Sell']);
            $table->string('ouid')->nullable();
            $table->string('order_id')->nullable();
            $table->integer('pair')->nullable();
            $table->integer('order_type')->nullable();
            $table->double('price')->nullable();
            $table->double('volume')->nullable();
            $table->double('value')->nullable();
            $table->double('fees')->nullable();
            $table->double('commission')->nullable();
            $table->double('remaining')->nullable();
            $table->double('stoplimit')->nullable();
            $table->integer('status')->default(0);
            $table->string('status_text')->nullable();
            $table->string('priceperunit')->nullable();
            $table->integer('leverage')->default(1);
            $table->double('spend')->nullable();
            $table->string('post_ty')->default('web');
            $table->double('balance')->default(0);
            $table->double('is_type')->default(0);
            $table->double('filled')->default(0);
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
        Schema::dropIfExists('trades');

    }
}
