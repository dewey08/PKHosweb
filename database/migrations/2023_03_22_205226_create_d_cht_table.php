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
        if (!Schema::hasTable('d_cht'))
        {
            Schema::connection('mysql')->create('d_cht', function (Blueprint $table) {
                $table->bigIncrements('d_cht_id');

                $table->string('HN',length: 15)->nullable();// 
                $table->string('AN',length: 15)->nullable();// 
                $table->date('DATE')->nullable();//                  
                $table->decimal('TOTAL',total: 12, places: 2)->nullable();//  
                $table->decimal('PAID',total: 12, places: 2)->nullable();//  
                $table->string('PTTYPE',length: 2)->nullable(); //   
                $table->string('PERSON_ID',length: 13)->nullable(); // 
                $table->string('SEQ',length: 15)->nullable(); // 
                $table->string('OPD_MEMO',length: 500)->nullable(); // 
                $table->string('INVOICE_NO',length: 50)->nullable(); // 
                $table->string('INVOICE_LT',length: 50)->nullable(); // 

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
        Schema::dropIfExists('d_cht');
    }
};
