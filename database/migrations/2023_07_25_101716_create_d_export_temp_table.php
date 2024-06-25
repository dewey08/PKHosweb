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
        if (!Schema::hasTable('d_export_temp'))
        {
            Schema::connection('mysql')->create('d_export_temp', function (Blueprint $table) { 
                $table->bigIncrements('d_export_temp_id');//  
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();// 
                $table->string('fullname')->nullable();//    
                $table->date('send_date')->nullable();//  
                $table->enum('active', ['Y','N'])->default('N')->nullable(); 
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
        Schema::dropIfExists('d_export_temp');
    }
};
