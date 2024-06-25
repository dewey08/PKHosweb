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
        if (!Schema::hasTable('d_oop'))
        {
            Schema::connection('mysql')->create('d_oop', function (Blueprint $table) {
                $table->bigIncrements('d_oop_id');

                $table->string('HN',length: 15)->nullable();// 
                $table->date('DATEOPD')->nullable();//                  
                $table->string('CLINIC',length: 5)->nullable();//  
                $table->string('OPER',length: 7)->nullable(); //             
                $table->string('DROPID',length: 6)->nullable(); //   
                $table->string('PERSON_ID',length: 13)->nullable(); // 
                $table->string('SEQ',length: 15)->nullable(); // 
                $table->decimal('SERVPRICE', total: 8, places: 2)->nullable(); // 
                
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
        Schema::dropIfExists('d_oop');
    }
};
