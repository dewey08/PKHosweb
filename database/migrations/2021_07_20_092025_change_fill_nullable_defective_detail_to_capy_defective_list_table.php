<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFillNullableDefectiveDetailToCapyDefectiveListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_defective_list', function (Blueprint $table) {
            if(Schema::hasColumn('cpay_defective_list','DEFECTIVE_DETAIL')){
                $table->string('DEFECTIVE_DETAIL')->nullable()->change();
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
        Schema::table('capy_defective_list', function (Blueprint $table) {
            //
        });
    }
}
