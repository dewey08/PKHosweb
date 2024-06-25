<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCpayUnitIdToCpaySetequpment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('cpay_setequpment')){
            Schema::table('cpay_setequpment', function (Blueprint $table) {
                if (!Schema::hasColumn('cpay_setequpment', 'CPAY_UNIT_ID'))
                {
                    $table->bigInteger('CPAY_UNIT_ID');
                }
            });
        }
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
