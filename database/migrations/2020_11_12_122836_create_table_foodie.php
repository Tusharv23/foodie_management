<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFoodie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foodies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('score')->nullable();
            $table->timestamp('date_of_birth');
            $table->string('gender');
            $table->string('favourite_food')->nullable();
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
        Schema::dropIfExists('foodies');
    }
}
