<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillInLaunderWithdrowSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('launder_withdrow_sub', function (Blueprint $table) {

            if(!schema::hasColumn('launder_withdrow_sub','LAUNDER_WITHDROW_SUB_TOP')){
                $table->text('LAUNDER_WITHDROW_SUB_TOP')->nullable();
            }

            if(!schema::hasColumn('launder_withdrow_sub','LAUNDER_WITHDROW_SUB_TREASURY')){
                $table->text('LAUNDER_WITHDROW_SUB_TREASURY')->nullable();
            }

            if(!schema::hasColumn('launder_withdrow_sub','LAUNDER_WITHDROW_SUB_HAVE')){
                $table->text('LAUNDER_WITHDROW_SUB_HAVE')->nullable();
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
        Schema::table('launder_withdrow_sub', function (Blueprint $table) {
            //
        });
    }
}
