<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {      
        if (!Schema::hasTable('risk_account'))
        {
        Schema::create('risk_account', function (Blueprint $table) {
            $table->id("RISK_ACCOUNT_ID",11);
            $table->String("RISK_ACCOUNT_YEAR",199)->nullable(); //พศ.
            $table->date("RISK_ACCOUNT_DATESAVE")->nullable(); //วันที่บันทึก.
            $table->String("RISK_ACCOUNT_NO",100)->nullable(); //NO.
            $table->String("RISK_ACCOUNT_DEBSUBSUB_ID",255)->nullable(); //หน่วยงาน
            $table->String("RISK_ACCOUNT_DEBSUBSUB_NAME",255)->nullable(); //หน่วยงาน
            $table->String("RISK_ACCOUNT_STEPWORK",255)->nullable();  //ขั้นตอนการทำงานของหน่วยงาน
            $table->String("RISK_ACCOUNT_OBJECTIVE",255)->nullable();  //วัตถุประสงค์   
            $table->String("RISK_ACCOUNT_RISK",255)->nullable();  //ความเสี่ยง     
            $table->String("RISK_ACCOUNT_RISK_DETAIL",500)->nullable();  //ความเสี่ยง (รายละเอียด) 
            $table->String("RISK_ACCOUNT_RISK_FACTOR",255)->nullable();  //ปัจจัยเสี่ยง  
            $table->String("RISK_ACCOUNT_LOSS",500)->nullable();  //ความสูญเสีย (รายละเอียด) 
            $table->String("RISK_ACCOUNT_SCOPE",255)->nullable();  //โอกาสที่จะเกิดขึ้น 
            $table->String("RISK_ACCOUNT_RISK_EFFECT",255)->nullable();  //ผลกระทบ / ความรุนแรง 
            $table->String("RISK_ACCOUNT_RISK_LEVEL",255)->nullable();  //ระดับความเสี่ยง
            $table->String("RISK_ACCOUNT_RISK_DEGREE",255)->nullable();  //ลำดับความเสี่ยง
            $table->String("RISK_ACCOUNT_RISK_HOWTO",255)->nullable();  //วิธีจัดการความเสี่ยง
            $table->String("RISK_ACCOUNT_RISK_PROCESS_DETAIL",255)->nullable();  //รายละเอียด/แนวทางการจัดการความเสี่ยง
            $table->String("RISK_ACCOUNT_RISK_CONTROLS",255)->nullable();  //การควบคุมที่มีอยู่แล้ว
            $table->String("RISK_ACCOUNT_RISK_CONTROLS_RESULTS",255)->nullable();  //การควบคุมที่มีอยู่แล้วได้ผลหรือไม่
            $table->String("RISK_ACCOUNT_RISK_FINISH",500)->nullable();  //กำหนดเสร็จ / ผู้รับผิดชอบ / E-mail / เบอร์โทรศัพท์
            $table->String("RISK_ACCOUNT_BUDGET_COMMENT",500)->nullable();  //หมายเหตุ (งบประมาณ/ค่าใช้จ่าย)            
            $table->String("RISK_ACCOUNT_USERID",199)->nullable(); // id ผู้รายงาน.
            $table->String("RISK_ACCOUNT_USERNAME",255)->nullable(); //ชื่อผู้รายงาน.
            $table->String("RISK_ACCOUNT_LEADERID",199)->nullable(); //id หัวหน้า.
            $table->String("RISK_ACCOUNT_LEADERNAME",255)->nullable(); //ชื่อหัวหน้า.
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
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
        Schema::dropIfExists('risk_account');
    }
}
