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
        if (!Schema::hasTable('ot_type_pk'))
        {
        Schema::create('ot_type_pk', function (Blueprint $table) {
            $table->bigIncrements('ot_type_pk_id');   
            $table->string('ot_type_pkname')->nullable();//   
            
            $table->enum('ot_type_pk_active', ['TRUE','FALSE'])->default('TRUE')->nullable();
            $table->timestamps();
        });

        if (Schema::hasTable('ot_type_pk')) {
            DB::table('ot_type_pk')->truncate();
        }
        DB::table('ot_type_pk')->insert(array(
            'ot_type_pk_id' => '1', 
            'ot_type_pkname' => 'พนักงานประจำ',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('ot_type_pk')->insert(array(
            'ot_type_pk_id' => '2', 
            'ot_type_pkname' => 'ลูกจ้าง',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        // DB::table('ot_type_pk')->insert(array(
        //     'ot_type_pk_id' => '3', 
        //     'ot_type_pkname' => 'อื่นฯ',          
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // ));  
        
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ot_type_pk');
    }
};
