<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillOilBillInCarRefer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_car_refer', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicle_car_refer', 'OIL_BILL'))
            {
                $table->string("OIL_BILL",255)->nullable();
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
        Schema::table('vehicle_car_refer', function (Blueprint $table) {
            //
        });
    }
}
