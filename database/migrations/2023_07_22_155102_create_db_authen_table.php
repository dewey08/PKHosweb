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
        if (!Schema::hasTable('db_authen'))
        {
        Schema::create('db_authen', function (Blueprint $table) {
            $table->bigIncrements('db_authen_id');    
            $table->string('month',100)->nullable();// 
            $table->string('year',100)->nullable();// loginname
            $table->string('countvn',255)->nullable();// 
            $table->string('countan',255)->nullable();// 
            $table->string('authen_opd',255)->nullable();// 
            $table->string('authen_ipd',255)->nullable();// 
            $table->string('authen_user',255)->nullable();// 
            $table->string('authen_kios',255)->nullable();// 
            $table->string('authen_no',255)->nullable();//   
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
        Schema::dropIfExists('db_authen');
    }
};
