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
        if (!Schema::hasTable('medical_typecat'))
        {
        Schema::create('medical_typecat', function (Blueprint $table) {
            $table->bigIncrements('medical_typecat_id');   
            $table->string('medical_typecatname')->nullable();//  
            $table->binary('img')->nullable();// 
            $table->string('img_name')->nullable();// 
            $table->enum('medical_typecat_active', ['TRUE','FALSE'])->default('TRUE')->nullable();
            $table->timestamps();
        });

        // if (Schema::hasTable('medical_typecat')) {
        //     DB::table('medical_typecat')->truncate();
        // }
        DB::table('medical_typecat')->insert(array(
            'medical_typecat_id' => '1', 
            'medical_typecatname' => 'defrib',   
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('medical_typecat')->insert(array(
            'medical_typecat_id' => '2', 
            'medical_typecatname' => 'EKG', 
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('medical_typecat')->insert(array(
            'medical_typecat_id' => '3', 
            'medical_typecatname' => 'Monitor',   
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('medical_typecat')->insert(array(
            'medical_typecat_id' => '4', 
            'medical_typecatname' => 'Syringe Pump',   
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('medical_typecat')->insert(array(
            'medical_typecat_id' => '5', 
            'medical_typecatname' => 'Infusion Pump',    
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_typecat');
    }
};
