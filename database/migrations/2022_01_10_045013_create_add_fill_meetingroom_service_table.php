<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddFillMeetingroomServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('meetingroom_service', function (Blueprint $table) {
            if(!schema::hasColumn('meetingroom_service', 'ROOM_STYLEROOM_ID')){
                $table->string('ROOM_STYLEROOM_ID')->nullable();
            }
            if(!schema::hasColumn('meetingroom_service', 'ROOM_STYLEROOM_NAME')){
                $table->string('ROOM_STYLEROOM_NAME')->nullable();
            }
            if(!schema::hasColumn('meetingroom_service', 'ROOM_STYLEROOM_IMAGE')){
                $table->string('ROOM_STYLEROOM_IMAGE')->nullable();
            }
            if(!schema::hasColumn('meetingroom_service', 'ROOM_STYLEROOM_DETAIL')){
                $table->string('ROOM_STYLEROOM_DETAIL')->nullable();
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
        Schema::dropIfExists('add_fill_meetingroom_service');
    }
}
