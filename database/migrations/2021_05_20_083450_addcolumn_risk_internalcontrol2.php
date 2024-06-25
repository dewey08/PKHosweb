<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnRiskInternalcontrol2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_internalcontrol',function (Blueprint $table) {           
            if (!Schema::hasColumn('risk_internalcontrol', 'INTERNALCONTROL_STATUS'))
            {
                $table->string("INTERNALCONTROL_STATUS",255)->nullable();
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
