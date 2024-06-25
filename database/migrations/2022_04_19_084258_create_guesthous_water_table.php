<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuesthousWaterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    if(!Schema::hasTable('guesthous_water')){
        Schema::create('guesthous_water', function (Blueprint $table) {
            $table->id("GUEST_WATER_ID",11);
            $table->String("LOCATION_ID",20)->nullable(); 
            $table->String("LOCATION_LEVEL_ID",50)->nullable(); 
            $table->String("LEVEL_ROOM_ID",50)->nullable(); 
            $table->String("GUEST_WATER_YEAR",20)->nullable(); 
            $table->String("GUEST_WATER_MONTH",20)->nullable(); 
            $table->String("GUEST_WATER_METER_NUM",255)->nullable(); 
            $table->String("GUEST_WATER_UNIT",255)->nullable(); 
            $table->String("GUEST_WATER_UNITPRICE",255)->nullable(); 
            $table->String("GUEST_WATER_PRICE",255)->nullable(); 
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
        Schema::dropIfExists('guesthous_water');
    }
}
