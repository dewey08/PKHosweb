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
        if (!Schema::hasTable('fdh_adp'))
        {
            Schema::connection('mysql')->create('fdh_adp', function (Blueprint $table) {
                $table->bigIncrements('fdh_adp_id'); 
                
                $table->string('HN',length: 15)->nullable();// 
                $table->string('AN',length: 15)->nullable();//  
                $table->string('DATEOPD')->nullable();//  
                $table->string('TYPE',length: 2)->nullable();//  
                $table->string('CODE',length: 30)->nullable(); //   
                $table->decimal('QTY',total: 4, places: 0)->nullable();//    
                $table->decimal('RATE',total: 12, places: 2)->nullable();//  
                $table->string('SEQ',length: 15)->nullable(); // 
                $table->string('CAGCODE',length: 10)->nullable(); //
                $table->string('DOSE',length: 10)->nullable(); //
                $table->string('CA_TYPE',length: 1)->nullable(); //
                $table->string('SERIALNO',length: 24)->nullable(); //
                $table->decimal('TOTCOPAY',total: 12, places: 2)->nullable();//  
                $table->string('USE_STATUS',length: 1)->nullable(); //
                $table->decimal('TOTAL',total: 12, places: 2)->nullable();//  
                $table->decimal('QTYDAY',total: 3, places: 0)->nullable();//  
                $table->string('TMLTCODE',length: 15)->nullable(); //
                $table->string('STATUS1',length: 1)->nullable(); // 
                $table->decimal('BI',total: 3, places: 0)->nullable();// 
                $table->string('CLINIC',length: 5)->nullable(); // 
                $table->decimal('ITEMSRC',total: 1, places: 0)->nullable();// 
                $table->string('PROVIDER',length: 15)->nullable(); //
                $table->string('GRAVIDA',length: 2)->nullable(); //
                $table->string('GA_WEEK',length: 2)->nullable(); //
                $table->string('DCIP',length: 2)->nullable(); //
                $table->string('LMP',length: 8)->nullable(); // 
                $table->string('SP_ITEM',length: 2)->nullable(); // 
                $table->string('icode')->nullable(); // 
                $table->date('vstdate')->nullable(); // 
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
        Schema::dropIfExists('fdh_adp');
    }
};
