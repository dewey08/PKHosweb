<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleCarFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vehicle_car_function'))
        {
                Schema::create('vehicle_car_function', function (Blueprint $table) {
                    $table->id("CAR_FUNCTION_ID",11);
                    $table->String("CAR_FUNCTION_NAME",255)->nullable(); 
                    $table->enum('CAR_FUNCTION_STATUS', ['True', 'False']);   
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
        Schema::dropIfExists('vehicle_car_function');
    }
}
