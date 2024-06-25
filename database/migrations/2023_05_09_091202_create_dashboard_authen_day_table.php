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
        if (!Schema::hasTable('dashboard_authen_day'))
        {
        Schema::create('dashboard_authen_day', function (Blueprint $table) {
            $table->bigIncrements('dashboard_authen_day_id');       
            $table->Date('vstdate')->nullable();// 
            $table->string('hn',100)->nullable();//  
            $table->string('vn',100)->nullable();// 
            $table->string('cid',100)->nullable();// 
            $table->string('Kios',255)->nullable();// 
            $table->string('Kios_success',255)->nullable();// 
            $table->string('Staff',255)->nullable();// 
            $table->string('Staff_success',255)->nullable();// 
            $table->string('Total_Success',255)->nullable();// 
            $table->string('Total_Unsuccess',255)->nullable();//  
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
        Schema::dropIfExists('dashboard_authen_day');
    }
};
