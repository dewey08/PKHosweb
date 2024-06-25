<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanProjectSubLastappTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('plan_project_sub_lastapp')){
                Schema::create('plan_project_sub_lastapp', function (Blueprint $table) {
                    $table->id("PRO_SUBLASTAPP_ID",11);
                    $table->String("PRO_SUB_ID",20)->nullable(); 
                    $table->String("PRO_SUBLASTAPP_HR_ID",50)->nullable(); 
                    $table->String("PRO_SUBLASTAPP_HR_NAME",255)->nullable(); 
                    $table->String("PRO_SUBLASTAPP_POSITION",255)->nullable(); 
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
        Schema::dropIfExists('plan_project_sub_lastapp');
    }
}
