<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingroomStyleroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(!schema::hasTable('meetingroom_stylerooms')){
            Schema::create('meetingroom_stylerooms', function (Blueprint $table) {
                $table->id();
                $table->string('STYLEROOM_NAME')->nullable();
                $table->binary('STYLEROOM_IMAGE')->nullable();
                $table->string('STYLEROOM_DETAIL')->nullable();
                $table->enum('STYLEROOM_STATUS', ['true', 'false']);
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('created_at')->nullable();
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
        Schema::dropIfExists('meetingroom_stylerooms');
    }
}
