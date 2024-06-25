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
        if (!Schema::connection('mysql')->hasTable('tempexport'))
        {
            Schema::connection('mysql')->create('tempexport', function (Blueprint $table) { 
                // $table->bigIncrements('tempexport_id');//  
                $table->enum('active', ['Y','N'])->default('N')->nullable(); 
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();// 
                $table->string('sn')->nullable();//    
                $table->date('send_date')->nullable();//   
                $table->string('status')->nullable();//   
                $table->string('status')->nullable();// 
                $table->string('user_id')->nullable(); //  
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
        Schema::dropIfExists('tempexport');
    }
};
