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
        if (!Schema::hasTable('fdh_odx'))
        {
            Schema::connection('mysql')->create('fdh_odx', function (Blueprint $table) {
                $table->bigIncrements('fdh_odx_id');
                $table->string('HN',length: 15)->nullable();// 
                $table->string('DATEDX',length: 8)->nullable();//                  
                $table->string('CLINIC',length: 5)->nullable();//  
                $table->string('DIAG',length: 7)->nullable(); //             
                $table->string('DXTYPE',length: 1)->nullable(); //  
                $table->string('DRDX',length: 6)->nullable(); //  
                $table->string('PERSON_ID',length: 13)->nullable(); // 
                $table->string('SEQ',length: 15)->nullable(); // 

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
        Schema::dropIfExists('fdh_odx');
    }
};
