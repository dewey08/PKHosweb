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
        if (!Schema::hasTable('dashboard_department_authen'))
        {
        Schema::create('dashboard_department_authen', function (Blueprint $table) {
            $table->bigIncrements('dashboard_department_authen_id');       
            $table->Date('vstdate')->nullable();//  
            $table->string('main_dep',100)->nullable();// 
            $table->string('department',255)->nullable();// 
            $table->string('vn',100)->nullable();// 
            $table->string('claimCode',255)->nullable();// 
            $table->string('Success',255)->nullable();// 
            $table->string('Unsuccess',255)->nullable();//  
            // $table->string('Totalsuccess',255)->nullable();//  
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
        Schema::dropIfExists('dashboard_department_authen');
    }
};
