<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFillToCpaySetequpmentSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_setequpment_sub', function (Blueprint $table) {
            if(schema::hasColumn('cpay_setequpment_sub','STORE_ID')){
                $table->integer('STORE_ID')->nullable()->comment('ไม่ได้ใช้แล้ว')->change();
            }
            if(schema::hasColumn('cpay_setequpment_sub','STORE_CODE')){
                $table->string('STORE_CODE',100)->nullable()->comment('ไม่ได้ใช้แล้ว')->change();
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
        Schema::table('cpay_setequpment_sub', function (Blueprint $table) {
            //
        });
    }
}
