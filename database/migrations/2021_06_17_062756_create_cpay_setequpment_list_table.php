<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpaySetequpmentListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cpay_setequpment_list')) {
            Schema::create('cpay_setequpment_list', function (Blueprint $table) {
                $table->increments('CPAY_SETLIST_ID');
                $table->integer('CPAY_SET_ID')->comment("FK=>cpay_setequpment['CPAY_SET_ID']");
                $table->integer('CPAY_SET_SUB_ID')->comment("ref=>cpay_setequpment_sub['CPAY_SET_SUB_ID']");            
                $table->integer('CPAY_SETLIST_QUANTITY');
                $table->string('UPDATED_BY',255);
                $table->timestamps();
            });
        }else{
            echo 'มีตารางนี้แล้ว : cpay_setequpment_list  //';
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpay_setequpment_list');
    }
}
