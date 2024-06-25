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
        if (!Schema::hasTable('plan_target_group'))
        {
            Schema::connection('mysql')->create('plan_target_group', function (Blueprint $table) { 
                $table->bigIncrements('plan_target_group_id');//   
                $table->string('plan_target_group_name')->nullable();//      
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
        Schema::dropIfExists('plan_target_group');
    }
};
