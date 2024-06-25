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
        if (!Schema::hasTable('ssop_stm_claim'))
        {
            Schema::connection('mysql7')->create('ssop_stm_claim', function (Blueprint $table) {
                $table->bigIncrements('ssop_stm_claim_id'); 
                $table->string('vn',255)->nullable(); 
                $table->string('hn',255)->nullable(); 
                $table->date('vstdate',255)->nullable(); 
                $table->Time('vsttime',255)->nullable(); 

                $table->string('an',255)->nullable(); 
                $table->string('Pid',255)->nullable(); 
                $table->string('fullname',255)->nullable(); 
              
                $table->string('pttype',255)->nullable(); 
                $table->string('hcode',255)->nullable(); 
                $table->string('pdx',255)->nullable(); 
                $table->string('dx0',255)->nullable(); 
                $table->string('dx1',255)->nullable(); 
                $table->string('dx2',255)->nullable(); 
                $table->string('dx3',255)->nullable(); 
                $table->string('dx4',255)->nullable(); 
                $table->string('dx5',255)->nullable(); 
                $table->string('sex',255)->nullable(); 
                $table->string('uc_money',255)->nullable(); 
                $table->string('hospmain',255)->nullable(); 

                $table->string('icode',255)->nullable(); 
                $table->string('qty',255)->nullable(); 
                $table->string('unitprice',255)->nullable(); 
                $table->string('income',255)->nullable(); 
                $table->string('paidst',255)->nullable(); 
                $table->string('sum_price',255)->nullable(); 
                $table->string('doctorname',255)->nullable(); 
                $table->string('licenseno',255)->nullable();  

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
        Schema::dropIfExists('ssop_stm_claim');
    }
};
