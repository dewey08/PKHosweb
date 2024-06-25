<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpaySetequpmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cpay_setequpment')) {
            Schema::create('cpay_setequpment', function (Blueprint $table) {
                $table->increments('CPAY_SET_ID');
                $table->string('CPAY_SET_NAME_INSIDE',255);        
                $table->string('CPAY_SET_NAME_TH',255)->nullable();        
                $table->string('CPAY_SET_NAME_EN',255)->nullable();        
                $table->string('CPAY_SET_BRAND',255)->nullable();        
                $table->float('CPAY_SET_PRICE',8,2);
                $table->integer('CPAY_SET_STERILE_DAY');    
                $table->integer('CPAY_SET_NOT_STERILE_QUANTITY')->default(0);
                $table->integer('CPAY_SET_STERILE_QUANTITY')->default(0);
                $table->integer('CPAY_TYPEMACH_ID')->comment("FK=>cpay_typemachine['CPAY_TYPEMACH_ID']");
                $table->text('CPAY_SET_DETAIL')->nullable();
                $table->boolean('CPAY_SET_HAVE_LIST')->defaut(false);
                $table->boolean('ACTIVE')->defaut(true);
                $table->string('UPDATED_BY',255);
                $table->timestamps();
            });
        }else{
            echo 'มีตารางนี้แล้ว : cpay_setequpment  //';
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpay_setequpment');
    }
}
