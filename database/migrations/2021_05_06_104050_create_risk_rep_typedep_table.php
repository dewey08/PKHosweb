<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskRepTypedepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('risk_rep_typedep'))
        {
            Schema::create('risk_rep_typedep', function (Blueprint $table) {
                $table->id("RISKREP_TYPEDEPART_ID",11);
                $table->String("RISKREP_TYPEDEPART_NAME",255)->nullable();          
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
        Schema::dropIfExists('risk_rep_typedep');
    }
}
