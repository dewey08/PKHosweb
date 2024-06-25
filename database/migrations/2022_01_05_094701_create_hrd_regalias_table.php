<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdRegaliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('hrd_regalias')) {
            Schema::create('hrd_regalias', function (Blueprint $table) {
                $table->id();
                $table->string('HRD_REGALIIAS')->nullable();
                $table->string('YEAR_OF_RECEIPT')->nullable();
                $table->string('DAY_OF_RECEIPT')->nullable();
                $table->string('POSITION')->nullable();
                $table->string('BADGE')->nullable();
                $table->string('BADGE_R_G_L')->nullable();
                $table->string('BADGE_R_G_D')->nullable();
                $table->string('ANNOUNCEMENT_DATE')->nullable();
                $table->string('VOLUME')->nullable();
                $table->string('DUTY')->nullable();
                $table->string('NO')->nullable();
                $table->string('AGENCY')->nullable();
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
        Schema::dropIfExists('hrd_regalias');
    }
}
