<?php

namespace App\Imports;

use App\Supplies;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Suppliesimport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Supplies([
            'ID' => $row['id'],
            'SUP_FSN_NUM' => $row['sup_fsn_num'],
            'SUP_NAME' => $row['sup_name'],
            'SUP_NAME_EN' => $row['sup_name_en'],
            'SUP_TYPE_ID' => $row['sup_type_id'],
            'SUP_TYPE_SUP_ID' => $row['sup_type_sup_id'],
            'CONTENT' => $row['content'],
            'PACKING' => $row['packing'],
            'AVE_RATE' => $row['ave_rate'],
            'PRICE_CENTER' => $row['price_center'],
            'PRICE_LAST' => $row['price_last'],
            'UNIT_TOTAL' => $row['unit_total'],
            'SUP_UNIT_ID' => $row['sup_unit_id'],
            'UNIT_TOTAL_SUB' => $row['unit_total_sub'],
            'IMG' => $row['img'],
            'SUP_BARCODE' => $row['sup_barcode'],
            'SUP_NUM' => $row['sup_num'],
            'ACTIVE' => $row['active'],
            'MAX' => $row['max'],
            'MIN' => $row['min'],
            'DATE_TIME_REGIS' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_time_regis'])->format('Y-m-d'),
            'HR_REGIS_ID' => $row['hr_regis_id'],
            'HR_REGIS_NAME' => $row['hr_regis_name'],
            'SUP_TYPE_KIND_ID' => $row['sup_type_kind_id'],
            'SUP_PROP' => $row['sup_prop'],
            'DECLINE_ID' => $row['decline_id'],
            'CONTINUE_PRICE_ID' => $row['continue_price_id'],
            'SUP_TYPE_MASTER_ID' => $row['sup_type_master_id'],
            'TPU_NUMBER' => $row['tpu_number'],
            'SUP_CODE' => $row['sup_code'],
            'SUP_GENUS' => $row['sup_genus'],
            'SUP_CAT' => $row['sup_cat'],
            'SUP_CAT_TYPE' => $row['sup_cat_type'],
            'SUP_GROUP' => $row['sup_group'],
            'SUP_VENDOR_CODE' => $row['sup_vendor_code'],
            'SUP_REMARK' => $row['sup_remark'],
            'SUP_MANU' => $row['sup_manu'],
            'SUP_SYNONYMS_01' => $row['sup_synonyms_01'],
            'SUP_SYNONYMS_02' => $row['sup_synonyms_02'],
        ]);
    }
}
