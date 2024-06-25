<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillProductionCancelByToCapyProduction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_production', function (Blueprint $table) {
            if(!schema::hasColumn('cpay_production','PRODUCTION_CANCEL_BY')){
                $table->string('PRODUCTION_CANCEL_BY')->nullable();
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
        Schema::table('capy_production', function (Blueprint $table) {
            //
        });
    }
}
