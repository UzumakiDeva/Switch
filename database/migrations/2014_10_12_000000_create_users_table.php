<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_country')->nullable();
            $table->string('phone_no')->nullable();            
            $table->integer('phone_verified')->default(0);
            $table->integer('country')->nullable();
            $table->string('nationality')->nullable();
            $table->date('dob')->nullable();
            $table->string('profileimg')->nullable();
            $table->text('address')->nullable();
            $table->string('twofa')->nullable();
            $table->integer('twofa_status')->nullable();
            $table->string('google2fa_secret')->nullable();
            $table->integer('google2fa_verify')->default(0);
            $table->integer('email_verify')->default(0);            
            $table->integer('kyc_verify')->default(0);
            $table->integer('profile_otp')->nullable();
            $table->string('company_type')->nullable();
            $table->string('business_name')->nullable();
            $table->string('business_country')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_first_name')->nullable();
            $table->string('business_middle_name')->nullable();
            $table->string('business_last_name')->nullable();
            $table->integer('status')->default(0);
            $table->text('reason')->nullable();
            $table->string('verifyToken')->nullable();
            $table->integer('is_logged')->nullable();
            $table->longtext('ipaddr')->nullable();
            $table->string('device')->nullable();
            $table->string('location')->nullable();
            $table->enum('type', ['web', 'app'])->default('web');
            $table->string('mobile_user')->default('Web');
            $table->boolean('is_address')->default(0);
            $table->string('referral_id')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('activation_token')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
