<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnEnvTrashSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('env_trash_sub', function (Blueprint $table) {
            if (!Schema::hasColumn('env_trash_sub', 'TRASH_SUB_IDID'))
            {
                $table->string("TRASH_SUB_IDID",11)->nullable();
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
        Schema::table('env_trash_sub', function (Blueprint $table) {
            
        });
    }
}
