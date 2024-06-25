<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanProjectSubDepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('plan_project_sub_dep')){
            Schema::create('plan_project_sub_dep', function (Blueprint $table) {
                $table->id("PRO_SUBDEP_ID",11);
                $table->String("PRO_SUB_ID",20)->nullable(); 
                $table->String("PRO_SUBDEP_NAME",255)->nullable(); 
                $table->String("PRO_SUBDEP_IDDEP",50)->nullable(); 
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
        Schema::dropIfExists('plan_project_sub_dep');
    }
}
