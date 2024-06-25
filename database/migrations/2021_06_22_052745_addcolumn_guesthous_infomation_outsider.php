<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnGuesthousInfomationOutsider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guesthous_infomation_outsider',function (Blueprint $table) {           
            if (!Schema::hasColumn('guesthous_infomation_outsider', 'STATUS'))
            {
                $table->enum('STATUS', ['true', 'false'])->default('true');  //สถานะ 
            }                   
        
        });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
