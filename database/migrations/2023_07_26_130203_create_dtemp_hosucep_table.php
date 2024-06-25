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
        if (!Schema::connection('mysql7')->hasTable('dtemp_hosucep'))
        {
            Schema::connection('mysql7')->create('dtemp_hosucep', function (Blueprint $table) {
                $table->bigIncrements('dtemp_hosucep_id'); 
                $table->string('an')->nullable();// 
                $table->string('hn')->nullable();//  
                $table->string('icode')->nullable();// 
                $table->date('rxdate')->nullable();//  
                $table->date('vstdate')->nullable();//  
                $table->string('rxtime')->nullable();//  
                $table->string('vsttime')->nullable(); //   
                $table->string('date_x')->nullable(); //
                $table->string('time_x')->nullable(); //
                
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
        Schema::dropIfExists('dtemp_hosucep');
    }
};
