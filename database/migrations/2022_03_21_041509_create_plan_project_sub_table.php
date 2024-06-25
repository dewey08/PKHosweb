<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanProjectSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('plan_project_sub')){
            Schema::create('plan_project_sub', function (Blueprint $table) {
                $table->id("PRO_SUB_ID",11);
                $table->String("PRO_ID",11)->nullable();                
                $table->String("PRO_SUB_CODE",50)->nullable(); 
                $table->String("PRO_SUB_NAME",225)->nullable(); 
                $table->String("PRO_SUB_DETAIL",600)->nullable(); 
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
        Schema::dropIfExists('plan_project_sub');
    }
}
