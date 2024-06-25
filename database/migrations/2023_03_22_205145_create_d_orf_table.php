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
        if (!Schema::hasTable('d_orf'))
        {
            Schema::connection('mysql')->create('d_orf', function (Blueprint $table) {
                $table->bigIncrements('d_orf_id');

                $table->string('HN',length: 15)->nullable();// 
                $table->date('DATEOPD')->nullable();//
                $table->string('CLINIC',length: 5)->nullable();//  
                $table->string('REFER',length: 5)->nullable(); //     
                $table->string('REFERTYPE',length: 1)->nullable(); //   
                $table->string('SEQ',length: 15)->nullable(); //  
                $table->date('REFERDATE')->nullable(); // 
                
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
        Schema::dropIfExists('d_orf');
    }
};
