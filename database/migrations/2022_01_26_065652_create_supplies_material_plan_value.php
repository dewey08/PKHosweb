<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliesMaterialPlanValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            if(!Schema::hasTable('supplies_material_plan_value')){
                Schema::create('supplies_material_plan_value', function (Blueprint $table) {
                    $table->increments("SUP_MATERIAL_ID", 11);
                    $table->integer('ID_SUP_TYPE');
                    $table->String("SUP_MATERIAL_VALUE", 350)->nullable();
                    $table->date('DATE_SAVE');
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
        Schema::dropIfExists('supplies_material_plan_value');
    }
}
