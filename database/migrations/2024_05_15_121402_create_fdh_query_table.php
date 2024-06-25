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
        if (!Schema::hasTable('fdh_query'))
        {
            Schema::connection('mysql')->create('fdh_query', function (Blueprint $table) {
                $table->bigIncrements('fdh_query_id');
                $table->longText('fdh_query_name')->nullable();// 
                $table->longText('fdh_where')->nullable();// 
                $table->longText('fdh_and')->nullable();// 
                $table->string('fdh_query_type')->nullable();//  
                $table->string('user_id')->nullable();//  
                $table->enum('active', ['N','Y'])->default('N'); 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fdh_query');
    }
};
