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
        if (!Schema::hasTable('user_permiss'))
        {
            Schema::create('user_permiss', function (Blueprint $table) {
                $table->bigIncrements('user_permiss_id'); 
                $table->string('user_id')->nullable();//   
                $table->string('user_permiss_num')->nullable();//   
                $table->string('user_permiss_name')->nullable();//     
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permiss');
    }
};
