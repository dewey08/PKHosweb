<?php

namespace App\Imports;

use App\Asset_article;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Assetimport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Asset_article([
            'ARTICLE_ID' => $row['article_id'],
            'ARTICLE_NUM' => $row['article_num'],
            'ARTICLE_NUM_OLD' => $row['article_num_old'],
            'NUM1' => $row['num1'],
            'NUM2' => $row['num2'],
            'NUM3' => $row['num3'],
            'NUM4' => $row['num4'],
            'ARTICLE_NAME' => $row['article_name'],
            'ARTICLE_NAME_EN' => $row['article_name_en'],
            'MODEL_ID' => $row['model_id'],
            'SIZE_ID' => $row['size_id'],
            'DEVICE_NUM' => $row['device_num'],
            'SERIAL_NO' => $row['serial_no'],
            'SUPPLIER_ID' => $row['supplier_id'],
            'SALE_ID' => $row['sale_id'],
            'COUNTRY_ID' => $row['country_id'],
            'TYPE_ID' => $row['type_id'],
            'TYPE_SUB_ID' => $row['type_sub_id'],
            'BRAND_ID' => $row['brand_id'],
            'SECTION_ID' => $row['section_id'],
            'COLOR_ID' => $row['color_id'],
            'RECEIVE_DATE' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['receive_date'])->format('Y-m-d'),
            'PRICE_PER_UNIT' => $row['price_per_unit'],
            'TYPE_MONEY_ID' => $row['type_money_id'],
            'TYPE_MONEY_COMMENT' => $row['type_money_comment'],
            'METHOD_ID' => $row['method_id'],
            'DOC_NO_NUM' => $row['doc_no_num'],
            'DOC_NO_FILE' => $row['doc_no_file'],
            'REMARK' => $row['remark'],
            'DEPT' => $row['dept'],
            'UNIT_ID' => $row['unit_id'],
            'EXPIRED' => $row['expired'],
            // 'EXPIRED' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['expired'])->format('Y-m-d'),
            'DEPREC' => $row['deprec'],
            'NOTES' => $row['notes'],
            'LOCATEDIVISION' => $row['locatedivision'],
            'LOCATEDEPT' => $row['locatedept'],
            'LOCATESECTION' => $row['locatesection'],
            'WAY_NAME' => $row['way_name'],
            'CHANGE' => $row['change'],
            'SALER' => $row['saler'],
            'STATUS_ID' => $row['status_id'],
            'DEPARTMENT_SUB_ID' => $row['department_sub_id'],
            'PERSON_ID' => $row['person_id'],
            'IMAGES' => $row['images'],
            'EXPIRE_DOC' => $row['expire_doc'],
            'EXPIRE_DATE' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['expire_date'])->format('Y-m-d'),
            'EXPIRE_DATE_SUBMIT' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['expire_date_submit'])->format('Y-m-d'),
            'DATE_DOC' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_doc'])->format('Y-m-d'),
            'CAR_TYPE_ID' => $row['car_type_id'],
            'CAR_REG' => $row['car_reg'],
            'UPDATE_PERSON_ID' => $row['update_person_id'],
            'UPDATE_DATE_TIME' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['update_dete_time'])->format('Y-m-d'),
            'ARTICLE_MODELS' => $row['article_models'],
            'MODEL_REGIS' => $row['model_regis'],
            'GROUP_ID' => $row['group_id'],
            'CLASS_ID' => $row['class_id'],
            'PROPOTIES_ID' => $row['propoties_id'],
            'ROOM_ID' => $row['room_id'],
            'LEVEL_ID' => $row['level_id'],
            'OLD_USE' => $row['old_use'],
            'VENDOR_ID' => $row['vendor_id'],
            'DEP_ID' => $row['dep_id'],
            'LOCATION_ID' => $row['location_id'],
            'IMG' => $row['img'],
            'BUY_ID' => $row['buy_id'],
            'LOCATION_LEVEL_ID' => $row['location_level_id'],
            'LEVEL_ROOM_ID' => $row['level_room_id'],
            'AR_REGIS_ID' => $row['ar_regis_id'],
            'YEAR_ID' => $row['year_id'],
            'OPENS' => $row['opens'],
            'DECLINE_ID' => $row['decline_id'],
            'CODE_REF' => $row['code_ref'],
            'BUDGET_ID' => $row['budget_id'], 
            'ARTICLE_PROP' => $row['article_prop'],
            'SUP_FSN' => $row['sup_fsn'],
            'SUP_ID' => $row['sup_id'],
            'AR_REGIS_COUNT' => $row['ar_regis_count'],
            'TYPE_VALUE_ID' => $row['type_value_id'],
            'QRCODE' => $row['qrcode'],
            'PM_TYPE_ID' => $row['pm_type_id'],
            'CAL_TYPE_ID' => $row['cal_type_id'],
            'RISK_TYPE_ID' => $row['risk_type_id'],
            'DEP_SUB_SUB_ID' => $row['dep_sub_sub_id'], 
            'DEP_SUB_SUB_NAME' => $row['dep_sub_sub_name'], 
        ]);
    }
}
