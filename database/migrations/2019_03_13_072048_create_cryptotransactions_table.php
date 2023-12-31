<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptotransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('cryptotransactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uid');
            $table->foreign('uid')->references('id')->on('users');
            $table->string('currency')->nullable();
            $table->string('txtype')->nullable();
            $table->string('txid')->nullable();
            $table->string('atxid')->nullable();
            $table->string('from_addr')->nullable();
            $table->string('to_addr')->nullable();
            $table->double('amount')->nullable();
            $table->double('credit_amount')->nullable();
            $table->integer('confirmation')->nullable();
            $table->integer('status')->nullable();
            $table->string('remark')->nullable();
            $table->integer('nirvaki_nilai')->default(0);
            $table->string('usdt_deposit_type')->nullable();
            $table->double('netfee')->nullable();
            $table->double('adminfee')->nullable();
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
        Schema::dropIfExists('cryptotransactions');
    }
}
