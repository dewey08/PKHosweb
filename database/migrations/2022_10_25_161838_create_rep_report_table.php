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
        if (!Schema::hasTable('rep_report'))
        {
        Schema::create('rep_report', function (Blueprint $table) {
            $table->bigIncrements('rep_report_id');  
            $table->date('rep_report_date')->nullable();//ลงสมุดบันทึก วันที่  
            $table->Time('rep_report_time')->nullable();//ลงสมุดบันทึก เวลา  
            $table->string('rep_report_name',255)->nullable();// ชื่อเรื่อง 
            $table->string('rep_report_detail',255)->nullable();//รายละเอียด
            $table->string('rep_report_rep_userid',255)->nullable();// ผู้ร้องขอ
            $table->string('rep_report_rep_checkid',255)->nullable();// ผู้เห็นชอบ
            $table->binary('img')->nullable();//        
            $table->string('img_name')->nullable();//
            // $table->string('rep_report_status_level')->nullable();// 
            $table->enum('rep_report_level', ['Normal','Fast','NoFast','Now'])->default('Normal')->nullable();  
            $table->enum('rep_report_status', ['Request','Recieve','Inprogress','Submitwork','Finish','Cancel'])->default('Request')->nullable();
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
        Schema::dropIfExists('rep_report');
    }
};
