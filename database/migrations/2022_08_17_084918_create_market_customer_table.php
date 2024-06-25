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
        if (!Schema::hasTable('market_customer'))
        {
        Schema::create('market_customer', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->string('customer_pname')->nullable();  //ชื่อ
            $table->string('pcustomer_fname')->nullable();  //ชื่อ  
            $table->string('pcustomer_lname')->nullable(); //
            $table->string('pcustomer_tel')->nullable(); // 
            $table->string('pcustomer_address')->nullable(); //
            $table->string('pcustomer_email')->nullable(); //
            $table->string('pcustomer_code')->nullable(); //รหัสสมาชิก
            // $table->string('product_unit_subname')->nullable(); //
            // $table->string('product_unit_total')->nullable(); //
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
        Schema::dropIfExists('market_customer');
    }
};
