<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseReportmainStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('warehouse_reportmain_status')){
            Schema::create('warehouse_reportmain_status', function (Blueprint $table) {
                $table->id("REPMAIN_STATUS_ID",11);
                $table->String("REPMAIN_STATUS_NAME",255)->nullable();                
                $table->enum('REPMAIN_STATUS_ACTIVE', ['TRUE', 'FALSE'])->default('FALSE');
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('created_at')->nullable();
            });
        }

        
        if (Schema::hasTable('warehouse_reportmain_status')) {
            DB::table('warehouse_reportmain_status')->truncate();
        }

        DB::table('warehouse_reportmain_status')->insert(array(
            'REPMAIN_STATUS_ID' => '1',
            'REPMAIN_STATUS_NAME' => 'YEAR',
            'REPMAIN_STATUS_ACTIVE' => 'TRUE',
            'updated_at' => '2021-07-30 14:52:49',
            'created_at' => '2021-07-30 14:52:49',
        ));
        DB::table('warehouse_reportmain_status')->insert(array(
            'REPMAIN_STATUS_ID' => '2',
            'REPMAIN_STATUS_NAME' => 'MOUNT',
            'REPMAIN_STATUS_ACTIVE' => 'TRUE',
            'updated_at' => '2021-07-30 14:52:49',
            'created_at' => '2021-07-30 14:52:49',
        ));
        DB::table('warehouse_reportmain_status')->insert(array(
            'REPMAIN_STATUS_ID' => '3',
            'REPMAIN_STATUS_NAME' => 'LISTTYPE',
            'REPMAIN_STATUS_ACTIVE' => 'TRUE',
            'updated_at' => '2021-07-30 14:52:49',
            'created_at' => '2021-07-30 14:52:49',
        ));
        DB::table('warehouse_reportmain_status')->insert(array(
            'REPMAIN_STATUS_ID' => '4',
            'REPMAIN_STATUS_NAME' => 'TOTAL_MAIN',
            'REPMAIN_STATUS_ACTIVE' => 'FALSE',
            'updated_at' => '2022-03-03 17:17:17',
            'created_at' => '2022-03-03 17:17:17',
        ));
        DB::table('warehouse_reportmain_status')->insert(array(
            'REPMAIN_STATUS_ID' => '5',
            'REPMAIN_STATUS_NAME' => 'TOTAL_SUB',
            'REPMAIN_STATUS_ACTIVE' => 'FALSE',
            'updated_at' => '2022-03-03 17:17:17',
            'created_at' => '2022-03-03 17:17:17',
        ));
        DB::table('warehouse_reportmain_status')->insert(array(
            'REPMAIN_STATUS_ID' => '6',
            'REPMAIN_STATUS_NAME' => 'BUY_MOUNT',
            'REPMAIN_STATUS_ACTIVE' => 'FALSE',
            'updated_at' => '2022-03-03 17:17:17',
            'created_at' => '2022-03-03 17:17:17',
        ));
        DB::table('warehouse_reportmain_status')->insert(array(
            'REPMAIN_STATUS_ID' => '7',
            'REPMAIN_STATUS_NAME' => 'PAY_RPST',
            'REPMAIN_STATUS_ACTIVE' => 'FALSE',
            'updated_at' => '2022-03-03 17:17:17',
            'created_at' => '2022-03-03 17:17:17',
        ));
        DB::table('warehouse_reportmain_status')->insert(array(
            'REPMAIN_STATUS_ID' => '8',
            'REPMAIN_STATUS_NAME' => 'PAY_RPR',
            'REPMAIN_STATUS_ACTIVE' => 'FALSE',
            'updated_at' => '2022-03-03 17:17:17',
            'created_at' => '2022-03-03 17:17:17',
        ));
        DB::table('warehouse_reportmain_status')->insert(array(
            'REPMAIN_STATUS_ID' => '9',
            'REPMAIN_STATUS_NAME' => 'PAY_RPR_SUB',
            'REPMAIN_STATUS_ACTIVE' => 'FALSE',
            'updated_at' => '2022-03-03 17:17:17',
            'created_at' => '2022-03-03 17:17:17',
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_reportmain_status');
    }
}
