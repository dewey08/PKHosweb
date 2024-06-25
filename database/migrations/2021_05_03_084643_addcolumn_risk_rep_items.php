<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnRiskRepItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep_items',function (Blueprint $table) {
            if (!Schema::hasColumn('risk_rep_items', 'RISK_GROUP_ID'))
            {
                $table->string("RISK_GROUP_ID",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep_items', 'RISK_GROUPSUB_ID'))
            {
                $table->string("RISK_GROUPSUB_ID",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep_items', 'RISK_GROUPSUBSUB_ID'))
            {
                $table->string("RISK_GROUPSUBSUB_ID",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep_items', 'RISK_REPDETAIL_ID'))
            {
                $table->string("RISK_REPDETAIL_ID",255)->nullable();
            }
            if (!Schema::hasColumn('risk_rep_items', 'RISK_REPITEMS_COMMENT'))
            {
                $table->string("RISK_REPITEMS_COMMENT",255)->nullable();
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
