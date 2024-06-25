<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpaySetequpmentSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cpay_setequpment_sub')) {
            Schema::create('cpay_setequpment_sub', function (Blueprint $table) {
                $table->increments('CPAY_SET_SUB_ID');
                $table->integer('STORE_ID')->comment("fk=>warehouse_store['STORE_ID']"); 
                $table->string('STORE_CODE',100)->nullable()->comment("ref=>warehouse_store['STORE_CODE']");
                $table->string('CPAY_SET_SUB_NAME_INSIDE',255);        
                $table->string('CPAY_SET_SUB_NAME_TH',255)->nullable();        
                $table->string('CPAY_SET_SUB_NAME_EN',255)->nullable();        
                $table->integer('CPAY_UNIT_ID')->comment("fk=>cpay_unit['CPAY_UNIT_ID']");
                $table->float('CPAY_SET_SUB_PRICE',8,2);      
                $table->text('CPAY_SET_SUB_DETAIL')->nullable();
                $table->boolean('ACTIVE')->default(true);
                $table->string('UPDATED_BY',255);
                $table->timestamps();
            });
        }else{
            echo 'มีตารางนี้แล้ว : cpay_setequpment_sub  //';
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpay_setequpment_sub');
    }
}
