<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableAddcolumnMeetingroomIndexROOMCOLOR extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meetingroom_index',function (Blueprint $table) {
            if (!Schema::hasColumn('meetingroom_index', 'ROOM_COLOR'))
            {
                $table->string("ROOM_COLOR",20)->nullable();
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
        //
    }
}
