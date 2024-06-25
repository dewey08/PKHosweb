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
        if (!Schema::hasTable('ot_settingform4'))
        {
        Schema::create('ot_settingform4', function (Blueprint $table) {
            $table->bigIncrements('ot_settingform4_id');   
            $table->date('ot_settingform4_date')->nullable();//   
            $table->string('ot_settingform4_detail')->nullable();//   
            $table->enum('ot_settingform4_active', ['TRUE','FALSE'])->default('TRUE')->nullable();
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
        Schema::dropIfExists('ot_settingform4');
    }
};
