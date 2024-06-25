<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayGsetequpmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cpay_gsetequpment')) {
            Schema::create('cpay_gsetequpment', function (Blueprint $table) {
                $table->increments('CPAY_GSET_ID');
                $table->string('CPAY_GSET_NAME',255);
                $table->text('CPAY_GSET_DETAIL')->nullable();
                $table->boolean('ACTIVE')->default(true);
                $table->string('UPDATED_BY',255);
                $table->timestamps();
            });
        }else{
            echo 'มีตารางนี้แล้ว : cpay_gsetequpment  //';
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpay_gsetequpment');
    }
}
