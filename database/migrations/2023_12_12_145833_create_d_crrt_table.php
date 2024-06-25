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
        if (!Schema::hasTable('d_crrt'))
        {
            Schema::create('d_crrt', function (Blueprint $table) {
                $table->bigIncrements('d_crrt_id'); 
                $table->string('icode')->nullable();//   
                $table->string('nhso_adp_code')->nullable();//  
                $table->string('name')->nullable();// 
                $table->string('day')->nullable();//   
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_crrt');
    }
};
