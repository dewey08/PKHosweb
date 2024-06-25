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
        if (!Schema::hasTable('plan_project_detail'))
        {
            Schema::create('plan_project_detail', function (Blueprint $table) {
                $table->bigIncrements('plan_project_detail_id');  
                $table->string('plan_project_detail_code',255)->nullable();//   
                $table->string('plan_project_detail_name',255)->nullable();//   
                $table->string('plan_project_id',255)->nullable();//ID โครงการ                
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
        Schema::dropIfExists('plan_project_detail');
    }
};
