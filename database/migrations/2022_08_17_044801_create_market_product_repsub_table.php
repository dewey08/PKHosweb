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
        if (!Schema::hasTable('market_product_repsub'))
        {
        Schema::create('market_product_repsub', function (Blueprint $table) {
            $table->bigIncrements('request_sub_id');
            $table->string('request_id')->nullable();//
            $table->string('request_sub_product_id')->nullable();//
            $table->string('request_sub_product_code')->nullable();//
            $table->string('request_sub_product_name')->nullable();//
            $table->string('request_sub_qty')->nullable();//
            $table->double('request_sub_price', 10, 2);
            $table->double('request_sub_sum_price', 10, 2);
            $table->string('request_sub_unitid')->nullable();//
            $table->string('request_sub_unitname')->nullable();//
            $table->string('request_sub_unit_bigid')->nullable();//
            $table->string('request_sub_unit_bigname')->nullable();//
            $table->string('request_sub_lot')->nullable();//
            $table->string('request_sub_pay_bigunit')->nullable();//
            $table->string('request_sub_pay_subunit')->nullable();//
            $table->string('request_sub_pay_totalunit')->nullable();//
            $table->date('request_sub_date_pay')->nullable();//
            $table->date('request_sub_date_exp')->nullable();//วันที่หมดอายุ             
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
        Schema::dropIfExists('market_product_repsub');
    }
};
