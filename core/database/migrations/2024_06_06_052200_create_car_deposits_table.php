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
        Schema::create('car_deposits', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('owner_id');
            $table->integer('booking_id');
            $table->integer('pay_for_month');
            $table->integer('method_code');
            $table->decimal('amount');
            $table->string('method_currency');
            $table->decimal('charge');
            $table->decimal('rate');
            $table->decimal('final_amo');
            $table->text('detail');
            $table->string('btc_amo');
            $table->string('btc_wallet');
            $table->string('trx');
            $table->integer('payment_try');
            $table->integer('status');
            $table->integer('form_api');
            $table->string('admin_feedback');
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
        Schema::dropIfExists('car_deposits');
    }
};
