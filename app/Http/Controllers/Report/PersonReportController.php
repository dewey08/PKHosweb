<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

date_default_timezone_set("Asia/Bangkok");

class PersonReportController extends Controller
{
    public function count_hrd_status($status_id = array(),$cmd = '')
    {
        $arr = array();
        foreach ($status_id as $value) {
            $arr[$value] = DB::table('hrd_person')->where('HR_STATUS_ID',$value)->count();
        }
        if($cmd == 'total'){
            $total = 0;
            foreach ($arr as $value) {
                $total += $value;
            }
            return $total;
        }
        return $arr;
    }

    public function count_hrd_position($HR_POSITION_ID = array())
    {
        $arr = array();
        foreach ($HR_POSITION_ID as $value) {
            $arr[$value] = DB::table('hrd_person')->where('HR_STATUS_ID',1)->where('HR_POSITION_ID',$value)->count(); 
            //HR_STATUS_ID == 1 //ยังทำงานปกติ
        }
        return $arr;
    }

    public function count_hrd_sex($sex_id = array())
    {
        $arr = array();
        foreach ($sex_id as $value) {
            $arr[$value] = DB::table('hrd_person')->where('HR_STATUS_ID',1)->where('SEX',$value)->count(); 
            //HR_STATUS_ID == 1 //ยังทำงานปกติ
        }
        return $arr;
    }
    public function count_perstatus_pertype($status_id , $personType_id = array())
    {
        $arr = array();
        foreach ($personType_id as $value) {
            $arr[$value] = DB::table('hrd_person')->where('HR_STATUS_ID',$status_id)->where('HR_PERSON_TYPE_ID',$value)->count(); 
        }
        return $arr;
    }

