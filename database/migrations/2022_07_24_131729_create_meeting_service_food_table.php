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
        if (!Schema::hasTable('meeting_service_food'))
        {
            Schema::create('meeting_service_food', function (Blueprint $table) {
                $table->bigIncrements('meeting_service_food_id');
                $table->string('food_list_id')->nullable();//
                $table->string('food_list_name')->nullable();//
                $table->string('meeting_service_food_qty')->nullable();// 
                $table->string('meeting_id')->nullable();//
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
        Schema::dropIfExists('meeting_service_food');
    }
};
