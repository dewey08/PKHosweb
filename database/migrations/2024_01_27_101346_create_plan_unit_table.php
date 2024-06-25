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
        if (!Schema::hasTable('plan_unit'))
        {
            Schema::connection('mysql')->create('plan_unit', function (Blueprint $table) { 
                $table->bigIncrements('plan_unit_id');//   
                $table->string('plan_unit_name')->nullable();//      
                $table->enum('status', ['N','Y'])->default('Y')->nullable(); 
                $table->timestamps();
            });    
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_unit');
    }
};
