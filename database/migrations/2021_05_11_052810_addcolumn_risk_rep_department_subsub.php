<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnRiskRepDepartmentSubsub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_rep_department_subsub',function (Blueprint $table) {           
            if (!Schema::hasColumn('risk_rep_department_subsub', 'RISKREP_ID'))
            {
                $table->string("RISKREP_ID",11)->nullable();
            } 
            if (!Schema::hasColumn('risk_rep_department_subsub', 'HR_DEPARTMENT_SUB_SUB_ID'))
            {
                $table->string("HR_DEPARTMENT_SUB_SUB_ID",11)->nullable();
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
