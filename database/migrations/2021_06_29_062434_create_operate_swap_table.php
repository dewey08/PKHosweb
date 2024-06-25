<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperateSwapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
  
        if (!Schema::hasTable('operate_swap'))
        {
        Schema::create('operate_swap', function (Blueprint $table) {
            $table->id("OPSWAP_ID",11);
            $table->String("OPSWAP_DEP",255)->nullable(); 
            $table->String("OPSWAP_DEP_NAME",255)->nullable(); 
            $table->String("OPSWAP_PERSON_1",255)->nullable();  
            $table->String("OPSWAP_PERSON_1_NAME",255)->nullable(); 
            $table->String("OPSWAP_PERSON_2",255)->nullable(); 
            $table->String("OPSWAP_PERSON_2_NAME",255)->nullable(); 
            $table->date("OPSWAP_DATE_1")->nullable(); 
            $table->String("OPSWAP_JOB_1",255)->nullable();
            $table->String("OPSWAP_REMARK",500)->nullable();
            $table->date("OPSWAP_DATE_2")->nullable();
            $table->String("OPSWAP_JOB_2",500)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
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
        Schema::dropIfExists('operate_swap');
    }
}
