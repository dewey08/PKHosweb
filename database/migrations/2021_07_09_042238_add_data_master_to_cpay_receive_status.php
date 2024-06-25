<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Cpay_receive_status;

class AddDataMasterToCpayReceiveStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('cpay_receive_status')) {
            Cpay_receive_status::truncate();
            $status = new Cpay_receive_status();
            $status->RECEIVE_STATUS_ID = 1;
            $status->RECEIVE_STATUS_NAME = 'ใช้แล้ว';
            $status->save();
            
            $status = new Cpay_receive_status();
            $status->RECEIVE_STATUS_ID = 2;
            $status->RECEIVE_STATUS_NAME = 'หมดอายุ';
            $status->save();
            
            $status = new Cpay_receive_status();
            $status->RECEIVE_STATUS_ID = 3;
            $status->RECEIVE_STATUS_NAME = 'ชำรุด';
            $status->save();
            
            $status = new Cpay_receive_status();
            $status->RECEIVE_STATUS_ID = 4;
            $status->RECEIVE_STATUS_NAME = 'รับเข้าใหม่';
            $status->save();
            
            $status = new Cpay_receive_status();
            $status->RECEIVE_STATUS_ID = 5;
            $status->RECEIVE_STATUS_NAME = 'อื่น ๆ';
            $status->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpay_receive_status', function (Blueprint $table) {
            //
        });
    }
}
