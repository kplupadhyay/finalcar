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
        Schema::create('car_owners', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id');
            $table->integer('role_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            
            $table->string('image');
            $table->string('country_code');
            $table->string('mobile');
            $table->decimal('balance');
            $table->string('password');
            $table->text('address');
            $table->integer('is_featured');
            $table->integer('req_step');
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
        Schema::dropIfExists('car_owners');
    }
};
