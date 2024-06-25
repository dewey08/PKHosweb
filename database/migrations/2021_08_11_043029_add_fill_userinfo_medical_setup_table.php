<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddFillUserinfoMedicalSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        Schema::table('medical_setup', function (Blueprint $table) {
            if (Schema::hasColumn('medical_setup', 'SETUP_DATE_WANT_USE'))
            {
                $table->date("SETUP_DATE_WANT_USE")->nullable()->change();
            } 
            if (Schema::hasColumn('medical_setup', 'created_at'))
            {
                $table->dateTime("created_at")->nullable()->change();
            } 
            if (Schema::hasColumn('medical_setup', 'updated_at'))
            {
                $table->dateTime("updated_at")->nullable()->change();
            }  
        });
        
        Schema::table('medical_setup', function (Blueprint $table) {
            if (!Schema::hasColumn('medical_setup', 'USE_INFO'))
            {
                $table->string("USE_INFO",10)->nullable();
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
        Schema::table('medical_setup', function (Blueprint $table) {
            //
        });
    }
}
