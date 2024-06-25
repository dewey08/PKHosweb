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
        if (!Schema::hasTable('fdh_pat'))
        {
            Schema::connection('mysql')->create('fdh_pat', function (Blueprint $table) {
                $table->bigIncrements('fdh_pat_id');

                $table->string('HCODE',5)->nullable();//
                $table->string('HN',15)->nullable();//
                $table->string('CHANGWAT',2)->nullable();//
                $table->string('AMPHUR',2)->nullable();//
                $table->string('DOB',8)->nullable();//                  
                $table->string('SEX',1)->nullable();//  
                $table->string('MARRIAGE',1)->nullable(); //             
                $table->string('OCCUPA',3)->nullable(); //  
                $table->string('NATION',3)->nullable(); // 
                $table->string('PERSON_ID',13)->nullable(); // 
                $table->string('NAMEPAT',36)->nullable(); // 
                $table->string('TITLE',30)->nullable(); // 
                $table->string('FNAME',40)->nullable(); // 
                $table->string('LNAME',40)->nullable(); // 
                $table->string('IDTYPE',1)->nullable(); // 

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
        Schema::dropIfExists('fdh_pat');
    }
};
