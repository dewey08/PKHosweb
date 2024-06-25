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
        if (!Schema::hasTable('operate_time'))
        {
        Schema::create('operate_time', function (Blueprint $table) {
            $table->bigIncrements('operate_time_id');  
            $table->date('operate_time_date')->nullable();// วันที่       
            $table->string('operate_time_personid',10)->nullable();//ID hrd_person
            $table->string('operate_time_person',255)->nullable();//NAME hrd_person
            $table->string('operate_time_typeid',10)->nullable();// ประเภท
            $table->string('operate_time_typename',10)->nullable();// ประเภท
            $table->Time('operate_time_in')->nullable();// เวลา IN
            $table->Time('operate_time_out')->nullable();// เวลา OUT
            $table->Time('operate_time_otin')->nullable();// เวลา OT IN
            $table->Time('operate_time_otout')->nullable();// เวลา OT OUT
            $table->string('totaltime_narmal',10)->nullable();//
            $table->string('totaltime_ot',10)->nullable();//
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
        Schema::dropIfExists('operate_time');
    }
};
