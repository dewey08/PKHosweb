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
        if (!Schema::hasTable('market_basket_bill'))
        {
        Schema::create('market_basket_bill', function (Blueprint $table) {
            $table->bigIncrements('bill_id');
            $table->string('bill_no')->nullable();//เลขที่บิล 
            $table->date('bill_date')->nullable();//ลงวันที่รับ  
            $table->string('bill_user_id')->nullable();//ผู้ขาย
            $table->string('bill_user_name')->nullable();//            
            $table->string('bill_status')->nullable();  //สถานะ  
            $table->double('bill_total', 10, 2)->nullable();
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
        Schema::dropIfExists('market_basket_bill');
    }
};
