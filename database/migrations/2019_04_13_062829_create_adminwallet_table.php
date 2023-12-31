<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminwalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adminwallet', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('currency')->nullable();
        $table->string('mukavari')->nullable();
        $table->double('balance')->default(0);
        $table->double('commission')->default(0);
        $table->string('instant_type')->nullable();
        $table->double('buytrade')->default(0);
        $table->double('selltrade')->default(0);
        $table->double('trade')->default(0);
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
        Schema::dropIfExists('adminwallet');
    }
}
