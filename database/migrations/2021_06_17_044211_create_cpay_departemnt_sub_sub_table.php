<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayDepartemntSubSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cpay_departemnt_sub_sub')) {
            Schema::create('cpay_departemnt_sub_sub', function (Blueprint $table) {
                $table->increments('CPAY_DEP_ID');
                $table->integer('HR_DEPARTMENT_SUB_SUB_ID')->comment("FK =>hrd_department_sub_sub['HR_DEPARTMENT_SUB_SUB_ID']");
                $table->string('DEP_CODE',10)->nullable()->comment("ref =>hrd_department_sub_sub['DEP_CODE']");
                $table->string('CPAY_DEP_NAME_INSIDE',255);
                $table->string('CPAY_DEP_NAME_TH',255)->nullable();
                $table->string('CPAY_DEP_NAME_EN',255)->nullable();
                $table->text('CPAY_DEP_DETAIL')->nullable();
                $table->boolean('ACTIVE')->default(true);
                $table->string('UPDATED_BY',255);
                $table->timestamps();
            });
        }else{
            echo 'มีตารางนี้แล้ว : cpay_departemnt_sub_sub  //';
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpay_departemnt_sub_sub');
    }
}
