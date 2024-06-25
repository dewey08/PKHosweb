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
        if (!Schema::hasTable('d_pat'))
        {
            Schema::connection('mysql')->create('d_pat', function (Blueprint $table) {
                $table->bigIncrements('d_pat_id');

                $table->string('HCODE',length: 5)->nullable();//
                $table->string('HN',length: 15)->nullable();//
                $table->string('CHANGWAT',length: 2)->nullable();//
                $table->string('AMPHUR',length: 2)->nullable();//
                $table->date('DOB')->nullable();//                  
                $table->string('SEX',length: 1)->nullable();//  
                $table->string('MARRIAGE',length: 1)->nullable(); //             
                $table->string('OCCUPA',length: 3)->nullable(); //  
                $table->string('NATION',length: 3)->nullable(); // 
                $table->string('PERSON_ID',length: 13)->nullable(); // 
                $table->string('NAMEPAT',length: 36)->nullable(); // 
                $table->string('TITLE',length: 30)->nullable(); // 
                $table->string('FNAME',length: 40)->nullable(); // 
                $table->string('LNAME',length: 40)->nullable(); // 
                $table->string('IDTYPE',length: 1)->nullable(); // 

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
        Schema::dropIfExists('d_pat');
    }
};
