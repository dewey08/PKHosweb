<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnRiskRep4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep',function (Blueprint $table) {
           
            if (!Schema::hasColumn('risk_rep', 'RISKREP_TYPESUBSUB_NAME'))
            {
                $table->string("RISKREP_TYPESUBSUB_NAME",255)->nullable();
            }  
            if (!Schema::hasColumn('risk_rep', 'RISKREP_TYPESUBSUB_ID'))
            {
                $table->string("RISKREP_TYPESUBSUB_ID",255)->nullable();
            }  
            if (!Schema::hasColumn('risk_rep', 'RISKREP_TYPEDEP_ID'))
            {
                $table->string("RISKREP_TYPEDEP_ID",255)->nullable();
            }   
            if (!Schema::hasColumn('risk_rep', 'RISKREP_TEAM_ID'))
            {
                $table->string("RISKREP_TEAM_ID",255)->nullable();
            }  if (!Schema::hasColumn('risk_rep', 'RISKREP_TEAM_CODE'))
            {
                $table->string("RISKREP_TEAM_CODE",255)->nullable();
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
