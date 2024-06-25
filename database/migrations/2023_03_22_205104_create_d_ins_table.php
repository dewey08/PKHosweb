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
        if (!Schema::hasTable('d_ins'))
        {
            Schema::connection('mysql')->create('d_ins', function (Blueprint $table) {
                $table->bigIncrements('d_ins_id');

                $table->string('HN',length: 15)->nullable();//
                $table->string('INSCL',length: 3)->nullable();//
                $table->string('SUBTYPE',length: 2)->nullable();//
                $table->string('CID',length: 16)->nullable();//      
                
                $table->string('HCODE',length: 5)->nullable();// 

                // $table->string('DATEIN',length: 8)->nullable();// 
                $table->string('DATEEXP',length: 8)->nullable();// 
                $table->string('HOSPMAIN',length: 5)->nullable();//  
                $table->string('HOSPSUB',length: 5)->nullable(); //             
                $table->string('GOVCODE',length: 6)->nullable(); //  
                $table->string('GOVNAME',length: 255)->nullable(); // 
                $table->string('PERMITNO',length: 30)->nullable(); // 
                $table->string('DOCNO',length: 30)->nullable(); // 
                $table->string('OWNRPID',length: 13)->nullable(); // 
                $table->string('OWNNAME',length: 255)->nullable(); // 
                $table->string('AN',length: 15)->nullable(); // 
                $table->string('SEQ',length: 15)->nullable(); // 
                $table->string('SUBINSCL',length: 2)->nullable(); // 
                $table->string('RELINSCL',length: 1)->nullable(); // 
                $table->string('HTYPE',length: 1)->nullable(); // 

                // $table->string('DATEIN')->nullable();// 
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
        Schema::dropIfExists('d_ins');
    }
};
