<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFillToCpayMachineMaintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_machine_maintenance', function (Blueprint $table) {
            if(schema::hasColumn('cpay_machine_maintenance','MMAINTeNANCE_ID')){
                $table->renameColumn('MMAINTeNANCE_ID','MMAINTENANCE_ID');
            }

            if(schema::hasColumn('cpay_machine_maintenance','MMAINTeNANCE_TEST_DATE')){
                $table->renameColumn('MMAINTeNANCE_TEST_DATE','MMAINTENANCE_TEST_DATE');
                $table->date('MMAINTENANCE_TEST_DATE')->change();
            }
            
            if(schema::hasColumn('cpay_machine_maintenance','MMAINTeNANCE_RESULT')){
                $table->renameColumn('MMAINTeNANCE_RESULT','MMAINTENANCE_RESULT');
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
        Schema::table('cpay_machine_maintenance', function (Blueprint $table) {
            //
        });
    }
}
