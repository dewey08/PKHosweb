<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvPlumbingGroupexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('env_plumbing_groupex'))
        {
        Schema::create('env_plumbing_groupex', function (Blueprint $table) {
            $table->id("PLUMBING_GROUP_EX_ID",11);
            $table->String("PLUMBING_GROUP_EX_NAME",255)->nullable();
            $table->dateTime("updated_at")->nullable();
            $table->dateTime("created_at")->nullable();
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
        Schema::dropIfExists('env_plumbing_groupex');
       
    }
}
