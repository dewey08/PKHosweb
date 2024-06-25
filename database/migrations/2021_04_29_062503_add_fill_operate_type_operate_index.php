<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillOperateTypeOperateIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operate_index', function (Blueprint $table) {
            if (!Schema::hasColumn('operate_index', 'OPERATE_TYPE'))
            {
                $table->String("OPERATE_TYPE",10)->nullable();
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
        Schema::table('operate_index', function (Blueprint $table) {
            //
        });
    }
}
