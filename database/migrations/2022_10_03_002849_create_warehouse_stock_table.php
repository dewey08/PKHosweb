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
        if (!Schema::hasTable('warehouse_stock'))
        {
        Schema::create('warehouse_stock', function (Blueprint $table) {
            $table->bigIncrements('warehouse_stock_id');  
            $table->string('warehouse_inven_id')->nullable();//  
            $table->string('product_id')->nullable();// 
            $table->string('product_code')->nullable();// 
            $table->string('product_name')->nullable();  //ชื่อ
            $table->string('product_type_id')->nullable(); //           
            $table->string('product_unit_bigid')->nullable(); //หน่วยบรรจุ            
            $table->string('product_unit_subid')->nullable(); //หน่วยย่อย 
            $table->string('product_unit_total')->nullable(); //ยอดรวมหน่วย
            $table->string('product_qty_insert')->nullable();  //จำนวน 
            $table->string('product_qty_update')->nullable();  //จำนวน 
            $table->string('product_qty_recieve')->nullable();  //จำนวน 
            $table->string('product_qty_pay')->nullable();  //จำนวน             
            $table->double('product_price', 10, 2)->nullable();//ราคา
            $table->string('product_qty_total')->nullable();  //จำนวน 
            $table->double('product_price_total', 10, 2)->nullable();  //ยอดรวมราคา   
            $table->enum('warehouse_stock_status',['TRUE', 'FALSE'])->default('TRUE');  //สถานะ   
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
        Schema::dropIfExists('warehouse_stock');
    }
};
