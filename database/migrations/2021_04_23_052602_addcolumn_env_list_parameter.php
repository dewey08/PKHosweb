<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnEnvListParameter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('env_list_parameter', function (Blueprint $table) {
            if (!Schema::hasColumn('env_list_parameter', 'LIST_USEANALYSIS_RESULTS'))
            {
                $table->string("LIST_USEANALYSIS_RESULTS",255)->nullable();
            }             
            if (!Schema::hasColumn('env_list_parameter', 'updated_at'))
            {
                $table->date("updated_at")->nullable();
            }   
            if (!Schema::hasColumn('env_list_parameter', 'created_at'))
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
        Schema::table('env_list_parameter', function (Blueprint $table) {
            
        });
    }
}
