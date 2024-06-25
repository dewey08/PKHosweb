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
        if (!Schema::hasTable('d_aipadt'))
        {
            Schema::connection('mysql')->create('d_aipadt', function (Blueprint $table) {
                $table->bigIncrements('d_aipadt_id');
                $table->string('AN')->nullable();//   
                $table->string('HN')->nullable();//  
                $table->string('IDTYPE')->nullable();// 
                $table->string('PIDPAT')->nullable();// 
                $table->string('TITLE')->nullable();// 
                $table->string('NAMEPAT')->nullable();// 
                $table->string('DOB')->nullable();// 
                $table->string('SEX')->nullable();// 
                $table->string('MARRIAGE')->nullable();// 
                $table->string('CHANGWAT')->nullable();// 
                $table->string('AMPHUR')->nullable();// 
                $table->string('NATION')->nullable();// 
                $table->string('AdmType')->nullable();// 
                $table->string('AdmSource')->nullable();// 
                $table->date('DTAdm_d')->nullable();// 
                $table->Time('DTAdm_t')->nullable();// 
                $table->date('DTDisch_d')->nullable();// 
                $table->Time('DTDisch_t')->nullable();//
                $table->string('LeaveDay')->nullable();// 
                $table->string('DischStat')->nullable();//  
                $table->string('DishType')->nullable();// 
                $table->string('AdmWt')->nullable();// 
                $table->string('DishWard')->nullable();// 
                $table->string('Dept')->nullable();//  
                $table->string('HMAIN')->nullable();// 
                $table->string('ServiceType')->nullable();//  
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
        Schema::dropIfExists('d_aipadt');
    }
};
