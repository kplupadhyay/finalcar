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
        Schema::create('car_withdrawl_logs', function (Blueprint $table) {
            $table->bigIncrements('id'); // Auto-incrementing unsigned bigint primary key
            $table->unsignedInteger('method_id')->default(0);
            $table->unsignedInteger('owner_id')->default(0);
            $table->decimal('amount', 28, 8)->default(0.00000000);
            $table->string('currency', 40)->nullable();
            $table->decimal('rate', 28, 8)->default(0.00000000);
            $table->decimal('charge', 28, 8)->default(0.00000000);
            $table->string('trx', 40)->nullable();
            $table->decimal('final_amount', 28, 8)->default(0.00000000);
            $table->decimal('after_charge', 28, 8)->default(0.00000000);
            $table->text('withdraw_information')->nullable();
            $table->tinyInteger('status')->default(0)->comment('1=>success, 2=>pending, 3=>cancel');
            $table->text('admin_feedback')->nullable();
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
        Schema::dropIfExists('car_withdrawl_logs');
    }
};
