<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnEnvTrashSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('env_trash_set', function (Blueprint $table) {
            if (!Schema::hasColumn('env_trash_set', 'updated_at'))
            {
                $table->date("updated_at")->nullable();
            }   
            if (!Schema::hasColumn('env_trash_set', 'created_at'))
            {
                $table->date("created_at")->nullable();
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
        Schema::table('env_trash_set', function (Blueprint $table) {
            
        });
    }
}
