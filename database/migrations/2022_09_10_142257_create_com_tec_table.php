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
        if (!Schema::hasTable('com_tec'))
        {
        Schema::create('com_tec', function (Blueprint $table) {
            $table->bigIncrements('com_tec_id');    
            $table->text('com_tec_user_id')->nullable();//พนักงานขับ
            $table->text('com_tec_user_name')->nullable();//พนักงานขับ
            $table->text('com_tec_user_position')->nullable();//ตำแหน่ง  
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
        Schema::dropIfExists('com_tec');
    }
};
