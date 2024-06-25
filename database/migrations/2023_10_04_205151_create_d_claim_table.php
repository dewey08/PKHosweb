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
        if (!Schema::hasTable('d_claim'))
        {
            Schema::connection('mysql')->create('d_claim', function (Blueprint $table) { 
                $table->bigIncrements('d_claim_id');//  
                $table->string('vn')->nullable();//   
                $table->string('an')->nullable();//  
                $table->string('hn')->nullable();//  
                $table->string('cid')->nullable();// 
                $table->string('ptname')->nullable();// 
                $table->string('pttype')->nullable();// 
                $table->date('vstdate')->nullable();// 
                $table->date('dchdate')->nullable();// 
                $table->string('hipdata_code')->nullable();//
                $table->string('qty')->nullable();//
                $table->string('sum_price')->nullable();//
                $table->string('type')->nullable();//
                $table->string('userid')->nullable();//
                $table->date('claimdate')->nullable();// 
                $table->enum('active', ['CLAIM','REP','STM','CANCEL','FINISH'])->default('CLAIM')->nullable(); 
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
        Schema::dropIfExists('d_claim');
    }
};
