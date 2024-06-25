<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanSuppliesYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('plan_supplies_year')){
                Schema::create('plan_supplies_year', function (Blueprint $table) {
                    $table->increments("PLAN_SUPPLIES_YEAR_ID",11);
                    $table->String("PLAN_SUPPLIES_YEAR",250);
                    $table->dateTime('updated_at');
                    $table->dateTime('created_at');
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
        Schema::dropIfExists('plan_supplies_year');
    }
}
