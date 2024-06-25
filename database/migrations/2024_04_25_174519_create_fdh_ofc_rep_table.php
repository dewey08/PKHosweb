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
        if (!Schema::hasTable('fdh_ofc_rep'))
        {
            Schema::connection('mysql')->create('fdh_ofc_rep', function (Blueprint $table) { 
                $table->bigIncrements('fdh_ofc_rep_id');//  
                $table->enum('active', ['N','S','Y','T'])->default('N')->nullable();
                $table->text('A')->nullable();//   
                $table->text('B')->nullable();//  
                $table->text('C')->nullable();//  
                $table->text('D')->nullable();//  
                $table->text('E')->nullable();//  
                $table->text('F')->nullable();// 
                $table->text('G')->nullable();// 
                $table->text('H')->nullable();//  
                $table->date('I')->nullable();//
                $table->text('J')->nullable();//  
                $table->decimal('K',total: 12, places: 2)->nullable();// 
                $table->decimal('L',total: 12, places: 2)->nullable();// 
                $table->text('M')->nullable();// 
                $table->text('N')->nullable();// 
                $table->text('O')->nullable();// 
                $table->text('P')->nullable();// 
                $table->text('Q')->nullable();// 
                $table->text('R')->nullable();// 
                $table->text('S')->nullable();// 
                $table->text('T')->nullable();// 
                $table->text('U')->nullable();// 
                $table->text('V')->nullable();// 
                $table->text('W')->nullable();// 
                $table->text('X')->nullable();// 
                $table->text('Y')->nullable();// 
                $table->text('Z')->nullable();// 
                $table->text('AA')->nullable();// 
                $table->text('AB')->nullable();// 
                $table->text('AC')->nullable();// 

                $table->decimal('AD',total: 12, places: 2)->nullable();// 
                $table->decimal('AE',total: 12, places: 2)->nullable();// 
                $table->decimal('AF',total: 12, places: 2)->nullable();// 
                $table->decimal('AG',total: 12, places: 2)->nullable();// 
                $table->decimal('AH',total: 12, places: 2)->nullable();// 
                $table->decimal('AI',total: 12, places: 2)->nullable();//  

              
                $table->text('AJ')->nullable();// 
                $table->text('AK')->nullable();// 
                $table->text('AL')->nullable();// 
                $table->text('AM')->nullable();//  
          
                $table->decimal('AN',total: 12, places: 2)->nullable();// 
                $table->decimal('AO',total: 12, places: 2)->nullable();// 
                $table->decimal('AP',total: 12, places: 2)->nullable();// 
                $table->decimal('AQ',total: 12, places: 2)->nullable();// 
                $table->decimal('AR',total: 12, places: 2)->nullable();//  
                $table->decimal('AS',total: 12, places: 2)->nullable();// 
                $table->decimal('AT',total: 12, places: 2)->nullable();// 
                $table->decimal('AU',total: 12, places: 2)->nullable();// 
                $table->decimal('AV',total: 12, places: 2)->nullable();//  

                $table->text('AW')->nullable();// 
                $table->text('AX')->nullable();// 
                $table->text('AY')->nullable();//   
                $table->text('AZ')->nullable();// 
                $table->text('BA')->nullable();//  
                $table->text('BB')->nullable();//  
                $table->text('BC')->nullable();// 
                $table->text('BD')->nullable();//  
                $table->text('STMdoc')->nullable();//  
                $table->timestamps();
            }); 
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fdh_ofc_rep');
    }
};
