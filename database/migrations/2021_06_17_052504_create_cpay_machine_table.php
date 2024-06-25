<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayMachineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cpay_machine')) {
            Schema::create('cpay_machine', function (Blueprint $table) {
                $table->increments('CPAY_MACH_ID');
                $table->integer('ARTICLE_ID')->comment("FK =>asset_article['ARTICLE_ID']");
                $table->string('ARTICLE_NUM',100)->nullable()->comment("ref =>asset_article['ARTICLE_NUM']");
                $table->string('CPAY_MACH_NAME_INSIDE',255);
                $table->string('CPAY_MACH_NAME_TH',255)->nullable();
                $table->string('CPAY_MACH_NAME_EN',255)->nullable();
                $table->integer('CPAY_MACH_NUMBER');
                $table->integer('CPAY_TYPEMACH_ID');            // FK =>cpay_typemachine['CPAY_TYPEMACH_ID']
                $table->text('CPAY_MACH_DETAIL')->nullable();
                $table->boolean('ACTIVE')->default(true);
                $table->string('UPDATED_BY',255);
                $table->timestamps();
            });
        }else{
            echo 'มีตารางนี้แล้ว : cpay_machine  //';
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpay_machine');
    }
}
