<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillBorrowDateAmountInSalaryborrow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_borrow', function (Blueprint $table) {
           
            if (!Schema::hasColumn('salary_borrow', 'BORROW_DATE_AMOUNT'))
            {
                $table->string("BORROW_DATE_AMOUNT",20)->nullable();
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
        Schema::table('salary_borrow', function (Blueprint $table) {
            //
        });
    }
}
