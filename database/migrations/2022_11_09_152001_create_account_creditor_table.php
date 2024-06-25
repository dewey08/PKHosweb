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
        if (!Schema::hasTable('account_creditor'))
        {
        Schema::create('account_creditor', function (Blueprint $table) {
            $table->bigIncrements('account_creditor_id'); 
            $table->string('account_creditor_code')->nullable();// 
            $table->string('account_creditor_name')->nullable();//  
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
        Schema::dropIfExists('account_creditor');
    }
};
