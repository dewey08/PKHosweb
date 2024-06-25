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
        if (!Schema::hasTable('plan_mission'))
        {
            Schema::create('plan_mission', function (Blueprint $table) {
                $table->bigIncrements('plan_mission_id');  
                $table->string('plan_mission_no',255)->nullable();//  
                $table->string('plan_mission_name',255)->nullable();//    
                $table->string('plan_vision_id',255)->nullable();//  วิสัยทัศน์
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
        Schema::dropIfExists('plan_mission');
    }
};
