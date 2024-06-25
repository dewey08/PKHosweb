<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataEnvPlumbingGroupexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('env_plumbing_groupex')) {
            DB::table('env_plumbing_groupex')->truncate();
        }

        DB::table('env_plumbing_groupex')->insert(array(
            'PLUMBING_GROUP_EX_ID' => '1',
            'PLUMBING_GROUP_EX_NAME' => 'น้ำดื่ม',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_plumbing_groupex')->insert(array(
            'PLUMBING_GROUP_EX_ID' => '2',
            'PLUMBING_GROUP_EX_NAME' => 'น้ำผิวดิน',
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
        // DB::table('env_plumbing_groupex')->where('PLUMBING_GROUP_EX_NAME','=','น้ำดื่ม')->delete();
        // DB::table('env_plumbing_groupex')->where('PLUMBING_GROUP_EX_NAME','=','น้ำผิวดิน')>delete();
    }
}
