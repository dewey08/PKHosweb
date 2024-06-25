<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpenformperdev extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {     
        if (!Schema::hasTable('openformperdev'))
        {
                Schema::create('openformperdev', function (Blueprint $table) {
                    $table->id("OPENFORMDEV_ID",11);
                    $table->String("OPENFORMDEV_CODE",255)->nullable(); 
                    $table->String("OPENFORMDEV_NAME",255)->nullable(); 
                    $table->enum('OPENFORMDEV_STATUS', ['True', 'False']);   
                    $table->dateTime('updated_at');
                    $table->dateTime('created_at');
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
        Schema::dropIfExists('openformperdev');
    }
}
