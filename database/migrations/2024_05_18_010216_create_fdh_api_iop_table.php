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
        if (!Schema::hasTable('fdh_api_iop'))
        {
            Schema::create('fdh_api_iop', function (Blueprint $table) {
                $table->bigIncrements('fdh_api_iop_id'); 
                $table->string('type')->nullable();//   "DRU.txt”  
                $table->longtext('file')->nullable();//       “SE58SU5T” 
                $table->string('encoding')->nullable();//   “UTF-8” 
                $table->string('claim_name')->nullable();// 
                $table->string('size')->nullable();// 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fdh_api_iop');
    }
};
