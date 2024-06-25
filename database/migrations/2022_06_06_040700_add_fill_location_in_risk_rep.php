<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillLocationInRiskRep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep', function (Blueprint $table) {
            //
        });


        Schema::table('risk_rep', function (Blueprint $table) {
            if(!schema::hasColumn('risk_rep','RISKREP_LOCATION_ID')){
                $table->string('RISKREP_LOCATION_ID',250)->nullable();               
            } 
            if(!schema::hasColumn('risk_rep','RISKREP_LOCATION_LEVEL')){
                $table->string('RISKREP_LOCATION_LEVEL',250)->nullable();               
            } 
            if(!schema::hasColumn('risk_rep','RISKREP_LOCATION_LEVEL_ROOM')){
                $table->string('RISKREP_LOCATION_LEVEL_ROOM',250)->nullable();               
            } 
            if(!schema::hasColumn('risk_rep','RISKREP_LOCATION_OTHER')){
                $table->string('RISKREP_LOCATION_OTHER',250)->nullable();               
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
        Schema::table('risk_rep', function (Blueprint $table) {
            //
        });
    }
}
