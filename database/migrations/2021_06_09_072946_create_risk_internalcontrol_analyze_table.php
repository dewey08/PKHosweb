<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskInternalcontrolAnalyzeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

                    if (!Schema::hasTable('risk_internalcontrol_analyze'))
                    {
                        Schema::create('risk_internalcontrol_analyze', function (Blueprint $table) {
                            $table->id("ANALYZE_ID",11);
                            $table->String("INTERNALCONTROL_ID",50)->nullable(); 
                            $table->String("ANALYZE_STEP",255)->nullable(); 
                            $table->String("ANALYZE_REDUCE",255)->nullable(); 
                            $table->String("ANALYZE_ACTIVITY",255)->nullable(); 
                            $table->String("ANALYZE_RESULTS",255)->nullable(); 
                            $table->String("ANALYZE_RISK",255)->nullable(); 
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
        Schema::dropIfExists('risk_internalcontrol_analyze');
    }
}
