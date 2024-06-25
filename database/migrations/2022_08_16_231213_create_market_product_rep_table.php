<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        if (!Schema::hasTable('market_product_rep'))
        {
        Schema::create('market_product_rep', function (Blueprint $table) {
            $table->bigIncrements('request_id');
            $table->string('request_code')->nullable();//เลขที่บิล
            $table->string('request_no_bill')->nullable();//เลขที่บิลตัวแทนจำหน่าย
            $table->string('request_year')->nullable();//ปี 
            $table->date('request_date')->nullable();//ลงวันที่รับ             
            $table->string('request_because')->nullable();//เหตุผล 
            $table->string('request_vendor_id')->nullable();//ตัวแทนจำหน่าย 
            $table->string('request_vendor_name')->nullable();//ตัวแทนจำหน่าย 
            $table->string('request_user_id')->nullable();//ผู้รายงาน 
            $table->string('request_user_name')->nullable();//
            
            $table->string('request_status')->nullable();  //สถานะ  
            $table->string('store_id')->nullable();  
            $table->timestamps();
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
        Schema::dropIfExists('market_product_rep');
    }
};
