<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayTypemachineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cpay_typemachine')) {
            Schema::create('cpay_typemachine', function (Blueprint $table) {
                $table->increments('CPAY_TYPEMACH_ID');
                $table->string('CPAY_TYPEMACH_NAME',255);
                $table->text('CPAY_TYPEMACH_DETAIL')->nullable();
                $table->boolean('ACTIVE')->default(true);
                $table->string('UPDATED_BY',255);
                $table->timestamps();
            });
        }else{
            echo 'มีตารางนี้แล้ว : cpay_typemachine  //';
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpay_typemachine');
    }
}
