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
        if (!Schema::hasTable('claim_temp_ssop'))
        {
            Schema::create('claim_temp_ssop', function (Blueprint $table) {
                $table->bigIncrements('claim_temp_ssop_id');
                $table->string('HN')->nullable();//  
                $table->string('AN')->nullable();//  
                $table->string('SEQ')->nullable(); // 
                $table->string('CID')->nullable(); // 
 
                $table->string('CHECK')->nullable();//  
                $table->string('STATUS')->nullable();// 
  
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
        Schema::dropIfExists('claim_temp_ssop');
    }
};
