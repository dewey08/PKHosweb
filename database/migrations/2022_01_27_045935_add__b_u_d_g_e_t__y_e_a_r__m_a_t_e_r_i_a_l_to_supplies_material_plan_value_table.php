<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBUDGETYEARMATERIALToSuppliesMaterialPlanValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplies_material_plan_value', function (Blueprint $table) {
            if(!schema::hasColumn('supplies_material_plan_value','BUDGET_YEAR_MATERIAL')){
                $table->String("BUDGET_YEAR_MATERIAL", 250)->nullable();
              
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
