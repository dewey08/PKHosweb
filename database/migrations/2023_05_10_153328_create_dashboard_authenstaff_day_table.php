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
        if (!Schema::hasTable('dashboard_authenstaff_day'))
        {
        Schema::create('dashboard_authenstaff_day', function (Blueprint $table) {
            $table->bigIncrements('dashboard_authenstaff_day_id');       
            $table->Date('vstdate')->nullable();// 
            $table->string('loginname',100)->nullable();// 
            $table->string('Staff',100)->nullable();// loginname
            $table->string('Spclty',255)->nullable();// 
            $table->string('vn',100)->nullable();// 
            $table->string('claimCode',255)->nullable();// 
            $table->string('Success',255)->nullable();// 
            $table->string('Unsuccess',255)->nullable();//   
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
        Schema::dropIfExists('dashboard_authenstaff_day');
    }
};
