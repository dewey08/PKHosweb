<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnVehicleCarPosition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_car_position', function (Blueprint $table) {
            
         
            if (!Schema::hasColumn('vehicle_car_position', 'ARTICLE_ID'))
            {
                $table->string("ARTICLE_ID",100)->nullable();
            }  

           
    


    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
