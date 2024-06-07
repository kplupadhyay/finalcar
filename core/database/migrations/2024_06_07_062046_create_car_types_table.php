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
        Schema::create('car_types', function (Blueprint $table) {
               $table->bigIncrements('id'); // Auto-incrementing unsigned bigint primary key
            $table->unsignedInteger('owner_id')->default(0);
            $table->string('name', 255)->nullable();
            $table->unsignedInteger('total_adult')->default(0);
            $table->unsignedInteger('total_child')->default(0);
            $table->decimal('fare', 28, 16)->nullable();
            $table->decimal('discount_percentage', 5, 2)->default(0.00)->comment('in percentage');
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->text('beds')->nullable();
            $table->decimal('cancellation_fee', 28, 8)->default(0.00000000);
            $table->text('cancellation_policy')->nullable();
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('car_types');
    }
};
