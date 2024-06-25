<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillLocationNameInRiskSetupincidenceOrigin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('risk_setupincidence_origin', function (Blueprint $table) {
            if(!schema::hasColumn('risk_setupincidence_origin','LOCATION_NAME')){
                $table->string('LOCATION_NAME',600)->nullable();
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
        Schema::table('risk_setupincidence_origin', function (Blueprint $table) {
            //
        });
    }
}
