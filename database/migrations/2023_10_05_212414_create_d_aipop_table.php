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
        if (!Schema::hasTable('d_aipop'))
        {
            Schema::connection('mysql')->create('d_aipop', function (Blueprint $table) {
                $table->bigIncrements('d_aipop_id'); 
                $table->string('an')->nullable();//   
                $table->string('sequence')->nullable();//   
                $table->string('CodeSys')->nullable();//  
                $table->string('Code')->nullable();//  
                $table->string('Procterm')->nullable();//  
                $table->string('DR')->nullable();// 
                $table->string('DateIn')->nullable();// 
                $table->string('DateOut')->nullable();//  
                $table->string('Location')->nullable();// 
                $table->timestamps();
                $table->date('Date_In')->nullable();// 
                $table->date('Date_Out')->nullable();// 
                $table->time('Time_in')->nullable();// 
                $table->time('Time_out')->nullable();// 
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
        Schema::dropIfExists('d_aipop');
    }
};
