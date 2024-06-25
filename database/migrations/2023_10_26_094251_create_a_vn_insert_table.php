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
        if (!Schema::hasTable('a_vn_insert'))
        {
            Schema::connection('mysql')->create('a_vn_insert', function (Blueprint $table) {
                // $table->bigIncrements('a_vn_insert_id');
                $table->string('vn',13)->nullable();//
                $table->string('clinic_list',150)->nullable();// 
                $table->char('hos_guid',38)->nullable();//  
                // $table->timestamps();
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
        Schema::dropIfExists('a_vn_insert');
    }
};
