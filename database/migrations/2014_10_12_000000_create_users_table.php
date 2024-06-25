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
        if (!Schema::hasTable('users'))
        {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('pname', length: 100)->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('cid', length: 100)->nullable();
            $table->string('fingle')->nullable();
            $table->string('tel', length: 100)->nullable();
            $table->string('username', length: 100);
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', length: 100);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('type', ['ADMIN', 'STAFF', 'CUSTOMER','SUPPLIES','MANAGE','USER','NOTUSER'])->default('USER');
            $table->string('passapp', length: 100)->nullable();
            $table->string('line_token')->nullable();
            $table->string('group_p4p')->nullable();            
            $table->string('dep_id', length: 100)->nullable();
            $table->string('dep_name')->nullable();
            $table->string('dep_subid', length: 100)->nullable();
            $table->string('dep_subname')->nullable();
            $table->string('dep_subsubid', length: 100)->nullable();
            $table->string('dep_subsubname')->nullable();
            $table->string('dep_subsubtrueid', length: 100)->nullable();
            $table->string('dep_subsubtruename')->nullable();
            $table->string('users_type_id', length: 100)->nullable(); //ประเภทข้าราชการ
            $table->string('users_type_name')->nullable(); //ประเภทข้าราชการ
            $table->string('users_group_id', length: 100)->nullable(); //กลุ่มบุคลากร
            $table->string('users_group_name')->nullable(); //กลุ่มบุคลากร
            $table->string('position_id', length: 100)->nullable();
            $table->string('position_name')->nullable();
            $table->string('status', length: 100)->nullable();
            $table->string('permiss_person', length: 100)->nullable();
            $table->string('permiss_book', length: 100)->nullable();
            $table->string('permiss_car', length: 100)->nullable();
            $table->string('permiss_meetting', length: 100)->nullable();
            $table->string('permiss_repair', length: 100)->nullable();
            $table->string('permiss_com', length: 100)->nullable();
            $table->string('permiss_medical', length: 100)->nullable();
            $table->string('permiss_hosing', length: 100)->nullable();
            $table->string('permiss_plan', length: 100)->nullable();
            $table->string('permiss_asset', length: 100)->nullable();
            $table->string('permiss_supplies', length: 100)->nullable();
            $table->string('permiss_store', length: 100)->nullable();
            $table->string('permiss_store_dug', length: 100)->nullable();
            $table->string('permiss_pay', length: 100)->nullable();
            $table->string('permiss_money', length: 100)->nullable();
            $table->string('permiss_claim', length: 100)->nullable();
            $table->string('permiss_ot', length: 100)->nullable();
            $table->string('permiss_medicine', length: 100)->nullable();
            $table->string('permiss_gleave', length: 100)->nullable();
            $table->string('permiss_p4p', length: 100)->nullable();

            $table->string('permiss_timeer', length: 100)->nullable();
            $table->string('permiss_env', length: 100)->nullable();
            $table->string('permiss_account', length: 100)->nullable();
            $table->string('permiss_dental', length: 100)->nullable();
            $table->string('permiss_report_all', length: 100)->nullable();
            $table->string('permiss_setting_account', length: 100)->nullable();  //การบัญชี
            $table->string('permiss_setting_upstm', length: 100)->nullable();  //UP STM
            $table->string('permiss_setting_env', length: 100)->nullable();
            $table->string('permiss_ucs', length: 100)->nullable();
            $table->string('permiss_sss', length: 100)->nullable();
            $table->string('permiss_ofc', length: 100)->nullable();
            $table->string('permiss_lgo', length: 100)->nullable();
            $table->string('permiss_prb', length: 100)->nullable();
            $table->string('permiss_ti', length: 100)->nullable();
            $table->string('permiss_setting_warehouse', length: 100)->nullable(); 
            $table->string('permiss_rep_money', length: 100)->nullable(); //ใบเสร็จรับเงิน
            $table->string('permiss_sot', length: 100)->nullable();
            $table->string('permiss_clinic_tb', length: 100)->nullable();
            $table->string('permiss_medicine_salt', length: 100)->nullable();
            $table->string('pesmiss_ct', length: 100)->nullable();
            $table->string('per_prs', length: 100)->nullable();

            $table->string('store_id', length: 100)->nullable();
            $table->string('member_id', length: 100)->nullable();
            $table->string('img')->nullable();
            $table->string('img_name')->nullable(); 
            $table->double('money', 10, 2)->nullable(); 
            $table->string('color_ot', length: 100)->nullable();
            $table->string('staff')->nullable();  
            $table->string('loginname', length: 100)->nullable(); 
            $table->string('passweb', length: 100)->nullable(); 
            $table->string('per_cctv', length: 100)->nullable(); 
            $table->string('per_fire', length: 100)->nullable(); 
            $table->string('per_air', length: 100)->nullable();
            $table->string('per_fdh', length: 100)->nullable(); 
            $table->string('lineid', length: 100)->nullable(); 
            $table->rememberToken();
            // $table->timestamps('created_at')->useCurrent();
            // $table->timestamps('updated_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
