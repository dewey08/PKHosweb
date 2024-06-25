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
        if (!Schema::hasTable('market_basket'))
        {
        Schema::create('market_basket', function (Blueprint $table) {
            $table->bigIncrements('basket_id');
            $table->string('bill_id')->nullable();//
            $table->string('basket_product_id')->nullable();//
            $table->string('basket_product_code')->nullable();//
            $table->string('basket_product_name')->nullable();// 
            $table->string('basket_qty')->nullable();//
            $table->double('basket_price', 10, 2)->nullable();
            $table->double('basket_sum_price', 10, 2)->nullable();
            $table->string('basket_sub_unitid')->nullable();//
            $table->string('basket_sub_unitname')->nullable();// 
            $table->string('basket_sub_lot')->nullable();//          
            $table->string('store_id')->nullable();
            $table->string('bill_no')->nullable();// 
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
        Schema::dropIfExists('market_basket');
    }
};