    // ดึงข้อมูลทั้งหมด โดยแยกจากประเภทพนักงาน
    public function data_personstatus($type = '')
    {
        return DB::table('hrd_person')->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.HR_STATUS_ID', $type)
            ->orderBy('hrd_person.ID', 'desc')
            ->get();
    }
    public function getPerson_type(){
        return DB::table('hrd_person_type')->get();
    }
    public function getperson_Bydepartment_details()
    {
        $person_depart = DB::table('hrd_department')->where('ACTIVE',True)->get();
        $person_type = $this->getPerson_type();
        $arr['header']['name'] = 'กลุ่มงาน';
        foreach ($person_type as $type) {
            $arr['header']['typename'.$type->HR_PERSON_TYPE_ID] = $type->HR_PERSON_TYPE_NAME;
        }
        $arr['header']['all'] = 'รวมทั้งหมด';
        $arr['header']['male'] = 'เพศชาย';
        $arr['header']['female'] = 'เพศหญิง';
        foreach ($person_depart as $depart) {
            $arr[$depart->HR_DEPARTMENT_ID]['type_id'] = $depart->HR_DEPARTMENT_ID;
            $arr[$depart->HR_DEPARTMENT_ID]['name'] = $depart->HR_DEPARTMENT_NAME;
            foreach ($person_type as $type) {
            $arr[$depart->HR_DEPARTMENT_ID][$type->HR_PERSON_TYPE_ID] = $this->count_person_bydepartment_bypersontype($depart->HR_DEPARTMENT_ID,$type->HR_PERSON_TYPE_ID);
            }
            $arr[$depart->HR_DEPARTMENT_ID]['all'] = DB::table('hrd_person')
            ->where(function ($q){
                $q->where('HR_STATUS_ID',1) //1 ปกติ
                ->orwhere('HR_STATUS_ID',2) //2 ลาศึกษาต่อ
                ->orwhere('HR_STATUS_ID',3) //3 ช่วยราชการ
                ->orwhere('HR_STATUS_ID',4); //4 พักราชการ
            })->where('HR_DEPARTMENT_ID',$depart->HR_DEPARTMENT_ID)->count();
            $arr[$depart->HR_DEPARTMENT_ID]['male'] = DB::table('hrd_person')
            ->where(function ($q){
                $q->where('HR_STATUS_ID',1) //1 ปกติ
                ->orwhere('HR_STATUS_ID',2) //2 ลาศึกษาต่อ
                ->orwhere('HR_STATUS_ID',3) //3 ช่วยราชการ
                ->orwhere('HR_STATUS_ID',4); //4 พักราชการ
            })->where('HR_DEPARTMENT_ID',$depart->HR_DEPARTMENT_ID)->where('SEX','M')->count();
            $arr[$depart->HR_DEPARTMENT_ID]['female'] = DB::table('hrd_person')
            ->where(function ($q){
                $q->where('HR_STATUS_ID',1) //1 ปกติ
                ->orwhere('HR_STATUS_ID',2) //2 ลาศึกษาต่อ
                ->orwhere('HR_STATUS_ID',3) //3 ช่วยราชการ
                ->orwhere('HR_STATUS_ID',4); //4 พักราชการ
            })->where('HR_DEPARTMENT_ID',$depart->HR_DEPARTMENT_ID)->where('SEX','F')->count();
        }
        return $arr;
    }
    public function getperson_Bydepartment_sub_details($department_id)
    {
        $person_depart_sub = DB::table('hrd_department_sub')->where('HR_DEPARTMENT_ID',$department_id)->where('ACTIVE',True)->get();
        $person_type = $this->getPerson_type();
        $arr['header']['name'] = 'ฝ่าย/แผนก';
        foreach ($person_type as $type) {
            $arr['header']['typename'.$type->HR_PERSON_TYPE_ID] = $type->HR_PERSON_TYPE_NAME;
        }
        $arr['header']['all'] = 'รวมทั้งหมด';
        $arr['header']['male'] = 'เพศชาย';
        $arr['header']['female'] = 'เพศหญิง';
        foreach ($person_depart_sub as $depart) {
            $arr[$depart->HR_DEPARTMENT_SUB_ID]['type_id'] = $depart->HR_DEPARTMENT_SUB_ID;
            $arr[$depart->HR_DEPARTMENT_SUB_ID]['name'] = $depart->HR_DEPARTMENT_SUB_NAME;
            foreach ($person_type as $type) {
                $arr[$depart->HR_DEPARTMENT_SUB_ID][$type->HR_PERSON_TYPE_ID] = $this->count_person_bydepartment_sub_bypersontype($depart->HR_DEPARTMENT_SUB_ID,$type->HR_PERSON_TYPE_ID);
            }
            $arr[$depart->HR_DEPARTMENT_SUB_ID]['all'] = DB::table('hrd_person')
            ->where(function ($q){
                $q->where('HR_STATUS_ID',1) //1 ปกติ
                ->orwhere('HR_STATUS_ID',2) //2 ลาศึกษาต่อ
                ->orwhere('HR_STATUS_ID',3) //3 ช่วยราชการ
                ->orwhere('HR_STATUS_ID',4); //4 พักราชการ
            })->where('HR_DEPARTMENT_SUB_ID',$depart->HR_DEPARTMENT_SUB_ID)->count();
            $arr[$depart->HR_DEPARTMENT_SUB_ID]['male'] = DB::table('hrd_person')
            ->where(function ($q){
                $q->where('HR_STATUS_ID',1) //1 ปกติ
                ->orwhere('HR_STATUS_ID',2) //2 ลาศึกษาต่อ
                ->orwhere('HR_STATUS_ID',3) //3 ช่วยราชการ
                ->orwhere('HR_STATUS_ID',4); //4 พักราชการ
            })->where('HR_DEPARTMENT_SUB_ID',$depart->HR_DEPARTMENT_SUB_ID)->where('SEX','M')->count();
            $arr[$depart->HR_DEPARTMENT_SUB_ID]['female'] = DB::table('hrd_person')
            ->where(function ($q){
                $q->where('HR_STATUS_ID',1) //1 ปกติ
                ->orwhere('HR_STATUS_ID',2) //2 ลาศึกษาต่อ
                ->orwhere('HR_STATUS_ID',3) //3 ช่วยราชการ
                ->orwhere('HR_STATUS_ID',4); //4 พักราชการ
            })->where('HR_DEPARTMENT_SUB_ID',$depart->HR_DEPARTMENT_SUB_ID)->where('SEX','F')->count();
        }
        return $arr;
    }
    public function getperson_Bydepartment_sub_sub_details($department_sub_id)
    {
        $person_depart = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_ID',$department_sub_id)->where('ACTIVE',True)->get();
        $person_type = $this->getPerson_type();
        $arr['header']['name'] = 'ฝ่าย/แผนก';
        foreach ($person_type as $type) {
            $arr['header']['typename'.$type->HR_PERSON_TYPE_ID] = $type->HR_PERSON_TYPE_NAME;
        }
        $arr['header']['all'] = 'รวมทั้งหมด';
        $arr['header']['male'] = 'เพศชาย';
        $arr['header']['female'] = 'เพศหญิง';
        foreach ($person_depart as $depart) {
            $arr[$depart->HR_DEPARTMENT_SUB_SUB_ID]['type_id'] = $depart->HR_DEPARTMENT_SUB_SUB_ID;
            $arr[$depart->HR_DEPARTMENT_SUB_SUB_ID]['name'] = $depart->HR_DEPARTMENT_SUB_SUB_NAME;
            foreach ($person_type as $type) {
                $arr[$depart->HR_DEPARTMENT_SUB_SUB_ID][$type->HR_PERSON_TYPE_ID] = $this->count_person_bydepartment_sub_sub_bypersontype($depart->HR_DEPARTMENT_SUB_SUB_ID,$type->HR_PERSON_TYPE_ID);
            }
            $arr[$depart->HR_DEPARTMENT_SUB_SUB_ID]['all'] = DB::table('hrd_person')
            ->where(function ($q){
                $q->where('HR_STATUS_ID',1) //1 ปกติ
                ->orwhere('HR_STATUS_ID',2) //2 ลาศึกษาต่อ
                ->orwhere('HR_STATUS_ID',3) //3 ช่วยราชการ
                ->orwhere('HR_STATUS_ID',4); //4 พักราชการ
            })->where('HR_DEPARTMENT_SUB_SUB_ID',$depart->HR_DEPARTMENT_SUB_SUB_ID)->count();
            $arr[$depart->HR_DEPARTMENT_SUB_SUB_ID]['male'] = DB::table('hrd_person')
            ->where(function ($q){
                $q->where('HR_STATUS_ID',1) //1 ปกติ
                ->orwhere('HR_STATUS_ID',2) //2 ลาศึกษาต่อ
                ->orwhere('HR_STATUS_ID',3) //3 ช่วยราชการ
                ->orwhere('HR_STATUS_ID',4); //4 พักราชการ
            })->where('HR_DEPARTMENT_SUB_SUB_ID',$depart->HR_DEPARTMENT_SUB_SUB_ID)->where('SEX','M')->count();
            $arr[$depart->HR_DEPARTMENT_SUB_SUB_ID]['female'] = DB::table('hrd_person')
            ->where(function ($q){
                $q->where('HR_STATUS_ID',1) //1 ปกติ
                ->orwhere('HR_STATUS_ID',2) //2 ลาศึกษาต่อ
                ->orwhere('HR_STATUS_ID',3) //3 ช่วยราชการ
                ->orwhere('HR_STATUS_ID',4); //4 พักราชการ
            })->where('HR_DEPARTMENT_SUB_SUB_ID',$depart->HR_DEPARTMENT_SUB_SUB_ID)->where('SEX','F')->count();
        }
        return $arr;
    }
    public function count_person_bydepartment_bypersontype($perdepart_id , $pertype_id)
    {
        return DB::table('hrd_person')
        ->where(function ($q){
            $q->where('HR_STATUS_ID',1) //1 ปกติ
            ->orwhere('HR_STATUS_ID',2) //2 ลาศึกษาต่อ
            ->orwhere('HR_STATUS_ID',3) //3 ช่วยราชการ
            ->orwhere('HR_STATUS_ID',4); //4 พักราชการ
        })->where('HR_DEPARTMENT_ID',$perdepart_id)->where('HR_PERSON_TYPE_ID',$pertype_id)->count();
    }
    public function count_person_bydepartment_sub_bypersontype($perdepart_sub_id , $pertype_id)
    {
        return DB::table('hrd_person')
        ->where(function ($q){
            $q->where('HR_STATUS_ID',1) //1 ปกติ
            ->orwhere('HR_STATUS_ID',2) //2 ลาศึกษาต่อ
            ->orwhere('HR_STATUS_ID',3) //3 ช่วยราชการ
            ->orwhere('HR_STATUS_ID',4); //4 พักราชการ
        })->where('HR_DEPARTMENT_SUB_ID',$perdepart_sub_id)->where('HR_PERSON_TYPE_ID',$pertype_id)->count();
    }
    public function count_person_bydepartment_sub_sub_bypersontype($perdepart_sub_sub_id , $pertype_id)
    {
        return DB::table('hrd_person')
        ->where(function ($q){
            $q->where('HR_STATUS_ID',1) //1 ปกติ
            ->orwhere('HR_STATUS_ID',2) //2 ลาศึกษาต่อ
            ->orwhere('HR_STATUS_ID',3) //3 ช่วยราชการ
            ->orwhere('HR_STATUS_ID',4); //4 พักราชการ
        })->where('HR_DEPARTMENT_SUB_SUB_ID',$perdepart_sub_sub_id)->where('HR_PERSON_TYPE_ID',$pertype_id)->count();
    }
}
