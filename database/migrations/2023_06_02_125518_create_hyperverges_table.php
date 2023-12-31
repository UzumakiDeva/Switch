<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHypervergesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hyperverges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('uid');
            $table->string('transaction_id')->nullable();
            $table->string('status')->nullable();
            $table->string('d_idpic')->nullable();
            $table->string('d_name')->nullable();
            $table->string('d_address')->nullable();
            $table->string('d_dob')->nullable();
            $table->string('p_id')->nullable();
            $table->string('p_id_number')->nullable();
            $table->string('p_name')->nullable();
            $table->string('p_dob')->nullable();
            $table->string('image')->nullable();
            $table->string('front_img')->nullable();
            $table->string('back_img')->nullable();
            $table->string('face_img')->nullable();
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
        Schema::dropIfExists('hyperverges');
    }
}
