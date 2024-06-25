<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('leave_leader'))
        {
        Schema::create('leave_leader', function (Blueprint $table) {
            $table->bigIncrements('leave_id');
            $table->string('leader_id')->nullable();//หัวหน้า 
            $table->string('leader_name')->nullable();//หัวหน้า 
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
        Schema::dropIfExists('leave_leader');
    }
};
