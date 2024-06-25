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
        if (!Schema::hasTable('air_supplies'))
        {
            Schema::create('air_supplies', function (Blueprint $table) {
                $table->bigIncrements('air_supplies_id'); 
                $table->string('air_user_id', length: 20)->nullable();  //  
                $table->string('air_user_name', length: 200)->nullable();  //  
                $table->string('supplies_name', length: 20)->nullable();  //  
                $table->string('supplies_tel', length: 200)->nullable();  //  
                $table->string('supplies_tax', length: 200)->nullable();  // 
                $table->text('supplies_address')->nullable();  // 
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
        Schema::dropIfExists('air_supplies');
    }
};
