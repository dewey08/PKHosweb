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
        if (!Schema::hasTable('d_irf'))
        {
            Schema::connection('mysql')->create('d_irf', function (Blueprint $table) {
                $table->bigIncrements('d_irf_id');
 
                $table->string('AN',length: 15)->nullable();//  
                $table->string('REFER',length: 5)->nullable();//  
                $table->string('REFERTYPE',length: 1)->nullable(); //  
                
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
        Schema::dropIfExists('d_irf');
    }
};
