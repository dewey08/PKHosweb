<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        if (!Schema::hasTable('plan_project_kpi'))
        {
            Schema::create('plan_project_kpi', function (Blueprint $table) {
                $table->bigIncrements('plan_project_kpi_id'); 
                $table->string('plan_project_kpi_code',255)->nullable();// kpi 
                $table->string('plan_project_kpi_name',255)->nullable();// kpi 
                $table->string('plan_project_id',255)->nullable();//แผน                
                $table->timestamps();
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
        Schema::dropIfExists('plan_project_kpi');
    }
};
