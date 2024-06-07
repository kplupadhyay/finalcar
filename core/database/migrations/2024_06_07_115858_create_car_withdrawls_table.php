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
        Schema::create('car_withdrawls', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
            $table->unsignedInteger('method_id')->default(0)->change();
            $table->unsignedInteger('owner_id')->default(0)->change();
            $table->decimal('amount', 28, 8)->default(0.00000000)->change();
            $table->string('currency', 40)->nullable()->change();
            $table->decimal('rate', 28, 8)->default(0.00000000)->change();
            $table->decimal('charge', 28, 8)->default(0.00000000)->change();
            $table->string('trx', 40)->nullable()->change();
            $table->decimal('final_amount', 28, 8)->default(0.00000000)->change();
            $table->decimal('after_charge', 28, 8)->default(0.00000000)->change();
            $table->text('withdraw_information')->nullable()->change();
            $table->tinyInteger('status')->default(0)->comment('1=>success, 2=>pending, 3=>cancel')->change();
            $table->text('admin_feedback')->nullable()->change();
            $table->timestamps(); // This will handle created_at a
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_withdrawls');
    }
};
