<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillInternalcontrolLinkRiskInternalcontrol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_internalcontrol', function (Blueprint $table) {
            if (!Schema::hasColumn('risk_internalcontrol', 'INTERNALCONTROL_LINK'))
            {
                $table->string("INTERNALCONTROL_LINK",500)->nullable();
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
        Schema::table('risk_internalcontrol', function (Blueprint $table) {
            //
            
        });
    }
}
