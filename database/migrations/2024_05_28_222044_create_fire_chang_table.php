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
        if (!Schema::hasTable('fire_chang'))
        {
            Schema::create('fire_chang', function (Blueprint $table) {
                $table->bigIncrements('fire_chang_id'); 
                $table->text('fire_id')->nullable();//  
                $table->text('fire_num')->nullable();// 
                $table->date('fire_chang_date')->nullable();//   
                $table->text('userid')->nullable();//   
                $table->longText('fire_chang_comment')->nullable();// 
                $table->text('fire_num_chang')->nullable();//  ตัวสำรอง 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fire_chang');
    }
};
