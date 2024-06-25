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
        if (!Schema::hasTable('users_group'))
        {
        Schema::create('users_group', function (Blueprint $table) {
            $table->bigIncrements('users_group_id');  
            $table->string('users_group_name')->nullable();// กลุ่มบุคลากร
            $table->string('users_group_detail')->nullable();//กลุ่มบุคลากร
            $table->string('users_group_leave_qty')->nullable();//กลุ่มบุคลากร
            $table->timestamps();
            });

            if (Schema::hasTable('users_group')) {
                DB::table('users_group')->truncate();
            }
            DB::table('users_group')->insert(array(
                'users_group_id' => '1',
                'users_group_name' => 'ข้าราชการ',   
                'users_group_detail' => 'ทำงานครบ 1 ปี ลาได้ 10 วัน สะสมไม่เกิน 20 ทำงานครบ 10 ปีสะสมได้ไม่เกิน 30', 
                'users_group_leave_qty' => '10',     
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_group')->insert(array(
                'users_group_id' => '2',
                'users_group_name' => 'ลูกจ้างประจำ', 
                'users_group_detail' => 'ทำงานครบ 1 ปี ลาได้ 10 วัน สะสมไม่เกิน 20 ทำงานครบ 10 ปีสะสมได้ไม่เกิน 30', 
                'users_group_leave_qty' => '10',             
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_group')->insert(array(
                'users_group_id' => '3',
                'users_group_name' => 'พนักงานราชการ', 
                'users_group_detail' => 'ทำงานครบ 1 ปี สะสมได้ไม่เกิน 15 วัน เมื่อรวมกับ ปีปัจจุบันแล้ว ทุกอายุงาน ทำยังไม่ครบ 6 เดือนไม่มีสิทธิลาพักผ่อน', 
                'users_group_leave_qty' => '10',             
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_group')->insert(array(
                'users_group_id' => '4',
                'users_group_name' => 'พนักงานกระทรวงสาธารณสุข', 
                'users_group_detail' => 'ทำงานครบ 1 ปี สะสมได้ไม่เกิน 15 วัน เมื่อรวมกับ ปีปัจจุบันแล้ว ทุกอายุงาน ทำยังไม่ครบ 6 เดือนไม่มีสิทธิลาพักผ่อน',  
                'users_group_leave_qty' => '10',            
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_group')->insert(array(
                'users_group_id' => '5',
                'users_group_name' => 'ลูกจ้างชั่วคราว', 
                'users_group_detail' => 'ทำงานไม่ครบ 6 เดือน ลาไม่ได้ ไม่มีสิทธิสะสม', 
                'users_group_leave_qty' => '10',             
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_group')->insert(array(
                'users_group_id' => '6',
                'users_group_name' => 'ลูกจ้างรายวัน', 
                'users_group_detail' => 'ไม่มีสิทธิสะสม',  
                'users_group_leave_qty' => '0',            
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_group')->insert(array(
                'users_group_id' => '7',
                'users_group_name' => 'อื่นๆ', 
                'users_group_detail' => 'อื่นๆ',    
                'users_group_leave_qty' => '0',          
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
        Schema::dropIfExists('users_group');
    }
};
