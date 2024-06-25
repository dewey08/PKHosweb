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
        if (!Schema::hasTable('d_abillitems'))
        {
            Schema::connection('mysql')->create('d_abillitems', function (Blueprint $table) {
                $table->bigIncrements('d_abillitems_id');
                $table->string('AN')->nullable();//   
                $table->string('sequence')->nullable();// 
                $table->date('ServDate')->nullable();// 
                $table->Time('ServTime')->nullable();// 
                $table->string('BillGr')->nullable();// 
                $table->string('LCCode')->nullable();// 
                $table->string('Descript')->nullable();// 
                $table->string('QTY')->nullable();//              
                $table->double('UnitPrice', 10, 2)->nullable();
                $table->double('ChargeAmt', 10, 4)->nullable();
                $table->double('Discount', 10, 4)->nullable();
                $table->string('ProcedureSeq')->nullable();// 
                $table->string('DiagnosisSeq')->nullable();// 
                $table->string('ClaimSys')->nullable();// 
                $table->string('BillGrCS')->nullable();// 
                $table->string('CSCode')->nullable();// 
                $table->string('CodeSys')->nullable();// 
                $table->string('STDCode')->nullable();// 
                $table->string('ClaimCat')->nullable();// 
                $table->date('DateRev')->nullable();// 
                $table->double('ClaimUP', 10, 4)->nullable();
                $table->double('ClaimAmt', 10, 4)->nullable();                 
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
        Schema::dropIfExists('d_abillitems');
    }
};
