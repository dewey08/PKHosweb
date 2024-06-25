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
        if (!Schema::hasTable('plan_main'))
        {
            Schema::connection('mysql')->create('plan_main', function (Blueprint $table) { 
                $table->bigIncrements('plan_main_id');//   
                $table->string('plan_main_name')->nullable();//         แผนงาน/โครงการ
                $table->string('plan_main_year')->nullable();//          ปีงบ
                $table->date('plan_main_date_start')->nullable();//        วันที่
                $table->date('plan_main_date_end')->nullable();//        ถึงวันที่  
                $table->string('user_id')->nullable();//         ผู้รับผิดชอบ 
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
        Schema::dropIfExists('plan_main');
    }
};
