<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftsScheduleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shifts_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shift_id')->unsigned();
            $table->enum('weekday', [1,2,3,4,5,6]);
            $table->string('start_time');
            $table->string('end_time');
            $table->string('location');
            $table->timestamps();

            $table->foreign('shift_id')->references('id')->on('shifts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shifts_schedule');
    }
}
