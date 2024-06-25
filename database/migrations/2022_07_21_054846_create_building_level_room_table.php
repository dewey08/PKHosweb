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
        if (!Schema::hasTable('building_level_room'))
        {
            Schema::create('building_level_room', function (Blueprint $table) {
                $table->bigIncrements('room_id');
                $table->string('room_name')->nullable();//ชื่อห้อง
                $table->string('building_level_id')->nullable();//ชั้น   
                $table->string('room_type')->nullable();//ประเภทห้อง  
                $table->string('room_amount')->nullable();//ความจุ
                $table->string('room_user_id')->nullable();//ผู้ดูแล
                $table->string('room_user_name')->nullable();//ผู้ดูแล
                $table->binary('room_img')->nullable();//รูป
                $table->string('room_img_name')->nullable();//รูป
                $table->string('room_status')->nullable();//สถานะ
                $table->string('room_color')->nullable();//สี
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
        Schema::dropIfExists('building_level_room');
    }
};
