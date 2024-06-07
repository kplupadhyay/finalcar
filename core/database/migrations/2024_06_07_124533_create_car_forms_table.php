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
        Schema::create('car_forms', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
            $table->string('act', 40)->nullable()->change();
            $table->text('form_data')->nullable()->change();
            $table->timestamps(); // Th
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_forms');
    }
};
