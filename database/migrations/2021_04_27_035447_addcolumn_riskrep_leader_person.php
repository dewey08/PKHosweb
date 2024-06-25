<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnRiskrepLeaderPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep', function (Blueprint $table) {
            if (!Schema::hasColumn('risk_rep', 'LEADER_PERSON_ID'))
            {
                $table->string("LEADER_PERSON_ID",11)->nullable();
            }   
            if (!Schema::hasColumn('risk_rep', 'LEADER_PERSON_NAME'))
            {
                $table->string("LEADER_PERSON_NAME",255)->nullable();
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
            
        });
    }
}
