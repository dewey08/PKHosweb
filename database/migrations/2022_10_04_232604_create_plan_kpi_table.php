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
        if (!Schema::hasTable('plan_kpi'))
        {
            Schema::create('plan_kpi', function (Blueprint $table) {
                $table->bigIncrements('plan_kpi_id');                 
                $table->string('plan_kpi_code',255)->nullable();//  
                $table->string('plan_kpi_name',255)->nullable();//   
                $table->string('plan_kpi_year',255)->nullable();// 
                $table->string('plan_taget_id',255)->nullable();// 
                $table->string('plan_strategic_id',255)->nullable();// 
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
        Schema::dropIfExists('plan_kpi');
    }
};
