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
        if (!Schema::hasTable('d_aer'))
        {
            Schema::connection('mysql')->create('d_aer', function (Blueprint $table) {
                $table->bigIncrements('d_aer_id');
                
                $table->string('HN',length: 15)->nullable();//  
                $table->string('AN',length: 15)->nullable();//  
                $table->date('DATEOPD')->nullable();// 
                $table->string('AUTHAE',length: 12)->nullable();//  
                $table->date('AEDATE')->nullable();// 
                $table->string('AETIME',length: 4)->nullable();//  
                $table->string('AETYPE',length: 1)->nullable(); //  
                $table->string('REFER_NO',length: 20)->nullable(); // 
                $table->string('REFMAINI',length: 5)->nullable(); // 
                $table->string('IREFTYPE',length: 4)->nullable(); // 
                $table->string('REFMAINO',length: 5)->nullable(); // 
                $table->string('OREFTYPE',length: 4)->nullable(); // 
                $table->string('UCAE',length: 1)->nullable(); // 
                $table->string('EMTYPE',length: 1)->nullable(); // 
                $table->string('SEQ',length: 15)->nullable(); // 
                $table->string('AESTATUS',length: 1)->nullable(); // 
                $table->date('DALERT')->nullable(); // 
                $table->string('TALERT',length: 4)->nullable(); // 

                $table->string('d_anaconda_id')->nullable(); // 
                $table->string('user_id')->nullable(); //  
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
        Schema::dropIfExists('d_aer');
    }
};
