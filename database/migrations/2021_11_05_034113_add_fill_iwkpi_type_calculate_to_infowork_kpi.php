<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillIwkpiTypeCalculateToInfoworkKpi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('infowork_kpi', function (Blueprint $table) {
            if(!schema::hasColumn('IWKPI_TYPE_CALCULATE','infowork_kpi')){
                $table->string('IWKPI_TYPE_CALCULATE');
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
        Schema::table('infowork_kpi', function (Blueprint $table) {
            //
        });
    }
}
