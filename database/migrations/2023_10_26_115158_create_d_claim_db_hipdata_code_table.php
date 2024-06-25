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
        
        if (!Schema::hasTable('d_claim_db_hipdata_code'))
        {
            Schema::connection('mysql')->create('d_claim_db_hipdata_code', function (Blueprint $table) {
                $table->bigIncrements('d_claim_db_hipdata_code_id');
                // $table->string('no',2)->nullable();//
                $table->date('vstdate')->nullable();// 
                $table->string('mo',2)->nullable();//
                $table->string('ye',4)->nullable();// 
                $table->string('vn',255)->nullable();//  
                $table->string('an',255)->nullable();// 
                $table->string('income_vn',255)->nullable();// 
                $table->string('claim_vn',255)->nullable();//   
                $table->string('income_an',255)->nullable();// 
                $table->string('claim_an',255)->nullable();//  
                $table->string('nhso_adp_code',255)->nullable();// 
                $table->string('hipdata_code',255)->nullable();// 
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
        Schema::dropIfExists('d_claim_db_hipdata_code');
    }
};
