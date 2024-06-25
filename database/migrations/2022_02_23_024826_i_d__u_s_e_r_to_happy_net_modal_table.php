<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IDUSERToHappyNetModalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happy_net_modal', function (Blueprint $table) {
            if(!schema::hasColumn('happy_net_modal','ID_USER')){
      
              
                $table->integer('ID_USER');
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
