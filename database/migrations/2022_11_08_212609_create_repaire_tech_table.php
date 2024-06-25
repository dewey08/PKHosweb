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
        if (!Schema::hasTable('repaire_tech'))
        {
        Schema::create('repaire_tech', function (Blueprint $table) {
            $table->bigIncrements('repaire_tech_id');    
            $table->text('repaire_tech_user_id')->nullable();//
            $table->text('repaire_tech_user_name')->nullable();// 
            $table->text('repaire_tech_user_position')->nullable();//ตำแหน่ง  
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
        Schema::dropIfExists('repaire_tech');
    }
};
