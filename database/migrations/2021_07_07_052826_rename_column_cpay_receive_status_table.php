<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnCpayReceiveStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('cpay_receive_status')){
            Schema::Table('cpay_receive_status',function (Blueprint $table) {
                if(Schema::hasColumn('cpay_receive_status','CPAY_STATUS_ID')){
                    $table->renameColumn('CPAY_STATUS_ID','RECEIVE_STATUS_ID');
                }
                if(Schema::hasColumn('cpay_receive_status','CPAY_STATUS_NAME')){
                    $table->renameColumn('CPAY_STATUS_NAME','RECEIVE_STATUS_NAME');
                }
            });
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
