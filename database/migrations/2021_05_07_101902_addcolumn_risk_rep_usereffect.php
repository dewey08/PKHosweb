<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnRiskRepUsereffect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep_usereffect',function (Blueprint $table) {
           
            if (!Schema::hasColumn('risk_rep_usereffect', 'RISKREP_ID'))
            {
                $table->string("RISKREP_ID",255)->nullable();
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
        //
    }
}
