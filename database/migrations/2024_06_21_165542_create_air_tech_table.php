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
        if (!Schema::hasTable('air_tech'))
        {
            Schema::create('air_tech', function (Blueprint $table) {
                $table->bigIncrements('air_tech_id'); 
                $table->string('air_user_id', length: 20)->nullable();  //  
                $table->string('air_user_name', length: 200)->nullable();  //  
                $table->string('air_tech_supplies_id', length: 20)->nullable();  //  
                $table->string('air_tech_supplies_name', length: 200)->nullable();  //  
                $table->enum('air_type', ['IN','OUT'])->default('IN');   //    ช่างใน รพ /ช่างนอก รพ 
                $table->enum('active', ['N','Y'])->default('Y');       //    พร้อมใช้งาน /ไม่พร้อมใช้งาน                  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_tech');
    }
};
