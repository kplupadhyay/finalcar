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
        Schema::create('car_payment_logs', function (Blueprint $table) {
            $table->bigIncrements('id'); // Auto-incrementing primary key
            $table->unsignedInteger('owner_id')->default(0);
            $table->unsignedInteger('booking_id')->default(0);
            $table->decimal('amount', 28, 8)->default(0.00000000);
            $table->string('type', 40)->nullable();
            $table->string('payment_system', 40)->nullable();
            $table->unsignedInteger('action_by')->default(0);
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
        Schema::dropIfExists('car_payment_logs');
    }
};
