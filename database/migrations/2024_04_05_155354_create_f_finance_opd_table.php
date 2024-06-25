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
        if (!Schema::hasTable('f_finance_opd'))
        {
            Schema::connection('mysql')->create('f_finance_opd', function (Blueprint $table) {
                $table->bigIncrements('f_finance_opd_id');

                $table->string('year',length: 15)->nullable();//
                $table->string('months',length: 15)->nullable();//
                $table->string('months_name',length: 100)->nullable();//  
                $table->string('main_dep',length: 5)->nullable();//  
                $table->string('count_vn',length: 15)->nullable(); //  
                $table->decimal('sum_income',total: 12, places: 2)->nullable(); // 
                $table->decimal('sum_paid_money',total: 12, places: 2)->nullable(); //  
                $table->decimal('sum_rcpt_money',total: 12, places: 2)->nullable(); //  
                $table->decimal('sum_Total',total: 12, places: 2)->nullable(); //  

             
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
        Schema::dropIfExists('f_finance_opd');
    }
};
