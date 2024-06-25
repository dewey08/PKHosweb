<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnInfoOrg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('info_org', function (Blueprint $table) {

            if (!Schema::hasColumn('info_org', 'POSECODE')) // Update Column ในกรณีที่ไม่มี
            {
                $table->string("POSECODE")->nullable();
            }          
            if (!Schema::hasColumn('info_org', 'updated_at'))
            {
                $table->dateTime("updated_at")->nullable();
            }  
            if (!Schema::hasColumn('info_org', 'created_at'))
            {
                $table->dateTime("created_at")->nullable();
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
