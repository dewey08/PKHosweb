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
        if (!Schema::hasTable('fdh_cha'))
        {
            Schema::connection('mysql')->create('fdh_cha', function (Blueprint $table) {
                $table->bigIncrements('fdh_cha_id');

                $table->string('HN',length: 15)->nullable();// 
                $table->string('AN',length: 15)->nullable();// 
                $table->string('DATE',length: 8)->nullable();//                  
                $table->string('CHRGITEM',length: 2)->nullable();//  
                $table->decimal('AMOUNT',total: 12, places: 2)->nullable();//   
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
        Schema::dropIfExists('fdh_cha');
    }
};
