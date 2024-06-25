<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvPlumbingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('env_plumbing'))
        {
        Schema::create('env_plumbing', function (Blueprint $table) {
            $table->id("PLUMBING_ID",11);
            $table->String("PLUMBING_BILL_NO",255)->nullable();
            $table->date("PLUMBING_DATE")->nullable(); 
            $table->String("PLUMBING_TIME")->nullable();    
            $table->String("PLUMBING_USER")->nullable();
            $table->String("PLUMBING_USERCHECK_ID")->nullable(); 
            $table->String("PLUMBING_USERCHECK_NAME")->nullable();  
            $table->String("PLUMBING_YEAR")->nullable(); 
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
        Schema::dropIfExists('env_plumbing');
    }
}
