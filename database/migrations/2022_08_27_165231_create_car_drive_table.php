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
        if (!Schema::hasTable('car_drive'))
        {
        Schema::create('car_drive', function (Blueprint $table) {
            $table->bigIncrements('car_drive_id');    
            $table->text('car_drive_user_id')->nullable();//พนักงานขับ
            $table->text('car_drive_user_name')->nullable();//พนักงานขับ
            $table->text('car_drive_user_position')->nullable();//ตำแหน่ง  
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
        Schema::dropIfExists('car_drive');
    }
};
