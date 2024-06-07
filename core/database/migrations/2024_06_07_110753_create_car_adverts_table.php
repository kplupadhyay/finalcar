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
        Schema::create('car_adverts', function (Blueprint $table) {
            $table->bigIncrements('id'); // Big integer auto-incrementing primary key
            $table->unsignedInteger('owner_id')->default(0); // Unsigned integer for owner_id with a default value of 0
            $table->text('url')->nullable(); // Text column for URL, allowing null values
            $table->string('image', 255)->nullable(); // Varchar column for image with a maximum length of 255, allowing null values
            $table->date('end_date')->nullable(); // Date column for end_date, allowing null values
            $table->timestamps(); // Timestamps for created_at and updated_at, allowing nu
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_adverts');
    }
};
