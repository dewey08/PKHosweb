<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataRiskRepTypedep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('risk_rep_typedep')) {
            DB::table('risk_rep_typedep')->truncate();
        }
        DB::table('risk_rep_typedep')->insert(array(
            'RISKREP_TYPEDEPART_ID' => '1',
            'RISKREP_TYPEDEPART_NAME' => 'กลุ่มงาน',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typedep')->insert(array(
            'RISKREP_TYPEDEPART_ID' => '2',
            'RISKREP_TYPEDEPART_NAME' => 'ฝ่าย/แผนก',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typedep')->insert(array(
            'RISKREP_TYPEDEPART_ID' => '3',
            'RISKREP_TYPEDEPART_NAME' => 'หน่วยงาน',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('risk_rep_typedep')->insert(array(
            'RISKREP_TYPEDEPART_ID' => '4',
            'RISKREP_TYPEDEPART_NAME' => 'ทีมนำองค์กร',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
