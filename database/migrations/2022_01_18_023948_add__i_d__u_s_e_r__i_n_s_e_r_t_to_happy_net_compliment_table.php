<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIDUSERINSERTToHappyNetComplimentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('happy_net_compliment', function (Blueprint $table) {
            if(!schema::hasColumn('happy_net_compliment','ID_USER_INSERT')){
                $table->integer('ID_USER_INSERT');
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
        Schema::table('happy_net_compliment', function (Blueprint $table) {
            //
        });
        
    }
}
