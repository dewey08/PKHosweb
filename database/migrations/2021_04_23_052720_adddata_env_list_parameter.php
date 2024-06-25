<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddataEnvListParameter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('env_list_parameter')) {
            DB::table('env_list_parameter')->truncate();
        }

        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '1',
            'LIST_PARAMETER_DETAIL' => 'บีโอดี(Biochemical Oxygen Demand;BOD)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'Azide Modification Method',
            'LIST_PARAMETER_NORMAL' => 'ไม่เกิน 20*',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '2',
            'LIST_PARAMETER_DETAIL' => 'ซีโอดี(Chemical Oxygen Demand;COD)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'Open Reflux Method',
            'LIST_PARAMETER_NORMAL' => 'ไม่เกิน 120*',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '3',
            'LIST_PARAMETER_DETAIL' => 'ปริมาณสารละลายได้ทั้งหมด (Total Dissolve Solid;TDS)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'TDS meter',
            'LIST_PARAMETER_NORMAL' => 'ไม่เกิน 500*,**',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '4',
            'LIST_PARAMETER_DETAIL' => 'ปริมาณสารแขวนลอย (Suspended Solid;SS)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'Glass Fibre Filter Disc Method',
            'LIST_PARAMETER_NORMAL' => 'ไม่เกิน 30*',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '5',
            'LIST_PARAMETER_DETAIL' => 'ปริมาณตะกอนหนัก(Settleable Solid)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'Imhoff cone Method',
            'LIST_PARAMETER_NORMAL' => 'ไม่เกิน 0.5*',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '6',
            'LIST_PARAMETER_DETAIL' => 'ไนโตรเจนในรูปทีเคเอ็น( Total Kjeldahl Nitrogen;TKN)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'Kjeldahl Method',
            'LIST_PARAMETER_NORMAL' => 'ไม่เกิน 35*',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '7',
            'LIST_PARAMETER_DETAIL' => 'ความเป็นกรดและด่าง(pH)',
            'LIST_PARAMETER_UNIT' => '',
            'LIST_USEANALYSIS_RESULTS' => 'pH Meter',
            'LIST_PARAMETER_NORMAL' => '5-9*',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '8',
            'LIST_PARAMETER_DETAIL' => 'ซัลไฟด์(Sulfide)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'Titrate Method',
            'LIST_PARAMETER_NORMAL' => 'ไม่เกิน 1.0*',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '9',
            'LIST_PARAMETER_DETAIL' => 'น้ำมันและไขมัน(Oil and Grease)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'Soxhlet Extraction',
            'LIST_PARAMETER_NORMAL' => 'ไม่เกิน 20*',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '10',
            'LIST_PARAMETER_DETAIL' => 'โคลิฟอร์มแบคทีเรีย(Total Coliform Bacteria)',
            'LIST_PARAMETER_UNIT' => 'MPN/100ml',
            'LIST_USEANALYSIS_RESULTS' => 'Multiple-tube Fermentation Technique',
            'LIST_PARAMETER_NORMAL' => 'ไม่เกิน 5,000',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '11',
            'LIST_PARAMETER_DETAIL' => 'ฟิคัลโคลิฟอร์มแบคทีเรีย(Fecal Coliform Bacteria)',
            'LIST_PARAMETER_UNIT' => 'MPN/100ml',
            'LIST_USEANALYSIS_RESULTS' => 'Multiple-tube Fermentation Technique',
            'LIST_PARAMETER_NORMAL' => 'ไม่เกิน 1,000',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '12',
            'LIST_PARAMETER_DETAIL' => 'ออกซิเจนละลาย(Dissolve Oxygen;DO)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'Azide Modification Method',
            'LIST_PARAMETER_NORMAL' => '-',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '13',
            'LIST_PARAMETER_DETAIL' => 'ความนำไฟฟ้า(Electrical Conductivity;EC)',
            'LIST_PARAMETER_UNIT' => 'uS/cm',
            'LIST_USEANALYSIS_RESULTS' => 'Conductivity',
            'LIST_PARAMETER_NORMAL' => '-',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '14',
            'LIST_PARAMETER_DETAIL' => 'อุณหภูมิ(Temperature)',
            'LIST_PARAMETER_UNIT' => 'C',
            'LIST_USEANALYSIS_RESULTS' => 'Themometer',
            'LIST_PARAMETER_NORMAL' => '-',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '15',
            'LIST_PARAMETER_DETAIL' => 'ไนเตรตละลาย(Soluble Nitrate;NO)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'Colorimetric Method',
            'LIST_PARAMETER_NORMAL' => '-',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '16',
            'LIST_PARAMETER_DETAIL' => 'ไนไตรต์ละลาย(Soluble Nitrate;NO2)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'Colorimetric Method',
            'LIST_PARAMETER_NORMAL' => '-',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '17',
            'LIST_PARAMETER_DETAIL' => 'แอมโมเนียละลาย(Soluble Ammonia;NH)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'Colorimetric Method',
            'LIST_PARAMETER_NORMAL' => '-',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '18',
            'LIST_PARAMETER_DETAIL' => 'ฟอสเฟตละลาย(Soluble phosphate;PO)',
            'LIST_PARAMETER_UNIT' => 'mg/l',
            'LIST_USEANALYSIS_RESULTS' => 'Colorimetric Method',
            'LIST_PARAMETER_NORMAL' => '-',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
        DB::table('env_list_parameter')->insert(array(
            'LIST_PARAMETER_ID' => '19',
            'LIST_PARAMETER_DETAIL' => 'ORP(Oxidation Reduction Potential)',
            'LIST_PARAMETER_UNIT' => 'mV',
            'LIST_USEANALYSIS_RESULTS' => 'ORP Meter',
            'LIST_PARAMETER_NORMAL' => '-',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
