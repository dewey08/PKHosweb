<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillToInfoOrg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('info_org', function (Blueprint $table) {
            if(!schema::hasColumn('info_org','ORG_INITIALS')){
                $table->string('ORG_INITIALS')->nullable();
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
            if(schema::hasColumn('info_org','ORG_INITIALS')){
                $table->dropColumn('ORG_INITIALS');
            }
        });
    }
}
