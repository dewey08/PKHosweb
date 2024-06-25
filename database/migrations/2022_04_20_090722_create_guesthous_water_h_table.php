<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuesthousWaterHTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('guesthous_water_h')){
                Schema::create('guesthous_water_h', function (Blueprint $table) {
                    $table->id("GUEST_WATER_H_ID",11);
                    $table->String("GUEST_WATER_H_YEAR",20)->nullable(); 
                    $table->String("GUEST_WATER_H_MONTH",50)->nullable(); 
                    $table->String("GUEST_WATER_H_AMOUNT",50)->nullable(); 
                    $table->dateTime('updated_at')->nullable();
                    $table->dateTime('created_at')->nullable();
                });

         }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guesthous_water_h');
    }
}
