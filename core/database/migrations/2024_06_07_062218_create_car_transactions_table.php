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
        Schema::create('car_transactions', function (Blueprint $table) {
            $table->bigIncrements('id'); // Auto-incrementing unsigned bigint primary key
            $table->unsignedInteger('owner_id')->default(0);
            $table->unsignedInteger('user_id')->default(0);
            $table->decimal('amount', 28, 8)->default(0.00000000);
            $table->decimal('charge', 28, 8)->default(0.00000000);
            $table->decimal('post_balance', 28, 8)->default(0.00000000);
            $table->string('trx_type', 40)->nullable();
            $table->string('trx', 40)->nullable();
            $table->string('details', 255)->nullable();
            $table->string('remark', 40)->nullable();
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
        Schema::dropIfExists('car_transactions');
    }
};
