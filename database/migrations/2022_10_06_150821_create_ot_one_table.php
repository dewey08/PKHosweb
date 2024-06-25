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
        if (!Schema::hasTable('ot_one'))
        {
        Schema::create('ot_one', function (Blueprint $table) {
            $table->bigIncrements('ot_one_id'); 
            $table->date('ot_one_date')->nullable();// 
            $table->Time('ot_one_starttime')->nullable();// เวลา   
            $table->Time('ot_one_endtime')->nullable();// เวลา           
            $table->string('ot_one_nameid',10)->nullable();// 
            $table->string('ot_one_type',10)->nullable();// 
            $table->string('ot_one_fullname',255)->nullable();// 
            $table->string('ot_one_detail',255)->nullable();// 
            $table->text('ot_one_sign')->nullable();//     
            $table->text('ot_one_sign2')->nullable();// 
            $table->string('ot_one_total',255)->nullable();//  
            $table->string('dep_subsubtrueid',10)->nullable();//  
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
        Schema::dropIfExists('ot_one');
    }
};
