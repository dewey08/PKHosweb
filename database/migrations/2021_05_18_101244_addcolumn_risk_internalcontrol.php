<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnRiskInternalcontrol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_internalcontrol',function (Blueprint $table) {           
            if (!Schema::hasColumn('risk_internalcontrol', 'INTERNALCONTROL_NO'))
            {
                $table->string("INTERNALCONTROL_NO",255)->nullable();
            } 
            if (!Schema::hasColumn('risk_internalcontrol', 'INTERNALCONTROL_DEP_SUBSUB'))
            {
                $table->string("INTERNALCONTROL_DEP_SUBSUB",255)->nullable();
            } 
            if (!Schema::hasColumn('risk_internalcontrol', 'INTERNALCONTROL_DEP_SUBSUB_NAME'))
            {
                $table->string("INTERNALCONTROL_DEP_SUBSUB_NAME",255)->nullable();
            } 
            if (!Schema::hasColumn('risk_internalcontrol', 'INTERNALCONTROL_USERID'))
            {
                $table->string("INTERNALCONTROL_USERID",255)->nullable();
            } 
            if (!Schema::hasColumn('risk_internalcontrol', 'INTERNALCONTROL_USERNAME'))
            {
                $table->string("INTERNALCONTROL_USERNAME",255)->nullable();
            } 

            if (!Schema::hasColumn('risk_internalcontrol', 'INTERNALCONTROL_LEADER_ID'))
            {
                $table->string("INTERNALCONTROL_LEADER_ID",255)->nullable();
            } 
            if (!Schema::hasColumn('risk_internalcontrol', 'INTERNALCONTROL_LEADER_NAME'))
            {
                $table->string("INTERNALCONTROL_LEADER_NAME",255)->nullable();
            } 

            if (!Schema::hasColumn('risk_internalcontrol', 'updated_at'))
            {
                $table->dateTime("updated_at")->nullable();
            } 
            if (!Schema::hasColumn('risk_internalcontrol', 'created_at'))
            {
                $table->dateTime("created_at")->nullable();
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
