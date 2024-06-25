<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTableCpayDepartemntSubSubToCpayDepartmentSubSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cpay_department_sub_sub') && Schema::hasTable('cpay_departemnt_sub_sub')) {
            Schema::rename('cpay_departemnt_sub_sub','cpay_department_sub_sub');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpay_department_sub_sub', function (Blueprint $table) {
            //
        });
    }
}
