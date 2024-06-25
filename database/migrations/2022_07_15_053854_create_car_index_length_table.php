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
        if (!Schema::hasTable('car_index_length'))
        {
        Schema::create('car_index_length', function (Blueprint $table) {
            $table->bigIncrements('car_index_length_id');  
                $table->string('car_index_id')->nullable();// 
                $table->enum('car_index_length_type', ['go','back'])->default('go'); //ไป-กลับ   
                $table->string('car_index_length_date')->nullable();//วันที่               
                $table->Time('car_index_length_time')->nullable();// เวลา  
                $table->enum('car_index_length_status', ['OPEN','CLOSE','CANCEL'])->default('CLOSE'); 
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
        Schema::dropIfExists('car_index_length');
    }
};
