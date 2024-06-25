<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillFoodBillDayRoundingInFoodbillday extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('food_bill_day', function (Blueprint $table) {
            if (!Schema::hasColumn('food_bill_day', 'FOOD_BILL_DAY_ROUNDING'))
            {
                $table->String("FOOD_BILL_DAY_ROUNDING",20)->nullable();
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
        Schema::table('food_bill_day', function (Blueprint $table) {
            //
        });
    }
}
