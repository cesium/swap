<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConditionalExchangeTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('conditionalExchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('conditionalExchanges');
    }
}
