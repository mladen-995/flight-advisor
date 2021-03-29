<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('city');
            $table->string('country');
            $table->string('iata')->nullable();
            $table->string('icao')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('altitude');
            $table->string('timezone');
            $table->string('dst');
            $table->string('tz');
            $table->string('type');
            $table->string('source');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airports');
    }
}
