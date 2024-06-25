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
        if (!Schema::hasTable('acc_stm_repmoney'))
        {
            Schema::connection('mysql')->create('acc_stm_repmoney', function (Blueprint $table) {
                $table->bigIncrements('acc_stm_repmoney_id');
                $table->string('acc_trimart_id')->nullable();//
                $table->string('acc_stm_repmoney_book')->nullable();//
                $table->string('acc_stm_repmoney_no')->nullable();//
                $table->string('acc_stm_repmoney_price301')->nullable();//
                $table->string('acc_stm_repmoney_price302')->nullable();//
                $table->string('acc_stm_repmoney_price310')->nullable();//
                $table->date('acc_stm_repmoney_date')->nullable();//
                $table->string('user_id')->nullable();//
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
        Schema::dropIfExists('acc_stm_repmoney');
    }
};
