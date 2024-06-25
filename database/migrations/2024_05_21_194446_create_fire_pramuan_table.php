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
        if (!Schema::hasTable('fire_pramuan'))
        {
            Schema::create('fire_pramuan', function (Blueprint $table) {
                $table->bigIncrements('fire_pramuan_id'); 
                $table->string('fire_pramuan_name')->nullable();//   
                // $table->string('fire_pramuan_5')->nullable();//   
                // $table->string('fire_pramuan_4')->nullable();//     
                // $table->string('fire_pramuan_3')->nullable();//   
                // $table->string('fire_pramuan_2')->nullable();//   
                // $table->string('fire_pramuan_1')->nullable();//   
                // $table->string('fire_pramuan_0')->nullable();//   
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fire_pramuan');
    }
};
