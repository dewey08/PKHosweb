<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillInActiveSalaryPayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_pay', function (Blueprint $table) {
            if (!Schema::hasColumn('salary_pay', 'ACTIVE'))
            {
                $table->enum('ACTIVE', ['TRUE', 'FALSE']);
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
        Schema::table('salary_pay', function (Blueprint $table) {
            //
        });
    }
}
