<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataNotify extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $maxnum = DB::table('line_token')->max('ID_LINE_TOKEN');

        if ($maxnum == 9 ) {
            DB::table('line_token')->insert(array(
                'ID_LINE_TOKEN' => '10',
                'ID_LINE_TOKEN_NAME' => 'ระบบความเสี่ยง',            
                'LINE_TOKEN' => '',
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
        //
    }
}
