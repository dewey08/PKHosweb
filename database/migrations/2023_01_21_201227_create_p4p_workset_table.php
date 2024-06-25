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
        if (!Schema::hasTable('p4p_workset'))
        {
            Schema::create('p4p_workset', function (Blueprint $table) {
                $table->bigIncrements('p4p_workset_id'); 
                $table->string('p4p_workset_code')->nullable();// 
                $table->string('p4p_workset_name')->nullable();// 
                $table->string('p4p_workset_position')->nullable();//สายงาน
                $table->string('p4p_workset_group')->nullable();// หมวด 
                $table->string('p4p_workset_unit')->nullable();// 
                $table->string('p4p_workset_time')->nullable();// ระยะเวลาที่ใช้จริง
                $table->string('p4p_workset_score')->nullable();// ค่าคะแนน/นาที
                $table->string('p4p_workset_wp')->nullable();//  
                $table->string('p4p_workset_user')->nullable();// 
                $table->enum('p4p_workset_active', ['TRUE','FALSE'])->default('TRUE')->nullable();
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
        Schema::dropIfExists('p4p_workset');
    }
};
