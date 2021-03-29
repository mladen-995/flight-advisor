<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('airline');
            $table->string('airline_id');
            $table->string('source_airport');
            $table->string('source_airport_id');
            $table->string('destination_airport');
            $table->string('destination_airport_id');
            $table->string('codeshare')->nullable();
            $table->string('stops');
            $table->string('equipment');
            $table->string('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routes');
    }
}
