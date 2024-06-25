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
        if (!Schema::hasTable('p4p_workload'))
        {
        Schema::create('p4p_workload', function (Blueprint $table) {
            $table->bigIncrements('p4p_workload_id'); 
            $table->string('p4p_work_id')->nullable();//  p4p_work    ปี เดือน
            
            $table->date('p4p_workload_date')->nullable();//   
            $table->string('p4p_workset_id'); 
            $table->string('p4p_workset_code')->nullable();// 
            $table->string('p4p_workset_name')->nullable();//  
            $table->string('p4p_workset_unit')->nullable();// 
            $table->string('p4p_workset_time')->nullable();// ระยะเวลาที่ใช้จริง
            $table->string('p4p_workset_score')->nullable();// ค่าคะแนน/นาที
            $table->string('p4p_workset_wp')->nullable();//  รวมคคะแนน  /นาที
            $table->string('p4p_workset_score_now')->nullable();// คะแนนที่ได้
            $table->string('p4p_workload_sum')->nullable();// รวมชิ้นงาน
            $table->string('p4p_workload_totalscore')->nullable();// รวมคคะแนน

            $table->string('p4p_workload_1')->nullable();
            $table->string('p4p_workload_2')->nullable();
            $table->string('p4p_workload_3')->nullable();
            $table->string('p4p_workload_4')->nullable();
            $table->string('p4p_workload_5')->nullable();
            $table->string('p4p_workload_6')->nullable();
            $table->string('p4p_workload_7')->nullable();
            $table->string('p4p_workload_8')->nullable();
            $table->string('p4p_workload_9')->nullable();
            $table->string('p4p_workload_10')->nullable();
            $table->string('p4p_workload_11')->nullable();
            $table->string('p4p_workload_12')->nullable();
            $table->string('p4p_workload_13')->nullable();
            $table->string('p4p_workload_14')->nullable();
            $table->string('p4p_workload_15')->nullable();
            $table->string('p4p_workload_16')->nullable();
            $table->string('p4p_workload_17')->nullable();
            $table->string('p4p_workload_18')->nullable();
            $table->string('p4p_workload_19')->nullable();
            $table->string('p4p_workload_20')->nullable();
            $table->string('p4p_workload_21')->nullable();
            $table->string('p4p_workload_22')->nullable();
            $table->string('p4p_workload_23')->nullable();
            $table->string('p4p_workload_24')->nullable();
            $table->string('p4p_workload_25')->nullable();
            $table->string('p4p_workload_26')->nullable();
            $table->string('p4p_workload_27')->nullable();
            $table->string('p4p_workload_28')->nullable();
            $table->string('p4p_workload_29')->nullable();
            $table->string('p4p_workload_30')->nullable();
            $table->string('p4p_workload_31')->nullable(); 

            $table->enum('p4p_workload_active', ['TRUE','FALSE'])->default('TRUE')->nullable();
            $table->string('p4p_workload_user')->nullable(); 
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
        Schema::dropIfExists('p4p_workload');
    }
};
