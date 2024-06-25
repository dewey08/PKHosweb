<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuesthousElecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     if(!Schema::hasTable('guesthous_elec')){
         Schema::create('guesthous_elec', function (Blueprint $table) {
            $table->id("GUEST_ELEC_ID",11);
            $table->String("LOCATION_ID",20)->nullable(); 
            $table->String("LOCATION_LEVEL_ID",50)->nullable(); 
            $table->String("LEVEL_ROOM_ID",50)->nullable(); 
            $table->String("GUEST_ELEC_YEAR",20)->nullable(); 
            $table->String("GUEST_ELEC_MONTH",20)->nullable(); 
            $table->String("GUEST_ELEC_METER_NUM",255)->nullable(); 
            $table->String("GUEST_ELEC_UNIT",255)->nullable(); 
            $table->String("GUEST_ELEC_UNITPRICE",255)->nullable(); 
            $table->String("GUEST_ELEC_PRICE",255)->nullable(); 
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
        Schema::dropIfExists('guesthous_elec');
    }
}
