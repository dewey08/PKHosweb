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
        if (!Schema::hasTable('claim_sixteen_idx'))
        {
            Schema::create('claim_sixteen_idx', function (Blueprint $table) {
                $table->bigIncrements('claim_sixteen_idx_id');
 
                $table->string('AN')->nullable();// 
                $table->string('DIAG')->nullable();// 
                $table->string('DXTYPE')->nullable();//                   
                $table->string('DRDX')->nullable();//   
   
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
        Schema::dropIfExists('claim_sixteen_idx');
    }
};
