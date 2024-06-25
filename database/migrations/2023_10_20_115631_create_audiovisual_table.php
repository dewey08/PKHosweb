<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        if (!Schema::hasTable('audiovisual'))
        {
            Schema::connection('mysql')->create('audiovisual', function (Blueprint $table) { 
                $table->bigIncrements('audiovisual_id');//  
                $table->string('billno')->nullable();// 
                $table->string('ptname')->nullable();//   
                $table->string('department')->nullable();//  
                $table->string('tel')->nullable();//  
                $table->date('work_order_date')->nullable();// 
                $table->date('job_request_date')->nullable();//  
                $table->string('audiovisual_name')->nullable();// 
                $table->string('audiovisual_type')->nullable();// 
                $table->string('audiovisual_detail')->nullable();// 
                $table->string('audiovisual_qty')->nullable();//
                $table->string('audiovisual_lineid')->nullable();//
                $table->text('lineid')->nullable();//
                $table->enum('audiovisual_status', ['REQUEST','ACCEPTING','INPROGRESS','VERIFY','FINISH','CANCEL','CONFIRM_CANCEL'])->default('REQUEST')->nullable();
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
        Schema::dropIfExists('audiovisual');
    }
};
