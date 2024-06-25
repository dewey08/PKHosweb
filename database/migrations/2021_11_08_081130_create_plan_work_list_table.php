<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanWorkListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('plan_work_list')) {

                        Schema::create('plan_work_list', function (Blueprint $table) {
                            $table->increments("PLANWORK_LIST_ID",11);
                            $table->String("PLANWORK_ID",255)->nullable();
                            $table->String("PLANWORK_LIST_DETAIL",255)->nullable();
                            $table->dateTime('updated_at')->nullable();
                            $table->dateTime('created_at')->nullable();
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
        Schema::dropIfExists('plan_work_list');
    }
}
