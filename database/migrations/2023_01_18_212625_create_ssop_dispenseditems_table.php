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
        if (!Schema::hasTable('ssop_dispenseditems'))
        {
            Schema::connection('mysql')->create('ssop_dispenseditems', function (Blueprint $table) {
                $table->bigIncrements('ssop_dispenseditems_id');
                $table->string('DispID')->nullable();//   
                $table->string('PrdCat')->nullable();// 
                $table->string('HospDrgID')->nullable();// 
                $table->string('DrgID')->nullable();// 
                $table->string('dfsText')->nullable();// 
                $table->string('Packsize')->nullable();// 
                $table->string('sigCode')->nullable();//  
                $table->string('sigText')->nullable();// 
                $table->string('Quantity')->nullable();// 

                $table->double('UnitPrice', 10, 2)->nullable();// 
                $table->double('ChargeAmt', 10, 2)->nullable();// 
                $table->double('ReimbPrice', 10, 2)->nullable();// 
                $table->double('ReimbAmt', 10, 2)->nullable();// 
                $table->string('PrdSeCode')->nullable();// 
                $table->string('Claimcont')->nullable();// 
                $table->string('ClaimCat')->nullable();// 
                $table->string('paidst')->nullable();//  
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
        Schema::dropIfExists('ssop_dispenseditems');
    }
};
