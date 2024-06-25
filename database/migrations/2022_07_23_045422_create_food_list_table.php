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
        if (!Schema::hasTable('food_list'))
        {
            Schema::create('food_list', function (Blueprint $table) {
                $table->bigIncrements('food_list_id');
                $table->string('food_list_name')->nullable();//รายการ
                $table->string('food_list_img')->nullable();//ภาพ    
                $table->string('food_list_qty')->nullable();//จำนวน 
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
        Schema::dropIfExists('food_list');
    }
};
