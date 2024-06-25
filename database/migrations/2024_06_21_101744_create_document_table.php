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
        if (!Schema::hasTable('document'))
        {
            Schema::create('document', function (Blueprint $table) {
                $table->bigIncrements('document_id'); 
                $table->string('document_name', length: 200)->nullable();  //  
                $table->string('hip_code', length: 100)->nullable();  // 
                $table->binary('img')->nullable();  // 
                $table->string('img_name', length: 200)->nullable();  // 
                $table->longText('img_base')->nullable();  // 
                $table->string('img_file', length: 100)->nullable();  // 
                $table->string('user_id', length: 100)->nullable();  // 
                $table->enum('active', ['N','R','Y'])->default('Y');   //    พร้อมใช้งาน /ไม่พร้อมใช้งาน                  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document');
    }
};
