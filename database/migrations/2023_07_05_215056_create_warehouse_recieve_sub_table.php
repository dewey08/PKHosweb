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
        if (!Schema::hasTable('warehouse_recieve_sub'))
        {
            Schema::create('warehouse_recieve_sub', function (Blueprint $table) {
                $table->bigIncrements('warehouse_recieve_sub_id');
                $table->string('warehouse_recieve_id')->nullable();//
                $table->string('warehouse_recieve_code')->nullable();//เลขที่บิล

                $table->string('product_id')->nullable();//
                $table->string('product_code')->nullable();//
                $table->string('product_name')->nullable();  //ชื่อ

                $table->string('product_type_id')->nullable(); //
                $table->string('product_unit_bigid')->nullable(); //หน่วยบรรจุ
                $table->string('product_unit_subid')->nullable(); //หน่วยย่อย

                $table->string('product_unit_total')->nullable(); //ยอดรวมหน่วย
                $table->string('product_qty')->nullable();  //จำนวน
                $table->string('product_price')->nullable();  //ราคา
                $table->string('product_price_total')->nullable();  //ยอดรวมราคา
                $table->string('product_lot')->nullable();  //lot

                $table->date('warehouse_recieve_sub_exedate')->nullable();//วันที่ผลิต
                $table->date('warehouse_recieve_sub_expdate')->nullable();//วันที่หมดอายุ

                $table->string('warehouse_recieve_sub_status')->nullable();  //สถานะ
                $table->string('warehouse_recieve_sub_total')->nullable();  //Totl
                $table->string('warehouse_rep_id')->nullable();
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
        Schema::dropIfExists('warehouse_recieve_sub');
    }
};
