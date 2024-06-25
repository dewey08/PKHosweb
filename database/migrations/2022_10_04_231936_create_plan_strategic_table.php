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
        if (!Schema::hasTable('plan_strategic'))
        {
            Schema::create('plan_strategic', function (Blueprint $table) {
                $table->bigIncrements('plan_strategic_id'); 
                $table->string('plan_strategic_name',255)->nullable();//  
                $table->string('plan_strategic_startyear',255)->nullable();// 
                $table->string('plan_strategic_endyear',255)->nullable();//  
                $table->string('plan_mission_id',255)->nullable();//  
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
        Schema::dropIfExists('plan_strategic');
    }
};
