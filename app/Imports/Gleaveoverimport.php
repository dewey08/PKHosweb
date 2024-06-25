<?php

namespace App\Imports;
use Carbon\Carbon;
use App\Gleaveover;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class Gleaveoverimport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Gleaveover([
            'ID' => $row['id'],
            'PERSON_ID' => $row['person_id'],
            'DAY_LEAVE_OVER' => $row['day_leave_over'],
            'DATE_TIME' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_time'])->format('Y-m-d'),
            'OVER_YEAR_ID' => $row['over_year_id'],
            'OLDS' => $row['olds'],
            'DAY_LEAVE_OVER_BEFORE' => $row['day_leave_over_before'],
            'HR_PERSON_TYPE_ID' => $row['hr_person_type_id'],
        ]);
    }
}
