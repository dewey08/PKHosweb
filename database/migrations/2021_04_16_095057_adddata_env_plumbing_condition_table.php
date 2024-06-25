<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataEnvPlumbingConditionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('env_plumbing_condition')) {
            DB::table('env_plumbing_condition')->truncate();
        }
        

        DB::table('env_plumbing_condition')->insert(array(
            'PLUMBING_CONDITION_ID' => '1',
            'PLUMBING_CONDITION_NAME' => 'ปกติ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_plumbing_condition')->insert(array(
            'PLUMBING_CONDITION_ID' => '2',
            'PLUMBING_CONDITION_NAME' => 'ปรับปรุง',
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
        // DB::table('env_plumbing_condition')->where('PLUMBING_CONDITION_NAME','=','ปกติ')->delete();
        // DB::table('env_plumbing_condition')->where('PLUMBING_CONDITION_NAME','=','ปรับปรุง')>delete();
    }
}
