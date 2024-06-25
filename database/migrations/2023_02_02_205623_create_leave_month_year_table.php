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
        if (!Schema::hasTable('leave_month_year'))
        {
            Schema::create('leave_month_year', function (Blueprint $table) {
                $table->bigIncrements('month_year_id'); 
                $table->string('month_year_code',255)->nullable();// 
                $table->string('month_year_name',255)->nullable();//สถานะ   
                $table->timestamps();
            }); 
            
            if (Schema::hasTable('leave_month_year')) {
                DB::table('leave_month_year')->truncate();
            }
            DB::table('leave_month_year')->insert(array(
                'month_year_id' => '1',
                'month_year_code' => '10',
                'month_year_name' => 'ตุลาคม',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('leave_month_year')->insert(array(
                'month_year_id' => '2',
                'month_year_code' => '11',
                'month_year_name' => 'พฤศจิกายน',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('leave_month_year')->insert(array(
                'month_year_id' => '3',
                'month_year_code' => '12',
                'month_year_name' => 'ธันวาคม',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('leave_month_year')->insert(array(
                'month_year_id' => '4',
                'month_year_code' => '01',
                'month_year_name' => 'มกราคม',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )); 
            DB::table('leave_month_year')->insert(array(
                'month_year_id' => '5',
                'month_year_code' => '02',
                'month_year_name' => 'กุมพาพันธ์',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('leave_month_year')->insert(array(
                'month_year_id' => '6',
                'month_year_code' => '03',
                'month_year_name' => 'มีนาคม',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('leave_month_year')->insert(array(
                'month_year_id' => '7',
                'month_year_code' => '04',
                'month_year_name' => 'เมษายน',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('leave_month_year')->insert(array(
                'month_year_id' => '8',
                'month_year_code' => '05',
                'month_year_name' => 'พฤษภาคม',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('leave_month_year')->insert(array(
                'month_year_id' => '9',
                'month_year_code' => '06',
                'month_year_name' => 'มิถุนายน',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('leave_month_year')->insert(array(
                'month_year_id' => '10',
                'month_year_code' => '07',
                'month_year_name' => 'กรกฎาคม',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('leave_month_year')->insert(array(
                'month_year_id' => '11',
                'month_year_code' => '08',
                'month_year_name' => 'สิงหาคม',           
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            DB::table('leave_month_year')->insert(array(
                'month_year_id' => '12',
                'month_year_code' => '09',
                'month_year_name' => 'กันยายน',           
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
        Schema::dropIfExists('leave_month_year');
    }
};
