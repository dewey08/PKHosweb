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
        if (!Schema::hasTable('products_vendor'))
        {
        Schema::create('products_vendor', function (Blueprint $table) {
            $table->bigIncrements('vendor_id');
            $table->string('vendor_name')->nullable();//ชื่อตัวแทน 
            $table->string('vendor_phone')->nullable();//เบอร์โทร 
            $table->string('vendor_address')->nullable();//ที่อยู่
            $table->string('vendor_tax')->nullable();//เลขผู้เสียภาษี
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
        Schema::dropIfExists('products_vendor');
    }
};
