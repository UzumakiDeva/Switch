<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompletedTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('completedtrades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pair')->default(0);
            $table->integer('buytrade_id')->default(0);
            $table->integer('selltrade_id')->default(0);
            $table->double('price')->nullable();
            $table->double('volume')->nullable();
            $table->double('value')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('completedtrades');
    }
}
