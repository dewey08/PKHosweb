<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpayMachineMaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cpay_machine_maintenance')) {
            Schema::create('cpay_machine_maintenance', function (Blueprint $table) {
            $table->id('MMAINTENANCE_ID');
            $table->bigInteger('CPAY_MACH_ID');
            $table->string('CPAY_MACH_NAME');
            $table->bigInteger('CHECK_PERSON_ID');
            $table->string('CHECK_PERSON_NAME');
            $table->bigInteger('CHECK_MACHINE_PERSON_ID');
            $table->string('CHECK_MACHINE_PERSON_NAME');
            $table->string('MMAINTENANCE_TEST_DATE');
            $table->boolean('MMAINTENANCE_RESULT')->default(false)->comment('1 = ผ่าน ,2 = ไม่ผ่าน');
            $table->timestamps();
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
        Schema::dropIfExists('cpay_machine_maintenance');
    }
}
