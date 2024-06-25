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
        if (!Schema::hasTable('air_repaire_ploblemsub'))
        {
            Schema::create('air_repaire_ploblemsub', function (Blueprint $table) {
                    $table->bigIncrements('air_repaire_ploblemsub_id'); 
                    $table->date('repaire_date_start')->nullable();  // 
                    $table->date('repaire_date_end')->nullable();  // 
                    $table->string('air_repaire_ploblem_id', length: 20)->nullable();  //   
                    $table->string('air_list_num', length: 100)->nullable();  //  
                    // รายการซ่อม(ตามปัญหา)
                    $table->char('air_problems_1', length: 100)->nullable();  //  น้ำหยด
                    $table->char('air_problems_2', length: 100)->nullable();  // ไม่เย็น มีแต่ลม  
                    $table->char('air_problems_3', length: 100)->nullable();  //  กลิ่นเหม็น
                    $table->char('air_problems_4', length: 100)->nullable();  // เสียงดัง 
                    $table->char('air_problems_5', length: 100)->nullable();  // ม่ติด/ติด ๆ ดับ ๆ         
                    $table->char('air_problems_orther', length: 100)->nullable();  // อื่นๆ 
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_repaire_ploblemsub');
    }
};
