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
        if (!Schema::hasTable('air_repaire_type'))
        {
            Schema::create('air_repaire_type', function (Blueprint $table) {
                $table->bigIncrements('air_repaire_type_id');  
                $table->char('air_repaire_typename', length: 150)->nullable();  //     
                $table->enum('active', ['N','Y'])->default('Y');   //  พร้อมใช้งาน /ไม่พร้อมใช้งาน 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_repaire_type');
    }
};
