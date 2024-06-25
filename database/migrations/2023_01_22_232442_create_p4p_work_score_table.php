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
        if (!Schema::hasTable('p4p_work_score'))
        {
            Schema::create('p4p_work_score', function (Blueprint $table) {
                $table->bigIncrements('p4p_work_score_id'); 
                $table->string('p4p_work_id')->nullable();// เลขที่ Main
                $table->string('p4p_workset_id')->nullable();// 
                $table->string('p4p_workset_code')->nullable();// 
                $table->string('p4p_workset_name')->nullable();// 
                $table->string('p4p_workset_group')->nullable();// หมวด 
                $table->string('p4p_workset_unit')->nullable();// 
                $table->string('p4p_workset_time')->nullable();// ระยะเวลาที่ใช้จริง
                $table->string('p4p_workset_score')->nullable();// ค่าคะแนน/นาที
                $table->string('p4p_workset_wp')->nullable();//  
                $table->string('p4p_workset_user')->nullable();// 
                $table->string('p4p_work_day1')->nullable();// 
                $table->string('p4p_work_day2')->nullable();// 
                $table->string('p4p_work_day3')->nullable();// 
                $table->string('p4p_work_day4')->nullable();// 
                $table->string('p4p_work_day5')->nullable();// 
                $table->string('p4p_work_day6')->nullable();// 
                $table->string('p4p_work_day7')->nullable();// 
                $table->string('p4p_work_day8')->nullable();// 
                $table->string('p4p_work_day9')->nullable();// 
                $table->string('p4p_work_day10')->nullable();// 
                $table->string('p4p_work_day11')->nullable();// 
                $table->string('p4p_work_day12')->nullable();// 
                $table->string('p4p_work_day13')->nullable();// 
                $table->string('p4p_work_day14')->nullable();// 
                $table->string('p4p_work_day15')->nullable();// 
                $table->string('p4p_work_day16')->nullable();// 
                $table->string('p4p_work_day17')->nullable();// 
                $table->string('p4p_work_day18')->nullable();// 
                $table->string('p4p_work_day19')->nullable();// 
                $table->string('p4p_work_day20')->nullable();// 
                $table->string('p4p_work_day21')->nullable();// 
                $table->string('p4p_work_day22')->nullable();// 
                $table->string('p4p_work_day23')->nullable();// 
                $table->string('p4p_work_day24')->nullable();// 
                $table->string('p4p_work_day25')->nullable();// 
                $table->string('p4p_work_day26')->nullable();// 
                $table->string('p4p_work_day27')->nullable();// 
                $table->string('p4p_work_day28')->nullable();// 
                $table->string('p4p_work_day29')->nullable();// 
                $table->string('p4p_work_day30')->nullable();// 
                $table->string('p4p_work_day31')->nullable();// 

                $table->string('p4p_work_sum')->nullable();// รวมชิ้นงาน
                $table->string('p4p_work_totalscore')->nullable();// รวมคคะแนน
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
        Schema::dropIfExists('p4p_work_score_score');
    }
};
