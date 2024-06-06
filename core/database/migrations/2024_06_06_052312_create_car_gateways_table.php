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
        Schema::create('car_gateways', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->integer('form_id');
            $table->integer('code');
            $table->string('name');
            $table->string('alias');
            $table->integer('status');
            $table->text('gateway_parameters');
            $table->text('supported_currencies');
            $table->integer('crypto');
            $table->text('extra');
            $table->text('description');
            
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
        Schema::dropIfExists('car_gateways');
    }
};
