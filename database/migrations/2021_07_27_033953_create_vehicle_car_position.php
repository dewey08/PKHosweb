<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleCarPosition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (!Schema::hasTable('vehicle_car_position'))
        {
                Schema::create('vehicle_car_position', function (Blueprint $table) {
                    $table->id("CAR_POSITION_ID",11);
                    $table->String("POSITION_ID",11)->nullable(); 
                    $table->String("POSITION_NAME",255)->nullable(); 
                    $table->String("CAR_ID",11)->nullable(); 
                    $table->String("CAR_REG",255)->nullable(); 
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
        Schema::dropIfExists('vehicle_car_position');
    }
}
