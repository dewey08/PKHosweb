<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRiskTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('risk_type'))
        {
            Schema::create('risk_type', function (Blueprint $table) {
                $table->id("RISK_TYPE_ID",11);
                $table->String("RISK_TYPE_CODE",255)->nullable(); 
                $table->String("RISK_TYPE_NAME",255)->nullable(); 
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('created_at')->nullable();
            });

            DB::table('risk_type')->insert([
                'RISK_TYPE_CODE' => 'RT001',
                'RISK_TYPE_NAME' => 'ด้านกลยุทธ์',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::table('risk_type')->insert([
                'RISK_TYPE_CODE' => 'RT002',
                'RISK_TYPE_NAME' => 'ด้านการปฏิบัติงาน',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::table('risk_type')->insert([
                'RISK_TYPE_CODE' => 'RT003',
                'RISK_TYPE_NAME' => 'ด้านนโยบาย/กฎหมาย/ข้อบังคับ',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::table('risk_type')->insert([
                'RISK_TYPE_CODE' => 'RT004',
                'RISK_TYPE_NAME' => 'ด้านการเงิน',
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
        Schema::dropIfExists('risk_type');
    }
}
