<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        if (!Schema::hasTable('fdh_opd'))
        {
            Schema::connection('mysql')->create('fdh_opd', function (Blueprint $table) {
                $table->bigIncrements('fdh_opd_id');

                $table->string('HN',length: 15)->nullable();//
                $table->string('CLINIC',length: 5)->nullable();//
                $table->string('DATEOPD',length: 8)->nullable();// 
                // $table->date('DATEOPD')->nullable();// 
                $table->string('TIMEOPD',length: 4)->nullable();//  
                $table->string('SEQ',length: 15)->nullable(); //             
                $table->string('UUC',length: 1)->nullable(); // 
               
                $table->string('DETAIL',length: 255)->nullable(); //  
                $table->decimal('BTEMP',total: 3, places: 1)->nullable(); // 
                $table->decimal('SBP',total: 3, places: 0)->nullable(); //  
                $table->decimal('DBP',total: 3, places: 0)->nullable(); //  
                $table->decimal('PR',total: 3, places: 0)->nullable(); // 
                $table->decimal('RR',total: 3, places: 0)->nullable(); //   
                $table->string('OPTYPE',length: 2)->nullable(); // 
                $table->string('TYPEIN',length: 1)->nullable(); // 
                $table->string('TYPEOUT',length: 1)->nullable(); // 

                $table->string('d_anaconda_id')->nullable(); // 
                $table->string('user_id')->nullable(); //        
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fdh_opd');
    }
};
