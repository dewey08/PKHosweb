<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillBookLinkInGbookIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gbook_index', function (Blueprint $table) {
            if(!schema::hasColumn('gbook_index','BOOK_LINK')){
                $table->string('BOOK_LINK',600)->nullable();
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
        Schema::table('gbook_index', function (Blueprint $table) {
            //
        });
    }
}
