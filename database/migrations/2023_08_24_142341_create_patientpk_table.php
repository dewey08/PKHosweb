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
        if (!Schema::hasTable('patientpk'))
        {
            Schema::connection('mysql')->create('patientpk', function (Blueprint $table) {
                $table->bigIncrements('patientpk_id');
                $table->string('patientpk_name')->nullable();//
                $table->string('patientpk_email')->nullable();//  
                $table->string('patientpk_subject')->nullable();// 
                $table->string('patientpk_message')->nullable();// 
                $table->Date('patientpk_date')->nullable();// 
                $table->enum('active', ['Y','N'])->default('N')->nullable(); 
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
        Schema::dropIfExists('patientpk');
    }
};
