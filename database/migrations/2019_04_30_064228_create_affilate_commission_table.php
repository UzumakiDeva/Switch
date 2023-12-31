<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffilateCommissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affilate_commission', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coin')->nullable();
            $table->string('generation')->nullable();
            $table->float('deposit', 10, 2);
            $table->float('trade', 10, 2);
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
        Schema::dropIfExists('affilate_commission');
    }
}
