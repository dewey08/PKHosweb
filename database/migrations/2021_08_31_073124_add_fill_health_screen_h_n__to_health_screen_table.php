<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillHealthScreenHNToHealthScreenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('health_screen', function (Blueprint $table) {
            if(!Schema::hasColumn('health_screen','HEALTH_SCREEN_H_29')){
                $table->string('HEALTH_SCREEN_H_29',20)->nullable();
            }
            if(!Schema::hasColumn('health_screen','HEALTH_SCREEN_H_29_COMMENT')){
                $table->string('HEALTH_SCREEN_H_29_COMMENT',255)->nullable();
            }
            if(!Schema::hasColumn('health_screen','HEALTH_SCREEN_H_30')){
                $table->string('HEALTH_SCREEN_H_30',20)->nullable();
            }
            if(!Schema::hasColumn('health_screen','HEALTH_SCREEN_H_30_COMMENT')){
                $table->string('HEALTH_SCREEN_H_30_COMMENT',255)->nullable();
            }
            if(!Schema::hasColumn('health_screen','HEALTH_SCREEN_H_31')){
                $table->string('HEALTH_SCREEN_H_31',20)->nullable();
            }
            if(!Schema::hasColumn('health_screen','HEALTH_SCREEN_H_31_COMMENT')){
                $table->string('HEALTH_SCREEN_H_31_COMMENT',255)->nullable();
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
        Schema::table('health_screen', function (Blueprint $table) {
            //
        });
    }
}
