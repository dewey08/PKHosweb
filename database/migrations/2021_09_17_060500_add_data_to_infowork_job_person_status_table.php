<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToInfoworkJobPersonStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(schema::hasTable('infowork_job_person_status')){
            DB::table('infowork_job_person_status')->truncate();
            DB::table('infowork_job_person_status')->insert([
                [
                    'IWJOB_PERSON_STATUS_ID' => 1,
                    'IWJPS_NAME' => 'รอดำเนินการ',

                ],
                [
                    'IWJOB_PERSON_STATUS_ID' => 2,
                    'IWJPS_NAME' => 'ประเมินผล 6 เดือนแรก',
                ],
                [
                    'IWJOB_PERSON_STATUS_ID' => 3,
                    'IWJPS_NAME' => 'ประเมินผล 6 เดือนหลัง',
                ]
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
        Schema::table('infowork_job_person_status', function (Blueprint $table) {
            //
        });
    }
}
