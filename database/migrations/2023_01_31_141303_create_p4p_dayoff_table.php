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
        if (!Schema::hasTable('p4p_dayoff'))
        {
            Schema::create('p4p_dayoff', function (Blueprint $table) {
                $table->bigIncrements('p4p_dayoff_id');  
                $table->date('date_holiday')->nullable();// 
                $table->string('date_detail')->nullable();// 
                $table->string('date_type')->nullable();//  
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
        Schema::dropIfExists('p4p_dayoff');
    }
};
