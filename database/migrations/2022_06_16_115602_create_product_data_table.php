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
        if (!Schema::hasTable('product_data'))
        {
        Schema::create('product_data', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->string('product_code')->nullable();  //ชื่อ
            $table->string('product_name')->nullable();  //ชื่อ
            $table->string('product_attribute')->nullable(); //คุณลักษณะ
            $table->string('product_spypriceid')->nullable(); //ราคาสืบ
            $table->string('product_spypricename')->nullable(); //ชื่อราคาสืบ
            $table->string('product_typeid')->nullable(); //ประเภทวัสดุ
            $table->string('product_typename')->nullable(); //ชื่อประเภทวัสดุ
            $table->string('product_categoryid')->nullable(); //หวมดวัสดุ
            $table->string('product_categoryname')->nullable(); //ชื่อหวมดวัสดุ
            $table->string('product_groupid')->nullable();//ชนิดวัสดุ
            $table->string('product_groupname')->nullable();//ชื่อชนิดวัสดุ
            $table->string('product_unit_bigid')->nullable(); //หน่วยบรรจุ
            $table->string('product_unit_bigname')->nullable(); //ชื่อหน่วยบรรจุ
            $table->string('product_unit_subid')->nullable(); //หน่วยย่อย
            $table->string('product_unit_subname')->nullable(); //ชื่อหน่วยย่อย
            $table->string('product_unit_total')->nullable(); //ยอดรวมหน่วย
            $table->string('img')->nullable();
            $table->string('store_id')->nullable(); 
            $table->enum('product_claim', ['CLAIM', 'NOCLAIM'])->default('NOCLAIM');//ส่งเคลมใด้
            $table->timestamps('created_at')->useCurrent();
            $table->timestamps('updated_at')->nullable();
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
        Schema::dropIfExists('product_data');
    }
};
