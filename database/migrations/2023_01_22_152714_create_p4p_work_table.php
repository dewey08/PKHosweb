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
        if (!Schema::hasTable('p4p_work'))
        {
            Schema::create('p4p_work', function (Blueprint $table) {
                $table->bigIncrements('p4p_work_id'); 
                $table->string('p4p_work_code')->nullable();// เลขที่บิล
                $table->string('p4p_work_year')->nullable();// 
                $table->string('p4p_work_month')->nullable();// 
                $table->string('p4p_work_monthth')->nullable();//  
                $table->string('p4p_work_user')->nullable();// 
                $table->string('p4p_work_file',255)->nullable();//
                $table->string('p4p_work_filename',255)->nullable();//
                $table->text('p4p_work_sig1',500)->nullable();//
                $table->text('p4p_work_sig2',500)->nullable();//
                $table->text('p4p_work_sig3',500)->nullable();//
                $table->text('p4p_work_sig4',500)->nullable();//
                $table->enum('p4p_work_active', ['TRUE','FALSE'])->default('TRUE')->nullable();
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
        Schema::dropIfExists('p4p_work');
    }
};
