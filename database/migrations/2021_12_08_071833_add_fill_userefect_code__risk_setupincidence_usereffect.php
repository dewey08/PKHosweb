<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillUserefectCodeRiskSetupincidenceUsereffect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_setupincidence_usereffect', function (Blueprint $table) {
            if(!schema::hasColumn('risk_setupincidence_usereffect','INCEDENCE_USEREFFECT_CODE')){
                $table->string('INCEDENCE_USEREFFECT_CODE')->nullable();
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
        Schema::table('risk_setupincidence_usereffect', function (Blueprint $table) {
            //
        });
    }
}
