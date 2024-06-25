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
        if (!Schema::hasTable('checkin_export'))
        {
            Schema::create('checkin_export', function (Blueprint $table) {
                $table->bigIncrements('checkin_export_id');   
                $table->date('checkindate')->nullable();//   
                $table->time('checkintime')->nullable();// 
                $table->string('ptname')->nullable();//  
                $table->time('checkin_time')->nullable();// 
                $table->time('checkout_time')->nullable();// 
                $table->string('checkin_type')->nullable();// 
                $table->string('checkin_typename')->nullable();// 
                $table->string('userid')->nullable();//
                $table->string('userid_save')->nullable();//
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
        Schema::dropIfExists('checkin_export');
    }
};
