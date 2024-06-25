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
        if (!Schema::hasTable('plan_control_money'))
        {
            Schema::connection('mysql')->create('plan_control_money', function (Blueprint $table) { 
                $table->bigIncrements('plan_control_money_id');//  
                $table->string('plan_control_id')->nullable();//   
                $table->string('plan_control_money_no')->nullable();//   ครั้งที่
                $table->date('plan_control_moneydate')->nullable();//     วันที่  
                $table->string('plan_control_moneyprice')->nullable();//   เบิก
              
                $table->string('plan_control_moneyuser_id')->nullable();//                  ผู้เบิก
                $table->string('plan_control_moneycomment')->nullable();//                 หมายเหตุ
                $table->enum('status', ['REQUEST','ACCEPT','INPROGRESS','FINISH','CANCEL','CONFIRM_CANCEL'])->default('REQUEST')->nullable();
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
        Schema::dropIfExists('plan_control_money');
    }
};
