<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillOrgPopularInfoOrg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('info_org', function (Blueprint $table) {
            if (!Schema::hasColumn('info_org', 'ORG_POPULAR'))
            {
                $table->string("ORG_POPULAR",255)->nullable();
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
        Schema::table('info_org', function (Blueprint $table) {
            //
        });
    }
}
