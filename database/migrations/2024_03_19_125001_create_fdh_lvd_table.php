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
        if (!Schema::hasTable('fdh_lvd'))
        {
            Schema::connection('mysql')->create('fdh_lvd', function (Blueprint $table) {
                $table->bigIncrements('fdh_lvd_id');

                $table->string('SEQLVD',length: 3)->nullable();// 
                $table->string('AN',length: 15)->nullable();//
                $table->string('DATEOUT',length: 8)->nullable();//  
                $table->string('TIMEOUT',length: 4)->nullable(); //     
                $table->string('DATEIN',length: 8)->nullable(); //   
                $table->string('TIMEIN',length: 4)->nullable(); //  
                $table->string('QTYDAY',length: 3)->nullable();//
                
                $table->string('d_anaconda_id')->nullable(); // 
                $table->string('user_id')->nullable(); //  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fdh_lvd');
    }
};
