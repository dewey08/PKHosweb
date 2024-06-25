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
        if (!Schema::hasTable('claim_sixteen_aer'))
        {
            Schema::create('claim_sixteen_aer', function (Blueprint $table) {
                $table->bigIncrements('claim_sixteen_aer_id');
                $table->string('HN')->nullable();//  
                $table->string('AN')->nullable();//  

                $table->date('DATEOPD')->nullable();// 

                $table->string('AUTHAE')->nullable();//  

                $table->date('AEDATE')->nullable();// 
                $table->string('AETIME')->nullable();//  

                $table->string('AETYPE')->nullable(); //  
                $table->string('REFER_NO')->nullable(); // 
                $table->string('REFMAINI')->nullable(); // 
                $table->string('IREFTYPE')->nullable(); // 
                $table->string('REFMAINO')->nullable(); // 
                $table->string('OREFTYPE')->nullable(); // 
                $table->string('UCAE')->nullable(); // 
                $table->string('EMTYPE')->nullable(); // 
                $table->string('SEQ')->nullable(); // 
                $table->string('AESTATUS')->nullable(); // 
                $table->string('DALERT')->nullable(); // 
                $table->string('TALERT')->nullable(); //  
  
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
        Schema::dropIfExists('claim_sixteen_aer');
    }
};
