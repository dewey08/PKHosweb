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
        if (!Schema::hasTable('ot_two'))
        {
        Schema::create('ot_two', function (Blueprint $table) {
            $table->bigIncrements('ot_two_id'); 
            $table->date('ot_two_date')->nullable();// 
            $table->Time('ot_two_starttime')->nullable();// เวลา   
            $table->Time('ot_two_endtime')->nullable();// เวลา           
            $table->string('ot_two_fullname',255)->nullable();// 
            $table->string('ot_two_detail',255)->nullable();// 
            $table->text('ot_two_sign')->nullable();//     
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
        Schema::dropIfExists('ot_two');
    }
};
