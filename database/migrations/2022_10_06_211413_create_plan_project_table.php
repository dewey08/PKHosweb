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
        if (!Schema::hasTable('plan_project'))
        {
            Schema::create('plan_project', function (Blueprint $table) {
                $table->bigIncrements('plan_project_id'); 
                $table->string('plan_project_no',255)->nullable();// เลขที่
                $table->string('plan_project_year',255)->nullable();// ปีงบประมาณ
                $table->string('plan_project_nameplan',255)->nullable();// ชื่อโครงการ  
                // $table->string('plan_project_name',255)->nullable();//  รายละเอียดโครงกา plan_project_detail
                // $table->string('plan_project_objective',255)->nullable();//วัตถุประสงค์  
                // $table->string('plan_project_target',255)->nullable();//กลุ่มเป้าหมาย +++sub 
                // $table->string('plan_project_kpi',255)->nullable();// ตัวชี้วัด +++sub
                $table->date('plan_project_startdate')->nullable();//ระยะเวลา
                $table->date('plan_project_enddate')->nullable();//ระยะเวลา 
                // $table->string('plan_project_budget',255)->nullable();// งบประมาณ มีรายละเอียด + เงิน +++ sub
                $table->string('plan_project_budgetsource',255)->nullable();// แหล่งงบประมาณ 
                $table->string('plan_project_userid',255)->nullable();// ผู้รับผิดชอบ 
                $table->string('plan_project_username',255)->nullable();// ผู้รับผิดชอบ 
                $table->string('plan_project_makeid',255)->nullable();// ผู้จัดทำ 
                $table->string('plan_project_makename',255)->nullable();// ผู้จัดทำ 
                $table->string('plan_project_hnid',255)->nullable();// ผู้ตรวจสอบ (หัวหน้า)
                $table->string('plan_project_hnname',255)->nullable();// ผู้ตรวจสอบ (หัวหน้า)
                $table->string('plan_project_groupid',255)->nullable();// ผู้เห็นชอบ (หัวหน้ากลุ่ม)
                $table->string('plan_project_groupname',255)->nullable();// ผู้เห็นชอบ (หัวหน้ากลุ่ม)
                $table->string('plan_project_poid',255)->nullable();// ผู้อนุมัติ (ผอ)
                $table->string('plan_project_poname',255)->nullable();// ผู้อนุมัติ (ผอ)
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
        Schema::dropIfExists('plan_project');
    }
};
