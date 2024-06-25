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
        if (!Schema::hasTable('d_export'))
        {
            Schema::connection('mysql')->create('d_export', function (Blueprint $table) {
                $table->bigIncrements('d_export_id');  
                $table->string('session_no',255)->nullable(); 
                $table->string('session_date',255)->nullable();   
                $table->string('session_time',255)->nullable(); 
                $table->string('session_filename',255)->nullable(); 
                $table->string('session_ststus',255)->nullable(); 
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
        Schema::dropIfExists('d_export');
    }
};
