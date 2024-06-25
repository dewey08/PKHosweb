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
        if (!Schema::hasTable('d_ofc_401'))
        {
            Schema::connection('mysql')->create('d_ofc_401', function (Blueprint $table) { 
                $table->bigIncrements('d_ofc_401_id');//  
                $table->enum('active', ['N','Y'])->default('N')->nullable();
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();//  
                $table->string('pttype')->nullable();// 
                $table->date('vstdate')->nullable();// 
                $table->string('ptname')->nullable();// 
                $table->string('Apphos')->nullable();// 
                $table->string('Appktb')->nullable();// 
                $table->string('price_ofc')->nullable();// 
                $table->string('icd10')->nullable();// 
                $table->string('pdx')->nullable();// 
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
        Schema::dropIfExists('d_ofc_401');
    }
};
