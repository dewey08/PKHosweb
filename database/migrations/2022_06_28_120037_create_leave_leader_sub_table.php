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
        if (!Schema::hasTable('leave_leader_sub'))
        {
        Schema::create('leave_leader_sub', function (Blueprint $table) {
            $table->bigIncrements('leave_sub_id');
            $table->string('leave_id')->nullable();//
            $table->string('leader_id')->nullable();//หัวหน้า 
            $table->string('leader_name')->nullable();//หัวหน้า 
            $table->string('user_id')->nullable();//ลูกน้อง 
            $table->string('user_name')->nullable();//ลูกน้อง 
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
        Schema::dropIfExists('leave_leader_sub');
    }
};
