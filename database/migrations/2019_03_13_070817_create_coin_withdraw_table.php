<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinWithdrawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('coin_withdraw', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uid');
            $table->foreign('uid')->references('id')->on('users');
            $table->string('coin_name')->nullable();
            $table->string('sender')->nullable();
            $table->string('reciever')->nullable();
            $table->double('amount')->nullable();
            $table->double('request_amount')->nullable();
            $table->double('admin_fee')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('mobile_type')->nullable();
            $table->string('remark')->nullable();
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
       Schema::dropIfExists('coin_withdraw');
    }
}
