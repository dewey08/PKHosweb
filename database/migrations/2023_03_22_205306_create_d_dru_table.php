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
        if (!Schema::hasTable('d_dru'))
        {
            Schema::connection('mysql')->create('d_dru', function (Blueprint $table) {
                $table->bigIncrements('d_dru_id');
                $table->string('HCODE',length: 5)->nullable();// 
                $table->string('HN',length: 15)->nullable();// 
                $table->string('AN',length: 9)->nullable();// 
                $table->string('CLINIC',length: 5)->nullable();// 
                $table->string('PERSON_ID',length: 13)->nullable();// 
                $table->string('DATE_SERV')->nullable();//                  
                $table->string('DID',length: 30)->nullable();//  
                $table->string('DIDNAME',length: 255)->nullable(); //   
                $table->string('AMOUNT',length: 12)->nullable(); // 
                $table->string('DRUGPRIC',length: 14)->nullable(); // 
                $table->string('DRUGCOST',length: 14)->nullable(); //
                $table->string('DIDSTD',length: 24)->nullable(); //
                $table->string('UNIT',length: 20)->nullable(); //
                $table->string('UNIT_PACK',length: 20)->nullable(); //
                $table->string('SEQ',length: 15)->nullable(); //
                $table->string('DRUGREMARK',length: 2)->nullable(); //
                $table->string('PA_NO',length: 9)->nullable(); // 
                $table->decimal('TOTCOPAY',total: 12, places: 2)->nullable();//   
                $table->string('USE_STATUS',length: 1)->nullable(); //
                $table->decimal('TOTAL',total: 12, places: 2)->nullable();//  
                $table->string('SIGCODE',length: 50)->nullable(); //
                $table->string('SIGTEXT',length: 255)->nullable(); // 
                $table->string('PROVIDER',length: 15)->nullable(); //                
                $table->string('SP_ITEM',length: 2)->nullable(); // 

                $table->string('d_anaconda_id')->nullable(); // 
                $table->date('vstdate')->nullable(); // 
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
        Schema::dropIfExists('d_dru');
    }
};
