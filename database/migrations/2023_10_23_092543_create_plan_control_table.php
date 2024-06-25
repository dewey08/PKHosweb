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
        if (!Schema::hasTable('plan_control'))
        {
            Schema::connection('mysql')->create('plan_control', function (Blueprint $table) { 
                $table->bigIncrements('plan_control_id');//  
                $table->string('billno')->nullable();//   
                $table->string('plan_year')->nullable();//         ปีงบประมาณ 
                $table->string('plan_strategic_id')->nullable();//   สอดคล้องกับยุทธศาสตร์
                $table->longtext('plan_name')->nullable();//         แผนงาน/โครงการ
                $table->string('plan_obj')->nullable();//          วัตถุประสงค์ /ตัวชี้วัด
                $table->string('plan_type')->nullable();//         แหล่งงบประมาณ
                $table->date('plan_starttime')->nullable();//     ระยะเวลา 
                $table->date('plan_endtime')->nullable();//       ระยะเวลา  
                $table->string('plan_price')->nullable();//       งบประมาณ   
                $table->string('plan_req_no')->nullable();//              
                $table->string('plan_reqtotal')->nullable();//   รวมเบิก
                $table->string('plan_price_total')->nullable();//  คงเหลือ
           
                $table->string('department')->nullable();//       กลุ่มงาน
                $table->string('user_id')->nullable();//         ผู้รับผิดชอบ
                $table->string('comment')->nullable();//           หมายเหตุ
                $table->string('hos_group')->nullable();//   รพ /  รพสต
                $table->string('plan_group')->nullable();//  ประเภทแผนเช่นครุภัณฑ์ บุคลากร
                $table->enum('status', ['REQUEST','ACCEPT','INPROGRESS_SSJ','INPROGRESS_PO','VERIFY','FINISH','CANCEL','CONFIRM_CANCEL','SUCCESS'])->default('REQUEST')->nullable();
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
        Schema::dropIfExists('plan_control');
    }
};
