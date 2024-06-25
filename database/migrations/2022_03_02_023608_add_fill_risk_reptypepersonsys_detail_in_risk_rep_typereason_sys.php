<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillRiskReptypepersonsysDetailInRiskRepTypereasonSys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep_typereason_sys', function (Blueprint $table) {
            if(!schema::hasColumn('risk_rep_typereason_sys','RISK_REPTYPERESONSYS_DETAIL')){
                $table->string('RISK_REPTYPERESONSYS_DETAIL',250)->nullable();               
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
        Schema::table('risk_rep_typereason_sys', function (Blueprint $table) {
            //
        });
    }
}
