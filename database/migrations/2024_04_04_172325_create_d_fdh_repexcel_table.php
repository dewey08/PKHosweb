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
        if (!Schema::hasTable('d_fdh_repexcel'))
        {
            Schema::connection('mysql')->create('d_fdh_repexcel', function (Blueprint $table) { 
                $table->bigIncrements('d_fdh_repexcel_id');//  
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
                $table->text('AD')->nullable();// 
                $table->text('AE')->nullable();// 
                $table->text('AF')->nullable();// 
                $table->text('AG')->nullable();// 
                $table->text('AH')->nullable();// 
                $table->text('AI')->nullable();// 
                $table->text('AJ')->nullable();// 
                $table->text('AK')->nullable();// 
                $table->text('AL')->nullable();//  
                $table->decimal('AM',total: 12, places: 2)->nullable();// 
                $table->decimal('AN',total: 12, places: 2)->nullable();// 
                $table->decimal('AO',total: 12, places: 2)->nullable();// 
                $table->decimal('AP',total: 12, places: 2)->nullable();// 
                $table->decimal('AQ',total: 12, places: 2)->nullable();// 
                $table->decimal('AR',total: 12, places: 2)->nullable();//  
                $table->text('AS')->nullable();// 
                $table->text('AT')->nullable();// 
                $table->text('AU')->nullable();// 
                $table->text('AV')->nullable();// 
                $table->text('AW')->nullable();//  
                $table->decimal('AX',total: 12, places: 2)->nullable();// 
                $table->decimal('AY',total: 12, places: 2)->nullable();//  
                $table->text('AZ')->nullable();// 
                $table->text('BA')->nullable();//  
                $table->decimal('BB',total: 12, places: 2)->nullable();// 
                $table->text('BC')->nullable();// 
                $table->text('BD')->nullable();// 
                $table->text('BE')->nullable();// 
                $table->text('BF')->nullable();// 
                $table->text('BG')->nullable();// 
                $table->text('BH')->nullable();// 
                $table->text('BI')->nullable();// 
                $table->text('BJ')->nullable();// 
                $table->text('BK')->nullable();// 
                $table->text('BL')->nullable();// 
                $table->text('BM')->nullable();// 
                $table->text('BN')->nullable();// 
                $table->text('BO')->nullable();// 
                $table->text('BP')->nullable();// 
                $table->text('BQ')->nullable();// 
                $table->text('BR')->nullable();// 
                $table->text('BS')->nullable();// 
                $table->text('BT')->nullable();// 
                $table->text('BU')->nullable();// 
                $table->text('BV')->nullable();// 
                $table->text('BW')->nullable();// 
                $table->text('BX')->nullable();//  
                $table->decimal('BY',total: 12, places: 2)->nullable();// 
                $table->decimal('BZ',total: 12, places: 2)->nullable();// 
                $table->text('CA')->nullable();// 
                $table->text('CB')->nullable();//  
                $table->decimal('CC',total: 12, places: 2)->nullable();// 
                $table->text('CD')->nullable();//  
                $table->decimal('CE',total: 12, places: 2)->nullable();// 
                $table->text('CF')->nullable();// 
                $table->decimal('CG',total: 12, places: 2)->nullable();// 
                $table->text('CH')->nullable();// 
                $table->text('CI')->nullable();//  
                $table->text('CJ')->nullable();// 
                $table->text('CK')->nullable();// 
                $table->text('CL')->nullable();// 
                $table->text('CM')->nullable();// 
                $table->text('CN')->nullable();// 
                $table->text('CO')->nullable();// 
                $table->text('CP')->nullable();// 
                $table->text('CQ')->nullable();// 
                $table->text('CR')->nullable();// 
                $table->text('CS')->nullable();// 
                $table->text('CT')->nullable();// 
                $table->text('CU')->nullable();// 
                $table->text('CV')->nullable();// 
                $table->text('CW')->nullable();// 
                $table->text('CX')->nullable();// 
                $table->text('CY')->nullable();// 
                $table->text('CZ')->nullable();// 
                $table->text('DA')->nullable();// 
                $table->text('DB')->nullable();// 
                $table->text('DC')->nullable();// 
                $table->text('DD')->nullable();// 
                $table->text('DE')->nullable();// 
                $table->text('DF')->nullable();// 
                $table->text('DG')->nullable();//  
                $table->decimal('DH',total: 12, places: 2)->nullable();//   
                $table->text('DI')->nullable();// 
                $table->text('DJ')->nullable();// 
                $table->text('DK')->nullable();// 
                $table->text('DL')->nullable();// 
                $table->text('DM')->nullable();// 
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
        Schema::dropIfExists('d_fdh_repexcel');
    }
};
