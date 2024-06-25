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
        if (!Schema::hasTable('market_product'))
        {
        Schema::create('market_product', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->string('product_code')->nullable();  //ชื่อ
            $table->string('product_name')->nullable();  //ชื่อ  
            $table->string('product_qty')->nullable(); 
            $table->double('product_price', 10, 2)->nullable();
            $table->string('product_categoryid')->nullable(); //หวมดสินค้า
            $table->string('product_categoryname')->nullable(); //ชื่อหวมดสินค้า 
            $table->string('product_unit_bigid')->nullable(); //หน่วยบรรจุ
            $table->string('product_unit_bigname')->nullable(); //ชื่อหน่วยบรรจุ
            $table->string('product_unit_subid')->nullable(); //หน่วยย่อย
            $table->string('product_unit_subname')->nullable(); //ชื่อหน่วยย่อย
            $table->string('product_unit_total')->nullable(); //ยอดรวมหน่วย
            $table->string('img_name')->nullable();
            $table->binary('img')->nullable();
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
        Schema::dropIfExists('market_product');
    }
};
