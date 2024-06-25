<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayDepartmentSubSubQuotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cpay_department_sub_sub_quota')) {
            Schema::create('cpay_department_sub_sub_quota', function (Blueprint $table) {
            $table->id('DEP_QUOTA_ID');
            $table->bigInteger('CPAY_SET_ID');
            $table->bigInteger('CPAY_DEP_ID');
            $table->integer('DEP_QUOTA_QUANTITY');
            $table->integer('DEP_QUOTA_BALANCE');
            $table->boolean('ACTIVE')->default(TRUE);
            $table->string('UPDATED_BY');
            $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpay_department_sub_sub_quota');
    }
}
