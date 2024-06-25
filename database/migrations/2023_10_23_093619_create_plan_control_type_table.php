<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        if (!Schema::hasTable('plan_control_type'))
        {
        Schema::create('plan_control_type', function (Blueprint $table) {
            $table->bigIncrements('plan_control_type_id');   
            $table->string('plan_control_typename')->nullable();//  
            $table->enum('plan_control_type_active', ['TRUE','FALSE'])->default('TRUE')->nullable();
            $table->timestamps();
        });

        if (Schema::hasTable('plan_control_type')) {
            DB::table('plan_control_type')->truncate();
        }

        DB::table('plan_control_type')->insert(array(
            'plan_control_type_id' => '1', 
            'plan_control_typename' => 'PP',           
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        )); 
        DB::table('plan_control_type')->insert(array(
            'plan_control_type_id' => '2', 
            'plan_control_typename' => 'เบิกแล้ว',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('plan_control_type')->insert(array(
            'plan_control_type_id' => '3', 
            'plan_control_typename' => 'UC',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('plan_control_type')->insert(array(
            'plan_control_type_id' => '4', 
            'plan_control_typename' => 'อปท',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('plan_control_type')->insert(array(
            'plan_control_type_id' => '5', 
            'plan_control_typename' => 'อื่นๆ',        
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
        Schema::dropIfExists('plan_control_type');
    }
};
