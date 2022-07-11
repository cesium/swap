<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConditionalExchange extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('conditionalExchange', function (Blueprint $table) {
            $table->increments('id');
            //tou na duvida do que meter aqui pois faz sentido ter um ID, mas os campos deveria ser "para cada exchange condicional a lista de exchanges a fazer", a cena é que não estou assim de 1a a ver como fazer isso
//depois ia por como foreign key os ids das exchanges a fazer
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}