<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddFillHrSoiName1ToHrdPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::table('hrd_person')->where('HR_STARTWORK_DATE','0000-00-00')->update(['HR_STARTWORK_DATE'=>'1970-01-01']);
        Schema::table('hrd_person', function (Blueprint $table) {
            if(!schema::hasColumn('hrd_person','HR_SOI_NAME_1')){
                $table->string('HR_SOI_NAME_1',45)->nullable();
            }
            if(!schema::hasColumn('hrd_person','HR_SOI_NAME_2')){
                $table->string('HR_SOI_NAME_2',45)->nullable();
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
        Schema::table('hrd_person', function (Blueprint $table) {
            //
        });
    }
}
