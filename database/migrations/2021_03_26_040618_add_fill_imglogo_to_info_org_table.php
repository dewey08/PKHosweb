<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillImglogoToInfoOrgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('info_org'))
        {
        Schema::table('info_org', function (Blueprint $table) {

            
            $table->binary('img_logo')->nullable();

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
        Schema::table('info_org', function (Blueprint $table) {
            
        });
    }
}
