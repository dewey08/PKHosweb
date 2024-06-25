<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillRiskrepLocaluseInRiskRep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep', function (Blueprint $table) {
            if(!schema::hasColumn('risk_rep','RISKREP_LOCALUSE')){
                $table->string('RISKREP_LOCALUSE')->nullable();
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
