<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HAPPYNETSETIDETHICSToHappyNetComplimentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('happy_net_compliment'))
        {
        Schema::table('happy_net_compliment', function (Blueprint $table) {
            if(!schema::hasColumn('happy_net_modal','HAPPY_NET_SET_ID_ETHICS')){
      
                $table->String("HAPPY_NET_SET_ID_ETHICS", 20)->nullable();
         
            }
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
        Schema::table('happy_net_compliment', function (Blueprint $table) {
            //
        });
    }
}
