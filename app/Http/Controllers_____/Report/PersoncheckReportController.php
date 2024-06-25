<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersoncheckReportController extends Controller
{
    public function getPersoncheckin($type , $date_start,$date_end)
    {
        return DB::table('checkin_index')->select('checkin_index.CHEACKIN_TIME','hrd_prefix.HR_PREFIX_NAME','hrd_person.HR_FNAME','hrd_person.HR_LNAME','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME')
        ->leftJoin('hrd_person','hrd_person.ID','checkin_index.CHECKIN_PERSON_ID')
        ->leftJoin('hrd_prefix','hrd_prefix.HR_PREFIX_ID','hrd_person.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','checkin_index.HR_DEPARTMENT_SUB_SUB_ID')
        ->orderBy('checkin_index.CHEACKIN_TIME','DESC')
        ->where('CHECKIN_TYPE_ID',$type)->whereBetween('CHEACKIN_DATE',[$date_start,$date_end])->get();
    }
    //
}
