<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaunderDepSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('launder_dep_sub'))
        {
        Schema::create('launder_dep_sub', function (Blueprint $table) {
         
                $table->id("LAUNDER_DEP_SUB_ID",11);
                $table->String("LAUNDER_DEP_ID",50)->nullable(); 
                $table->String("LAUNDER_DEP_SUB_TYPE",255)->nullable(); 
                $table->String("LAUNDER_DEP_SUB_DETAIL",255)->nullable(); 
                $table->String("LAUNDER_DEP_SUB_MIN",255)->nullable(); 
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
        Schema::dropIfExists('launder_dep_sub');
    }
}
