<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlumbingName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    
       
    {      
        Schema::table('env_plumbing_set',function (Blueprint $table)
        {
            if(!Schema::hasColumn('env_plumbing_set','SETUP_PLUMBING_TESTER')){
                $table->String('SETUP_PLUMBING_TESTER',255)->nullable();
            }
            if(!Schema::hasColumn('env_plumbing_set','SETUP_PLUMBING_UNIT')){
                $table->String('SETUP_PLUMBING_UNIT',255)->nullable();
            }
        });        
        DB::table('env_plumbing_set')->truncate();
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '1',
            'SETUP_PLUMBING_NAME' => 'สี(Colour)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'Spectrophotometric-Single-Wavelength',
            'SETUP_PLUMBING_UNIT' => '( แพลตตินัมโคบอลท์ )',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
         ));
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '2',
           'SETUP_PLUMBING_NAME' => 'ความขุ่น(Turbidity)',
           'SETUP_PLUMBING_TEST' => '',
           'SETUP_PLUMBING_TESTER' => 'Nephelometric',
           'SETUP_PLUMBING_UNIT' => '( เอ็นทียู )',
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
         ));
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '3',
            'SETUP_PLUMBING_NAME' => 'ปริมาณสารทั้งหมดที่เหลือจากการระเหย(TDS)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'TDS Dried at 180 C',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
         ));
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '4',
            'SETUP_PLUMBING_NAME' => 'ความกระด้าง(Hardness)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'EDTA Titrimetry',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
         ));
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '5',
            'SETUP_PLUMBING_NAME' => 'ซัลเฟต(Sulfate)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'Ion Chromatography',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
         ));
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '6',
            'SETUP_PLUMBING_NAME' => 'คลอไรด์(Chloride)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'Ion Chromatography',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
         ));
         DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '7',
            'SETUP_PLUMBING_NAME' => 'ไนเตรท(Nitrate)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'Ion Chromatography',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
         ));
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '8',
            'SETUP_PLUMBING_NAME' => 'ฟลูออไรด์(Fluoride)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'Ion Chromatography',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
       
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '9',
            'SETUP_PLUMBING_NAME' => 'เหล็ก(Iron)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'ICP',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '10',
            'SETUP_PLUMBING_NAME' => 'แมงกานีส(Manganese)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'ICP',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
         DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '11',
            'SETUP_PLUMBING_NAME' => 'ทองแดง(Copper)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'ICP',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '12',
            'SETUP_PLUMBING_NAME' => 'สังกะสี(Zinc)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'ICP',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
      
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '13',
            'SETUP_PLUMBING_NAME' => 'ตะกั่ว(Lead)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'ICP',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '14',
            'SETUP_PLUMBING_NAME' => 'โครเมี่ยม(Cromium)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'ICP',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '15',
            'SETUP_PLUMBING_NAME' => 'แคดเมี่ยม(Cadmium)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'ICP',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
         DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '16',
            'SETUP_PLUMBING_NAME' => 'สารหนู(Arsenic)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'ICP',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_plumbing_set')->insert(array(
            'SETUP_PLUMBING_ID' => '17',
            'SETUP_PLUMBING_NAME' => 'ปรอท(Mercury)',
            'SETUP_PLUMBING_TEST' => '',
            'SETUP_PLUMBING_TESTER' => 'ICP',
            'SETUP_PLUMBING_UNIT' => '( มก./ล.)',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
         ));
     


    }
 
    public function down()
     {
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','สี(Colour)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TESTER','=','Spectrophotometric-Single-Wavelength')->where('SETUP_PLUMBING_UNIT','=','แพลตตินัมโคบอลท์')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','ความขุ่น(Turbidity)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','Nephelometric')->where('SETUP_PLUMBING_UNIT','=','เอ็นทียู')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','ปริมาณสารทั้งหมดที่เหลือจากการระเหย(TDS)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','TDS Dried at 180 ํC')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','ความกระด้าง(Hardness)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','EDTA Titrimetry')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','ซัลเฟต(Sulfate')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','Ion Chromatography')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','คลอไรด์(Chloride)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','Ion Chromatography')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','ไนเตรท(Nitrate')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','Ion Chromatography')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','ฟลูออไรด์(Fluoride)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','Ion Chromatography')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','เหล็ก(Iron)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','ICP')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','แมงกานีส(Manganese)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','ICP')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','ทองแดง(Copper)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','ICP')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','สังกะสี(Zinc)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','ICP')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','ตะกั่ว(Lead)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','ICP')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','โครเมี่ยม(Cromium)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','ICP')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','แคดเมี่ยม(Cadmium)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','ICP')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','สารหนู(Arsenic)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','ICP')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();
    //    DB::table('env_plumbing_set')->where('SETUP_PLUMBING_NAME','=','ปรอท(Mercury)')->where('SETUP_PLUMBING_TEST','=','')
    //    ->where('SETUP_PLUMBING_TEST','=','TCP')->where('SETUP_PLUMBING_UNIT','=','( มก./ล.)')->delete();

      

     
    }
}
