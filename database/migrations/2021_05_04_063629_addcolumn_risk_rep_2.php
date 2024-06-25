<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnRiskRep2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep',function (Blueprint $table) {
            if (!Schema::hasColumn('risk_rep', 'RISK_REPPROGRAM_ID'))
            {
                $table->string("RISK_REPPROGRAM_ID",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISK_REPPROGRAMSUB_ID'))
            {
                $table->string("RISK_REPPROGRAMSUB_ID",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISK_REPPROGRAMSUBSUB_ID'))
            {
                $table->string("RISK_REPPROGRAMSUBSUB_ID",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISK_REPTYPERESON_ID'))
            {
                $table->string("RISK_REPTYPERESON_ID",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISK_REPTYPERESONSYS_ID'))
            {
                $table->string("RISK_REPTYPERESONSYS_ID",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISKREP_DETAILRISK'))
            {
                $table->string("RISKREP_DETAILRISK",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISKREP_DETAILRISK2'))
            {
                $table->string("RISKREP_DETAILRISK2",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISK_REPITEMS_ID'))
            {
                $table->string("RISK_REPITEMS_ID",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep', 'RISK_REPITEMSSUB_ID'))
            {
                $table->string("RISK_REPITEMSSUB_ID",255)->nullable();
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
