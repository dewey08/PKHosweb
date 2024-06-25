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
        if (!Schema::hasTable('aipn_session'))
        {
            Schema::connection('mysql')->create('aipn_session', function (Blueprint $table) {
                $table->bigIncrements('aipn_session_id'); 
                $table->string('aipn_session_no')->nullable();// รหัส
                $table->date('aipn_session_date')->nullable();//  
                $table->Time('aipn_session_time')->nullable();//  
                $table->string('aipn_session_filename')->nullable();// 
                $table->string('aipn_session_ststus')->nullable();// 
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
        Schema::dropIfExists('aipn_session');
    }
};
