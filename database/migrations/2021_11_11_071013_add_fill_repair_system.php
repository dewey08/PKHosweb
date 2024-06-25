<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillRepairSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informcom_repair', function (Blueprint $table) {

            if(!schema::hasColumn('informcom_repair','REPAIR_SYSTEM')){
                $table->string('REPAIR_SYSTEM')->nullable();
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
        Schema::table('informcom_repair', function (Blueprint $table) {
            //
        });
    }
}
