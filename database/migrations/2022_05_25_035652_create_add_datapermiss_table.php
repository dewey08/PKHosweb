<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddDatapermissTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $check =  DB::table('gsy_permis')->where('PERMIS_ID', '=', 'GSU004')->count();
        if ($check == 0) {
            DB::table('gsy_permis')->insert(array(
                'PERMIS_ID' => 'GSU004',
                'PERMIS_NAME' => 'ออกเลขทะเบียนคุม(อย่างเดียว)',

            ));
        }
        // Schema::create('add_datapermiss', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('add_datapermiss');
    }
}
