<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        if (!Schema::hasTable('p4p_work_position'))
        {
            Schema::create('p4p_work_position', function (Blueprint $table) {
                $table->bigIncrements('p4p_work_position_id'); 
                $table->string('p4p_work_position_code')->nullable();// รหัส
                $table->string('p4p_work_position_name')->nullable();//  
                $table->string('p4p_work_position_user')->nullable();// 
                $table->enum('p4p_work_position_active', ['TRUE','FALSE'])->default('TRUE')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p4p_work_position_position');
    }
};
