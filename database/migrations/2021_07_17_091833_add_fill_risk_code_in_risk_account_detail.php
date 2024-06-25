<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillRiskCodeInRiskAccountDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_account_detail', function (Blueprint $table) {
            if(!schema::hasColumn('risk_account_detail','RISK_CODE')){
                $table->string('RISK_CODE')->nullable();
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
        Schema::table('risk_account_detail', function (Blueprint $table) {
            //
        });
    }
}
