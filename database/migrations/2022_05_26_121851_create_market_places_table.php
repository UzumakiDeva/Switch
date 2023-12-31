<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uid');
            $table->enum('trade_type', ['Buy', 'Sell']);
            $table->string('ouid')->nullable();
            $table->string('tuid')->nullable();
            $table->string('buyer')->nullable();
            $table->string('order_id')->nullable();
            $table->integer('pair')->nullable();
            $table->integer('order_type')->nullable();
            $table->double('price')->nullable();
            $table->double('volume')->nullable();
            $table->double('value')->nullable();
            $table->double('fees')->nullable();
            $table->double('commission')->nullable();
            $table->double('remaining')->nullable();
            $table->integer('status')->default(0);
            $table->integer('buyer_status')->default(0);
            $table->integer('seller_status')->default(0);
            $table->string('status_text')->nullable();
            $table->string('slipupload')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('post_ty')->default('web');
            $table->double('balance')->default(0);
            $table->double('is_type')->default(0);
            $table->double('filled')->default(0);
            $table->timestamp('closed_at')->nullable();
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
        Schema::dropIfExists('market_places');
    }
}
