<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        if (!Schema::hasTable('fdh_sesion'))
        {
            Schema::connection('mysql')->create('fdh_sesion', function (Blueprint $table) { 
                $table->bigIncrements('fdh_sesion_id');//  
               
                $table->string('folder_name')->nullable();// 
                $table->string('d_anaconda_id')->nullable(); //  
                $table->date('date_save')->nullable();//   
                $table->time('time_save')->nullable();//   
                $table->enum('active', ['N','Y'])->default('N')->nullable();
                $table->string('userid')->nullable();// 
                $table->timestamps();
            }); 
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fdh_sesion');
    }
};
