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
        if (!Schema::hasTable('plan_project_budget'))
        {
            Schema::create('plan_project_budget', function (Blueprint $table) {
                $table->bigIncrements('plan_project_budget_id'); 
                $table->string('plan_project_budget_name',255)->nullable();// งบประมาณ 
                $table->string('plan_project_budget_qty',255)->nullable();// งบประมาณ  
                $table->double('plan_project_budget_price', 10, 2)->nullable();//ราคา
                $table->string('plan_project_id',255)->nullable();// ID แผน                
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
        Schema::dropIfExists('plan_project_budget');
    }
};
