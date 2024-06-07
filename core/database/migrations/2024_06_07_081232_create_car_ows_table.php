<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_ows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->unsignedInteger('role_id');
            $table->string('firstname', 40)->nullable();
            $table->string('lastname', 40)->nullable();
            $table->string('email', 40)->nullable();
            $table->string('image')->nullable();
            $table->string('country_code', 40)->nullable();
            $table->string('mobile', 40)->nullable();
            $table->decimal('balance', 28, 8)->default(0.00000000);
            $table->string('password');
            $table->text('address')->nullable();
            $table->unsignedTinyInteger('is_featured')->default(0);
            $table->unsignedInteger('req_step')->default(1);
            $table->tinyInteger('status')->default(1)->comment('0 = deactive, 1 = active, 2 = send request completed, 5 = send request without form data');
            $table->string('ver_code')->nullable()->comment('stores verification code');
            $table->dateTime('ver_code_send_at')->nullable()->comment('verification send time');
            $table->tinyInteger('ts')->default(0)->comment('0: 2fa Off; 1: 2fa On');
            $table->tinyInteger('tv')->default(1)->comment('0: 2fa unverified; 1: 2fa verified');
            $table->string('tsc')->nullable();
            $table->text('form_data')->nullable();
            $table->text('ban_reason')->nullable();
            $table->date('expire_at')->nullable();
            $table->decimal('avg_rating', 5, 2)->default(0.00);
            $table->tinyInteger('auto_payment')->default(0);
            $table->string('remember_token')->nullable();
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
        Schema::dropIfExists('car_ows');
    }
};
