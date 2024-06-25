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
        if (!Schema::hasTable('acc_stm_repmoney_file'))
        {
            Schema::connection('mysql')->create('acc_stm_repmoney_file', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_repmoney_file_id');
                $table->string('acc_stm_repmoney_id')->nullable();//
                $table->binary('file')->nullable();// 
                $table->string('filename')->nullable();// 
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
        Schema::dropIfExists('acc_stm_repmoney_file');
    }
};
