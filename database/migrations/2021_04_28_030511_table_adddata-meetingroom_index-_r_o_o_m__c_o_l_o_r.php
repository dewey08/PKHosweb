<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TableAdddataMeetingroomIndexROOMCOLOR extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $color[1] = '#EC7063';
        $color[2] = '#A569BD';
        $color[3] = '#5DADE2';
        $color[4] = '#45B39D';
        $color[5] = '#58D68D';
        $color[6] = '#F5B041';
        $color[7] = '#DC7633';
        $color[8] = '#CD6155';
        $color[9] = '#AF7AC5';
        $color[10] = '#5499C7';
        $color[11] = '#48C9B0';
        $color[12] = '#52BE80';
        $color[13] = '#F4D03F';
        $color[14] = '#EB984E';
        $color[15] = '#CCCCFF';

        $i = 1;
            $data = DB::table('meetingroom_index')->get();
            foreach ($data as $value) {
                DB::update(
                    'update meetingroom_index set ROOM_COLOR = "'.$color[$i].'" where ROOM_ID = ?',
                    [$value->ROOM_ID]
                );
                if($i == 15){
                    $i = 0;
                }
                $i++;
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
