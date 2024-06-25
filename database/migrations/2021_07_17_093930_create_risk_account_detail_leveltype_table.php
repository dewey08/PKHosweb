<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskAccountDetailLeveltypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('risk_account_detail_leveltype'))
        {
            Schema::create('risk_account_detail_leveltype', function (Blueprint $table) {
                $table->id("RISK_LEVELTYPE_ID",11);
                $table->String("RISK_LEVELTYPE_NAME",255)->nullable(); 
                $table->String("RISK_LEVELTYPE_SCORE",255)->nullable();
                $table->String("RISK_LEVELTYPE_DETAIL",255)->nullable(); 
                $table->String("RISK_LEVELTYPE_COLOR",255)->nullable();  
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('created_at')->nullable();
            });

            DB::table('risk_account_detail_leveltype')->insert([
                'RISK_LEVELTYPE_NAME' => 'ต่ำ',
                'RISK_LEVELTYPE_SCORE' => '1-3 คะแนน',
                'RISK_LEVELTYPE_DETAIL' => 'ยอมรับความเสี่ยง',
                'RISK_LEVELTYPE_COLOR' => '#82E0AA',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::table('risk_account_detail_leveltype')->insert([
                'RISK_LEVELTYPE_NAME' => 'ปานกลาง',
                'RISK_LEVELTYPE_SCORE' => '4-8 คะแนน',
                'RISK_LEVELTYPE_DETAIL' => 'ยอมรับความเสี่ยง แต่มีมาตรการควบคุมความเสี่ยง',
                'RISK_LEVELTYPE_COLOR' => '#F7DC6F',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::table('risk_account_detail_leveltype')->insert([
                'RISK_LEVELTYPE_NAME' => 'เสี่ยงสูง',
                'RISK_LEVELTYPE_SCORE' => '9-18 คะแนน',
                'RISK_LEVELTYPE_DETAIL' => 'มีมาตรการลดความเสี่ยง',
                'RISK_LEVELTYPE_COLOR' => '#FAD7A0',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::table('risk_account_detail_leveltype')->insert([
                'RISK_LEVELTYPE_NAME' => 'เสี่ยงสูงมาก',
                'RISK_LEVELTYPE_SCORE' => '15-25 คะแนน',
                'RISK_LEVELTYPE_DETAIL' => 'มีมาตรการลด และประเมินซ้ำ หรือถ่ายโอนความเสี่ยง',
                'RISK_LEVELTYPE_COLOR' => '#F1948A',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_account_detail_leveltype');
    }
}
