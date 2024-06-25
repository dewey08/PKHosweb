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
        if (!Schema::hasTable('meeting_list'))
        {
            Schema::create('meeting_list', function (Blueprint $table) {
                $table->bigIncrements('meeting_list_id');
                $table->string('meeting_list_name')->nullable();//รายการ
                $table->string('meeting_list_img')->nullable();//ภาพ    
                $table->string('meeting_list_qty')->nullable();//จำนวน 
                $table->string('room_id')->nullable();// 
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
        Schema::dropIfExists('meeting_list');
    }
};
