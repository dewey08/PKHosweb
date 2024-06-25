<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleCarFunctioncheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        if (!Schema::hasTable('vehicle_car_functioncheck'))
        {
                Schema::create('vehicle_car_functioncheck', function (Blueprint $table) {
                    $table->id("CAR_FUNCTIONCHECK_ID",11);
                    $table->String("CAR_FUNCTIONCHECK_NAME",255)->nullable(); 
                    $table->String("CAR_FUNCTIONCHECK_NAMEENG",255)->nullable(); 
                    $table->enum('CAR_FUNCTIONCHECK_STATUS', ['True', 'False']);   
                    $table->dateTime('updated_at');
                    $table->dateTime('created_at');
                }); 
        }
        DB::table('vehicle_car_functioncheck')->insert(array(
            'CAR_FUNCTIONCHECK_ID' => '1',
            'CAR_FUNCTIONCHECK_NAME' => 'เช็ครถยนต์',
            'CAR_FUNCTIONCHECK_NAMEENG' => 'APPROVE',
            'CAR_FUNCTIONCHECK_STATUS' => 'False',
            'updated_at' => '2021-09-01 13:43:49',
            'created_at' => '2021-09-01 13:43:49',
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_car_functioncheck');
    }
}
