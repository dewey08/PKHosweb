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
        if (!Schema::hasTable('claim_sixteen_irf'))
        {
            Schema::create('claim_sixteen_irf', function (Blueprint $table) {
                $table->bigIncrements('claim_sixteen_irf_id');
 
                $table->string('AN')->nullable();//  
                $table->string('REFER')->nullable();//  
                $table->string('REFERTYPE')->nullable(); //   
 
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
        Schema::dropIfExists('claim_sixteen_irf');
    }
};
