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
        if (!Schema::hasTable('d_dru_out'))
        {
            Schema::create('d_dru_out', function (Blueprint $table) {
                $table->bigIncrements('d_dru_out_id'); 
                $table->date('vstdate')->nullable();//   
                $table->string('HN')->nullable();//   
                $table->string('PERSON_ID')->nullable();//  
                $table->string('DID')->nullable();// 
                $table->string('DIDNAME')->nullable();//   
                $table->string('AMOUNT')->nullable();//
                $table->string('DRUGPRIC')->nullable();//
                $table->string('DRUGCOST')->nullable();//
                $table->string('DIDSTD')->nullable();//
                $table->string('UNIT')->nullable();//
                $table->string('UNIT_PACK')->nullable();//
                $table->string('SEQ')->nullable();//
                $table->string('DRUGREMARK')->nullable();//
                $table->string('PA_NO')->nullable();// 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_dru_out');
    }
};
