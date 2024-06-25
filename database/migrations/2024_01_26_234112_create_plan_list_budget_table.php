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
        if (!Schema::hasTable('plan_list_budget'))
        {
            Schema::connection('mysql')->create('plan_list_budget', function (Blueprint $table) { 
                $table->bigIncrements('plan_list_budget_id');//   
                $table->string('plan_list_budget_name')->nullable();//      
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
        Schema::dropIfExists('plan_list_budget');
    }
};
