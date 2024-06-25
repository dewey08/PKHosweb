<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillLEAVEAPPSENDInGleaveRegister extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gleave_register', function (Blueprint $table) {

            if(!schema::hasColumn('gleave_register','LEAVE_APP_SEND')){
                $table->string('LEAVE_APP_SEND',50)->nullable();
                
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
        Schema::table('gleave_register', function (Blueprint $table) {
            //
        });
    }
}
