<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataEnvTrashSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('env_trash_set')) {
            DB::table('env_trash_set')->truncate();
        }

        DB::table('env_trash_set')->insert(array(
            'SET_TRASH_ID' => '1',
            'SET_TRASH_NAME' => 'ขยะติดเชื้อ',
            'SET_TRASH_UNIT'=>'KG.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_trash_set')->insert(array(
            'SET_TRASH_ID' => '2',
            'SET_TRASH_NAME' => 'ขยะอันตราย',
            'SET_TRASH_UNIT'=>'KG.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_trash_set')->insert(array(
            'SET_TRASH_ID' => '3',
            'SET_TRASH_NAME' => 'ขยะอินทรีย์',
            'SET_TRASH_UNIT'=>'KG.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_trash_set')->insert(array(
            'SET_TRASH_ID' => '4',
            'SET_TRASH_NAME' => 'ขยะรีไซเคิล',
            'SET_TRASH_UNIT'=>'บาท',
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
