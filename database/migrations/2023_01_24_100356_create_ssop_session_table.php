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
       
        if (!Schema::hasTable('ssop_session'))
        {
            Schema::connection('mysql')->create('ssop_session', function (Blueprint $table) {
                $table->bigIncrements('ssop_session_id'); 
                $table->string('ssop_session_no')->nullable();// รหัส
                $table->date('ssop_session_date')->nullable();//  
                $table->Time('ssop_session_time')->nullable();//  
                $table->string('ssop_session_filename')->nullable();// 
                $table->string('ssop_session_ststus')->nullable();// 
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
        Schema::dropIfExists('ssop_session');
    }
};
