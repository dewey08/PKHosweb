<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        if (!Schema::hasTable('fdh_ins'))
        {
            Schema::connection('mysql')->create('fdh_ins', function (Blueprint $table) {
                $table->bigIncrements('fdh_ins_id');

                $table->string('HN', 15)->nullable();//
                $table->string('INSCL',3)->nullable();//
                $table->string('SUBTYPE', 2)->nullable();//
                $table->string('CID',16)->nullable();//  
                $table->string('HCODE',5)->nullable();// 

                // $table->string('DATEIN', 8)->nullable();//   

                $table->string('DATEEXP', 8)->nullable();// 
                $table->string('HOSPMAIN', 5)->nullable();//  
                $table->string('HOSPSUB',5)->nullable(); //             
                $table->string('GOVCODE', 6)->nullable(); //    
                $table->string('GOVNAME',255)->nullable(); // 
                $table->string('PERMITNO', 30)->nullable(); // 
                $table->string('DOCNO', 30)->nullable(); // 
                $table->string('OWNRPID', 13)->nullable(); // 
                $table->string('OWNNAME', 255)->nullable(); // 
                $table->string('AN', 15)->nullable(); // 
                $table->string('SEQ',15)->nullable(); // 
                $table->string('SUBINSCL', 2)->nullable(); // 
                $table->string('RELINSCL', 1)->nullable(); // 
                $table->string('HTYPE', 1)->nullable(); // 
 
                $table->string('d_anaconda_id')->nullable(); // 
                $table->string('user_id')->nullable(); //  
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fdh_ins');
    }
};
