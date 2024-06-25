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
        if (!Schema::hasTable('users_kind_type'))
        {
        Schema::create('users_kind_type', function (Blueprint $table) {
            $table->bigIncrements('users_kind_type_id');  
            $table->string('users_kind_type_name')->nullable();// ประเภทบุคลากร
            $table->timestamps();
            });

            if (Schema::hasTable('users_kind_type')) {
                DB::table('users_kind_type')->truncate();
            }
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '1',
                'users_kind_type_name' => 'ข้าราชการพลเรือนสามัญ',  
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '2',
                'users_kind_type_name' => 'ข้าราชการพลเรือนในสถาบันอุดมศึกษา',          
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '3',
                'users_kind_type_name' => 'ข้าราชการครูและบุคลากรทางการศึกษา',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '4',
                'users_kind_type_name' => 'ข้าราชการฝ่ายทหาร',  
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '5',
                'users_kind_type_name' => 'ข้าราชการตำรวจ',       
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '6',
                'users_kind_type_name' => 'ข้าราชการฝ่ายตุลาการศาลยุติธรรม',      
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '7',
                'users_kind_type_name' => 'ข้าราชการฝ่ายอัยการ',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));

            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '8',
                'users_kind_type_name' => 'ข้าราชการรัฐสภา',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '9',
                'users_kind_type_name' => 'ข้าราชการฝ่ายศาลปกครอง',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '10',
                'users_kind_type_name' => 'ข้าราชการฝ่ายศาลรัฐธรรมนูญ',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '11',
                'users_kind_type_name' => 'ข้าราชการ สนง.ปปช',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '12',
                'users_kind_type_name' => 'ข้าราชการสำนักงานการตรวจเงินแผ่นดิน',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '13',
                'users_kind_type_name' => 'ข้าราชการกรุงเทพมหานครและบุคลากรกรุงเทพมหานคร',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '14',
                'users_kind_type_name' => 'ข้าราชการส่วนท้องถิ่น',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '15',
                'users_kind_type_name' => 'ข้าราชการการเมือง',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));

            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '16',
                'users_kind_type_name' => 'พนักงานราชการ',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '17',
                'users_kind_type_name' => 'พนักงานมหาวิทยาลัย',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '18',
                'users_kind_type_name' => 'พนักงานรัฐวิสาหกิจ',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '19',
                'users_kind_type_name' => 'พนักงานองค์การมหาชนและหน่วยงานอื่น',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '20',
                'users_kind_type_name' => 'พนักงานกระทรวงสาธารณสุข',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '21',
                'users_kind_type_name' => 'ลูกจ้างประจำ',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '22',
                'users_kind_type_name' => 'ข้าราชการพลเรือนวิสามัญ',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '23',
                'users_kind_type_name' => 'เสมียนพนักงาน',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '24',
                'users_kind_type_name' => 'ข้าราชการพลเรือนรัฐพาณิชย์',        
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('users_kind_type')->insert(array(
                'users_kind_type_id' => '25',
                'users_kind_type_name' => 'ข้าราชการประจำต่างประเทศพิเศษ',        
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
        Schema::dropIfExists('users_kind_type');
    }
};
