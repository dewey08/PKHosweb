<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPLANSUPPLIESIDYEARToSuppliesMaterialPlanValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplies_material_plan_value', function (Blueprint $table) {
            if(!schema::hasColumn('supplies_material_plan_value','PLAN_SUPPLIES_ID_YEAR')){
                $table->String('PLAN_SUPPLIES_ID_YEAR')->nullable();
              
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
        Schema::table('supplies_material_plan_value', function (Blueprint $table) {
            //
        });
    }
}
