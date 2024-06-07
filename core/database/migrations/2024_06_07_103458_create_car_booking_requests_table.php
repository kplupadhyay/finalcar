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
        Schema::create('car_booking_requests', function (Blueprint $table) {
            $table->bigIncrements('id'); // Big integer auto-incrementing primary key
            $table->unsignedInteger('owner_id'); // Unsigned integer for owner_id
            $table->unsignedInteger('booking_id')->default(0); // Unsigned integer for booking_id with a default value of 0
            $table->unsignedInteger('user_id')->default(0); // Unsigned integer for user_id with a default value of 0
            $table->unsignedInteger('total_adult')->default(0); // Unsigned integer for total_adult with a default value of 0
            $table->unsignedInteger('total_child')->default(0); // Unsigned integer for total_child with a default value of 0
            $table->date('check_in')->nullable(); // Date for check_in
            $table->date('check_out')->nullable(); // Date for check_out
            $table->decimal('total_amount', 28, 8)->default(0.00000000); // Decimal for total_amount with precision and scale
            $table->text('contact_info')->nullable(); // Text for contact_info
            $table->tinyInteger('status')->default(0)->comment('0 = request send, 1 = approved, 3 = cancelled'); // Tiny integer for status with default value and comment
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_booking_requests');
    }
};
