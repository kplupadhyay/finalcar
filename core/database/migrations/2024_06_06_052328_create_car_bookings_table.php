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
        
            Schema::create('car_bookings', function (Blueprint $table) {
                $table->increments('id'); // Auto-incrementing primary key
                $table->unsignedInteger('owner_id')->default(0);
                $table->string('booking_number', 40)->nullable();
                $table->unsignedInteger('user_id')->default(0);
                $table->unsignedInteger('guest_id')->default(0);
                $table->date('check_in')->nullable();
                $table->date('check_out')->nullable();
                $table->text('contact_info')->nullable();
                $table->unsignedInteger('total_adult')->default(0);
                $table->unsignedInteger('total_child')->default(0);
                $table->decimal('total_discount', 28, 8)->default(0.00000000);
                $table->decimal('tax_charge', 28, 8)->default(0.00000000);
                $table->decimal('booking_fare', 28, 8)->default(0.00000000)->comment('Total of room * nights fare');
                $table->decimal('service_cost', 28, 8)->default(0.00000000);
                $table->decimal('extra_charge', 28, 8)->default(0.00000000);
                $table->decimal('extra_charge_subtracted', 28, 8)->default(0.00000000);
                $table->decimal('paid_amount', 28, 8)->default(0.00000000);
                $table->decimal('cancellation_fee', 28, 8)->default(0.00000000);
                $table->decimal('refunded_amount', 28, 8)->default(0.00000000);
                $table->tinyInteger('key_status')->default(0);
                $table->unsignedTinyInteger('status')->default(0)->comment('1= success/active; 3 = cancelled; 9 = checked Out');
                $table->dateTime('checked_in_at')->nullable();
                $table->dateTime('checked_out_at')->nullable();
                $table->timestamps(); // Creates 'created_at' and 'updated_at' columns
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_bookings');
    }
};
