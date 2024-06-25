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
        if (!Schema::hasTable('d_ipd'))
        {
            Schema::connection('mysql')->create('d_ipd', function (Blueprint $table) {
                $table->bigIncrements('d_ipd_id');

                $table->string('HN',length: 15)->nullable();// 
                $table->string('AN',length: 15)->nullable();// 
                $table->date('DATEADM')->nullable();// 
                $table->string('TIMEADM',length: 4)->nullable();//  
                $table->date('DATEDSC')->nullable();// 
                $table->string('TIMEDSC',length: 4)->nullable();//  
                $table->string('DISCHS',length: 1)->nullable();//  
                $table->string('DISCHT',length: 1)->nullable(); //   
                $table->string('WARDDSC',length: 4)->nullable(); //  
                $table->string('DEPT',length: 2)->nullable(); //  
                $table->decimal('ADM_W', total: 5, places: 2)->nullable(); // 
                $table->string('UUC',length: 1)->nullable(); // 
                $table->string('SVCTYPE',length: 1)->nullable(); // 

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
        Schema::dropIfExists('d_ipd');
    }
};
