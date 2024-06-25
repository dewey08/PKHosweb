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
        if (!Schema::hasTable('medical_repaire'))
        {
        Schema::create('medical_repaire', function (Blueprint $table) {
            $table->bigIncrements('medical_repaire_id'); 
            $table->string('medical_repaire_rep')->nullable();//  เลขที่ส่ง
            $table->dateTime('medical_repaire_date')->nullable();// วันที่ส่ง
            $table->dateTime('medical_repaire_backdate')->nullable();// วันที่รับคืน
            $table->string('medical_repaire_article_id')->nullable();//  รายการ           
            $table->string('medical_repaire_vender')->nullable();//  ส่งซ่อมที่ร้าน
            $table->string('medical_repaire_userrep')->nullable();//  ผู้รับซ่อม
            $table->string('medical_repaire_because')->nullable();//  เหตุผลที่ส่งซ่อม
            $table->string('medical_repaire_listgo')->nullable();// อุปกรณ์ที่ติดไปด้วย
            $table->string('medical_repaire_users_id')->nullable();// ผู้บันทึก
            $table->string('medical_repaire_backusers_rep')->nullable();// ผู้รับคืน
            $table->string('medical_repaire_status')->nullable();//  ความเร่งด่วน
            $table->enum('medical_repaire_active', ['INPROGRESS','APPROVE','CANCEL','SEND'])->default('SEND')->nullable();
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
        Schema::dropIfExists('medical_repaire');
    }
};
