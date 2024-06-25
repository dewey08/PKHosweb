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
        if (!Schema::hasTable('plan_taget'))
        {
            Schema::create('plan_taget', function (Blueprint $table) {
                $table->bigIncrements('plan_taget_id'); 
                $table->string('plan_taget_code',255)->nullable();//  
                $table->string('plan_taget_name',255)->nullable();//  
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
        Schema::dropIfExists('plan_taget');
    }
};
