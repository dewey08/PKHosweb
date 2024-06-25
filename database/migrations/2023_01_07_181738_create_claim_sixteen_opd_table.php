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
        if (!Schema::hasTable('claim_sixteen_opd'))
        {
            Schema::create('claim_sixteen_opd', function (Blueprint $table) {
                $table->bigIncrements('claim_sixteen_opd_id');

                $table->string('HN')->nullable();//
                $table->string('CLINIC')->nullable();//
                $table->date('DATEOPD')->nullable();// 
                $table->string('TIMEOPD')->nullable();//  
                $table->string('SEQ')->nullable(); //             
                $table->string('UUC')->nullable(); //           
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
        Schema::dropIfExists('claim_sixteen_opd');
    }
};
