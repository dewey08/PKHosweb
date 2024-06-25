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
        if (!Schema::hasTable('claim_sixteen_orf'))
        {
            Schema::create('claim_sixteen_orf', function (Blueprint $table) {
                $table->bigIncrements('claim_sixteen_orf_id');

                $table->string('HN')->nullable();// 
                $table->date('DATEOPD')->nullable();// 
                 
                $table->string('CLINIC')->nullable();//  
                $table->string('REFER')->nullable(); //             
                $table->string('REFERTYPE')->nullable(); //  
                $table->string('SEQ')->nullable(); //  
                 
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
        Schema::dropIfExists('claim_sixteen_orf');
    }
};
