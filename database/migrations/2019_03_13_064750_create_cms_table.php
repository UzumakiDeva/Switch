<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('cms', function (Blueprint $table) {
            $table->increments('id');
            $table->text('privacy_policy')->nullable();
            $table->text('tc')->nullable();
            $table->text('aboutus')->nullable();
            $table->text('logo')->nullable();
            $table->text('favicon')->nullable();
            $table->text('kyc_content')->nullable();
            $table->text('termsservice')->nullable();
            $table->integer('kyc_enable')->default(0);
            $table->integer('twofa_withdraw_enable')->default(0);
            $table->text('homebanner')->nullable();
            $table->text('homebanner_title')->nullable();
            $table->integer('homepage_liveprice_view')->nullable();
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
        Schema::dropIfExists('cms');

    }
}
