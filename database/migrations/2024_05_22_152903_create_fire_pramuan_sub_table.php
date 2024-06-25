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
        if (!Schema::hasTable('fire_pramuan_sub'))
        {
            Schema::create('fire_pramuan_sub', function (Blueprint $table) {
                $table->bigIncrements('fire_pramuan_sub_id'); 
                $table->string('fire_pramuan_id')->nullable();//  
                $table->string('fire_pramuan_name')->nullable();//   
                $table->string('fire_pramuan_name_number')->nullable();//   
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fire_pramuan_sub');
    }
};
