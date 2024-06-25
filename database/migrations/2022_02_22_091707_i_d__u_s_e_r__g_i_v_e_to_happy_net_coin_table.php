<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IDUSERGIVEToHappyNetCoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happy_net_coin', function (Blueprint $table) {
          
            if(!schema::hasColumn('happy_net_coin','ID_USER_GIVE')){
                $table->integer('ID_USER_GIVE');
              
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
        Schema::table('happy_net_coin', function (Blueprint $table) {
            //
        });
    }
}
