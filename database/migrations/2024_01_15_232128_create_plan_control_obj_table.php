<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        if (!Schema::hasTable('plan_control_obj'))
        {
            Schema::connection('mysql')->create('plan_control_obj', function (Blueprint $table) { 
                $table->bigIncrements('plan_control_obj_id');//  
                $table->string('plan_control_id')->nullable();//   
                $table->string('billno')->nullable();//   
                $table->string('plan_control_obj_name')->nullable();//         วัตถุประสงค์ /ตัวชี้วัด
                $table->string('plan_control_obj_score')->nullable();//        คะแนน  วัตถุประสงค์ /ตัวชี้วัด     
                $table->string('user_id')->nullable();//         
                $table->timestamps();
            }); 
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_control_obj');
    }
};
