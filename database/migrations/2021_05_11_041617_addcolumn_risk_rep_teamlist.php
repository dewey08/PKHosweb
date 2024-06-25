<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnRiskRepTeamlist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep_teamlist',function (Blueprint $table) {
            if (!Schema::hasColumn('risk_rep_teamlist', 'RISK_REP_TEAMLIST_CODE'))
            {
                $table->string("RISK_REP_TEAMLIST_CODE",100)->nullable();
            } 
            if (!Schema::hasColumn('risk_rep_teamlist', 'RISKREP_ID'))
            {
                $table->string("RISKREP_ID",11)->nullable();
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
