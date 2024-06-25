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
        if (!Schema::hasTable('warehouse_deb_req'))
        {
        Schema::create('warehouse_deb_req', function (Blueprint $table) {
            $table->bigIncrements('warehouse_deb_req_id');
            $table->string('warehouse_deb_req_code')->nullable();//เลขที่บิล
            $table->string('warehouse_deb_req_year')->nullable();//ปี 
            $table->dateTime('warehouse_deb_req_date')->nullable();//ลงวันที่่ต้องการ
            $table->dateTime('warehouse_deb_req_savedate')->nullable();//วันที่่บันทึก
            $table->string('warehouse_deb_req_inven_id')->nullable();//คลังที่ต้องการเบิก
            $table->string('warehouse_deb_req_inven_name')->nullable();//คลังที่ต้องการเบิก                     
            $table->string('warehouse_deb_req_userid')->nullable();//ผู้ขอเบิก
            $table->string('warehouse_deb_req_username')->nullable();//ผู้ขอเบิก 
            $table->string('warehouse_deb_req_debsubtruid')->nullable();//หน่วยงานผู้ขอเบิก
            $table->string('warehouse_deb_req_because')->nullable();//เหตุผลที่ต้องการเบิก  
            $table->string('warehouse_deb_req_hnid')->nullable();//หัวหน้า  
            $table->string('warehouse_deb_req_staffid')->nullable();//ผู้ดูแลคลัง 
            $table->string('warehouse_deb_req_poid')->nullable();//ผอ
            $table->string('warehouse_deb_req_status')->nullable();  //สถานะ   
            $table->string('warehouse_deb_req_total')->nullable();  //Totl    
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
        Schema::dropIfExists('warehouse_deb_req');
    }
};
