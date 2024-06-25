<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillDefectiveCancelByADetailsToCpayDefectiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_defective', function (Blueprint $table) {
            if(!schema::hasColumn('cpay_defective','DEFECTIVE_CANCEL_BY')){
                $table->text('DEFECTIVE_CANCEL_BY')->nullable();
            }
            if(!schema::hasColumn('cpay_defective','DEFECTIVE_DETAILS')){
                $table->text('DEFECTIVE_DETAILS')->nullable();
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
        Schema::table('cpay_defective', function (Blueprint $table) {
            //
        });
    }
}
