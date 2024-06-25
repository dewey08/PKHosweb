<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillCpaySetNameToCpayDefectiveList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_defective_list', function (Blueprint $table) {
            if(!schema::hasColumn('cpay_defective_list','CPAY_SET_NAME')){
                $table->string('CPAY_SET_NAME');
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
        Schema::table('cpay_defective_list', function (Blueprint $table) {
            //
        });
    }
}
