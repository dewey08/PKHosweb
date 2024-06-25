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
        if (!Schema::connection('mysql7')->hasTable('tempexport_ofc401'))
        {
            Schema::connection('mysql7')->create('tempexport_ofc401', function (Blueprint $table) { 
                // $table->bigIncrements('tempexport_id');//  
                $table->enum('active', ['Y','N'])->default('N')->nullable(); 
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();// 
                $table->string('cid')->nullable();// 
                $table->string('sn')->nullable();//    
                $table->date('send_date')->nullable();//   
                $table->date('status')->nullable();//   
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
        Schema::dropIfExists('tempexport_ofc401');
    }
};
