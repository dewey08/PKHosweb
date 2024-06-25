<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HAPPYNETMODALTYPEToHappyNetModalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happy_net_modal', function (Blueprint $table) {
            if(!schema::hasColumn('happy_net_modal','HAPPY_NET_MODAL_TYPE')){
      
                $table->String("HAPPY_NET_MODAL_TYPE", 350)->nullable();
         
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
        Schema::table('happy_net_modal', function (Blueprint $table) {
            //
        });
    }
}
