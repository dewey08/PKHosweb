<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFiilHealthBodyNToHealthBodyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('health_body', function (Blueprint $table) {
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_GA')){
                $table->string('HEALTH_BODY_GENARAL_GA',20)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_GA_COMMENT')){
                $table->string('HEALTH_BODY_GENARAL_GA_COMMENT',255)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_HEENT')){
                $table->string('HEALTH_BODY_GENARAL_HEENT',20)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_HEENT_COMMENT')){
                $table->string('HEALTH_BODY_GENARAL_HEENT_COMMENT',255)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_HEART')){
                $table->string('HEALTH_BODY_GENARAL_HEART',20)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_HEART_COMMENT')){
                $table->string('HEALTH_BODY_GENARAL_HEART_COMMENT',255)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_LUNG')){
                $table->string('HEALTH_BODY_GENARAL_LUNG',20)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_LUNG_COMMENT')){
                $table->string('HEALTH_BODY_GENARAL_LUNG_COMMENT',255)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_ABD')){
                $table->string('HEALTH_BODY_GENARAL_ABD',20)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_ABD_COMMENT')){
                $table->string('HEALTH_BODY_GENARAL_ABD_COMMENT',255)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_EXT')){
                $table->string('HEALTH_BODY_GENARAL_EXT',20)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_EXT_COMMENT')){
                $table->string('HEALTH_BODY_GENARAL_EXT_COMMENT',255)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_NEURO')){
                $table->string('HEALTH_BODY_GENARAL_NEURO',20)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_NEURO_COMMENT')){
                $table->string('HEALTH_BODY_GENARAL_NEURO_COMMENT',255)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_BREAST')){
                $table->string('HEALTH_BODY_GENARAL_BREAST',20)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_BREAST_COMMENT')){
                $table->string('HEALTH_BODY_GENARAL_BREAST_COMMENT',255)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_OTHER')){
                $table->string('HEALTH_BODY_GENARAL_OTHER',20)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_GENARAL_OTHER_COMMENT')){
                $table->string('HEALTH_BODY_GENARAL_OTHER_COMMENT',255)->nullable();
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_HAVE_RISK')){
                $table->boolean('HEALTH_BODY_HAVE_RISK')->default(0);
            }
            if(!Schema::hasColumn('health_body','HEALTH_BODY_CARE_PLAN')){
                $table->string('HEALTH_BODY_CARE_PLAN',255)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('health_body', function (Blueprint $table) {
            //
        });
    }
}
