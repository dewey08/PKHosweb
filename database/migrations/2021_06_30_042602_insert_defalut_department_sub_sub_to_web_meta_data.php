<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertDefalutDepartmentSubSubToWebMetaData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('web_meta_data')){
            DB::table('web_meta_data')->insert([
                'meta_name' => 'CPAY_DEFAULT_DEPARTMENT_SUB_SUB_ID',
                'meta_value' => 12,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('web_meta_data', function (Blueprint $table) {
            //
        });
    }
}
