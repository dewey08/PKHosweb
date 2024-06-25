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
        if (!Schema::hasTable('claim_sixteen_dru'))
        {
            Schema::create('claim_sixteen_dru', function (Blueprint $table) {
                $table->bigIncrements('claim_sixteen_dru_id');

                $table->string('HCODE')->nullable();// 
                $table->string('HN')->nullable();// 
                $table->string('AN')->nullable();// 
                $table->string('CLINIC')->nullable();// 
                $table->string('PERSON_ID')->nullable();// 

                $table->date('DATE_SERV')->nullable();// 
                 
                $table->string('DID')->nullable();//  
                $table->string('DIDNAME')->nullable(); //   
                $table->string('AMOUNT')->nullable(); // 
                $table->string('DRUGPRIC')->nullable(); // 
                $table->string('DRUGCOST')->nullable(); //

                $table->string('DIDSTD')->nullable(); //
                $table->string('UNIT')->nullable(); //
                $table->string('UNIT_PACK')->nullable(); //
                $table->string('SEQ')->nullable(); //
                $table->string('DRUGREMARK')->nullable(); //
                $table->string('PA_NO')->nullable(); //
                $table->string('TOTCOPAY')->nullable(); //
                $table->string('USE_STATUS')->nullable(); //
                $table->string('STATUS1')->nullable(); //
                $table->string('TOTAL')->nullable(); //
                $table->string('a1')->nullable(); //
                $table->string('a2')->nullable(); // 
   
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
        Schema::dropIfExists('claim_sixteen_dru');
    }
};
