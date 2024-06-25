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
        if (!Schema::hasTable('d_opd'))
        {
            Schema::connection('mysql')->create('d_opd', function (Blueprint $table) {
                $table->bigIncrements('d_opd_id');

                $table->string('HN',length: 15)->nullable();//
                $table->string('CLINIC')->nullable();//
                $table->string('DATEOPD')->nullable();// 
                $table->string('TIMEOPD')->nullable();//  
                $table->string('SEQ')->nullable(); //             
                $table->string('UUC')->nullable(); // 
                $table->string('DETAIL')->nullable(); //  
                $table->decimal('BTEMP',3,1)->nullable(); // 
                $table->decimal('SBP',3)->nullable(); //  
                $table->decimal('DBP',3)->nullable(); //  
                $table->decimal('PR',3)->nullable(); // 
                $table->decimal('RR',3)->nullable(); //   
                $table->text('OPTYPE',2)->nullable(); // 
                $table->text('TYPEIN',1)->nullable(); // 
                $table->text('TYPEOUT',1)->nullable(); // 
                $table->string('d_anaconda_id')->nullable(); // 
                $table->string('user_id')->nullable(); //        
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
        Schema::dropIfExists('d_opd');
    }
};
