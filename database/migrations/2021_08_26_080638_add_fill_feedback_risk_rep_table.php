<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillFeedbackRiskRepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


  


        Schema::table('risk_rep', function (Blueprint $table) {
           
       
            Schema::table('risk_rep', function (Blueprint $table) {
                if (!Schema::hasColumn('risk_rep', 'RISK_REP_FEEDBACK'))
                {
                    $table->string("RISK_REP_FEEDBACK",500)->nullable();
                }  
            });


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_rep', function (Blueprint $table) {
            //
        });
    }
}
