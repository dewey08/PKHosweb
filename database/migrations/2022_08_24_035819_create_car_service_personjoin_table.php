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
        if (!Schema::hasTable('car_service_personjoin'))
        {
        Schema::create('car_service_personjoin', function (Blueprint $table) {
                $table->bigIncrements('car_service_personjoin_id');  
                $table->string('car_service_id')->nullable();//id main   
                // $table->string('car_service_no')->nullable();
                $table->string('person_join_id',255)->nullable();//ผู้ร่วมเดินทาง 
                $table->string('person_join_name',255)->nullable();//ผู้ร่วมเดินทาง  
               
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
        Schema::dropIfExists('car_service_personjoin');
    }
};
