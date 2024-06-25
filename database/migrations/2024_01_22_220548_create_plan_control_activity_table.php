<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        if (!Schema::hasTable('plan_control_activity'))
        {
            Schema::connection('mysql')->create('plan_control_activity', function (Blueprint $table) { 
                $table->bigIncrements('plan_control_activity_id');//  
                $table->string('plan_control_id')->nullable();//   
                $table->string('billno')->nullable();//   
                $table->string('plan_control_activity_name')->nullable();//         /แผนงาน/กิจกรรมสำคัญ
                $table->string('plan_control_activity_group')->nullable();//        กลุ่มเป้าหมาย
                $table->string('qty')->nullable();//  
                $table->string('plan_control_unit')->nullable();// 
                $table->string('trimart_11')->nullable();// ไตรมาสที่ 1
                $table->string('trimart_12')->nullable();// ไตรมาสที่ 1
                $table->string('trimart_13')->nullable();// ไตรมาสที่ 1
                $table->string('trimart_21')->nullable();// ไตรมาสที่ 2
                $table->string('trimart_22')->nullable();// ไตรมาสที่ 2
                $table->string('trimart_23')->nullable();// ไตรมาสที่ 2
                $table->string('trimart_31')->nullable();// ไตรมาสที่ 3
                $table->string('trimart_32')->nullable();// ไตรมาสที่ 3
                $table->string('trimart_33')->nullable();// ไตรมาสที่ 3
                $table->string('trimart_41')->nullable();// ไตรมาสที่ 4
                $table->string('trimart_42')->nullable();// ไตรมาสที่ 4
                $table->string('trimart_43')->nullable();// ไตรมาสที่ 4
                $table->longtext('budget_detail')->nullable();//   งบประมาณรายละเอียด
                $table->string('budget_price')->nullable();//    งบประมาณ
                $table->string('budget_source')->nullable();//     แหล่งงบประมาณ
                $table->string('budget_source_name')->nullable();//     แหล่งงบประมาณ
                $table->string('responsible_person')->nullable();//     ผู้รับผิดชอบ
                $table->string('responsible_person_name')->nullable();//     ผู้รับผิดชอบ
                $table->enum('status', ['REQUEST','ACCEPT','INPROGRESS_SSJ','INPROGRESS_PO','VERIFY','FINISH','CANCEL','CONFIRM_CANCEL'])->default('REQUEST')->nullable();
                $table->string('user_id')->nullable();//         
                $table->timestamps();
            });    
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_control_activity');
    }
};
