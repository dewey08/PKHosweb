<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        if (!Schema::hasTable('audiovisual_type'))
        {
        Schema::create('audiovisual_type', function (Blueprint $table) {
            $table->bigIncrements('audiovisual_type_id');   
            $table->string('audiovisual_typename')->nullable();//  
            $table->enum('audiovisual_type_active', ['TRUE','FALSE'])->default('TRUE')->nullable();
            $table->timestamps();
        });

        if (Schema::hasTable('audiovisual_type')) {
            DB::table('audiovisual_type')->truncate();
        }

        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '1', 
            'audiovisual_typename' => 'หนังสืออิเล็กทรอนิค e-book',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '2', 
            'audiovisual_typename' => 'ออกแบบป้ายหน้าห้องประชุม/อบรม',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '3', 
            'audiovisual_typename' => 'ออกแบบโปสเตอร์',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '4', 
            'audiovisual_typename' => 'ออกแบบป้ายไวนิล',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '5', 
            'audiovisual_typename' => 'ออกแบบเกียรติบัตร/การ์ด',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '6', 
            'audiovisual_typename' => 'ออกแบบแผ่นพับ/แผ่นปลิว',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '7', 
            'audiovisual_typename' => 'ออกแบบปกหนังสือ/วารสาร',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '8', 
            'audiovisual_typename' => 'ออกแบบสื่อประชาสัมพันธ์ออนไลน์',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '9', 
            'audiovisual_typename' => 'ออกแบบ PowerPoint',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '10', 
            'audiovisual_typename' => 'ป้ายสติ๊กเกอร์',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '11', 
            'audiovisual_typename' => 'ป้ายฟิวเจอร์บอร์ด/อะคริลิค/พลาสวูด',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '12', 
            'audiovisual_typename' => 'ตกแต่งภาพ',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '13', 
            'audiovisual_typename' => 'ถ่ายภาพ',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '14', 
            'audiovisual_typename' => 'ปริ้นงาน/เคลือบงาน',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '15', 
            'audiovisual_typename' => 'ถ่ายภาพเคลื่อนไหววิดิทัศน์',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '16', 
            'audiovisual_typename' => 'ตัดต่อภาพเคลื่อนไหววิดิทัศน์',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '17', 
            'audiovisual_typename' => 'ไรท์แผ่น CD/DVD',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('audiovisual_type')->insert(array(
            'audiovisual_type_id' => '18', 
            'audiovisual_typename' => 'อื่นๆ:',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audiovisual_type');
    }
};
