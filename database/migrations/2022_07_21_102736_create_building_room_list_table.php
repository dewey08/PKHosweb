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
        if (!Schema::hasTable('building_room_list'))
        {
            Schema::create('building_room_list', function (Blueprint $table) {
                $table->bigIncrements('room_list_id');
                $table->string('room_list_name')->nullable();//รายการ
                $table->string('room_list_qty')->nullable();//จำนวน   
                $table->string('room_id')->nullable();//ห้อง  
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
        Schema::dropIfExists('building_room_list');
    }
};
