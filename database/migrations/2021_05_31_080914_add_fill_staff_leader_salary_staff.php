<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillStaffLeaderSalaryStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(!Schema::hasTable('salary_staff')){
            Schema::create('salary_staff', function (Blueprint $table) {
                $table->increments('STAFF_ID');
                $table->string('STAFF_HR_ID',50);
                $table->string('STAFF_LEADER_ID',50);
                $table->dateTime("updated_at")->nullable();
                $table->dateTime("created_at")->nullable();

            });

            DB::table('risk_rep_level')->insert(array(
                'STAFF_ID' => '1',
                'STAFF_HR_ID' => '00001',
                'STAFF_LEADER_ID' => 'A',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));


        }
        


        Schema::table('salary_staff', function (Blueprint $table) {
            if (!Schema::hasColumn('salary_staff', 'STAFF_LEADER_ID'))
            {
                $table->string("STAFF_LEADER_ID",50)->nullable();
            }  
        });


    

    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_staff', function (Blueprint $table) {
            //
        });
    }
}
