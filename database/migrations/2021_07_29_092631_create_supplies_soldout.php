<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliesSoldout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('supplies_soldout'))
        {
                Schema::create('supplies_soldout', function (Blueprint $table) {
                    $table->id("SOLDOUT_ID",11);
                    $table->String("SOLDOUT_NO",100)->nullable(); 
                    $table->String("SOLDOUT_YEAR",11)->nullable(); 
                    $table->dateTime("SOLDOUT_DATE")->nullable(); 
                    $table->String("SOLDOUT_ARTICLE_ID",11)->nullable(); 
                    $table->String("SOLDOUT_DETAIL",255)->nullable(); 
                    $table->String("SOLDOUT_WIN",255)->nullable(); 
                    $table->float("SOLDOUT_PRICE",8,2)->nullable(); 
                    $table->String("SOLDOUT_COMMENT",255)->nullable(); 
                    $table->String("SOLDOUT_STATUS",11)->nullable(); 
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
        Schema::dropIfExists('supplies_soldout');
    }
}
