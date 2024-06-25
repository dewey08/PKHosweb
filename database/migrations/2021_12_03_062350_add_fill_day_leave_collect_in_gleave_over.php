<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillDayLeaveCollectInGleaveOver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gleave_over', function (Blueprint $table) {
            if(!schema::hasColumn('gleave_over','DAY_LEAVE_COLLECT')){
                $table->string('DAY_LEAVE_COLLECT')->nullable();
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
        Schema::table('gleave_over', function (Blueprint $table) {
            //
        });
    }
}
