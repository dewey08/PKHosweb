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
        if (!Schema::hasTable('air_repaire'))
        {
            Schema::create('air_repaire', function (Blueprint $table) {
                $table->bigIncrements('air_repaire_id');
                $table->date('repaire_date')->nullable();  //

                $table->char('air_repaire_no', length: 150)->nullable();  //  เลขที่แจ้ง
                $table->char('air_repaire_num', length: 250)->nullable();  //  เลขครุภัณฑ์

                $table->char('air_list_id', length: 10)->nullable();  //   
                $table->char('air_list_num', length: 200)->nullable();  //           
                $table->char('air_list_name', length: 200)->nullable(); //   
                $table->char('btu', length: 200)->nullable(); //
                $table->char('serial_no', length: 200)->nullable(); //
                $table->char('air_location_id', length: 200)->nullable(); //   
                $table->char('air_location_name', length: 200)->nullable();  // 
                
                // รายการซ่อม(ตามปัญหา)
                $table->char('air_problems_1', length: 200)->nullable();  //  น้ำหยด
                $table->char('air_problems_2', length: 200)->nullable();  // ไม่เย็น มีแต่ลม  
                $table->char('air_problems_3', length: 200)->nullable();  //  กลิ่นเหม็น
                $table->char('air_problems_4', length: 200)->nullable();  // เสียงดัง 
                $table->char('air_problems_5', length: 200)->nullable();  // ม่ติด/ติด ๆ ดับ ๆ
                $table->char('air_problems_orther', length: 200)->nullable();  // อื่นๆ
                $table->char('air_problems_orthersub', length: 200)->nullable();  //  รายละเอียดอื่นๆ
 
                //การบำรุงรักษาประจำปี ครั้ง 1
                $table->char('air_problems_6', length: 200)->nullable();  // ถอดล้างพัดลมกรงกระรอก
                $table->char('air_problems_7', length: 200)->nullable();  // ล้างถาดหลังแอร์
                $table->char('air_problems_8', length: 200)->nullable();  // ล้างแผงคอยล์เย็น
                $table->char('air_problems_9', length: 200)->nullable();  // ล้างแผงคอยล์ร้อน
                $table->char('air_problems_10', length: 200)->nullable();  // ตรวจเช็คน้ำยา

                 //การบำรุงรักษาประจำปี ครั้ง 2
                 $table->char('air_problems_11', length: 200)->nullable();  // ถอดล้างพัดลมกรงกระรอก
                 $table->char('air_problems_12', length: 200)->nullable();  // ล้างถาดหลังแอร์
                 $table->char('air_problems_13', length: 200)->nullable();  // ล้างแผงคอยล์เย็น
                 $table->char('air_problems_14', length: 200)->nullable();  // ล้างแผงคอยล์ร้อน
                 $table->char('air_problems_15', length: 200)->nullable();  // ตรวจเช็คน้ำยา

                  //การบำรุงรักษาประจำปี ครั้ง 3
                $table->char('air_problems_16', length: 200)->nullable();  // ถอดล้างพัดลมกรงกระรอก
                $table->char('air_problems_17', length: 200)->nullable();  // ล้างถาดหลังแอร์
                $table->char('air_problems_18', length: 200)->nullable();  // ล้างแผงคอยล์เย็น
                $table->char('air_problems_19', length: 200)->nullable();  // ล้างแผงคอยล์ร้อน
                $table->char('air_problems_20', length: 200)->nullable();  // ตรวจเช็คน้ำยา

                

                $table->enum('air_status_techout', ['N','R','Y'])->default('N');   // พร้อมใช้งาน /ไม่พร้อมใช้งาน
                $table->char('air_techout_name', length: 200)->nullable();          // ช่างนอก
                $table->longText('signature')->nullable();  

                $table->enum('air_status_staff', ['N','R','Y'])->default('N');   // พร้อมใช้งาน /ไม่พร้อมใช้งาน
                $table->char('air_staff_id', length: 200)->nullable();          // เจ้าหน้าที่หน้างานรับทราบ
                $table->longText('signature2')->nullable();                //  ลายเซนเจ้าหน้าที่

                $table->enum('air_status_tech', ['N','R','Y'])->default('N');   //  พร้อมใช้งาน /ไม่พร้อมใช้งาน
                $table->char('air_tech_id', length: 200)->nullable();          //  เจ้าหน้าที่หน้างานรับทราบ
                $table->longText('signature3')->nullable();                //  ลายเซนเจ้าหน้าที่
                
                 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_repaire');
    }
};
