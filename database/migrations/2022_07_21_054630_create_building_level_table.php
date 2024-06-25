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
        if (!Schema::hasTable('building_level'))
        {
        Schema::create('building_level', function (Blueprint $table) {
            $table->bigIncrements('building_level_id');
            $table->string('building_level_name')->nullable();//ชื่อชั้น 
            $table->string('building_id')->nullable();//อาคาร   
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
        Schema::dropIfExists('building_level');
    }
};
