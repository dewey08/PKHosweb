<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvPlumbingSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('env_plumbing_sub'))
        {
        Schema::create('env_plumbing_sub', function (Blueprint $table) {
            $table->id("PLUMBING_SUB_ID",11);
            $table->String("PLUMBING_ID",255);
            $table->String("PLUMBING_SUB_TESTLIST",255)->nullable();
            $table->String("PLUMBING_SUB_TESTER",255)->nullable();
            $table->float("PLUMBING_SUB_PRICE", 8, 2)->nullable();
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
        Schema::dropIfExists('env_plumbing_sub');
        
    }
}
