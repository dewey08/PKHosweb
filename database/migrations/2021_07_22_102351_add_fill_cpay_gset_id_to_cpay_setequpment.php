<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillCpayGsetIdToCpaySetequpment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_setequpment', function (Blueprint $table) {
            if(!schema::hasColumn('cpay_setequpment','CPAY_GSET_ID')){
                $table->bigInteger('CPAY_GSET_ID');
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
        Schema::table('cpay_setequpment', function (Blueprint $table) {
            //
        });
    }
}
