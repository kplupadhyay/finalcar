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
        Schema::create('car_settings', function (Blueprint $table) {
            $table->bigIncrements('id'); // Auto-incrementing unsigned bigint primary key
            $table->unsignedInteger('owner_id')->notNull();
            $table->string('name', 255)->nullable();
            $table->unsignedInteger('star_rating')->default(1);
            $table->string('image', 255)->nullable();
            $table->decimal('latitude', 10, 6)->default(0.000000);
            $table->decimal('longitude', 10, 6)->default(0.000000);
            $table->string('hotel_address', 255)->nullable();
            $table->unsignedInteger('country_id')->default(0);
            $table->unsignedInteger('city_id')->default(0);
            $table->unsignedInteger('location_id')->default(0);
            $table->string('tax_name', 40)->nullable();
            $table->decimal('tax_percentage', 5, 2)->default(0.00);
            $table->time('checkin_time')->nullable();
            $table->time('checkout_time')->nullable();
            $table->unsignedInteger('upcoming_checkin_days')->notNull();
            $table->unsignedInteger('upcoming_checkout_days')->notNull();
            $table->decimal('confirmation_amount_percentage', 5, 2)->default(0.00)->comment('Ex: should payment 30% of total amount');
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->text('cancellation_policy')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_settings');
    }
};
