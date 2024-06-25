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
        if (!Schema::hasTable('claim_ssop'))
        {
            Schema::connection('mysql')->create('claim_ssop', function (Blueprint $table) {
                $table->bigIncrements('claim_ssop_id');
                $table->string('session_id')->nullable();//  
                $table->date('sss_date')->nullable();//  
                $table->Time('sss_time')->nullable(); // 
                $table->string('station')->nullable(); // 
   
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
        Schema::dropIfExists('claim_ssop');
    }
};
