<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('txid')->nullable();
            $table->unsignedBigInteger('uid');
            $table->foreign('uid')->references('id')->on('users');
            $table->string('payment_name')->nullable();
            $table->double('amount')->nullable();
            $table->double('credit_amount')->nullable();
            $table->string('proof')->nullable();
            $table->string('currency')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
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
       Schema::dropIfExists('deposits');
    }
}
