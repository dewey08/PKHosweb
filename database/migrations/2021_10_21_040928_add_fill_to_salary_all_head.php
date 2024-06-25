<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillToSalaryAllHead extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_all_head', function (Blueprint $table) {
            if(!schema::hasColumn('salary_all_head','SALARYALL_IS_SENDED')){
                $table->boolean('SALARYALL_IS_SENDED')->nullable()->default(0);
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
        Schema::table('salary_all_head', function (Blueprint $table) {
            //
        });
    }
}
