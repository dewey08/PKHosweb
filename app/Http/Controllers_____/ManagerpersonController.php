<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Report\PersonReportController;
use App\Http\Controllers\Report\HealthpersonReportController as healreport;

use App\Models\Adduser;
use App\Models\Healthbody;
use App\Models\Healthscreen;
use App\Models\Healthscreenconfirm;
use App\Models\Infoworkcapacity;
use App\Models\Infoworkcorcom;
use App\Models\Infoworkcorcomlevel;
use App\Models\Infoworkcorcomlevelsub;
use App\Models\Infoworkfuntion;
use App\Models\Infoworkfuntionlevel;
use App\Models\Infoworkfuntionlevelsub;
use App\Models\Infoworkfuntionposition;
use App\Models\Infoworkjobdis;
use App\Models\Infoworkjobdisposition;
use App\Models\Infoworkkpis;
use App\Models\Infoworktypescore;
use App\Models\Infoworktypescoresub;
use App\Models\Meetting_inside_type;
use App\Models\Person;
use App\Models\Recordindex;
use App\Models\Meetting_inside_index;
use App\Models\Meetting_inside_performancesub;
use App\Models\Meetting_inside_professionsub;
use App\Models\Meetting_inside_useroutsub;
use App\Models\Meetting_inside_usersub;
use App\Models\Salary;
use App\Models\Openformperdev;
use App\Models\Infowork_kpi;
use App\Models\Infowork_job_descriptions;
use App\Models\Infowork_job_descriptions_set;
use App\Models\Infowork_job_person_status;
use App\Models\Infowork_job_person;
use App\Models\Infowork_job_person_list;
use App\Models\Infowork_job_person_permission;
use App\Models\Infowork_job_person_permission_list;
use App\Models\Hrdfileperson;
use App\Models\Education;
use App\Models\Work;
use App\Models\Reward;
use App\Models\Expert;
use App\Models\Changename;
use App\Models\Trainspacial;
use App\Models\Occu;
use App\Models\Family;
use App\Models\Hrddisciplinary;
use App\Models\Cid;
use App\Models\Official;
use App\Models\Hrdsignature;
use App\Models\Hrd_regalia;
use App\Models\Teamlist;
use App\Models\Persondev_function;

use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//class manager data in datatable
use Illuminate\Support\Facades\Hash;
use Session;
use Cookie;

date_default_timezone_set("Asia/Bangkok");

class ManagerpersonController extends Controller
{

    public function dashboard()
    {
        $data = array();

        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }

        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        // 1 ทำงานปกติ / 2 ลาศึกษา / 3 ช่วยราชการ / 4 พักราชการ / 5 ลาออกแล้ว / 6 ให้ออก / 7 ย้าย / 8 เกษียณ
        $data['person_status_count']       = $psreport->count_hrd_status([1, 2, 3, 4, 5, 6, 7, 8]);
        $data['person_status_count_total'] = $psreport->count_hrd_status([1, 2, 3, 4], 'total');
        //เลขเรียงตามรายชื่อ 24 > นายแพทย์ , 21 > ทันตแพทย์ , 26 > เภสัชกร , 23 > พยาบาลวิชาชีพ , 22 > นักเทคนิคการแพทย์ , 17 > นักกายภาพบำบัด , 30 > นักวิชาการสาธารณสุข
        // , 7 > นักวิชาการคอมพิวเตอร์ , 28 > นักรังสีการแพทย์
        $data['person_position_count'] = $psreport->count_hrd_position([24, 21, 26, 23, 22, 17, 30, 7, 28]);
        $data['person_sex_count']      = $psreport->count_hrd_sex(['F', 'M']);
        $data['person_type_count'][1]  = DB::table('hrd_person')->where('HR_STATUS_ID', 1)->where('HR_PERSON_TYPE_ID', 1)->count();
        $data['person_type_count'][2]  = DB::table('hrd_person')->where('HR_STATUS_ID', 1)->where('HR_PERSON_TYPE_ID', '<>', 1)->count();
        $data['person_Bydepartment'] = $psreport->getperson_Bydepartment_details();
        return view('manager_person.dashboard_person', $data);
    }
    public function ajax_getdepartment_sub_by_emptype(Request $req)
    {
        $personreport = new PersonReportController();
        $person_Bydepartment = $personreport->getperson_Bydepartment_sub_details($req->department_id);

        $result = '<table class="table table-striped mb-0">
                            <thead class="header-group bg-sl-y2" >
                                <tr>';
                                    foreach($person_Bydepartment['header'] as $value){
                                        $result .='<th class="py-2">'.$value.'</th>';
                                    }
                    $result .='</tr>
                            </thead>
                            <tbody>';
                                    foreach($person_Bydepartment as $key => $row){
                                    if($key == 'header'){
                                        continue;
                                    }
                                    $result .='<tr class="department_sub_row" data-id="'.$row['type_id'].'" onclick="showdepartment_sub_sub(this)" style="cursor:pointer">';
                                    $i = 1;
                                        foreach($row as $key => $col){
                                        if($key == 'type_id'){
                                            continue;
                                        }
                                        if($i == 1){
                                            $result .= '<td class="py-1">'.$col.'</td>';
                                            $i++;
                                        }else{
                                            $result .= '<td class="py-1 text-center">'.$col.'</td>';
                                        }
                                        }
                                    $result .= '</tr>';
                                    }
                            $result .= '</tbody>
                            </table>';
        echo $result;
    }
    
    public function ajax_getdepartment_sub_sub_by_emptype(Request $req)
    {
        $personreport = new PersonReportController();
        $person_Bydepartment = $personreport->getperson_Bydepartment_sub_sub_details($req->department_sub_id);
        $result = '<table class="table table-striped mb-0">
                            <thead class="header-group bg-sl-r1" >
                                <tr>';
                                    foreach($person_Bydepartment['header'] as $value){
                                        $result .='<th class="py-2">'.$value.'</th>';
                                    }
                    $result .='</tr>
                            </thead>
                            <tbody>';
                                    foreach($person_Bydepartment as $key => $row){
                                    if($key == 'header'){
                                        continue;
                                    }
                                    $result .='<tr class="department_sub_sub_row" data-id="'.$row['type_id'].'">';
                                    $i = 1;
                                        foreach($row as $key => $col){
                                        if($key == 'type_id'){
                                            continue;
                                        }
                                    if($i==1){
                                        $result .= '<td class="py-1">'.$col.'</td>';
                                        $i++;
                                    }else{
                                        $result .= '<td class="py-1 text-center">'.$col.'</td>';
                                    }
                                        }
                                    $result .= '</tr>';
                                    }
                            $result .= '</tbody>
                            </table>';
        echo $result;
    }

    public function dashboard_nw()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $psreport      = new PersonReportController();
        $data['year_'] = $year_;
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(1,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(1);
        return view('manager_person.dashboard_nw',$data);
    }

    public function dashboard_sl()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(2,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(2);

        return view('manager_person.dashboard_sl',$data);
    }

    public function dashboard_hgo()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(3,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(3);
        return view('manager_person.dashboard_hgo',$data);
    }

    public function dashboard_sis()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(4,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(4);
        return view('manager_person.dashboard_sis',$data);
    }

    public function dashboard_res()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(5,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(5);
        return view('manager_person.dashboard_res',$data);
    }

    public function dashboard_go()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(6,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(6);
        return view('manager_person.dashboard_go',$data);
    }

    public function dashboard_mo()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(7,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(7);
        return view('manager_person.dashboard_mo',$data);
    }

    public function dashboard_ret()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(8,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(8);
        return view('manager_person.dashboard_ret',$data);
    }


    public function carcalendar()
    {

        $birthday = Person::where('hrd_person.HR_STATUS_ID', '<>', 5)
        ->where('hrd_person.HR_STATUS_ID', '<>', 6)
        ->where('hrd_person.HR_STATUS_ID', '<>', 7)
        ->where('hrd_person.HR_STATUS_ID', '<>', 8)->get();

        return view('manager_person.carcalendar_person', [
            'birthdays' => $birthday

        ]);
    }

    public function inforperson(Request $request)
    {
        if(!empty($request->_token)){
            $search = $request->search;
            session(['manager_person.inforperson'=> $search]);
        }elseif(!empty(session('manager_person.inforperson'))){
            $search = session('manager_person.inforperson');
        }else{
            $search = '';
        }
        $person = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.HR_STATUS_ID', '<>', 5)
            ->where('hrd_person.HR_STATUS_ID', '<>', 6)
            ->where('hrd_person.HR_STATUS_ID', '<>', 7)
            ->where('hrd_person.HR_STATUS_ID', '<>', 8)
            ->where(function ($q) use ($search) {
                $q->where('hrd_person.HR_CID', 'like', '%' . $search . '%');
                $q->orwhere('HR_PREFIX_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_FNAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                $q->orwhere('NICKNAME', 'like', '%' . $search . '%');
                $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_STATUS_NAME', 'like', '%' . $search . '%');
                $q->orwhere('POSITION_IN_WORK', 'like', '%' . $search . '%');
                $q->orwhere('HR_LEVEL_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_PERSON_TYPE_NAME', 'like', '%' . $search . '%');
            })
            ->orderBy('hrd_person.ID', 'desc')
            ->get();

        $count = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.HR_STATUS_ID', '<>', 5)
            ->where('hrd_person.HR_STATUS_ID', '<>', 6)
            ->where('hrd_person.HR_STATUS_ID', '<>', 7)
            ->where('hrd_person.HR_STATUS_ID', '<>', 8)
            ->where(function ($q) use ($search) {
                $q->where('hrd_person.HR_CID', 'like', '%' . $search . '%');
                $q->orwhere('HR_PREFIX_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_FNAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                $q->orwhere('NICKNAME', 'like', '%' . $search . '%');
                $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_STATUS_NAME', 'like', '%' . $search . '%');
                $q->orwhere('POSITION_IN_WORK', 'like', '%' . $search . '%');
                $q->orwhere('HR_LEVEL_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_PERSON_TYPE_NAME', 'like', '%' . $search . '%');
            })->count();

        return view('manager_person.inforperson', [
            'persons' => $person,
            'count'   => $count,
            'search'   => $search
        ]);
    }

    public function create()
    {

        $infoprefix             = DB::table('hrd_prefix')->get();
        $infomarry              = DB::table('hrd_marry_status')->get();
        $inforeligion           = DB::table('hrd_religion')->get();
        $infonation             = DB::table('hrd_nationality')->get();
        $infocitizen            = DB::table('hrd_citizenship')->get();
        $infosex                = DB::table('hrd_sex')->get();
        $infoblood              = DB::table('hrd_bloodgroup')->get();
        $infoprovince           = DB::table('hrd_province')->get();
        $infodepartment         = DB::table('hrd_department')->get();
        $infodepartment_sub     = DB::table('hrd_department_sub')->get();
        $infodepartment_sub_sub = DB::table('hrd_department_sub_sub')->get();
        $infolevel              = DB::table('hrd_level')->get();
        $infostatus             = DB::table('hrd_status')->get();
        $infokind               = DB::table('hrd_kind')->get();
        $infokind_type          = DB::table('hrd_kind_type')->get();
        $infoperson_type        = DB::table('hrd_person_type')->get();
        $infoposition           = DB::table('hrd_position')->get();

        return view('manager_person.adduser', [
            'infoprefixs'             => $infoprefix,
            'infomarrys'              => $infomarry,
            'inforeligions'           => $inforeligion,
            'infonations'             => $infonation,
            'infocitizens'            => $infocitizen,
            'infosexs'                => $infosex,
            'infobloods'              => $infoblood,
            'infoprovinces'           => $infoprovince,
            'infodepartments'         => $infodepartment,
            'infodepartment_subs'     => $infodepartment_sub,
            'infodepartment_sub_subs' => $infodepartment_sub_sub,
            'infolevels'              => $infolevel,
            'infostatuss'             => $infostatus,
            'infokinds'               => $infokind,
            'infokind_types'          => $infokind_type,
            'infoperson_types'        => $infoperson_type,
            'infopositions'           => $infoposition

        ]);

    }

    public function store(Request $request)
    {
        $checkbirt  = $request->HR_BIRTHDAY;
        $checkstart = $request->STARTWORK;
        $checkvcode = $request->VCODE_DATE;

        if ($checkbirt != '') {
            $BIRTHDAY         = Carbon::createFromFormat('d/m/Y', $checkbirt)->format('Y-m-d');
            $date_arrary      = explode("-", $BIRTHDAY);
            $y                = $date_arrary[0] - 543;
            $m                = $date_arrary[1];
            $d                = $date_arrary[2];
            $displaybirthdate = $y . "-" . $m . "-" . $d;
        } else {
            $displaybirthdate = null;
        }

        if ($checkstart != '') {
            $STARTDAY         = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
            $date_arrary_st   = explode("-", $STARTDAY);
            $y_st             = $date_arrary_st[0] - 543;
            $m_st             = $date_arrary_st[1];
            $d_st             = $date_arrary_st[2];
            $displaystartdate = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $displaystartdate = null;
        }
        if ($checkvcode != '') {
            $VCODEDAY         = Carbon::createFromFormat('d/m/Y', $checkvcode)->format('Y-m-d');
            $date_arrary_v    = explode("-", $VCODEDAY);
            $y_v              = $date_arrary_v[0] - 543;
            $m_v              = $date_arrary_v[1];
            $d_v              = $date_arrary_v[2];
            $displayvcodedate = $y_v . "-" . $m_v . "-" . $d_v;
        } else {
            $displayvcodedate = null;
        }

      $checkcidperson = DB::table('hrd_person')->where('HR_CID','=',$request->HR_CID)->count();

      if($checkcidperson  == 0){

        $addperson                     = new Person();
        $addperson->HR_PREFIX_ID       = $request->HR_PREFIX;
        $addperson->HR_FNAME           = $request->HR_FNAME;
        $addperson->HR_LNAME           = $request->HR_LNAME;
        $addperson->HR_EN_NAME         = $request->HR_EN_NAME;
        $addperson->NICKNAME           = $request->NICKNAME;
        $addperson->HR_BIRTHDAY        = $displaybirthdate;
        $addperson->HR_CID             = $request->HR_CID;
        $addperson->HR_MARRY_STATUS_ID = $request->HR_MARRY_STATUS;
        $addperson->HR_RELIGION_ID     = $request->HR_RELIGION;
        $addperson->HR_NATIONALITY_ID  = $request->HR_NATIONALITY;
        $addperson->HR_CITIZENSHIP_ID  = $request->HR_CITIZENSHIP;
        $addperson->SEX                = $request->SEX;
        $addperson->HR_BLOODGROUP_ID   = $request->HR_BLOODGROUP;
        $addperson->HR_HIGH            = $request->HR_HIGH;
        $addperson->HR_WEIGHT          = $request->HR_WEIGHT;
        $addperson->HR_PHONE           = $request->HR_PHONE;
        $addperson->HR_EMAIL           = $request->HR_EMAIL;
        $addperson->HR_FACEBOOK        = $request->HR_FACEBOOK;
        $addperson->HR_LINE            = $request->HR_LINE;

        $addperson->HR_DEPARTMENT_ID         = $request->HR_DEPARTMENT;
        $addperson->HR_DEPARTMENT_SUB_ID     = $request->DEPARTMENT_SUB;
        $addperson->HR_DEPARTMENT_SUB_SUB_ID = $request->HR_DEPARTMENT_SUB_SUB;

        $addperson->HR_STARTWORK_DATE = $displaystartdate;

        $addperson->HR_POSITION_NUM = $request->HR_POSITION_NUM;
        $addperson->VCODE           = $request->VCODE;

        $addperson->VCODE_DATE = $displayvcodedate;

        $position = DB::table('hrd_position')
            ->where('HR_POSITION_ID', '=', $request->POSITION_IN_WORK)
            ->first();
        $addperson->POSITION_IN_WORK = $position->HR_POSITION_NAME;

        $addperson->HR_POSITION_ID    = $request->POSITION_IN_WORK;
        $addperson->HR_LEVEL_ID       = $request->HR_LEVEL;
        $addperson->HR_STATUS_ID      = $request->HR_STATUS;
        $addperson->HR_KIND_ID        = $request->HR_KIND;
        $addperson->HR_KIND_TYPE_ID   = $request->HR_KIND_TYPE;
        $addperson->HR_PERSON_TYPE_ID = $request->HR_PERSON_TYPE;
        $addperson->HR_SALARY         = $request->HR_SALARY;
        $addperson->MONEY_POSITION    = $request->MONEY_POSITION;

        $addperson->HR_HOME_NUMBER = $request->HR_HOME_NUMBER;
        $addperson->HR_VILLAGE_NO  = $request->HR_VILLAGE_NO;
        $addperson->HR_ROAD_NAME   = $request->HR_ROAD_NAME;
        $addperson->HR_SOI_NAME    = $request->HR_SOI_NAME;
        $addperson->HR_HOME_NUMBER = $request->HR_HOME_NUMBER;
        $addperson->PROVINCE_ID    = $request->PROVINCE_NAME;
        $addperson->AMPHUR_ID      = $request->AMPHUR_NAME;
        $addperson->TUMBON_ID      = $request->TUMBON_NAME;
        $addperson->HR_ZIPCODE     = $request->HR_ZIPCODE;

        $addperson->HR_HOME_NUMBER_1 = $request->HR_HOME_NUMBER_1;
        $addperson->HR_VILLAGE_NO_1  = $request->HR_VILLAGE_NO_1;
        $addperson->HR_ROAD_NAME_1   = $request->HR_ROAD_NAME_1;
        $addperson->PROVINCE_ID_1    = $request->PROVINCE_NAME_1;
        $addperson->AMPHUR_ID_1      = $request->AMPHUR_NAME_1;
        $addperson->TUMBON_ID_1      = $request->TUMBON_NAME_1;
        $addperson->HR_ZIPCODE_1     = $request->HR_ZIPCODE_1;

        $addperson->BOOK_BANK_NUMBER = $request->BOOK_BANK_NUMBER;
        $addperson->BOOK_BANK_NAME   = $request->BOOK_BANK_NAME;
        $addperson->BOOK_BANK        = $request->BOOK_BANK;
        $addperson->BOOK_BANK_BRANCH = $request->BOOK_BANK_BRANCH;

        $addperson->BOOK_BANK_OT_NUMBER = $request->BOOK_BANK_OT_NUMBER;
        $addperson->BOOK_BANK_OT_NAME   = $request->BOOK_BANK_OT_NAME;
        $addperson->BOOK_BANK_OT        = $request->BOOK_BANK_OT;
        $addperson->BOOK_BANK_OT_BRANCH = $request->BOOK_BANK_OT_BRANCH;

        if ($request->hasFile('picture')) {

            $file                = $request->file('picture');
            $contents            = $file->openFile()->fread($file->getSize());
            $addperson->HR_IMAGE = $contents;
           
        }
        $addperson->save();

        $idperson = Person::max('ID');
        $password                = "123456";
        $adduser                 = new Adduser();
        $adduser->name           = $request->HR_FNAME . ' ' . $request->HR_LNAME;
        $adduser->email          = $request->HR_EMAIL;
        $adduser->password       = Hash::make($password);
        $adduser->remember_token = $request->_token;
        $adduser->status         = 'USER';
        $adduser->username       = $request->HR_USERNAME;
        $adduser->PERSON_ID      = $idperson;
        $adduser->save();

        }
        return redirect()->route('mperson.inforperson');
    }

    public function get_ajex_infouser(Request $request, $iduser)
    {
        $inforpersonuser = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_religion', 'hrd_person.HR_RELIGION_ID', '=', 'hrd_religion.HR_RELIGION_ID')
            ->leftJoin('hrd_nationality', 'hrd_person.HR_NATIONALITY_ID', '=', 'hrd_nationality.HR_NATIONALITY_ID')
            ->leftJoin('hrd_citizenship', 'hrd_person.HR_CITIZENSHIP_ID', '=', 'hrd_citizenship.HR_CITIZENSHIP_ID')
            ->leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID', '=', 'hrd_province.ID')
            ->leftJoin('hrd_kind', 'hrd_person.HR_KIND_ID', '=', 'hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type', 'hrd_person.HR_KIND_TYPE_ID', '=', 'hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.ID', '=', $iduser)->first();

        $inforadd2 = Person::leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID_1', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID_1', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID_1', '=', 'hrd_province.ID')
            ->where('hrd_person.ID', '=', $iduser)->first();

        $userid = Person::where('hrd_person.ID', '=', $iduser)->first();

        $str = '
    
        <div class="block-content">
            <h2 class="content-heading pt-0" style="font-family: &#39;Kanit&#39;, sans-serif;"><span
                    style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลส่วนตัว&nbsp;&nbsp;</span>
            </h2>

            <div class="row push">
                <div class="col-lg-4">
                    <div class="form-group">
    
                        <img src="data:image/png;base64,'.chunk_split(base64_encode($inforpersonuser->HR_IMAGE)).'"
                            height="80%" width="60%">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>คำนำหน้า</label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_PREFIX_NAME .'
                            </div>
                        </div>
                    </div>

                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>ชื่อ</label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_FNAME .'
                            </div>
                        </div>
                    </div>

                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>นามสกุล</label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_LNAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>ชื่ออังกฤษ</label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_EN_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>ชื่อเล่น </label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> NICKNAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>วันเกิด </label>
                            </div>
                            <div class="col-lg-9">
                                '. DateThai($inforpersonuser -> HR_BIRTHDAY) .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-5">
                                <label>เลขประจำตัวประชาชน </label>
                            </div>
                            <div class="col-lg-7">
                                '. $inforpersonuser -> HR_CID .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-5">
                                <label>สถานะสมรส </label>
                            </div>
                            <div class="col-lg-7">
                                '. $inforpersonuser -> HR_MARRY_STATUS_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-5">
                                <label>ศาสนา </label>
                            </div>
                            <div class="col-lg-7">
                                '. $inforpersonuser -> HR_RELIGION_NAME .'
                            </div>
                        </div>
                    </div>
    
    
    
                </div>
                <div class="col-lg-4">
    
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>เชื้อชาติ </label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_NATIONALITY_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>สัญชาติ </label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_CITIZENSHIP_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>เพศ </label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> SEX_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>กรุ๊ปเลือด </label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_BLOODGROUP_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-12">
                                <label>ส่วนสูง </label>
                                '. $inforpersonuser -> HR_HIGH .'
                                <label>เซนติเมตร</label>
                                <label>น้ำหนัก </label>
                                '. $inforpersonuser -> HR_WEIGHT .'
                                <label>กิโลกรัม</label>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>เบอร์โทร </label>
                                </div>
                                <div class="col-lg-9">
                                    '. $inforpersonuser -> HR_PHONE .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>อีเมลล </label>
                                </div>
                                <div class="col-lg-9">
                                    '. $inforpersonuser -> HR_EMAIL  .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>Facebook </label>
                                </div>
                                <div class="col-lg-9">
                                    <p>'. $inforpersonuser -> HR_FACEBOOK .'
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>Line </label>
                                </div>
                                <div class="col-lg-9">
                                    <p style="word-wrap: break-word;">
                                    '. $inforpersonuser->HR_LINE .'
                                    </p>
                                </div>
                            </div>
                        </div>
    
                    </div>
    
                </div>
    
            </div>
    
    
    
            <div class="block-content">
                <h2 class="content-heading pt-0" style="font-family: &#39;Kanit&#39;, sans-serif;"><span
                        style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลอาชีพ&nbsp;&nbsp;</span>
                </h2>
                <div class="row push">
                    <div class="col-lg-4">
                        <form role="form">
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>กลุ่มงาน </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> HR_DEPARTMENT_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>ฝ่าย/แผนก </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> HR_DEPARTMENT_SUB_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>หน่วยงาน </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '.$inforpersonuser -> HR_DEPARTMENT_SUB_SUB_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>วันที่บรรจุ </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '.DateThai($inforpersonuser -> HR_STARTWORK_DATE).'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>เลขตำแหน่ง </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> HR_POSITION_NUM .'
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <form role="form">
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>เลขใบประกอบวิชาชีพ
                                        </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> VCODE .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>วดป.รับใบประกอบ </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. DateThai($inforpersonuser -> VCODE_DATE) .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>ตำแหน่ง </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> POSITION_IN_WORK .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>ระดับ </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> HR_LEVEL_NAME.'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>สถานะปัจจุบัน </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> HR_STATUS_NAME .'
                                    </div>
                                </div>
                            </div>
    
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <form role="form">
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>กลุ่มข้าราชการ </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> HR_KIND_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>ประเภทข้าราชการ </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> HR_KIND_TYPE_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>กลุ่มบุคลากร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> HR_PERSON_TYPE_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>ต้นสังกัด </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> HR_AGENCY_ID .'
    
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>เงินเดือน</label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. number_format($inforpersonuser -> HR_SALARY,2) .'
                                        <label>บาท</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>เงินประจำตำแหน่ง</label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. number_format($inforpersonuser -> MONEY_POSITION,2) .'
                                        <label>บาท</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
    
            </div>
    
    
            <div class="block-content">
                <h2 class="content-heading pt-0" style="font-family: &#39;Kanit&#39;, sans-serif;"><span
                        style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลที่อยู่อาศัยปัจจุบัน&nbsp;&nbsp;</span>
                </h2>
                <div class="row">
    
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>บ้านเลขที่ </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser ->HR_HOME_NUMBER  .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>ตำบล </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> TUMBON_NAME .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>หมู่ที่ </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser ->HR_VILLAGE_NO  .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>อำเภอ </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> AMPHUR_NAME .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>ถนน </label>
                                </div>
                                <div class="col-lg-8">
                                    '.  $inforpersonuser -> HR_ROAD_NAME .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>จังหวัด </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> PROVINCE_NAME .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>ซอย </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> HR_SOI_NAME .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-5">
                                    <label>รหัสไปรษณีย์ </label>
                                </div>
                                <div class="col-lg-7">
                                    '. $inforpersonuser -> HR_ZIPCODE .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
    
    
            <div class="block-content">
                <h2 class="content-heading pt-0" style="font-family: &#39;Kanit&#39;, sans-serif;"><span
                        style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลที่อยู่อาศัยตามทะเบียนบ้าน&nbsp;&nbsp;</span>
                </h2>
                <div class="row push">
    
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>บ้านเลขที่ </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> HR_HOME_NUMBER_1 .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>ตำบล </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforadd2 -> TUMBON_NAME .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>หมู่ที่ </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> HR_VILLAGE_NO_1 .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>อำเภอ </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforadd2 -> AMPHUR_NAME .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>ถนน </label>
                                </div>
                                <div class="col-lg-8">
                                    '.  $inforpersonuser -> HR_ROAD_NAME_1 .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>จังหวัด </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforadd2 -> PROVINCE_NAME .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>ซอย </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> HR_SOI_NAME_1 .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-5">
                                    <label>รหัสไปรษณีย์ </label>
                                </div>
                                <div class="col-lg-7">
                                    '. $inforpersonuser -> HR_ZIPCODE_1 .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
            <div class="block-content">
                <h2 class="content-heading pt-0" style="font-family: &#39;Kanit&#39;, sans-serif;"><span
                        style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลบัญชีธนาคาร&nbsp;&nbsp;</span>
                </h2>
                <div class="row">
                    <div class="col-lg-4">
                        <form role="form">
                            <div class="form">
    
                                <label>เงินค่าตอบแทน </label>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>เลขบัญชีธนาคาร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_NUMBER .'
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>ชื่อบัญชีธนาคาร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>ธนาคาร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>สาขา </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_BRANCH .'
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <form role="form">
                            <div class="form">
                                <label>เงินค่าตอบแทน OT</label>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>เลขบัญชีธนาคาร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_OT_NUMBER .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>ชื่อบัญชีธนาคาร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_OT_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>ธนาคาร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_OT .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>สาขา </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_OT_BRANCH .'
                                    </div>
                                </div>
                            </div>
    
                        </form>
                    </div>
                    <div class="col-lg-4">
                    </div>
                </div>
            </div>
        </div>';
        echo $str;
    }

    public function infouser(Request $request, $iduser)
    {

        $inforpersonusersalaryid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonusersalaryid->ID;

        $inforpersonuser = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_religion', 'hrd_person.HR_RELIGION_ID', '=', 'hrd_religion.HR_RELIGION_ID')
            ->leftJoin('hrd_nationality', 'hrd_person.HR_NATIONALITY_ID', '=', 'hrd_nationality.HR_NATIONALITY_ID')
            ->leftJoin('hrd_citizenship', 'hrd_person.HR_CITIZENSHIP_ID', '=', 'hrd_citizenship.HR_CITIZENSHIP_ID')
            ->leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID', '=', 'hrd_province.ID')
            ->leftJoin('hrd_kind', 'hrd_person.HR_KIND_ID', '=', 'hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type', 'hrd_person.HR_KIND_TYPE_ID', '=', 'hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.ID', '=', $id)->first();

        $inforadd2 = Person::leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID_1', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID_1', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID_1', '=', 'hrd_province.ID')
            ->where('hrd_person.ID', '=', $id)->first();

        $userid = Person::where('hrd_person.ID', '=', $id)->first();

        $infosalary= Salary::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_salary.ID', 'desc')  
        ->get();

      
       $infoposition = DB::table('hrd_position')->get();

       $infolevel = DB::table('hrd_level')->get();

        return view('manager_person.detailuser', [
            'inforpersonuser' => $inforpersonuser,
            'userid'          => $userid,
            'inforadd2'       => $inforadd2,
            'infolevels'      => $infolevel,
            'infopositions'   => $infoposition,
        'infosalarys'      => $infosalary, 
        ]);
    }

    public function editinfouser(Request $request, $iduser)
    {

        $inforperson = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_religion', 'hrd_person.HR_RELIGION_ID', '=', 'hrd_religion.HR_RELIGION_ID')
            ->leftJoin('hrd_nationality', 'hrd_person.HR_NATIONALITY_ID', '=', 'hrd_nationality.HR_NATIONALITY_ID')
            ->leftJoin('hrd_citizenship', 'hrd_person.HR_CITIZENSHIP_ID', '=', 'hrd_citizenship.HR_CITIZENSHIP_ID')
            ->leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID', '=', 'hrd_province.ID')
            ->leftJoin('hrd_kind', 'hrd_person.HR_KIND_ID', '=', 'hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type', 'hrd_person.HR_KIND_TYPE_ID', '=', 'hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.ID', '=', $iduser)->first();

        $inforperson_add1 = Person::leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID_1', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID_1', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID_1', '=', 'hrd_province.ID')
            ->where('hrd_person.ID', '=', $iduser)->first();

        $infoprefix   = DB::table('hrd_prefix')->get();
        $infomarry    = DB::table('hrd_marry_status')->get();
        $inforeligion = DB::table('hrd_religion')->get();
        $infonation   = DB::table('hrd_nationality')->get();
        $infocitizen  = DB::table('hrd_citizenship')->get();
        $infosex      = DB::table('hrd_sex')->get();
        $infoblood    = DB::table('hrd_bloodgroup')->get();

        $infoprovince = DB::table('hrd_province')->get();

        $infoid = DB::table('hrd_person')->where('hrd_person.ID', '=', $iduser)->first();

        $infodepartment         = DB::table('hrd_department')->get();
        $infodepartment_sub     = DB::table('hrd_department_sub')->get();
        $infodepartment_sub_sub = DB::table('hrd_department_sub_sub')->get();
        $infolevel              = DB::table('hrd_level')->get();
        $infostatus             = DB::table('hrd_status')->get();
        $infokind               = DB::table('hrd_kind')->get();
        $infokind_type          = DB::table('hrd_kind_type')->get();
        $infoperson_type        = DB::table('hrd_person_type')->get();
        $infoposition           = DB::table('hrd_position')->get();

        $name_userdetail = DB::table('users')->where('PERSON_ID', '=', $iduser)->first();
        if ($name_userdetail != null) {
            $name_user = $name_userdetail->username;
        } else {
            $name_user = '';
        }

        return view('manager_person.edituser', [
            'inforpersons'            => $inforperson,
            'infoprefixs'             => $infoprefix,
            'infomarrys'              => $infomarry,
            'inforeligions'           => $inforeligion,
            'infonations'             => $infonation,
            'infocitizens'            => $infocitizen,
            'infosexs'                => $infosex,
            'infobloods'              => $infoblood,
            'infoid'                  => $infoid,
            'infoprovinces'           => $infoprovince,
            'inforperson_add1'        => $inforperson_add1,
            'infodepartments'         => $infodepartment,
            'infodepartment_subs'     => $infodepartment_sub,
            'infodepartment_sub_subs' => $infodepartment_sub_sub,
            'infolevels'              => $infolevel,
            'infostatuss'             => $infostatus,
            'infokinds'               => $infokind,
            'infokind_types'          => $infokind_type,
            'infoperson_types'        => $infoperson_type,
            'infopositions'           => $infoposition,
            'name_user'               => $name_user

        ]);
    }

    public function editinfouserupdate(Request $request)
    {
        $checkstart = $request->STARTWORK;
        $checkvcode = $request->VCODE_DATE;
        $checkend = $request->ENDWORK;

        $iduser = $request->USER_ID;

        $BIRTHDAY    = Carbon::createFromFormat('d/m/Y', $request->HR_BIRTHDAY)->format('Y-m-d');
        $date_arrary = explode("-", $BIRTHDAY);
        $y_sub       = $date_arrary[0];

        if ($y_sub >= 2500) {
            $y = $y_sub - 543;
        } else {
            $y = $y_sub;
        }

        $m                = $date_arrary[1];
        $d                = $date_arrary[2];
        $displaybirthdate = $y . "-" . $m . "-" . $d;

        if ($checkstart != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st             = $date_arrary_st[1];
            $d_st             = $date_arrary_st[2];
            $displaystartdate = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $displaystartdate = null;
        }
        /////////////////////////
        if ($checkvcode != '') {
            $VCODEDAY      = Carbon::createFromFormat('d/m/Y', $checkvcode)->format('Y-m-d');
            $date_arrary_v = explode("-", $VCODEDAY);
            $y_sub_v       = $date_arrary_v[0];

            if ($y_sub_v >= 2500) {
                $y_v = $y_sub_v - 543;
            } else {
                $y_v = $y_sub_v;
            }
            $m_v              = $date_arrary_v[1];
            $d_v              = $date_arrary_v[2];
            $displayvcodedate = $y_v . "-" . $m_v . "-" . $d_v;
        } else {
            $displayvcodedate = null;
        }
        ////////////////////////
        if ($checkend != '') {
            $VCODEDAY      = Carbon::createFromFormat('d/m/Y', $checkend)->format('Y-m-d');
            $date_arrary_v = explode("-", $VCODEDAY);
            $y_sub_v       = $date_arrary_v[0];

            if ($y_sub_v >= 2500) {
                $y_v = $y_sub_v - 543;
            } else {
                $y_v = $y_sub_v;
            }
            $m_v              = $date_arrary_v[1];
            $d_v              = $date_arrary_v[2];
            $displaycheckend = $y_v . "-" . $m_v . "-" . $d_v;
        } else {
            $displaycheckend = null;
        }


        $inforpersonedit = Person::find($iduser);
        $inforpersonedit->HR_PREFIX_ID       = $request->HR_PREFIX;
        $inforpersonedit->HR_FNAME           = $request->HR_FNAME;
        $inforpersonedit->HR_LNAME           = $request->HR_LNAME;
        $inforpersonedit->HR_EN_NAME         = $request->HR_EN_NAME;
        $inforpersonedit->NICKNAME           = $request->NICKNAME;
        $inforpersonedit->HR_BIRTHDAY        = $displaybirthdate;
        $inforpersonedit->HR_CID             = $request->HR_CID;
        $inforpersonedit->HR_MARRY_STATUS_ID = $request->HR_MARRY_STATUS;
        $inforpersonedit->HR_RELIGION_ID     = $request->HR_RELIGION;
        $inforpersonedit->HR_NATIONALITY_ID  = $request->HR_NATIONALITY;
        $inforpersonedit->HR_CITIZENSHIP_ID  = $request->HR_CITIZENSHIP;
        $inforpersonedit->SEX                = $request->SEX;
        $inforpersonedit->HR_BLOODGROUP_ID   = $request->HR_BLOODGROUP;
        $inforpersonedit->HR_HIGH            = $request->HR_HIGH;
        $inforpersonedit->HR_WEIGHT          = $request->HR_WEIGHT;
        $inforpersonedit->HR_PHONE           = $request->HR_PHONE;
        $inforpersonedit->HR_EMAIL           = $request->HR_EMAIL;
        $inforpersonedit->HR_FACEBOOK        = $request->HR_FACEBOOK;
        $inforpersonedit->HR_LINE            = $request->HR_LINE;

        $inforpersonedit->HR_DEPARTMENT_ID         = $request->HR_DEPARTMENT;
        $inforpersonedit->HR_DEPARTMENT_SUB_ID     = $request->DEPARTMENT_SUB;
        $inforpersonedit->HR_DEPARTMENT_SUB_SUB_ID = $request->HR_DEPARTMENT_SUB_SUB;

        $inforpersonedit->HR_STARTWORK_DATE = $displaystartdate;
        $inforpersonedit->HR_WORK_END_DATE = $displaycheckend;

        $inforpersonedit->HR_POSITION_NUM = $request->HR_POSITION_NUM;
        $inforpersonedit->VCODE           = $request->VCODE;

        $inforpersonedit->VCODE_DATE   = $displayvcodedate;
        $inforpersonedit->HR_AGENCY_ID = $request->HR_AGENCY_ID;

        $position = DB::table('hrd_position')
            ->where('HR_POSITION_ID', '=', $request->POSITION_IN_WORK)
            ->first();
        $inforpersonedit->POSITION_IN_WORK = $position->HR_POSITION_NAME;

        $inforpersonedit->HR_POSITION_ID    = $request->POSITION_IN_WORK;
        $inforpersonedit->HR_LEVEL_ID       = $request->HR_LEVEL;
        $inforpersonedit->HR_STATUS_ID      = $request->HR_STATUS;
        $inforpersonedit->HR_KIND_ID        = $request->HR_KIND;
        $inforpersonedit->HR_KIND_TYPE_ID   = $request->HR_KIND_TYPE;
        $inforpersonedit->HR_PERSON_TYPE_ID = $request->HR_PERSON_TYPE;
        $inforpersonedit->HR_SALARY         = $request->HR_SALARY;
        $inforpersonedit->MONEY_POSITION    = $request->MONEY_POSITION;

        $inforpersonedit->HR_HOME_NUMBER = $request->HR_HOME_NUMBER;
        $inforpersonedit->HR_VILLAGE_NO  = $request->HR_VILLAGE_NO;
        $inforpersonedit->HR_ROAD_NAME   = $request->HR_ROAD_NAME;
        $inforpersonedit->HR_SOI_NAME    = $request->HR_SOI_NAME;
        $inforpersonedit->PROVINCE_ID    = $request->PROVINCE_NAME;
        $inforpersonedit->AMPHUR_ID      = $request->AMPHUR_NAME;
        $inforpersonedit->TUMBON_ID      = $request->TUMBON_NAME;
        $inforpersonedit->HR_ZIPCODE     = $request->HR_ZIPCODE;

        $inforpersonedit->HR_HOME_NUMBER_1 = $request->HR_HOME_NUMBER_1;
        $inforpersonedit->HR_VILLAGE_NO_1  = $request->HR_VILLAGE_NO_1;
        $inforpersonedit->HR_ROAD_NAME_1   = $request->HR_ROAD_NAME_1;
        $inforpersonedit->PROVINCE_ID_1    = $request->PROVINCE_NAME_1;
        $inforpersonedit->AMPHUR_ID_1      = $request->AMPHUR_NAME_1;
        $inforpersonedit->TUMBON_ID_1      = $request->TUMBON_NAME_1;
        $inforpersonedit->HR_ZIPCODE_1     = $request->HR_ZIPCODE_1;

        $inforpersonedit->BOOK_BANK_NUMBER = $request->BOOK_BANK_NUMBER;
        $inforpersonedit->BOOK_BANK_NAME   = $request->BOOK_BANK_NAME;
        $inforpersonedit->BOOK_BANK        = $request->BOOK_BANK;
        $inforpersonedit->BOOK_BANK_BRANCH = $request->BOOK_BANK_BRANCH;

        $inforpersonedit->BOOK_BANK_OT_NUMBER = $request->BOOK_BANK_OT_NUMBER;
        $inforpersonedit->BOOK_BANK_OT_NAME   = $request->BOOK_BANK_OT_NAME;
        $inforpersonedit->BOOK_BANK_OT        = $request->BOOK_BANK_OT;
        $inforpersonedit->BOOK_BANK_OT_BRANCH = $request->BOOK_BANK_OT_BRANCH;

        $picid = $request->HR_CID;

        if ($request->hasFile('picture')) {

            $file                      = $request->file('picture');
            $contents                  = $file->openFile()->fread($file->getSize());
            $inforpersonedit->HR_IMAGE = $contents;

        }

    
        $inforpersonedit->save();

        $inforuserdit        = Adduser::where('PERSON_ID', '=', $iduser)->first();
        $inforuserdit->name  = $request->HR_FNAME . ' ' . $request->HR_LNAME;
        $inforuserdit->email = $request->HR_EMAIL;
        $inforuserdit->save();

        if ($displaycheckend != '' ) {

            $idper = Person::where('ID', '=', $iduser)->first();        

            // อัปเดท สถานะ  ********************************************
            $statuscode = 'NOTUSER';
              DB::table('users')->where('PERSON_ID','=',$idper->ID)
                ->update(['status' => $statuscode]);
        }

        return redirect()->route('mperson.inforperson', ['iduser' => $iduser]);
    }

    public function infousersalary(Request $request)
    {

        $inforpersonuser = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_religion', 'hrd_person.HR_RELIGION_ID', '=', 'hrd_religion.HR_RELIGION_ID')
            ->leftJoin('hrd_nationality', 'hrd_person.HR_NATIONALITY_ID', '=', 'hrd_nationality.HR_NATIONALITY_ID')
            ->leftJoin('hrd_citizenship', 'hrd_person.HR_CITIZENSHIP_ID', '=', 'hrd_citizenship.HR_CITIZENSHIP_ID')
            ->leftJoin('hrd_kind', 'hrd_person.HR_KIND_ID', '=', 'hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type', 'hrd_person.HR_KIND_TYPE_ID', '=', 'hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->get();
                   
      
       $infoposition = DB::table('hrd_position')->get();

       $infolevel = DB::table('hrd_level')->get();

        return view('manager_person.infousersalary', [
            'inforpersonuser' => $inforpersonuser,
            'infolevels'      => $infolevel,
            'infopositions'   => $infoposition,
        ]);
    }

    public function infousersalarynewsave(Request $request)
    {

    

       $checkstart= $request->DATE_CHANGE;     



                if($checkstart != ''){
                
                    $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
                    $date_arrary_st=explode("-",$STARTDAY);  
                    $y_sub_st = $date_arrary_st[0]; 
                    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];  
                    $displaystartdate= $y_st."-".$m_st."-".$d_st;
                

                    }else{
                    $displaystartdate= null;
                }
        
            $idperson = $request->idlist;
            $newsalary = $request->SALARYNEW; 

            $addsalary = new Salary(); 
            $addsalary->PERSON_ID = $idperson;
            $addsalary->DATE_CHANGE = $displaystartdate;

            $addsalary->SALARY_NUMBER = $request->SALARY_NUMBER;   
            $addsalary->SALARYNEW = $newsalary; 
            $addsalary->COMMENT = $request->COMMENT;

            $l = $request->HR_LEVEL_ID;
       
            
            $addsalary->POSITION_ID = $request->POSITION_ID;
            $nameposition = DB::table('hrd_position')->where('HR_POSITION_ID','=',$request->POSITION_ID)->first();
            $addsalary->POSITION_IN_WORK = $nameposition->HR_POSITION_NAME;

            $addsalary->LAVEL_ID = $request->HR_LEVEL_ID;

            $namelevel = DB::table('hrd_level')->where('HR_LEVEL_ID','=',$request->HR_LEVEL_ID)->first();
            $addsalary->LAVEL_NAME = $namelevel->HR_LEVEL_NAME;


            $addsalary->USER_EDIT_ID = $request->USER_EDIT_ID;
          
            $addsalary->save();

            $updatesaraly = Person::find($idperson);
            $updatesaraly->HR_SALARY = $newsalary;
            $updatesaraly->save();

    }


    public function infousersalarysave(Request $request)
    {

       $request->validate([
        'SALARY_NUMBER' => 'required',
        'DATE_CHANGE' => 'required',
        'POSITION_ID' => 'required',
        'LAVEL_ID' => 'required',
        'SALARYNEW' => 'required'
     
    ]);
    
       $checkstart= $request->DATE_CHANGE;     

        if($checkstart != ''){
           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $displaystartdate= $y_st."-".$m_st."-".$d_st;
         

            }else{
            $displaystartdate= null;
        }
        
            $idperson = $request->PERSON_ID;
            $newsalary = $request->SALARYNEW; 

            $addsalary = new Salary(); 
            $addsalary->PERSON_ID = $idperson;
            $addsalary->DATE_CHANGE = $displaystartdate;

            $addsalary->SALARY_NUMBER = $request->SALARY_NUMBER;   
            $addsalary->SALARYNEW = $newsalary; 
            $addsalary->COMMENT = $request->COMMENT;
            
            $addsalary->POSITION_ID = $request->POSITION_ID;
            $nameposition = DB::table('hrd_position')->where('HR_POSITION_ID','=',$request->POSITION_ID)->first();
            $addsalary->POSITION_IN_WORK = $nameposition->HR_POSITION_NAME;

            $addsalary->LAVEL_ID = $request->LAVEL_ID;
            $namelevel = DB::table('hrd_level')->where('HR_LEVEL_ID','=',$request->LAVEL_ID)->first();
            $addsalary->LAVEL_NAME = $namelevel->HR_LEVEL_NAME;


            $addsalary->USER_EDIT_ID = $request->USER_EDIT_ID;
          
            $addsalary->save();

            $updatesaraly = Person::find($idperson);
            $updatesaraly->HR_SALARY = $newsalary;
            $updatesaraly->save();


            return response()->json([
                'status' => 1,
                'url' => url('manager_person/detail/'.$request->PERSON_ID)
            ]);

    }

    public function infousersalaryupdate(Request $request)
    {

        $request->validate([
            'SALARY_NUMBER_edit' => 'required',
            'DATE_CHANGE_edit' => 'required',
            'POSITION_ID_edit' => 'required',
            'LAVEL_ID_edit' => 'required',
            'SALARYNEW_edit' => 'required'
            
    
        ]);

        
        $id = $request->ID; 

        $checkstart= $request->DATE_CHANGE_edit;
      

    if($checkstart != ''){           
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        if($y_sub_st < 2500){
            $y_st = $y_sub_st;
        }else{
            $y_st = $y_sub_st-543;
        }
        
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $displaystartdate= $y_st."-".$m_st."-".$d_st;
        }else{
        $displaystartdate= null;
    }
    
    $idperson = $request->PERSON_ID;
    $newsalary = $request->SALARYNEW_edit; 

        $salaryedit = Salary::find($id);
    
        $salaryedit->DATE_CHANGE = $displaystartdate;

        $salaryedit->SALARY_NUMBER = $request->SALARY_NUMBER_edit; 
        $salaryedit->SALARYNEW = $newsalary;
        $salaryedit->COMMENT = $request->COMMENT;

          
        $salaryedit->POSITION_ID = $request->POSITION_ID_edit;
        $nameposition = DB::table('hrd_position')->where('HR_POSITION_ID','=',$request->POSITION_ID_edit)->first();
        $salaryedit->POSITION_IN_WORK = $nameposition->HR_POSITION_NAME;

        $salaryedit->LAVEL_ID = $request->LAVEL_ID_edit;
        $namelevel = DB::table('hrd_level')->where('HR_LEVEL_ID','=',$request->LAVEL_ID_edit)->first();
        $salaryedit->LAVEL_NAME = $namelevel->HR_LEVEL_NAME;

        $salaryedit->USER_EDIT_ID = $request->USER_EDIT_ID;
 
    
        $salaryedit->save();
        
        $updatesaraly = Person::find($idperson);
        $updatesaraly->HR_SALARY = $newsalary;
        $updatesaraly->save();
        // Toastr::success('บันทึกข้อมูลสำเร็จ');
        return response()->json([
            'status' => 1,
            'url' => url('manager_person/detail/'.$request->PERSON_ID)
        ]);


    }

    public function infousersalary_destroy($id,$iduser) { 
                
        $userid = Person::where('hrd_person.ID', '=', $iduser)->first();

        Salary::destroy($id);         
        //return redirect()->action('SalaryController@infousersalary'); 
        return redirect()->route('mperson.infouser',['iduser'=>  $userid]);    
        // return response()->json([
        //     'status' => 1,
        //     'url' => url('manager_person/detail/'.$request->PERSON_ID)
        // ]);
    }

    //===========================================================================//

    public function setupjobdescription(Request $request)
    {

        $jobdescription = Infoworkjobdis::get();

        return view('manager_person.setupjobdescription', [
            'jobdescriptions' => $jobdescription
        ]);
    }

    public function setupjobdescription_add(Request $request)
    {

        return view('manager_person.setupjobdescription_add');
    }

    public function setupjobdescription_save(Request $request)
    {

        $add               = new Infoworkjobdis();
        $add->JOD_DIS_NAME = $request->JOD_DIS_NAME;
        $add->save();

        return redirect()->action('ManagerpersonController@setupjobdescription');
    }

    public function setupjobdescriptionposition(Request $request, $idref)
    {
        $infojob = Infoworkjobdis::where('JOD_DIS_ID', '=', $idref)->first();

        $jobposition = Infoworkjobdisposition::where('JOD_DIS_ID', '=', $idref)->get();

        $infoposition = DB::table('hrd_position')->get();

        return view('manager_person.setupjobdescription_position', [
            'jobpositions'  => $jobposition,
            'infojob'       => $infojob,
            'infopositions' => $infoposition
        ]);
    }

    public function setupjobdescriptionposition_save(Request $request)
    {

        $add                  = new Infoworkjobdisposition();
        $add->JOD_DIS_ID      = $request->JOD_DIS_ID;
        $add->JOD_POSITION_ID = $request->JOD_POSITION_ID;

        $infoposition           = DB::table('hrd_position')->where('HR_POSITION_ID', '=', $request->JOD_POSITION_ID)->first();
        $add->JOD_POSITION_NAME = $infoposition->HR_POSITION_NAME;
        $add->save();

        $idref = $request->JOD_DIS_ID;

        return redirect()->action('ManagerpersonController@setupjobdescriptionposition', [
            'idref' => $idref
        ]);
    }

    public function setupjobdescriptionposition_destroy($idref, $id)
    {

        Infoworkjobdisposition::destroy($id);
        return redirect()->action('ManagerpersonController@setupjobdescriptionposition', [
            'idref' => $idref
        ]);
    }

    public function setupjobdescription_edit(Request $request, $idref)
    {
        $infojob = Infoworkjobdis::where('JOD_DIS_ID', '=', $idref)->first();

        return view('manager_person.setupjobdescription_edit', [
            'infojob' => $infojob
        ]);
    }

    public function setupjobdescription_update(Request $request)
    {

        $id                   = $request->JOD_DIS_ID;
        $update               = Infoworkjobdis::find($id);
        $update->JOD_DIS_NAME = $request->JOD_DIS_NAME;
        $update->save();

        return redirect()->action('ManagerpersonController@setupjobdescription');
    }

    public function setupjobdescription_destroy($idref)
    {

        Infoworkjobdis::destroy($idref);
        return redirect()->action('ManagerpersonController@setupjobdescription');
    }

    //-------------------------------

    public function setupcorecompetency(Request $request)
    {

        $corecompetecy = Infoworkcorcom::get();

        return view('manager_person.setupcorecompetency', [
            'corecompetecys' => $corecompetecy
        ]);
    }

    public function setupcorecompetency_add(Request $request)
    {

        return view('manager_person.setupcorecompetency_add');
    }

    public function setupcorecompetency_save(Request $request)
    {

        $add                 = new Infoworkcorcom();
        $add->COR_COM_NAME   = $request->COR_COM_NAME;
        $add->COR_COM_DETAIL = $request->COR_COM_DETAIL;
        $add->save();

        return redirect()->action('ManagerpersonController@setupcorecompetency');
    }

    public function setupcorecompetency_edit(Request $request, $idref)
    {
        $infocorcom = Infoworkcorcom::where('COR_COM_ID', '=', $idref)->first();

        return view('manager_person.setupcorecompetency_edit', [
            'infocorcom' => $infocorcom
        ]);
    }

    public function setupcorecompetency_update(Request $request)
    {

        $id                     = $request->COR_COM_ID;
        $update                 = Infoworkcorcom::find($id);
        $update->COR_COM_NAME   = $request->COR_COM_NAME;
        $update->COR_COM_DETAIL = $request->COR_COM_DETAIL;
        $update->save();

        return redirect()->action('ManagerpersonController@setupcorecompetency');
    }

    public function setupcorecompetency_destroy($idref)
    {
        Infoworkcorcom::destroy($idref);
        return redirect()->action('ManagerpersonController@setupcorecompetency');
    }

    //----------------------------------เพิ่มระดับ

    public function setupcorecompetencylevel(Request $request, $idref)
    {
        $infocorcom = Infoworkcorcom::where('COR_COM_ID', '=', $idref)->first();
        $infocorcomlevel = DB::table('infowork_cor_com_level')->where('COR_COM_ID', '=', $idref)->get();

        return view('manager_person.setupcorecompetencylevel', [
            'infocorcom'       => $infocorcom,
            'infocorcomlevels' => $infocorcomlevel
        ]);
    }

    public function setupcorecompetencylevel_add(Request $request, $idref)
    {

        $infoscoretype = DB::table('infowork_type_score')->get();
        $infocorcom = Infoworkcorcom::where('COR_COM_ID', '=', $idref)->first();

        return view('manager_person.setupcorecompetencylevel_add', [
            'idref'          => $idref,
            'infocorcom'     => $infocorcom,
            'infoscoretypes' => $infoscoretype
        ]);
    }

    public function setupcorecompetencylevel_save(Request $request)
    {

        $add                       = new Infoworkcorcomlevel();
        $add->COR_COM_ID           = $request->COR_COM_ID;
        $add->COR_COM_LEVEL_DETAIL = $request->COR_COM_LEVEL_DETAIL;
        $add->save();

        $COR_COM_LEVEL_ID = Infoworkcorcomlevel::max('COR_COM_LEVEL_ID');

        if ($request->COR_COM_LEVEL_SUB_NUMBER[0] != '' || $request->COR_COM_LEVEL_SUB_NUMBER[0] != null) {

            $COR_COM_LEVEL_SUB_NUMBER = $request->COR_COM_LEVEL_SUB_NUMBER;
            $COR_COM_LEVEL_SUB_DETAIL = $request->COR_COM_LEVEL_SUB_DETAIL;
            $TYPE_SCORE_ID            = $request->TYPE_SCORE_ID;

            $number = count($COR_COM_LEVEL_SUB_NUMBER);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addsup                           = new Infoworkcorcomlevelsub();
                $addsup->COR_COM_LEVEL_ID         = $COR_COM_LEVEL_ID;
                $addsup->COR_COM_LEVEL_SUB_NUMBER = $COR_COM_LEVEL_SUB_NUMBER[$count];
                $addsup->COR_COM_LEVEL_SUB_DETAIL = $COR_COM_LEVEL_SUB_DETAIL[$count];
                $addsup->TYPE_SCORE_ID            = $TYPE_SCORE_ID[$count];
                $addsup->save();

            }
        }

        $idref = $request->COR_COM_ID;

        return redirect()->action('ManagerpersonController@setupcorecompetencylevel', [
            'idref' => $idref
        ]);
    }

    public function setupcorecompetencylevel_edit(Request $request, $idref, $id)
    {

        $infoscoretype      = DB::table('infowork_type_score')->get();
        $infocorcom         = Infoworkcorcom::where('COR_COM_ID', '=', $idref)->first();
        $infocorcomlevel    = Infoworkcorcomlevel::where('COR_COM_LEVEL_ID', '=', $id)->first();
        $infocorcomlevelsub = Infoworkcorcomlevelsub::where('COR_COM_LEVEL_ID', '=', $id)->get();

        return view('manager_person.setupcorecompetencylevel_edit', [
            'idref'               => $idref,
            'infocorcom'          => $infocorcom,
            'infoscoretypes'      => $infoscoretype,
            'infocorcomlevel'     => $infocorcomlevel,
            'infocorcomlevelsubs' => $infocorcomlevelsub
        ]);
    }

    public function setupcorecompetencylevel_update(Request $request)
    {

        $id = $request->COR_COM_LEVEL_ID;

        $update                       = Infoworkcorcomlevel::find($id);
        $update->COR_COM_ID           = $request->COR_COM_ID;
        $update->COR_COM_LEVEL_DETAIL = $request->COR_COM_LEVEL_DETAIL;
        $update->save();

        $COR_COM_LEVEL_ID = $id;

        Infoworkcorcomlevelsub::where('COR_COM_LEVEL_ID', '=', $id)->delete();

        if ($request->COR_COM_LEVEL_SUB_NUMBER[0] != '' || $request->COR_COM_LEVEL_SUB_NUMBER[0] != null) {

            $COR_COM_LEVEL_SUB_NUMBER = $request->COR_COM_LEVEL_SUB_NUMBER;
            $COR_COM_LEVEL_SUB_DETAIL = $request->COR_COM_LEVEL_SUB_DETAIL;
            $TYPE_SCORE_ID            = $request->TYPE_SCORE_ID;

            $number = count($COR_COM_LEVEL_SUB_NUMBER);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addsup                           = new Infoworkcorcomlevelsub();
                $addsup->COR_COM_LEVEL_ID         = $COR_COM_LEVEL_ID;
                $addsup->COR_COM_LEVEL_SUB_NUMBER = $COR_COM_LEVEL_SUB_NUMBER[$count];
                $addsup->COR_COM_LEVEL_SUB_DETAIL = $COR_COM_LEVEL_SUB_DETAIL[$count];
                $addsup->TYPE_SCORE_ID            = $TYPE_SCORE_ID[$count];
                $addsup->save();

            }
        }

        $idref = $request->COR_COM_ID;

        return redirect()->action('ManagerpersonController@setupcorecompetencylevel', [
            'idref' => $idref
        ]);
    }

    //------------------------------------------------
    public function setupfuntionalcompetency(Request $request)
    {

        $funtion = Infoworkfuntion::get();
        return view('manager_person.setupfuntionalcompetency', [
            'funtions' => $funtion
        ]);
    }

    public function setupfuntionalcompetency_add(Request $request)
    {
        return view('manager_person.setupfuntionalcompetency_add');
    }

    public function setupfuntionalcompetency_save(Request $request)
    {

        $add                 = new Infoworkfuntion();
        $add->FUNTION_NAME   = $request->FUNTION_NAME;
        $add->FUNTION_DETAIL = $request->FUNTION_DETAIL;
        $add->save();

        return redirect()->action('ManagerpersonController@setupfuntionalcompetency');
    }

    public function setupfuntionalcompetencyposition(Request $request, $idref)
    {
        $infofun = Infoworkfuntion::where('FUNTION_ID', '=', $idref)->first();
        $funposition = Infoworkfuntionposition::where('FUNTION_ID', '=', $idref)->get();
        $infoposition = DB::table('hrd_position')->get();

        return view('manager_person.setupfuntionalcompetency_position', [
            'funpositions'  => $funposition,
            'infofun'       => $infofun,
            'infopositions' => $infoposition
        ]);
    }

    public function setupfuntionalcompetencyposition_save(Request $request)
    {

        $add                  = new Infoworkfuntionposition();
        $add->FUNTION_ID      = $request->FUNTION_ID;
        $add->FUN_POSITION_ID = $request->FUN_POSITION_ID;

        $infoposition           = DB::table('hrd_position')->where('HR_POSITION_ID', '=', $request->FUN_POSITION_ID)->first();
        $add->FUN_POSITION_NAME = $infoposition->HR_POSITION_NAME;
        $add->save();

        $idref = $request->FUNTION_ID;

        return redirect()->action('ManagerpersonController@setupfuntionalcompetencyposition', [
            'idref' => $idref
        ]);
    }

    public function setupfuntionalcompetencyposition_destroy($idref, $id)
    {

        Infoworkfuntionposition::destroy($id);
        return redirect()->action('ManagerpersonController@setupfuntionalcompetencyposition', [
            'idref' => $idref
        ]);
    }

    public function setupfuntionalcompetency_edit(Request $request, $idref)
    {
        $infofuntion = Infoworkfuntion::where('FUNTION_ID', '=', $idref)->first();

        return view('manager_person.setupfuntionalcompetency_edit', [
            'infofuntion' => $infofuntion
        ]);
    }

    public function setupfuntionalcompetency_update(Request $request)
    {

        $id                     = $request->FUNTION_ID;
        $update                 = Infoworkfuntion::find($id);
        $update->FUNTION_NAME   = $request->FUNTION_NAME;
        $update->FUNTION_DETAIL = $request->FUNTION_DETAIL;
        $update->save();

        return redirect()->action('ManagerpersonController@setupfuntionalcompetency');
    }

    public function setupfuntionalcompetency_destroy($idref)
    {
        Infoworkfuntion::destroy($idref);
        return redirect()->action('ManagerpersonController@setupfuntionalcompetency');
    }

    //----------------------------------เพิ่มระดับ

    public function setupfuntionalcompetencylevel(Request $request, $idref)
    {
        $infofuntion = Infoworkfuntion::where('FUNTION_ID', '=', $idref)->first();
        $infofuntionlevel = Infoworkfuntionlevel::where('FUNTION_ID', '=', $idref)->get();

        return view('manager_person.setupfuntionalcompetencylevel', [
            'infofuntion'       => $infofuntion,
            'infofuntionlevels' => $infofuntionlevel
        ]);
    }

    public function setupfuntionalcompetencylevel_add(Request $request, $idref)
    {
        $infoscoretype = DB::table('infowork_type_score')->get();
        return view('manager_person.setupfuntionalcompetencylevel_add', [
            'idref'          => $idref,
            'infoscoretypes' => $infoscoretype
        ]);
    }

    public function setupfuntionalcompetencylevel_save(Request $request)
    {

        $add                       = new Infoworkfuntionlevel();
        $add->FUNTION_ID           = $request->FUNTION_ID;
        $add->FUNTION_LEVEL_DETAIL = $request->FUNTION_LEVEL_DETAIL;
        $add->save();

        $FUNTION_LEVEL_ID = Infoworkfuntionlevel::max('FUNTION_LEVEL_ID');

        if ($request->FUNTION_LEVEL_SUB_NUMBER[0] != '' || $request->FUNTION_LEVEL_SUB_NUMBER[0] != null) {

            $FUNTION_LEVEL_SUB_NUMBER = $request->FUNTION_LEVEL_SUB_NUMBER;
            $FUNTION_LEVEL_SUB_DETAIL = $request->FUNTION_LEVEL_SUB_DETAIL;
            $TYPE_SCORE_ID            = $request->TYPE_SCORE_ID;

            $number = count($FUNTION_LEVEL_SUB_NUMBER);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addsup                           = new Infoworkfuntionlevelsub();
                $addsup->FUNTION_LEVEL_ID         = $FUNTION_LEVEL_ID;
                $addsup->FUNTION_LEVEL_SUB_NUMBER = $FUNTION_LEVEL_SUB_NUMBER[$count];
                $addsup->FUNTION_LEVEL_SUB_DETAIL = $FUNTION_LEVEL_SUB_DETAIL[$count];
                $addsup->TYPE_SCORE_ID            = $TYPE_SCORE_ID[$count];
                $addsup->save();

            }
        }

        $idref = $request->FUNTION_ID;

        return redirect()->action('ManagerpersonController@setupfuntionalcompetencylevel', [
            'idref' => $idref
        ]);
    }

    public function setupfuntionalcompetencylevel_edit(Request $request, $idref, $id)
    {

        $infoscoretype   = DB::table('infowork_type_score')->get();
        $infofun         = Infoworkfuntion::where('FUNTION_ID', '=', $idref)->first();
        $infofunlevel    = Infoworkfuntionlevel::where('FUNTION_LEVEL_ID', '=', $id)->first();
        $infofunlevelsub = Infoworkfuntionlevelsub::where('FUNTION_LEVEL_ID', '=', $id)->get();

        return view('manager_person.setupfuntionalcompetencylevel_edit', [
            'idref'            => $idref,
            'infofun'          => $infofun,
            'infoscoretypes'   => $infoscoretype,
            'infofunlevel'     => $infofunlevel,
            'infofunlevelsubs' => $infofunlevelsub

        ]);
    }

    public function setupfuntionalcompetencylevel_update(Request $request)
    {

        $id = $request->FUNTION_LEVEL_ID;

        $add                       = Infoworkfuntionlevel::find($id);
        $add->FUNTION_ID           = $request->FUNTION_ID;
        $add->FUNTION_LEVEL_DETAIL = $request->FUNTION_LEVEL_DETAIL;
        $add->save();

        Infoworkfuntionlevelsub::where('FUNTION_LEVEL_ID', '=', $id)->delete();

        $FUNTION_LEVEL_ID = $id;

        if ($request->FUNTION_LEVEL_SUB_NUMBER[0] != '' || $request->FUNTION_LEVEL_SUB_NUMBER[0] != null) {

            $FUNTION_LEVEL_SUB_NUMBER = $request->FUNTION_LEVEL_SUB_NUMBER;
            $FUNTION_LEVEL_SUB_DETAIL = $request->FUNTION_LEVEL_SUB_DETAIL;
            $TYPE_SCORE_ID            = $request->TYPE_SCORE_ID;

            $number = count($FUNTION_LEVEL_SUB_NUMBER);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addsup                           = new Infoworkfuntionlevelsub();
                $addsup->FUNTION_LEVEL_ID         = $FUNTION_LEVEL_ID;
                $addsup->FUNTION_LEVEL_SUB_NUMBER = $FUNTION_LEVEL_SUB_NUMBER[$count];
                $addsup->FUNTION_LEVEL_SUB_DETAIL = $FUNTION_LEVEL_SUB_DETAIL[$count];
                $addsup->TYPE_SCORE_ID            = $TYPE_SCORE_ID[$count];
                $addsup->save();

            }
        }

        $idref = $request->FUNTION_ID;

        return redirect()->action('ManagerpersonController@setupfuntionalcompetencylevel', [
            'idref' => $idref
        ]);
    }

    //---------------------------------------------------------------------
    public function resultability(Request $request)
    {

        $person = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
            ->orderBy('hrd_person.ID', 'desc')
            ->get();

        return view('manager_person.resultability', [
            'persons' => $person

        ]);
    }

    public function setupsetscore(Request $request)
    {
        $typescore = Infoworktypescore::get();

        return view('manager_person.setupsetscore', [
            'typescores' => $typescore
        ]);
    }

    public function setupsetscore_add(Request $request)
    {

        return view('manager_person.setupsetscore_add');
    }

    public function setupsetscore_save(Request $request)
    {

        $add                  = new Infoworktypescore();
        $add->TYPE_SCORE_NAME = $request->TYPE_SCORE_NAME;
        $add->save();

        $TYPE_SCORE_ID = Infoworktypescore::max('TYPE_SCORE_ID');

        if ($request->TYPE_SCORE_SUB_TOTAL[0] != '' || $request->TYPE_SCORE_SUB_TOTAL[0] != null) {

            $TYPE_SCORE_SUB_TOTAL = $request->TYPE_SCORE_SUB_TOTAL;
            $TYPE_SCORE_SUB_NAME  = $request->TYPE_SCORE_SUB_NAME;

            $number = count($TYPE_SCORE_SUB_TOTAL);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addsup                       = new Infoworktypescoresub();
                $addsup->TYPE_SCORE_ID        = $TYPE_SCORE_ID;
                $addsup->TYPE_SCORE_SUB_TOTAL = $TYPE_SCORE_SUB_TOTAL[$count];
                $addsup->TYPE_SCORE_SUB_NAME  = $TYPE_SCORE_SUB_NAME[$count];
                $addsup->save();

            }
        }

        return redirect()->action('ManagerpersonController@setupsetscore');
    }

    public function setupsetscore_edit(Request $request, $idref)
    {
        $infotypescore    = Infoworktypescore::where('TYPE_SCORE_ID', '=', $idref)->first();
        $infotypescoresub = Infoworktypescoresub::where('TYPE_SCORE_ID', '=', $idref)->get();

        return view('manager_person.setupsetscore_edit', [
            'infotypescore'     => $infotypescore,
            'infotypescoresubs' => $infotypescoresub

        ]);
    }

    public function setupsetscore_update(Request $request)
    {

        $id = $request->TYPE_SCORE_ID;

        $add                  = Infoworktypescore::find($id);
        $add->TYPE_SCORE_NAME = $request->TYPE_SCORE_NAME;
        $add->save();

        $TYPE_SCORE_ID = $id;

        Infoworktypescoresub::where('TYPE_SCORE_ID', '=', $id)->delete();

        if ($request->TYPE_SCORE_SUB_TOTAL[0] != '' || $request->TYPE_SCORE_SUB_TOTAL[0] != null) {

            $TYPE_SCORE_SUB_TOTAL = $request->TYPE_SCORE_SUB_TOTAL;
            $TYPE_SCORE_SUB_NAME  = $request->TYPE_SCORE_SUB_NAME;

            $number = count($TYPE_SCORE_SUB_TOTAL);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addsup                       = new Infoworktypescoresub();
                $addsup->TYPE_SCORE_ID        = $TYPE_SCORE_ID;
                $addsup->TYPE_SCORE_SUB_TOTAL = $TYPE_SCORE_SUB_TOTAL[$count];
                $addsup->TYPE_SCORE_SUB_NAME  = $TYPE_SCORE_SUB_NAME[$count];
                $addsup->save();

            }
        }

        return redirect()->action('ManagerpersonController@setupsetscore');
    }

    public function jobdescription(Request $request)
    {

        $infojabdis = DB::table('infowork_job_dis')->get();
        return view('manager_person.jobdescription', [
            'infojabdiss' => $infojabdis

        ]);
    }

    //----------------------------------------------

    public function setupkpis(Request $request)
    {
        $infoworkkpis = DB::table('infowork_kpis')->get();

        return view('manager_person.setupkpis', [
            'infoworkkpis' => $infoworkkpis
        ]);
    }

    public function setupkpis_add(Request $request)
    {

        return view('manager_person.setupkpis_add');
    }

    public function setupkpis_save(Request $request)
    {

        $add            = new Infoworkkpis();
        $add->KPIS_CODE = $request->KPIS_CODE;
        $add->KPIS_NAME = $request->KPIS_NAME;
        $add->save();

        return redirect()->action('ManagerpersonController@setupkpis');
    }

    public function setupkpis_edit(Request $request, $idref)
    {
        $infoworkkpis = DB::table('infowork_kpis')->where('KPIS_ID', '=', $idref)->first();

        return view('manager_person.setupkpis_edit', [
            'infokpis' => $infoworkkpis
        ]);
    }

    public function setupkpis_update(Request $request)
    {
        $id = $request->KPIS_ID;

        $add            = Infoworkkpis::find($id);
        $add->KPIS_CODE = $request->KPIS_CODE;
        $add->KPIS_NAME = $request->KPIS_NAME;
        $add->save();

        return redirect()->action('ManagerpersonController@setupkpis');
    }

    public function setupkpis_destroy($idref)
    {

        Infoworkkpis::destroy($idref);
        return redirect()->action('ManagerpersonController@setupkpis');
    }

    //===============================================

    public function setupsetscoreweight(Request $request)
    {
        return view('manager_person.setupsetscoreweight');
    }

    public function setupsetscoreweight_add(Request $request)
    {
        return view('manager_person.setupsetscoreweight_add');
    }

    public function setupsetscoreweight_edit(Request $request)
    {
        return view('manager_person.setupsetscoreweight_edit');
    }

    //================================================

    public function kpis_detail(Request $request)
    {
        return view('manager_person.kpis_detail');
    }

    public function funtionalcompetency_detail(Request $request)
    {
        return view('manager_person.funtionalcompetency_detail');
    }

    public function corecompetency_detail(Request $request)
    {
        return view('manager_person.corecompetency_detail');
    }

    //===================================================

    public function kpis(Request $request)
    {

        $infokpiorg = DB::table('plan_kpi')->get();

        $infokpiperson = DB::table('infowork_kpis')->get();

        return view('manager_person.kpis', [
            'infokpiorgs'    => $infokpiorg,
            'infokpipersons' => $infokpiperson
        ]);
    }

    public function funtionalcompetency(Request $request)
    {
        $infoworkfuntion = DB::table('infowork_funtion')->get();

        return view('manager_person.funtionalcompetency', [
            'infoworkfuntions' => $infoworkfuntion
        ]);
    }

    public function corecompetency(Request $request)
    {
        $infoworkcorcom = DB::table('infowork_cor_com')->get();
        return view('manager_person.corecompetency', [
            'infoworkcorcoms' => $infoworkcorcom
        ]);
    }

    public function checkscore(Request $request)
    {
        $idscore = $request->SCORE;
        $idhead  = $request->idhead;

        $inforscore = DB::table('infowork_type_score_sub')->where('TYPE_SCORE_SUB_ID', '=', $idscore)->first();

        echo '<input type="hidden" name="sum' . $idhead . '" id="scorenum' . $idhead . '" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="' . $inforscore->TYPE_SCORE_SUB_TOTAL . '">' . $inforscore->TYPE_SCORE_SUB_TOTAL;

    }

    //=============================================

    public function capacity_main()
    {
        $person = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
            ->where('hrd_person.HR_STATUS_ID', '<>', 5)
            ->where('hrd_person.HR_STATUS_ID', '<>', 6)
            ->where('hrd_person.HR_STATUS_ID', '<>', 7)
            ->where('hrd_person.HR_STATUS_ID', '<>', 8)
            ->orderBy('hrd_person.ID', 'desc')
            ->get();

        return view('manager_person.personinfoworkcapacity_main', [
            'persons' => $person

        ]);
    }

    public function capacity(Request $request, $iduser)
    {

        $infocapa = DB::table('infowork_capacity')->where('CAPACITY_PERSON_ID', '=', $iduser)->get();

        $infouser = DB::table('hrd_person')->where('ID', '=', $iduser)->first();

        return view('manager_person.personinfoworkcapacity', [
            'infouser'  => $infouser,
            'infocapas' => $infocapa

        ]);
    }

    public function capacity_detail(Request $request, $iduser, $idref)
    {

        $infocapacity = DB::table('infowork_capacity')->where('CAPACITY_ID', '=', $idref)->first();
        $infouser     = DB::table('hrd_person')->where('ID', '=', $iduser)->first();

        return view('manager_person.personinfoworkcapacity_detail', [
            'infocapacity' => $infocapacity,
            'infouser'     => $infouser
        ]);
    }

    public function capacity_add(Request $request, $iduser)
    {
        $infouser = DB::table('hrd_person')->where('ID', '=', $iduser)->first();

        return view('manager_person.personinfoworkcapacity_add', [
            'infouser' => $infouser
        ]);
    }

    public function capacity_save(Request $request)
    {

        $CAPACITY_TESTDATE = $request->CAPACITY_TEST_DATE;

        if ($CAPACITY_TESTDATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $CAPACITY_TESTDATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st             = $date_arrary_st[1];
            $d_st             = $date_arrary_st[2];
            $CAPACITYTESTDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $CAPACITYTESTDATE = null;
        }

        $add                            = new Infoworkcapacity();
        $add->CAPACITY_PERSON_ID        = $request->CAPACITY_PERSON_ID;
        $add->CAPACITY_YEAR             = $request->CAPACITY_YEAR;
        $add->CAPACITY_HEIGHT           = $request->CAPACITY_HEIGHT;
        $add->CAPACITY_WEIGHT           = $request->CAPACITY_WEIGHT;
        $add->CAPACITY_TEST_DATE        = $CAPACITYTESTDATE;
        $add->CAPACITY_HEARTRATE_RESULT = $request->CAPACITY_HEARTRATE_RESULT;
        $add->CAPACITY_HEARTRATE_LEVEL  = $request->CAPACITY_HEARTRATE_LEVEL;
        $add->CAPACITY_HEARTRATE_AVG    = $request->CAPACITY_HEARTRATE_AVG;
        $add->CAPACITY_HEARTRATE_NOMAL  = $request->CAPACITY_HEARTRATE_NOMAL;
        $add->CAPACITY_BLOOD_RESULT     = $request->CAPACITY_BLOOD_RESULT;
        $add->CAPACITY_BLOOD_LEVEL      = $request->CAPACITY_BLOOD_LEVEL;
        $add->CAPACITY_BLOOD_AVG        = $request->CAPACITY_BLOOD_AVG;
        $add->CAPACITY_BLOOD_NOMAL      = $request->CAPACITY_BLOOD_NOMAL;
        $add->CAPACITY_BODY_RESULT      = $request->CAPACITY_BODY_RESULT;
        $add->CAPACITY_BODY_LEVEL       = $request->CAPACITY_BODY_LEVEL;
        $add->CAPACITY_BODY_AVG         = $request->CAPACITY_BODY_AVG;
        $add->CAPACITY_BODY_NOMAL       = $request->CAPACITY_BODY_NOMAL;
        $add->CAPACITY_WAISTLINE_RESULT = $request->CAPACITY_WAISTLINE_RESULT;
        $add->CAPACITY_WAISTLINE_LEVEL  = $request->CAPACITY_WAISTLINE_LEVEL;
        $add->CAPACITY_WAISTLINE_AVG    = $request->CAPACITY_WAISTLINE_AVG;
        $add->CAPACITY_WAISTLINE_NOMAL  = $request->CAPACITY_WAISTLINE_NOMAL;
        $add->CAPACITY_FAT_RESULT       = $request->CAPACITY_FAT_RESULT;
        $add->CAPACITY_FAT_LEVEL        = $request->CAPACITY_FAT_LEVEL;
        $add->CAPACITY_FAT_AVG          = $request->CAPACITY_FAT_AVG;
        $add->CAPACITY_FAT_NOMAL        = $request->CAPACITY_FAT_NOMAL;
        $add->CAPACITY_LUNG_RESULT      = $request->CAPACITY_LUNG_RESULT;
        $add->CAPACITY_LUNG_LEVEL       = $request->CAPACITY_LUNG_LEVEL;
        $add->CAPACITY_LUNG_AVG         = $request->CAPACITY_LUNG_AVG;
        $add->CAPACITY_LUNG_NOMAL       = $request->CAPACITY_LUNG_NOMAL;
        $add->CAPACITY_HAND_RESULT      = $request->CAPACITY_HAND_RESULT;
        $add->CAPACITY_HAND_LEVEL       = $request->CAPACITY_HAND_LEVEL;
        $add->CAPACITY_HAND_AVG         = $request->CAPACITY_HAND_AVG;
        $add->CAPACITY_LEG_RESULT       = $request->CAPACITY_LEG_RESULT;
        $add->CAPACITY_LEG_LEVEL        = $request->CAPACITY_LEG_LEVEL;
        $add->CAPACITY_LEG_AVG          = $request->CAPACITY_LEG_AVG;
        $add->CAPACITY_CULEDUP_RESULT   = $request->CAPACITY_CULEDUP_RESULT;
        $add->CAPACITY_CULEDUP_LEVEL    = $request->CAPACITY_CULEDUP_LEVEL;
        $add->CAPACITY_CULEDUP_AVG      = $request->CAPACITY_CULEDUP_AVG;
        $add->save();

        return redirect()->action('ManagerpersonController@capacity', [
            'iduser' => $request->CAPACITY_PERSON_ID
        ]);
    }

    public function capacity_update(Request $request)
    {

        $CAPACITY_TESTDATE = $request->CAPACITY_TEST_DATE;

        if ($CAPACITY_TESTDATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $CAPACITY_TESTDATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st             = $date_arrary_st[1];
            $d_st             = $date_arrary_st[2];
            $CAPACITYTESTDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $CAPACITYTESTDATE = null;
        }

        $id = $request->IDREF;

        $add                            = Infoworkcapacity::find($id);
        $add->CAPACITY_PERSON_ID        = $request->CAPACITY_PERSON_ID;
        $add->CAPACITY_YEAR             = $request->CAPACITY_YEAR;
        $add->CAPACITY_HEIGHT           = $request->CAPACITY_HEIGHT;
        $add->CAPACITY_WEIGHT           = $request->CAPACITY_WEIGHT;
        $add->CAPACITY_TEST_DATE        = $CAPACITYTESTDATE;
        $add->CAPACITY_HEARTRATE_RESULT = $request->CAPACITY_HEARTRATE_RESULT;
        $add->CAPACITY_HEARTRATE_LEVEL  = $request->CAPACITY_HEARTRATE_LEVEL;
        $add->CAPACITY_HEARTRATE_AVG    = $request->CAPACITY_HEARTRATE_AVG;
        $add->CAPACITY_HEARTRATE_NOMAL  = $request->CAPACITY_HEARTRATE_NOMAL;
        $add->CAPACITY_BLOOD_RESULT     = $request->CAPACITY_BLOOD_RESULT;
        $add->CAPACITY_BLOOD_LEVEL      = $request->CAPACITY_BLOOD_LEVEL;
        $add->CAPACITY_BLOOD_AVG        = $request->CAPACITY_BLOOD_AVG;
        $add->CAPACITY_BLOOD_NOMAL      = $request->CAPACITY_BLOOD_NOMAL;
        $add->CAPACITY_BODY_RESULT      = $request->CAPACITY_BODY_RESULT;
        $add->CAPACITY_BODY_LEVEL       = $request->CAPACITY_BODY_LEVEL;
        $add->CAPACITY_BODY_AVG         = $request->CAPACITY_BODY_AVG;
        $add->CAPACITY_BODY_NOMAL       = $request->CAPACITY_BODY_NOMAL;
        $add->CAPACITY_WAISTLINE_RESULT = $request->CAPACITY_WAISTLINE_RESULT;
        $add->CAPACITY_WAISTLINE_LEVEL  = $request->CAPACITY_WAISTLINE_LEVEL;
        $add->CAPACITY_WAISTLINE_AVG    = $request->CAPACITY_WAISTLINE_AVG;
        $add->CAPACITY_WAISTLINE_NOMAL  = $request->CAPACITY_WAISTLINE_NOMAL;
        $add->CAPACITY_FAT_RESULT       = $request->CAPACITY_FAT_RESULT;
        $add->CAPACITY_FAT_LEVEL        = $request->CAPACITY_FAT_LEVEL;
        $add->CAPACITY_FAT_AVG          = $request->CAPACITY_FAT_AVG;
        $add->CAPACITY_FAT_NOMAL        = $request->CAPACITY_FAT_NOMAL;
        $add->CAPACITY_LUNG_RESULT      = $request->CAPACITY_LUNG_RESULT;
        $add->CAPACITY_LUNG_LEVEL       = $request->CAPACITY_LUNG_LEVEL;
        $add->CAPACITY_LUNG_AVG         = $request->CAPACITY_LUNG_AVG;
        $add->CAPACITY_LUNG_NOMAL       = $request->CAPACITY_LUNG_NOMAL;
        $add->CAPACITY_HAND_RESULT      = $request->CAPACITY_HAND_RESULT;
        $add->CAPACITY_HAND_LEVEL       = $request->CAPACITY_HAND_LEVEL;
        $add->CAPACITY_HAND_AVG         = $request->CAPACITY_HAND_AVG;
        $add->CAPACITY_LEG_RESULT       = $request->CAPACITY_LEG_RESULT;
        $add->CAPACITY_LEG_LEVEL        = $request->CAPACITY_LEG_LEVEL;
        $add->CAPACITY_LEG_AVG          = $request->CAPACITY_LEG_AVG;
        $add->CAPACITY_CULEDUP_RESULT   = $request->CAPACITY_CULEDUP_RESULT;
        $add->CAPACITY_CULEDUP_LEVEL    = $request->CAPACITY_CULEDUP_LEVEL;
        $add->CAPACITY_CULEDUP_AVG      = $request->CAPACITY_CULEDUP_AVG;
        $add->save();

        return redirect()->action('ManagerpersonController@capacity', [
            'iduser' => $request->CAPACITY_PERSON_ID
        ]);
    }

    public function destroy_capacity($id, $iduser)
    {

        Infoworkcapacity::destroy($id);

        return redirect()->action('ManagerpersonController@capacity', [
            'iduser' => $iduser
        ]);

    }

//-----------------------------สุขภาพ--------------------
    public function healthdashboard()
    {

        $m_budget = date("m");
        if ($m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $checkinfo = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->count();

        if ($checkinfo != 0) {
            $countperson       = DB::table('hrd_person')->where('HR_STATUS_ID', '=', 1)->count();
            $countpersonscreen = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->count();

            $amontpersonnot = $countperson - $countpersonscreen;

            $countpersonscon = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->where('HEALTH_SCREEN_STATUS', '=', 'CONFIRM')->count();
            $countpersonbody = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->where('HEALTH_SCREEN_STATUS', '=', 'SUCCESS')->count();

            $personscreens = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->get();

            $result_1 = 0;
            $result_2 = 0;
            $result_3 = 0;
            $result_4 = 0;
            $result_5 = 0;
            $result_6 = 0;

            foreach ($personscreens as $personscreen) {

                $resualbmi = $personscreen->HEALTH_SCREEN_BODY;

                if ($resualbmi < 18.50) {
                    $result_1++;
                } elseif ($resualbmi >= 18.50 && $resualbmi <= 22.99) {
                    $result_2++;
                } elseif ($resualbmi > 22.99 && $resualbmi <= 24.99) {
                    $result_3++;
                } elseif ($resualbmi > 24.99 && $resualbmi <= 29.99) {
                    $result_4++;
                } elseif ($resualbmi > 29.99) {
                    $result_5++;
                } else {
                    $result_6++;
                }

            }

        } else {

            $result_1          = 0;
            $result_2          = 0;
            $result_3          = 0;
            $result_4          = 0;
            $result_5          = 0;
            $result_6          = 0;
            $countperson       = 1;
            $amontpersonnot    = 0;
            $countpersonscreen = 1;
            $countpersonscon   = 0;
            $countpersonbody   = 0;
        }

        $budget  = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $groupwork = DB::table('hrd_department_sub_sub')->get();

        $totalhealth_1 = DB::table('health_body')->where('HEALTH_BODY_RESULT', '=', 1)->count();
        $totalhealth_2 = DB::table('health_body')->where('HEALTH_BODY_RESULT', '=', 2)->count();
        $totalhealth_3 = DB::table('health_body')->where('HEALTH_BODY_RESULT', '=', 3)->count();
        $healreport = new healreport();
        $Illness_history = $healreport->count_health_screen_by_budgetyear($yearbudget);

        return view('manager_person.healthdashboard', [
            'budgets'           => $budget,
            'year_id'           => $year_id,
            'countperson'       => $countperson,
            'amontpersonnot'    => $amontpersonnot,
            'countpersonscreen' => $countpersonscreen,
            'countpersonscon'   => $countpersonscon,
            'countpersonbody'   => $countpersonbody,
            'result_1'          => $result_1,
            'result_2'          => $result_2,
            'result_3'          => $result_3,
            'result_4'          => $result_4,
            'result_5'          => $result_5,
            'result_6'          => $result_6,
            'groupworks'        => $groupwork,
            'totalhealth_1'     => $totalhealth_1,
            'totalhealth_2'     => $totalhealth_2,
            'totalhealth_3'     => $totalhealth_3,
            'Illness_history'   => $Illness_history,
        ]);
    }

    public function healthdashboard_search(Request $request)
    {
        $yearbudget = $request->LEAVE_YEAR_ID;
        $checkinfo = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->count();

        if ($checkinfo != 0) {
            $countperson       = DB::table('hrd_person')->where('HR_STATUS_ID', '=', 1)->count();
            $countpersonscreen = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->count();

            $amontpersonnot = $countperson - $countpersonscreen;

            $countpersonscon = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->where('HEALTH_SCREEN_STATUS', '=', 'CONFIRM')->count();
            $countpersonbody = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->where('HEALTH_SCREEN_STATUS', '=', 'SUCCESS')->count();

            $personscreens = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->get();

            $result_1 = 0;
            $result_2 = 0;
            $result_3 = 0;
            $result_4 = 0;
            $result_5 = 0;
            $result_6 = 0;

            foreach ($personscreens as $personscreen) {

                $resualbmi = $personscreen->HEALTH_SCREEN_BODY;

                if ($resualbmi < 18.50) {
                    $result_1++;
                } elseif ($resualbmi >= 18.50 && $resualbmi <= 22.99) {
                    $result_2++;
                } elseif ($resualbmi > 22.99 && $resualbmi <= 24.99) {
                    $result_3++;
                } elseif ($resualbmi > 24.99 && $resualbmi <= 29.99) {
                    $result_4++;
                } elseif ($resualbmi > 29.99) {
                    $result_5++;
                } else {
                    $result_6++;
                }

            }

        } else {

            $result_1          = 0;
            $result_2          = 0;
            $result_3          = 0;
            $result_4          = 0;
            $result_5          = 0;
            $result_6          = 0;
            $countperson       = 1;
            $amontpersonnot    = 0;
            $countpersonscreen = 1;
            $countpersonscon   = 0;
            $countpersonbody   = 0;
        }

        $budget  = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $groupwork = DB::table('hrd_department_sub_sub')->get();
        $totalhealth_1 = DB::table('health_body')->where('HEALTH_BODY_RESULT', '=', 1)->count();
        $totalhealth_2 = DB::table('health_body')->where('HEALTH_BODY_RESULT', '=', 2)->count();
        $totalhealth_3 = DB::table('health_body')->where('HEALTH_BODY_RESULT', '=', 3)->count();
        $healreport = new healreport();
        $Illness_history = $healreport->count_health_screen_by_budgetyear($yearbudget);

        return view('manager_person.healthdashboard', [
            'budgets'           => $budget,
            'year_id'           => $year_id,
            'countperson'       => $countperson,
            'amontpersonnot'    => $amontpersonnot,
            'countpersonscreen' => $countpersonscreen,
            'countpersonscon'   => $countpersonscon,
            'countpersonbody'   => $countpersonbody,
            'result_1'          => $result_1,
            'result_2'          => $result_2,
            'result_3'          => $result_3,
            'result_4'          => $result_4,
            'result_5'          => $result_5,
            'result_6'          => $result_6,
            'groupworks'        => $groupwork,
            'totalhealth_1'     => $totalhealth_1,
            'totalhealth_2'     => $totalhealth_2,
            'totalhealth_3'     => $totalhealth_3,
            'Illness_history'   => $Illness_history,

        ]);
    }

    public function healthdashboard_Illness_history(Request $request){
        $name_title = 'ไม่พบการค้นหา';
        if($request->disease == 1){
            $name_title = 'โรคเบาหวาน';
        }elseif($request->disease == 2){
            $name_title = 'โรคความดันโลหิตสูง';
        }elseif($request->disease == 3){
            $name_title = 'โรคตับ';
        }elseif($request->disease == 4){
            $name_title = 'โรคอัมพาต';
        }elseif($request->disease == 6){
            $name_title = 'โรคไขมันในเลือดผิดปกติ';
        }elseif($request->disease == 27){
            $name_title = 'โรคเชื้อไวรัสตับอักเสบ';
        }elseif($request->disease == 28){
            $name_title = 'โรคต่อมธัยรอยด์';
        }
        $data['name_title'] = $name_title;
        $data['select_disease'] = $request->disease;
        $data['select_budgetyear'] = $request->budgetyear;
        $healreport = new healreport();
        $data['diseases'] = $healreport->health_screen_by_budgetyear($request->budgetyear,$request->disease);
        $data['budgetyear_list'] = getBudgetYearAmount();
        $list_disease = [
            1 => "โรคเบาหวาน",
            2 => "โรคความดันโลหิตสูง",
            3 => "โรคตับ",
            4 => "โรคอัมพาต",
            6 => "โรคไขมันในเลือดผิดปกติ",
            27 => "โรคเชื้อไวรัสตับอักเสบ",
            28 => "โรคต่อมธัยรอยด์",
        ];
        $data['disease_list'] = $list_disease;
        return view('manager_person.healthdashboard_Illness_history',$data);
    }

    public function healthdashboard_physical_examination_results(Request $request){
        $data['budgetyear_list'] = getBudgetYearAmount_all();
        $data['bodyresult_list'] = [
                                    'all' => 'ทั้งหมด',
                                    1 => 'ป่วย',
                                    2 => 'เสี่ยง',
                                    3 => 'สุขภาพดี',
                                ];
        $data['select_budgetyear']      = $request->budgetyear;
        $data['select_bodyresult']      = $request->bodyresult;
        $healreport = new healreport();
        $data['health_result'] = $healreport->physical_examination_results_by_budgetyear($request->budgetyear,$request->bodyresult);
        return view('manager_person.healthdashboard_physical_examination_results',$data);
    }
    
    public function carcalendarhealth()
    {

        $daycheck = Healthscreen::leftJoin('hrd_person', 'hrd_person.ID', '=', 'health_screen.HEALTH_SCREEN_PERSON_ID')
            ->get();

        return view('manager_person.carcalendarhealth', [
            'daychecks' => $daycheck

        ]);
    }

    public function summarize_health_check_history(Request $request){
        if($request->method() === "POST"){
            $person_id = $request->person_id;
            $search = $request->search;
            $data_search = json_encode_u([
                'person_id' => $person_id,
                'search' => $search,
            ]);
            Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data_search    = json_decode(Cookie::get('data_search'));
            $person_id = $data_search->person_id;
            $search = $data_search->search;
        }else{
            $person_id = '';
            $search = '';
        }
        $screen_body = DB::table('health_screen')
            ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=',
            'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('HEALTH_SCREEN_PERSON_ID', '=', $person_id);
            $data['screen_body']    = $screen_body->where(function ($q) use ($search) {
                $q->where('HR_FNAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
            })
        ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
            ->get();
        
        $data['budgetyear_list'] = getBudgetYearAmount_all();
        $data['person_list'] = Person::all();
        $data['person_id']  = $person_id;
        return view('manager_person.summarize_health_check_history',$data);
    }

    public function inforpersonhealth(Request $request)
    {
        if($request->method() === 'POST'){
            $search     = $request->get('search');
            $status     = $request->STATUS_CODE;
            $datebigin  = $request->get('DATE_BIGIN');
            $dateend    = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            $data_search = json_encode_u([
                'search' => $search,
                'yearbudget' => $yearbudget,
                'datebigin' => $datebigin,
                'dateend' => $dateend,
                'status' => $status,
            ]);
            Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data_search    = json_decode(Cookie::get('data_search'));
            $search     = $data_search->search;
            $yearbudget     = $data_search->yearbudget;
            $datebigin     = $data_search->datebigin;
            $dateend     = $data_search->dateend;
            $status     = $data_search->status;
        }else{
            $search     = '';
            $yearbudget = getBudgetYear();
            $datebigin  = date('01/10/'.($yearbudget-1));
            $dateend    = date('30/09/'.$yearbudget);
            $status       = '';
        }
        if ($datebigin != '' && $dateend != '') {
            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary  = explode("-", $date_bigen_c);
            $y_sub_st     = $date_arrary[0];
            if ($y_sub_st >= 2500) {
                $y = $y_sub_st - 543;
            } else {
                $y = $y_sub_st;
            }
            $m                 = $date_arrary[1];
            $d                 = $date_arrary[2];
            $displaydate_bigen = $y . "-" . $m . "-" . $d;
            $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e = explode("-", $date_end_c);
            $y_sub_e = $date_arrary_e[0];
            if ($y_sub_e >= 2500) {
                $y_e = $y_sub_e - 543;
            } else {
                $y_e = $y_sub_e;
            }
            $m_e             = $date_arrary_e[1];
            $d_e             = $date_arrary_e[2];
            $displaydate_end = $y_e . "-" . $m_e . "-" . $d_e;
            $from = date($displaydate_bigen);
            $to   = date($displaydate_end);

        if ($status == null) {
            $info = DB::table('health_screen')
                ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where(function ($q) use ($search) {
                    $q->where('HR_FNAME', 'like', '%' . $search . '%');
                    $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                    $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                    $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');                    
                })
                ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                ->get();
            $amount = DB::table('health_screen')
                ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where(function ($q) use ($search) {
                    $q->where('HR_FNAME', 'like', '%' . $search . '%');
                    $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                    $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                    $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                })
                ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                ->count();
        } else {
            $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');

                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();

            $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');

                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();
            }
        } else {
            if ($status == null) {
                $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();
            $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();
        } else {
            $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();
            $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();
            }
        }

        $year_id = $yearbudget;
        $infostatus = DB::table('health_screen_status')->get();
        $budget     = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        return view('manager_person.inforpersonhealth', [
            'infos'             => $info,
            'infostatuss'       => $infostatus,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'year_id'           => $year_id,
            'amount'            => $amount,
            'budgets'           => $budget
        ]);
    }

    public function inforpersonhealth_search(Request $request)
    {

        $search     = $request->get('search');
        $status     = $request->STATUS_CODE;
        $datebigin  = $request->get('DATE_BIGIN');
        $dateend    = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if ($search == '') {
            $search = "";
        }

        if ($datebigin != '' && $dateend != '') {

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary  = explode("-", $date_bigen_c);
            $y_sub_st     = $date_arrary[0];

            if ($y_sub_st >= 2500) {
                $y = $y_sub_st - 543;
            } else {
                $y = $y_sub_st;
            }

            $m                 = $date_arrary[1];
            $d                 = $date_arrary[2];
            $displaydate_bigen = $y . "-" . $m . "-" . $d;

            $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e = explode("-", $date_end_c);

            $y_sub_e = $date_arrary_e[0];

            if ($y_sub_e >= 2500) {
                $y_e = $y_sub_e - 543;
            } else {
                $y_e = $y_sub_e;
            }
            $m_e             = $date_arrary_e[1];
            $d_e             = $date_arrary_e[2];
            $displaydate_end = $y_e . "-" . $m_e . "-" . $d_e;

            $from = date($displaydate_bigen);
            $to   = date($displaydate_end);

            if ($status == null) {

                $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');

                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();

                $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');

                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();

            } else {

                $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');

                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();

                $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');

                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();

            }

        } else {

            if ($status == null) {

                $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();

                $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();

            } else {

                $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();

                $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })

                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();

            }

        }

        $year_id = $yearbudget;

        $infostatus = DB::table('health_screen_status')->get();
        $budget     = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        return view('manager_person.inforpersonhealth', [
            'infos'             => $info,
            'infostatuss'       => $infostatus,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'year_id'           => $year_id,
            'amount'            => $amount,
            'budgets'           => $budget
        ]);
    }

    public function excelinforpersonhealth()
    {

        $m_budget = date("m");
        if ($m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $count      = Person::count();

        $info = DB::table('health_screen')
            ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)
            ->orderBy('HEALTH_SCREEN_ID', 'desc')
            ->get();

        $amount = DB::table('health_screen')
            ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->count();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget - 544) . '-10-01';
        $displaydate_end   = ($yearbudget - 543) . '-09-30';
        $search            = '';
        $year_id           = $yearbudget;

        $status     = '';
        $infostatus = DB::table('health_screen_status')->get();

        return view('manager_person.excelinforpersonhealth', [
            'infos'             => $info,
            'infostatuss'       => $infostatus,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'budgets'           => $budget,
            'amount'            => $amount,
            'year_id'           => $year_id
        ]);
    }

    public function health(Request $request, $iduser)
    {

        $budgetyear = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $infoscreen = DB::table('health_screen')->where('HEALTH_SCREEN_PERSON_ID', '=', $iduser)->orderBy('HEALTH_SCREEN_ID', 'desc')->get();

        $infoperson = DB::table('hrd_person')->where('ID', '=', $iduser)->first();

        return view('manager_person.personinfoworkhealth', [
            'budgetyears' => $budgetyear,
            'infoscreens' => $infoscreen,
            'iduser'      => $iduser,
            'infoperson'  => $infoperson

        ]);
    }

    public function mana_screen_save(Request $request)
    {

        $addinfo                          = new Healthscreen();
        $addinfo->HEALTH_SCREEN_YEAR      = $request->HEALTH_SCREEN_YEAR;
        $addinfo->HEALTH_SCREEN_PERSON_ID = $request->HEALTH_SCREEN_PERSON_ID;
        $addinfo->HEALTH_SCREEN_HEIGHT    = '';
        $addinfo->HEALTH_SCREEN_WEIGHT    = '';
        $addinfo->HEALTH_SCREEN_BODY      = '';
        $addinfo->save();

        return redirect()->route('mperson.health', ['iduser' => $request->HEALTH_SCREEN_PERSON_ID]);
    }

    public function health_add(Request $request, $idref, $iduser)
    {

        $inforef = DB::table('health_screen')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        $infoperson = DB::table('hrd_person')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('ID', '=', $inforef->HEALTH_SCREEN_PERSON_ID)->first();

        $infolab   = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->get();
        $sumamount = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->SUM('HEALTH_SCREEN_CON_SUMPICE');

        $inforbody = DB::table('health_body')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        $check = DB::table('health_body')->where('HEALTH_SCREEN_ID', '=', $idref)->count();

        return view('manager_person.personinfoworkhealth_add', [
            'idref'      => $idref,
            'inforef'    => $inforef,
            'infoperson' => $infoperson,
            'infolabs'   => $infolab,
            'sumamount'  => $sumamount,
            'inforbody'  => $inforbody,
            'check'      => $check

        ]);
    }

    public function health_save(Request $request)
    {

        $id = $request->idref;

        $addinfo                       = Healthscreen::find($id);
        $addinfo->HEALTH_SCREEN_HEIGHT = $request->HEALTH_SCREEN_HEIGHT;
        $addinfo->HEALTH_SCREEN_WEIGHT = $request->HEALTH_SCREEN_WEIGHT;
        $addinfo->HEALTH_SCREEN_BODY   = $request->HEALTH_SCREEN_BODY;

        $addinfo->HEALTH_SCREEN_FM_DIA    = $request->HEALTH_SCREEN_FM_DIA;
        $addinfo->HEALTH_SCREEN_FM_BLOOD  = $request->HEALTH_SCREEN_FM_BLOOD;
        $addinfo->HEALTH_SCREEN_FM_GOUT   = $request->HEALTH_SCREEN_FM_GOUT;
        $addinfo->HEALTH_SCREEN_FM_KIDNEY = $request->HEALTH_SCREEN_FM_KIDNEY;
        $addinfo->HEALTH_SCREEN_FM_HEART  = $request->HEALTH_SCREEN_FM_HEART;
        $addinfo->HEALTH_SCREEN_FM_BRAIN  = $request->HEALTH_SCREEN_FM_BRAIN;
        $addinfo->HEALTH_SCREEN_FM_EMPHY  = $request->HEALTH_SCREEN_FM_EMPHY;
        $addinfo->HEALTH_SCREEN_FM_UNKNOW = $request->HEALTH_SCREEN_FM_UNKNOW;
        $addinfo->HEALTH_SCREEN_FM_OTHER  = $request->HEALTH_SCREEN_FM_OTHER;

        $addinfo->HEALTH_SCREEN_BS_DIA    = $request->HEALTH_SCREEN_BS_DIA;
        $addinfo->HEALTH_SCREEN_BS_BLOOD  = $request->HEALTH_SCREEN_BS_BLOOD;
        $addinfo->HEALTH_SCREEN_BS_GOUT   = $request->HEALTH_SCREEN_BS_GOUT;
        $addinfo->HEALTH_SCREEN_BS_KIDNEY = $request->HEALTH_SCREEN_BS_KIDNEY;
        $addinfo->HEALTH_SCREEN_BS_HEART  = $request->HEALTH_SCREEN_BS_HEART;
        $addinfo->HEALTH_SCREEN_BS_BRAIN  = $request->HEALTH_SCREEN_BS_BRAIN;
        $addinfo->HEALTH_SCREEN_BS_EMPHY  = $request->HEALTH_SCREEN_BS_EMPHY;
        $addinfo->HEALTH_SCREEN_BS_UNKNOW = $request->HEALTH_SCREEN_BS_UNKNOW;
        $addinfo->HEALTH_SCREEN_BS_OTHER  = $request->HEALTH_SCREEN_BS_OTHER;

        $addinfo->HEALTH_SCREEN_H_1    = $request->HEALTH_SCREEN_H_1;
        $addinfo->HEALTH_SCREEN_H_2    = $request->HEALTH_SCREEN_H_2;
        $addinfo->HEALTH_SCREEN_H_3    = $request->HEALTH_SCREEN_H_3;
        $addinfo->HEALTH_SCREEN_H_4    = $request->HEALTH_SCREEN_H_4;
        $addinfo->HEALTH_SCREEN_H_5    = $request->HEALTH_SCREEN_H_5;
        $addinfo->HEALTH_SCREEN_H_6    = $request->HEALTH_SCREEN_H_6;
        $addinfo->HEALTH_SCREEN_H_7    = $request->HEALTH_SCREEN_H_7;
        $addinfo->HEALTH_SCREEN_H_8    = $request->HEALTH_SCREEN_H_8;
        $addinfo->HEALTH_SCREEN_H_9    = $request->HEALTH_SCREEN_H_9;
        $addinfo->HEALTH_SCREEN_H_10   = $request->HEALTH_SCREEN_H_10;
        $addinfo->HEALTH_SCREEN_H_11   = $request->HEALTH_SCREEN_H_11;
        $addinfo->HEALTH_SCREEN_H_12   = $request->HEALTH_SCREEN_H_12;
        $addinfo->HEALTH_SCREEN_H_13   = $request->HEALTH_SCREEN_H_13;
        $addinfo->HEALTH_SCREEN_H_14   = $request->HEALTH_SCREEN_H_14;
        $addinfo->HEALTH_SCREEN_H_15   = $request->HEALTH_SCREEN_H_15;
        $addinfo->HEALTH_SCREEN_H_16   = $request->HEALTH_SCREEN_H_16;
        $addinfo->HEALTH_SCREEN_H_17   = $request->HEALTH_SCREEN_H_17;
        $addinfo->HEALTH_SCREEN_H_18   = $request->HEALTH_SCREEN_H_18;
        $addinfo->HEALTH_SCREEN_H_19   = $request->HEALTH_SCREEN_H_19;
        $addinfo->HEALTH_SCREEN_H_20   = $request->HEALTH_SCREEN_H_20;
        $addinfo->HEALTH_SCREEN_H_21   = $request->HEALTH_SCREEN_H_21;
        $addinfo->HEALTH_SCREEN_H_22   = $request->HEALTH_SCREEN_H_22;
        $addinfo->HEALTH_SCREEN_H_23   = $request->HEALTH_SCREEN_H_23;
        $addinfo->HEALTH_SCREEN_H_24   = $request->HEALTH_SCREEN_H_24;
        $addinfo->HEALTH_SCREEN_H_25   = $request->HEALTH_SCREEN_H_25;
        $addinfo->HEALTH_SCREEN_H_26   = $request->HEALTH_SCREEN_H_26;
        $addinfo->HEALTH_SCREEN_H_27   = $request->HEALTH_SCREEN_H_27;
        $addinfo->HEALTH_SCREEN_H_28   = $request->HEALTH_SCREEN_H_28;
        $addinfo->HEALTH_SCREEN_H_29   = $request->HEALTH_SCREEN_H_29;
        $addinfo->HEALTH_SCREEN_H_29_COMMENT =  $request->HEALTH_SCREEN_H_29_COMMENT;
        $addinfo->HEALTH_SCREEN_H_30 =  $request->HEALTH_SCREEN_H_30;
        $addinfo->HEALTH_SCREEN_H_30_COMMENT =  $request->HEALTH_SCREEN_H_30_COMMENT;
        $addinfo->HEALTH_SCREEN_H_31 =  $request->HEALTH_SCREEN_H_31;
        $addinfo->HEALTH_SCREEN_H_31_COMMENT =  $request->HEALTH_SCREEN_H_31_COMMENT;
        $addinfo->HEALTH_SCREEN_H_HAVE = $request->HEALTH_SCREEN_H_HAVE;

        $addinfo->HEALTH_SCREEN_SMOK        = $request->HEALTH_SCREEN_SMOK;
        $addinfo->HEALTH_SCREEN_SMOK_AMOUNT = $request->HEALTH_SCREEN_SMOK_AMOUNT;
        $addinfo->HEALTH_SCREEN_SMOK_TYPE   = $request->HEALTH_SCREEN_SMOK_TYPE;
        $addinfo->HEALTH_SCREEN_SMOK_TIME   = $request->HEALTH_SCREEN_SMOK_TIME;

        $addinfo->HEALTH_SCREEN_DRINK        = $request->HEALTH_SCREEN_DRINK;
        $addinfo->HEALTH_SCREEN_DRINK_AMOUNT = $request->HEALTH_SCREEN_DRINK_AMOUNT;

        $addinfo->HEALTH_SCREEN_EXERCISE = $request->HEALTH_SCREEN_EXERCISE;
        $addinfo->HEALTH_SCREEN_FOOD_1   = $request->HEALTH_SCREEN_FOOD_1;
        $addinfo->HEALTH_SCREEN_FOOD_2   = $request->HEALTH_SCREEN_FOOD_2;
        $addinfo->HEALTH_SCREEN_FOOD_3   = $request->HEALTH_SCREEN_FOOD_3;
        $addinfo->HEALTH_SCREEN_FOOD_4   = $request->HEALTH_SCREEN_FOOD_4;
        $addinfo->HEALTH_SCREEN_FOOD_5   = $request->HEALTH_SCREEN_FOOD_5;

        $addinfo->HEALTH_SCREEN_DRIVE = $request->HEALTH_SCREEN_DRIVE;
        $addinfo->HEALTH_SCREEN_SEX   = $request->HEALTH_SCREEN_SEX;

        $addinfo->save();

        return redirect()->route('health.inforpersonhealth');
    }

    public function destroy_screen($id, $iduser)
    {

        Healthscreen::destroy($id);

        return redirect()->route('mperson.health', ['iduser' => $iduser]);
    }

    public function healthConfirm(Request $request, $idref, $iduser)
    {
        $infoscreenlab = DB::table('health_screen_lab')->get();

        $inforef = DB::table('health_screen')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        $infoperson = DB::table('hrd_person')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->where('ID', '=', $iduser)->first();

        if ($inforef->HEALTH_SCREEN_AGE < 35) {

            if ($infoperson->SEX == 'F') {
                $infoscreenlabcon = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '2')->get();
                $infosumlab       = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '2')->sum('HEALTH_SCREEN_LAB_PICE');
                $infocountlab     = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '2')->count();
            } else {
                $infoscreenlabcon = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->get();
                $infosumlab       = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->sum('HEALTH_SCREEN_LAB_PICE');
                $infocountlab     = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->count();
            }

        } else {

            if ($infoperson->SEX == 'F') {
                $infoscreenlabcon = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '2')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '3')->get();
                $infosumlab       = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '2')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '3')->sum('HEALTH_SCREEN_LAB_PICE');
                $infocountlab     = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '2')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '3')->count();
            } else {
                $infoscreenlabcon = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '3')->get();
                $infosumlab       = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '3')->sum('HEALTH_SCREEN_LAB_PICE');
                $infocountlab     = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '3')->count();
            }

        }

        return view('manager_person.personinfoworkhealthConfirm', [
            'infoscreenlabs'    => $infoscreenlab,
            'infoscreenlabcons' => $infoscreenlabcon,
            'inforef'           => $inforef,
            'infoperson'        => $infoperson,
            'infosumlab'        => $infosumlab,
            'infocountlab'      => $infocountlab
        ]);
    }

    public function healthConfirmsave(Request $request)
    {

        if ($request->HEALTH_SCREEN_LAB_ID[0] != '' || $request->HEALTH_SCREEN_LAB_ID[0] != null) {

            $HEALTH_SCREEN_ID         = $request->HEALTH_SCREEN_ID;
            $HEALTH_SCREEN_LAB_ID     = $request->HEALTH_SCREEN_LAB_ID;
            $HEALTH_SCREEN_CON_AMOUNT = $request->HEALTH_SCREEN_CON_AMOUNT;

            $number = count($HEALTH_SCREEN_LAB_ID);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addinfo                       = new Healthscreenconfirm();
                $addinfo->HEALTH_SCREEN_ID     = $request->HEALTH_SCREEN_ID[$count];
                $addinfo->HEALTH_SCREEN_LAB_ID = $request->HEALTH_SCREEN_LAB_ID[$count];

                $infolab = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_ID', '=', $request->HEALTH_SCREEN_LAB_ID[$count])->first();

                $addinfo->HEALTH_SCREEN_CON_CODE    = $infolab->HEALTH_SCREEN_LAB_CODE;
                $addinfo->HEALTH_SCREEN_CON_NAME    = $infolab->HEALTH_SCREEN_LAB_NAME;
                $addinfo->HEALTH_SCREEN_CON_PICE    = $infolab->HEALTH_SCREEN_LAB_PICE;
                $addinfo->HEALTH_SCREEN_CON_AMOUNT  = $request->HEALTH_SCREEN_CON_AMOUNT[$count];
                $addinfo->HEALTH_SCREEN_CON_SUMPICE = $request->HEALTH_SCREEN_CON_AMOUNT[$count] * $infolab->HEALTH_SCREEN_LAB_PICE;
                $addinfo->save();

            }
        }

        $CHECK_DATE = $request->HEALTH_SCREEN_CON_DATE;

        if ($CHECK_DATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $CHECK_DATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st      = $date_arrary_st[1];
            $d_st      = $date_arrary_st[2];
            $CHECKDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $CHECKDATE = null;
        }

        $id                                  = $request->HEALTH_SCREEN_ID_UP;
        $upstatus                            = Healthscreen::find($id);
        $upstatus->HEALTH_SCREEN_CON_DATE    = $CHECKDATE;
        $upstatus->HEALTH_SCREEN_CON_TIME    = $request->HEALTH_SCREEN_CON_TIME;
        $upstatus->HEALTH_SCREEN_CON_COMMENT = $request->HEALTH_SCREEN_CON_COMMENT;
        $upstatus->HEALTH_SCREEN_STATUS      = 'CONFIRM';
        $upstatus->save();

        $inforeport     = $request->inforeport;
        $inforeportname = DB::table('hrd_person')->where('ID', '=', $inforeport)->first();

        $infouser = DB::table('health_screen')->where('HEALTH_SCREEN_ID', '=', $id)->first();

        function DateThai($strDate)
        {
            $strYear  = date("Y", strtotime($strDate)) + 543;
            $strMonth = date("n", strtotime($strDate));
            $strDay   = date("j", strtotime($strDate));

            $strMonthCut  = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
            $strMonthThai = $strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear";
        }

        $header  = "แจ้งนัดตรวจสุขภาพ";
        $message = $header .
        "\n" . "วันที่นัด : " . DateThai($CHECKDATE) .
        "\n" . "เวลา : " . $request->HEALTH_SCREEN_CON_TIME .
        "\n" . "ผู้แจ้ง : " . $inforeportname->HR_FNAME . '' . $inforeportname->HR_LNAME;

        $name = DB::table('hrd_person')->where('ID', '=', $infouser->HEALTH_SCREEN_PERSON_ID)->first();
        $test = $name->HR_LINE;

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, $message);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$message");
        curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $test . '');
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);
        if (curl_error($chOne)) {echo 'error:' . curl_error($chOne);} else { $result_ = json_decode($result, true);
            echo "status : " . $result_['status'];
            echo "message : " . $result_['message'];}
        curl_close($chOne);

        return redirect()->route('health.inforpersonhealth');
    }

    public function healthConfirm_edit(Request $request, $idref, $iduser)
    {
        $infoscreenlab = DB::table('health_screen_lab')->get();

        $inforef = DB::table('health_screen')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        $infoperson = DB::table('hrd_person')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->where('ID', '=', $iduser)->first();

        $infoscreenlabcon = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->get();
        $infosumlab       = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->sum('HEALTH_SCREEN_CON_SUMPICE');

        return view('manager_person.personinfoworkhealthConfirm_edit', [
            'infoscreenlabs'    => $infoscreenlab,
            'infoscreenlabcons' => $infoscreenlabcon,
            'inforef'           => $inforef,
            'infoperson'        => $infoperson,
            'infosumlab'        => $infosumlab

        ]);
    }

    public function healthConfirmupdate(Request $request)
    {
        $id = $request->HEALTH_SCREEN_ID_UP;

        Healthscreenconfirm::where('HEALTH_SCREEN_ID', '=', $id)->delete();

        if ($request->HEALTH_SCREEN_LAB_ID[0] != '' || $request->HEALTH_SCREEN_LAB_ID[0] != null) {

            $HEALTH_SCREEN_LAB_ID     = $request->HEALTH_SCREEN_LAB_ID;
            $HEALTH_SCREEN_CON_AMOUNT = $request->HEALTH_SCREEN_CON_AMOUNT;

            $number = count($HEALTH_SCREEN_LAB_ID);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addinfo                       = new Healthscreenconfirm();
                $addinfo->HEALTH_SCREEN_ID     = $id;
                $addinfo->HEALTH_SCREEN_LAB_ID = $request->HEALTH_SCREEN_LAB_ID[$count];

                $infolab = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_ID', '=', $request->HEALTH_SCREEN_LAB_ID[$count])->first();

                $addinfo->HEALTH_SCREEN_CON_CODE    = $infolab->HEALTH_SCREEN_LAB_CODE;
                $addinfo->HEALTH_SCREEN_CON_NAME    = $infolab->HEALTH_SCREEN_LAB_NAME;
                $addinfo->HEALTH_SCREEN_CON_PICE    = $infolab->HEALTH_SCREEN_LAB_PICE;
                $addinfo->HEALTH_SCREEN_CON_AMOUNT  = $request->HEALTH_SCREEN_CON_AMOUNT[$count];
                $addinfo->HEALTH_SCREEN_CON_SUMPICE = $request->HEALTH_SCREEN_CON_AMOUNT[$count] * $infolab->HEALTH_SCREEN_LAB_PICE;
                $addinfo->save();

            }
        }

        $CHECK_DATE = $request->HEALTH_SCREEN_CON_DATE;

        if ($CHECK_DATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $CHECK_DATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st      = $date_arrary_st[1];
            $d_st      = $date_arrary_st[2];
            $CHECKDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $CHECKDATE = null;
        }

        $upstatus                            = Healthscreen::find($id);
        $upstatus->HEALTH_SCREEN_CON_DATE    = $CHECKDATE;
        $upstatus->HEALTH_SCREEN_CON_TIME    = $request->HEALTH_SCREEN_CON_TIME;
        $upstatus->HEALTH_SCREEN_CON_COMMENT = $request->HEALTH_SCREEN_CON_COMMENT;
        $upstatus->save();

        return redirect()->route('health.inforpersonhealth');
    }

    public function reportinforpersonhealth()
    {

        return view('manager_person.reportinforpersonhealth');
    }

    public function healthBody(Request $request, $idref, $iduser)
    {

        $infosumlab = DB::table('health_screen_lab')->sum('HEALTH_SCREEN_LAB_PICE');

        $inforef = DB::table('health_screen')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        $infolab   = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->get();
        $sumamount = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->SUM('HEALTH_SCREEN_CON_SUMPICE');

        $infoperson = DB::table('hrd_person')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->where('ID', '=', $iduser)->first();

        return view('manager_person.personinfoworkhealthBody', [
            'infolabs'   => $infolab,
            'inforef'    => $inforef,
            'infoperson' => $infoperson,
            'infosumlab' => $infosumlab,
            'sumamount'  => $sumamount
        ]);

    }

    public function healthbodysave(Request $request)
    {

        $addinfo                      = new Healthbody();
        $addinfo->HEALTH_SCREEN_ID    = $request->HEALTH_SCREEN_ID;
        $addinfo->HEALTH_BODY_DATE    = date('Y-m-d');
        $addinfo->HEALTH_BODY_BLOOD11 = $request->HEALTH_BODY_BLOOD11;
        $addinfo->HEALTH_BODY_BLOOD12 = $request->HEALTH_BODY_BLOOD12;
        $addinfo->HEALTH_BODY_BLOOD21 = $request->HEALTH_BODY_BLOOD21;
        $addinfo->HEALTH_BODY_BLOOD22 = $request->HEALTH_BODY_BLOOD22;

        $addinfo->HEALTH_BODY_BLOOD_LOWER = number_format(($request->HEALTH_BODY_BLOOD11 + $request->HEALTH_BODY_BLOOD21) / 2);
        $addinfo->HEALTH_BODY_BLOOD_TOP   = number_format(($request->HEALTH_BODY_BLOOD12 + $request->HEALTH_BODY_BLOOD22) / 2);

        $addinfo->HEALTH_BODY_WAISTLINE  = $request->HEALTH_BODY_WAISTLINE;
        $addinfo->HEALTH_BODY_BEWAN      = $request->HEALTH_BODY_BEWAN;
        $addinfo->HEALTH_BODY_SUGAR      = $request->HEALTH_BODY_SUGAR;
        $addinfo->HEALTH_BODY_MG         = $request->HEALTH_BODY_MG;
        $addinfo->HEALTH_BODY_COMMENT    = $request->HEALTH_BODY_COMMENT;
        $addinfo->HEALTH_BODY_RISK       = $request->HEALTH_BODY_RISK;
        $addinfo->HEALTH_BODY_RISKDETAIL = $request->HEALTH_BODY_RISKDETAIL;
        $addinfo->HEALTH_BODY_ADVICE     = $request->HEALTH_BODY_ADVICE;
        $addinfo->HEALTH_BODY_SEND       = $request->HEALTH_BODY_SEND;
        $addinfo->HEALTH_BODY_GENARAL_GA            = $request->HEALTH_BODY_GENARAL_GA;
        $addinfo->HEALTH_BODY_GENARAL_GA_COMMENT    = $request->HEALTH_BODY_GENARAL_GA_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_HEENT         = $request->HEALTH_BODY_GENARAL_HEENT;
        $addinfo->HEALTH_BODY_GENARAL_HEENT_COMMENT = $request->HEALTH_BODY_GENARAL_HEENT_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_HEART         = $request->HEALTH_BODY_GENARAL_HEART;
        $addinfo->HEALTH_BODY_GENARAL_HEART_COMMENT = $request->HEALTH_BODY_GENARAL_HEART_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_LUNG          = $request->HEALTH_BODY_GENARAL_LUNG;
        $addinfo->HEALTH_BODY_GENARAL_LUNG_COMMENT  = $request->HEALTH_BODY_GENARAL_LUNG_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_ABD           = $request->HEALTH_BODY_GENARAL_ABD;
        $addinfo->HEALTH_BODY_GENARAL_ABD_COMMENT   = $request->HEALTH_BODY_GENARAL_ABD_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_EXT           = $request->HEALTH_BODY_GENARAL_EXT;
        $addinfo->HEALTH_BODY_GENARAL_EXT_COMMENT   = $request->HEALTH_BODY_GENARAL_EXT_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_NEURO         = $request->HEALTH_BODY_GENARAL_NEURO;
        $addinfo->HEALTH_BODY_GENARAL_NEURO_COMMENT = $request->HEALTH_BODY_GENARAL_NEURO_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_BREAST        = $request->HEALTH_BODY_GENARAL_BREAST;
        $addinfo->HEALTH_BODY_GENARAL_BREAST_COMMENT    = $request->HEALTH_BODY_GENARAL_BREAST_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_OTHER         = $request->HEALTH_BODY_GENARAL_OTHER;
        $addinfo->HEALTH_BODY_GENARAL_OTHER_COMMENT = $request->HEALTH_BODY_GENARAL_OTHER_COMMENT;
        $addinfo->HEALTH_BODY_HAVE_RISK             = $request->HEALTH_BODY_HAVE_RISK?1:0;
        $addinfo->HEALTH_BODY_CARE_PLAN             = $request->HEALTH_BODY_CARE_PLAN;
        $addinfo->HEALTH_BODY_RESULT                = $request->HEALTH_BODY_RESULT;
        $addinfo->save();

        $id = $request->HEALTH_SCREEN_ID;

        $upstatus                       = Healthscreen::find($id);
        $upstatus->HEALTH_BODY_DATE     = date('Y-m-d');
        $upstatus->HEALTH_SCREEN_STATUS = 'SUCCESS';
        $upstatus->save();

        return redirect()->route('health.inforpersonhealth');
    }

    public function healthBody_edit(Request $request, $idref, $iduser)
    {

        $infosumlab = DB::table('health_screen_lab')->sum('HEALTH_SCREEN_LAB_PICE');

        $inforef = DB::table('health_screen')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        $infolab   = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->get();
        $sumamount = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->SUM('HEALTH_SCREEN_CON_SUMPICE');

        $infoperson = DB::table('hrd_person')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->where('ID', '=', $iduser)->first();

        $inforbody = DB::table('health_body')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        return view('manager_person.personinfoworkhealthBody_edit', [
            'inforef'    => $inforef,
            'sumamount'  => $sumamount,
            'infolabs'   => $infolab,
            'infoperson' => $infoperson,
            'infosumlab' => $infosumlab,
            'inforbody'  => $inforbody
        ]);

    }

    public function healthbodyupdate(Request $request)
    {

        $id = $request->HEALTH_BODY_ID;

        $addinfo = Healthbody::find($id);

        $addinfo->HEALTH_BODY_DATE    = date('Y-m-d');
        $addinfo->HEALTH_BODY_BLOOD11 = $request->HEALTH_BODY_BLOOD11;
        $addinfo->HEALTH_BODY_BLOOD12 = $request->HEALTH_BODY_BLOOD12;
        $addinfo->HEALTH_BODY_BLOOD21 = $request->HEALTH_BODY_BLOOD21;
        $addinfo->HEALTH_BODY_BLOOD22 = $request->HEALTH_BODY_BLOOD22;

        $addinfo->HEALTH_BODY_BLOOD_LOWER = number_format(($request->HEALTH_BODY_BLOOD11 + $request->HEALTH_BODY_BLOOD21) / 2);
        $addinfo->HEALTH_BODY_BLOOD_TOP   = number_format(($request->HEALTH_BODY_BLOOD12 + $request->HEALTH_BODY_BLOOD22) / 2);

        $addinfo->HEALTH_BODY_WAISTLINE  = $request->HEALTH_BODY_WAISTLINE;
        $addinfo->HEALTH_BODY_BEWAN      = $request->HEALTH_BODY_BEWAN;
        $addinfo->HEALTH_BODY_SUGAR      = $request->HEALTH_BODY_SUGAR;
        $addinfo->HEALTH_BODY_MG         = $request->HEALTH_BODY_MG;
        $addinfo->HEALTH_BODY_COMMENT    = $request->HEALTH_BODY_COMMENT;
        $addinfo->HEALTH_BODY_RISK       = $request->HEALTH_BODY_RISK;
        $addinfo->HEALTH_BODY_RISKDETAIL = $request->HEALTH_BODY_RISKDETAIL;
        $addinfo->HEALTH_BODY_ADVICE     = $request->HEALTH_BODY_ADVICE;
        $addinfo->HEALTH_BODY_SEND       = $request->HEALTH_BODY_SEND;
        $addinfo->HEALTH_BODY_GENARAL_GA            = $request->HEALTH_BODY_GENARAL_GA;
        $addinfo->HEALTH_BODY_GENARAL_GA_COMMENT    = $request->HEALTH_BODY_GENARAL_GA_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_HEENT         = $request->HEALTH_BODY_GENARAL_HEENT;
        $addinfo->HEALTH_BODY_GENARAL_HEENT_COMMENT = $request->HEALTH_BODY_GENARAL_HEENT_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_HEART         = $request->HEALTH_BODY_GENARAL_HEART;
        $addinfo->HEALTH_BODY_GENARAL_HEART_COMMENT = $request->HEALTH_BODY_GENARAL_HEART_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_LUNG          = $request->HEALTH_BODY_GENARAL_LUNG;
        $addinfo->HEALTH_BODY_GENARAL_LUNG_COMMENT  = $request->HEALTH_BODY_GENARAL_LUNG_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_ABD           = $request->HEALTH_BODY_GENARAL_ABD;
        $addinfo->HEALTH_BODY_GENARAL_ABD_COMMENT   = $request->HEALTH_BODY_GENARAL_ABD_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_EXT           = $request->HEALTH_BODY_GENARAL_EXT;
        $addinfo->HEALTH_BODY_GENARAL_EXT_COMMENT   = $request->HEALTH_BODY_GENARAL_EXT_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_NEURO         = $request->HEALTH_BODY_GENARAL_NEURO;
        $addinfo->HEALTH_BODY_GENARAL_NEURO_COMMENT = $request->HEALTH_BODY_GENARAL_NEURO_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_BREAST        = $request->HEALTH_BODY_GENARAL_BREAST;
        $addinfo->HEALTH_BODY_GENARAL_BREAST_COMMENT    = $request->HEALTH_BODY_GENARAL_BREAST_COMMENT;
        $addinfo->HEALTH_BODY_GENARAL_OTHER         = $request->HEALTH_BODY_GENARAL_OTHER;
        $addinfo->HEALTH_BODY_GENARAL_OTHER_COMMENT = $request->HEALTH_BODY_GENARAL_OTHER_COMMENT;
        $addinfo->HEALTH_BODY_HAVE_RISK             = $request->HEALTH_BODY_HAVE_RISK;
        $addinfo->HEALTH_BODY_CARE_PLAN             = $request->HEALTH_BODY_CARE_PLAN;
        $addinfo->HEALTH_BODY_RESULT     = $request->HEALTH_BODY_RESULT;
        $addinfo->save();

        return redirect()->route('health.inforpersonhealth');
    }

    public function health_destroy($idref, $iduser)
    {
        Healthscreen::destroy($idref);

        return redirect()->route('health.inforpersonhealth');

    }

    public function inforperson_meetinginside(Request $request)
    {
        if(!empty($request->get('DATE_BIGIN'))){
            $yearbudget = $request->get('BUDGET_YEAR');
            $displaydate_bigen = datepickerTodate($request->DATE_BIGIN);
            $displaydate_end   = datepickerTodate($request->DATE_END);
            $status            = $request->STATUS_CODE;
            $search            = $request->search;
            session([
                'manager_person.inforperson_meetinginside.yearbudget' => $yearbudget,
                'manager_person.inforperson_meetinginside.displaydate_bigen' => $displaydate_bigen,
                'manager_person.inforperson_meetinginside.displaydate_end' => $displaydate_end,
                'manager_person.inforperson_meetinginside.status' => $status,
                'manager_person.inforperson_meetinginside.search' => $search,
                ]);
        }elseif(!empty(session('manager_person.inforperson_meetinginside'))){
            $yearbudget = session('manager_person.inforperson_meetinginside.yearbudget');
            $displaydate_bigen = session('manager_person.inforperson_meetinginside.displaydate_bigen');
            $displaydate_end = session('manager_person.inforperson_meetinginside.displaydate_end');
            $status = session('manager_person.inforperson_meetinginside.status');
            $search = session('manager_person.inforperson_meetinginside.search');
        }else{
            $yearbudget = getBudgetYear();
            $displaydate_bigen = date('Y-m-1');
            $displaydate_end   = date('Y-m-d', strtotime(date('Y-m-1'). '+1month -1days'));
            $status            = '';
            $search            = '';
        }
            $datebigin_year = Carbon::createFromFormat('Y-m-d', $displaydate_bigen)->format('Y');
            if($datebigin_year >= 2500){
                $datebigin_month = Carbon::createFromFormat('Y-m-d', $displaydate_bigen)->format('-m-d');
                $displaydate_bigen = ($datebigin_year-543).$datebigin_month;
            }
            $dateend_year = Carbon::createFromFormat('Y-m-d', $displaydate_end)->format('Y');
            if($dateend_year >= 2500){
                $dateend_month = Carbon::createFromFormat('Y-m-d', $displaydate_end)->format('-m-d');
                $displaydate_end = ($dateend_year-543).$dateend_month;
            }
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $meettingstatus = DB::table('grecord_status')->get();
        $room = DB::table('meetingroom_index')->get();
        $infostatus = DB::table('health_screen_status')->get();
        $user1 = DB::table('meetting_inside_usersub')->count();
        $q = DB::table('meetting_inside_index')
            ->leftJoin('hrd_person', 'meetting_inside_index.MEETING_INSIDE_PRESIDENT', '=', 'hrd_person.ID')
            ->leftJoin('meetting_inside_type', 'meetting_inside_index.MEETING_INSIDE_TYPE', '=', 'meetting_inside_type.MEETTINGSIDE_ID')
            ->leftjoin('grecord_org_location', 'meetting_inside_index.MEETING_INSIDE_LOCATION', '=', 'grecord_org_location.LOCATION_ID')
            ->leftjoin('meetingroom_index', 'meetting_inside_index.ROOM_ID', '=', 'meetingroom_index.ROOM_ID')
            ->leftjoin('grecord_status', 'meetting_inside_index.MEETING_STATUS', '=', 'grecord_status.STATUS')
            ->whereBetween('meetting_inside_index.MEETING_INSIDE_DATE',[$displaydate_bigen,$displaydate_end]);
            if($status != '' || $status !== null){
                $q->where('MEETING_STATUS',$status);
            }
            if($search != '' || $search !== null){
                $q->where(function ($q) use ($search){
                    $q->where('meetting_inside_index.MEETING_INSIDE_TITLE','like','%'.$search.'%')
                    ->orwhere('meetting_inside_type.MEETTINGSIDE_NAME','like','%'.$search.'%')
                    ->orwhere('meetting_inside_index.MEETING_INSIDE_DATE','like','%'.$search.'%')
                    ->orwhere('meetingroom_index.ROOM_NAME','like','%'.$search.'%')
                    ->orwhere('meetting_inside_index.MEETING_INSIDE_STARTTIME','like','%'.$search.'%')
                    ->orwhere('meetting_inside_index.MEETING_INSIDE_ENDTIME','like','%'.$search.'%');
                });
            }
            $meetinginside = $q->get();
     
        return view('manager_person.inforperson_meetinginside', [
            'infostatuss'       => $infostatus,
            'rooms'             => $room,
            'meetinginsides'    => $meetinginside,
            'status_check'      => $status,
            'search'            => $search,
            'budgets'           => $budget,
            'year_id'           => $yearbudget,
            'meettingstatuss'   => $meettingstatus,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'user1'             => $user1
        ]);
    }

   

    public function inforperson_meetinginside_add(Request $request)
    {

        $meetting_inside_type = DB::table('meetting_inside_type')->get();

        $infopresident = DB::table('hrd_person')->get();

        $m_budget = date("m");
        if ($m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $budget            = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget - 544) . '-10-01';
        $displaydate_end   = ($yearbudget - 543) . '-09-30';
        $status            = '';
        $search            = '';
        $year_id           = $yearbudget;

        $meetting_inside_type = DB::table('meetting_inside_type')->get();
        $location             = DB::table('grecord_org_location')->get();

        $infopresident = DB::table('hrd_person')->get();
        $room          = DB::table('meetingroom_index')->get();

        return view('manager_person.inforperson_meetinginside_add', [

            'meetting_inside_types' => $meetting_inside_type,
            'infopresidents'        => $infopresident,
            'rooms'                 => $room,
            'locations'             => $location,
            'meetting_inside_types' => $meetting_inside_type,
            'infopresidents'        => $infopresident,
             'displaydate_bigen'     => $displaydate_bigen,
            'displaydate_end'       => $displaydate_end,
            'status_check'          => $status,
            'search'                => $search,
            'budgets'               => $budget,
            'year_id'               => $year_id
        ]);
    }

    public function inforperson_meetinginside_save(Request $request)
    {
    
        $iduser = $request->iduser;
     
        $ic_date = $request->MEETING_INSIDE_DATE;
    
        if($ic_date != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $ic_date)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $icontrol_date= $y_st."-".$m_st."-".$d_st;
        }else{
        $icontrol_date= null;
        }
    
        $usersave = Person::where('ID','=',$iduser)->first();
    
        $add = new Meetting_inside_index(); 
        $add->MEETING_INSIDE_CODE = $request->MEETING_INSIDE_CODE;
        $add->MEETING_INSIDE_NO = $request->MEETING_INSIDE_NO;
        $add->MEETING_INSIDE_BUDGET = $request->MEETING_INSIDE_BUDGET;
        $add->ROOM_ID = $request->ROOM_ID;
        $add->MEETING_INSIDE_DATE = $icontrol_date;
        $add->MEETING_INSIDE_STARTTIME = $request->MEETING_INSIDE_STARTTIME;
        $add->MEETING_INSIDE_ENDTIME = $request->MEETING_INSIDE_ENDTIME;
        $add->MEETING_INSIDE_TITLE = $request->MEETING_INSIDE_TITLE;
        $add->MEETING_INSIDE_PRESIDENT = $request->MEETING_INSIDE_PRESIDENT;
        $add->MEETING_INSIDE_TYPE = $request->MEETING_INSIDE_TYPE;
        $add->MEETING_INSIDE_LOCATION = $request->MEETING_INSIDE_LOCATION;
        $add->MEETING_INSIDE_USERSAVE = $usersave->ID;
        $add->MEETING_INSIDE_USERSAVE_NAME = $usersave->HR_FNAME.' ' .$usersave->HR_LNAME;
        $add->MEETING_STATUS = 'APPLY';
                            
        $maxid = Meetting_inside_index::max('MEETING_INSIDE_ID');    
        $idfile = $maxid+1;
    
        if($request->hasFile('pdfupload')){
            $newFileName = 'meetinside_'.$idfile.'.'.$request->pdfupload->extension();          
            $request->pdfupload->storeAs('meettinginsidepdf',$newFileName,'public');     
            $add->MEETING_INSIDE_FILE = $newFileName;        
        }
       
        $add->save();
    
        if($request->MEETING_INSIDE_USER != '' || $request->MEETING_INSIDE_USER != null)
        {        
            $MEETING_INSIDE_USER = $request->MEETING_INSIDE_USER;                         
            $number =count($MEETING_INSIDE_USER);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $usersub = Person::where('ID','=',$MEETING_INSIDE_USER[$count])->first();
    
                        $add_usersub = new Meetting_inside_usersub();    
                        $add_usersub->MEETING_INSIDE_ID = $idfile;   
                        $add_usersub->MEETING_INSIDE_USERSUB_IDNAME = $usersub->ID; 
                        $add_usersub->MEETING_INSIDE_USERSUB_FNAME = $usersub->HR_FNAME; 
                        $add_usersub->MEETING_INSIDE_USERSUB_LNAME = $usersub->HR_LNAME;
                        $add_usersub->save(); 
                    }
        } 
    
        if($request->MEETING_INSIDE_USEROUT != '' || $request->MEETING_INSIDE_USEROUT != null)
        {        
            $MEETING_INSIDE_USEROUT = $request->MEETING_INSIDE_USEROUT;                         
            $number =count($MEETING_INSIDE_USEROUT);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $add_useroutsub = new Meetting_inside_useroutsub();    
                        $add_useroutsub->MEETING_INSIDE_ID = $idfile;   
                        $add_useroutsub->MEETING_INSIDE_USEROUT_NAME = $MEETING_INSIDE_USEROUT[$count];   
                        $add_useroutsub->save(); 
                    }
        } 
        
        if($request->MEETING_INSIDE_PERFORMANCE != '' || $request->MEETING_INSIDE_PERFORMANCE != null)
        {        
            $MEETING_INSIDE_PERFORMANCE = $request->MEETING_INSIDE_PERFORMANCE;                         
            $number =count($MEETING_INSIDE_PERFORMANCE);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $add_performancesub = new Meetting_inside_performancesub();    
                        $add_performancesub->MEETING_INSIDE_ID = $idfile;   
                        $add_performancesub->MEETING_INSIDE_PERFORMANCE_NAME = $MEETING_INSIDE_PERFORMANCE[$count];   
                        $add_performancesub->save(); 
                    }
        }
    
        if($request->MEETING_INSIDE_PROFESSION != '' || $request->MEETING_INSIDE_PROFESSION != null)
        {        
            $MEETING_INSIDE_PROFESSION = $request->MEETING_INSIDE_PROFESSION;                         
            $number =count($MEETING_INSIDE_PROFESSION);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $add_performancesub = new Meetting_inside_professionsub();    
                        $add_performancesub->MEETING_INSIDE_ID = $idfile;   
                        $add_performancesub->MEETING_INSIDE_PROFESSION_NAME = $MEETING_INSIDE_PROFESSION[$count];   
                        $add_performancesub->save(); 
                    }
        }
    
        return redirect()->route('mperson.inforperson_meetinginside');
    }


    public function inforperson_meetinginside_edit(Request $request,$id)
    {

        $meetting_inside_type = DB::table('meetting_inside_type')->get();

        $infopresident = DB::table('hrd_person')->get();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $meetting_inside_type = DB::table('meetting_inside_type')->get();
        $location             = DB::table('grecord_org_location')->get();    
        $room          = DB::table('meetingroom_index')->get();
        $infopresident =  DB::table('hrd_person')->get();

        $meetinginside = DB::table('meetting_inside_index')
        ->leftJoin('hrd_person','meetting_inside_index.MEETING_INSIDE_PRESIDENT','=','hrd_person.ID')
        ->leftJoin('meetting_inside_type','meetting_inside_index.MEETING_INSIDE_TYPE','=','meetting_inside_type.MEETTINGSIDE_ID')
        ->leftjoin('grecord_status','meetting_inside_index.MEETING_STATUS','=','grecord_status.STATUS')
        ->where('meetting_inside_index.MEETING_INSIDE_ID','=',$id)->first();


        $inside_usersub =  DB::table('meetting_inside_usersub') ->where('meetting_inside_usersub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_useroutsub =  DB::table('meetting_inside_useroutsub') ->where('meetting_inside_useroutsub.MEETING_INSIDE_ID','=',$id)->get();


        $inside_performance =  DB::table('meetting_inside_performancesub') ->where('meetting_inside_performancesub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_professionsub =  DB::table('meetting_inside_professionsub') ->where('meetting_inside_professionsub.MEETING_INSIDE_ID','=',$id)->get();



        return view('manager_person.inforperson_meetinginside_edit', [
            'inside_usersubs' =>  $inside_usersub,
            'inside_useroutsubs' =>  $inside_useroutsub,
            'meetinginsides' =>  $meetinginside,
            'inside_performances' =>  $inside_performance,
            'inside_professionsubs' =>  $inside_professionsub,
            'rooms'                 => $room,
            'locations'             => $location,
            'meetting_inside_types' => $meetting_inside_type,
            'infopresidents'        => $infopresident,
             'displaydate_bigen'     => $displaydate_bigen,
            'displaydate_end'       => $displaydate_end,
            'status_check'          => $status,
            'search'                => $search,
            'budgets'               => $budget,
            'year_id'               => $year_id
        ]);
    }


    public function inforperson_meetinginside_update(Request $request)
    {
        $iduser = $request->iduser;
        $id = $request->MEETING_INSIDE_ID;
     
        $ic_date = $request->MEETING_INSIDE_DATE;
    
        if($ic_date != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $ic_date)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $icontrol_date= $y_st."-".$m_st."-".$d_st;
        }else{
        $icontrol_date= null;
        }
    
     
        $usersave = Person::where('ID','=',$iduser)->first();
    
        
        $update = Meetting_inside_index::find($id); 
        $update->MEETING_INSIDE_CODE = $request->MEETING_INSIDE_CODE;
        $update->MEETING_INSIDE_NO = $request->MEETING_INSIDE_NO;
        $update->MEETING_INSIDE_BUDGET = $request->MEETING_INSIDE_BUDGET;
        $update->MEETING_INSIDE_DATE = $icontrol_date;
        $update->MEETING_INSIDE_STARTTIME = $request->MEETING_INSIDE_STARTTIME;
        $update->MEETING_INSIDE_ENDTIME = $request->MEETING_INSIDE_ENDTIME;
        $update->MEETING_INSIDE_TITLE = $request->MEETING_INSIDE_TITLE;
        $update->MEETING_INSIDE_PRESIDENT = $request->MEETING_INSIDE_PRESIDENT;
        $update->MEETING_INSIDE_TYPE = $request->MEETING_INSIDE_TYPE;
        $update->MEETING_INSIDE_LOCATION = $request->MEETING_INSIDE_LOCATION;
        $update->ROOM_ID = $request->ROOM_ID;
        $update->MEETING_INSIDE_USERSAVE = $usersave->ID;
        $update->MEETING_INSIDE_USERSAVE_NAME = $usersave->HR_FNAME.' ' .$usersave->HR_LNAME;
        $update->MEETING_STATUS = 'APPLY';
    
    
        if($request->hasFile('pdfupload')){
            $newFileName = 'meetinside_'.$id.'.'.$request->pdfupload->extension();          
            $request->pdfupload->storeAs('meettinginsidepdf',$newFileName,'public');     
            $update->MEETING_INSIDE_FILE = $newFileName;        
        }        
        $update->save();                     
       
        Meetting_inside_usersub::where('MEETING_INSIDE_ID','=',$id)->delete();
    
        if($request->MEETING_INSIDE_USER != '' || $request->MEETING_INSIDE_USER != null)
        {        
            $MEETING_INSIDE_USER = $request->MEETING_INSIDE_USER;                         
            $number =count($MEETING_INSIDE_USER);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $usersub = Person::where('ID','=',$MEETING_INSIDE_USER[$count])->first();
    
                        $update_usersub = new Meetting_inside_usersub();    
                        $update_usersub->MEETING_INSIDE_ID = $id;   
                        $update_usersub->MEETING_INSIDE_USERSUB_IDNAME = $usersub->ID; 
                        $update_usersub->MEETING_INSIDE_USERSUB_FNAME = $usersub->HR_FNAME; 
                        $update_usersub->MEETING_INSIDE_USERSUB_LNAME = $usersub->HR_LNAME;
                        $update_usersub->save(); 
                    }
        } 
    
        Meetting_inside_useroutsub::where('MEETING_INSIDE_ID','=',$id)->delete();
    
        if($request->MEETING_INSIDE_USEROUT != '' || $request->MEETING_INSIDE_USEROUT != null)
        {        
            $MEETING_INSIDE_USEROUT = $request->MEETING_INSIDE_USEROUT;                         
            $number =count($MEETING_INSIDE_USEROUT);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $update_useroutsub = new Meetting_inside_useroutsub();    
                        $update_useroutsub->MEETING_INSIDE_ID = $id;   
                        $update_useroutsub->MEETING_INSIDE_USEROUT_NAME = $MEETING_INSIDE_USEROUT[$count];   
                        $update_useroutsub->save(); 
                    }
        } 
    
        Meetting_inside_performancesub::where('MEETING_INSIDE_ID','=',$id)->delete();
        
        if($request->MEETING_INSIDE_PERFORMANCE != '' || $request->MEETING_INSIDE_PERFORMANCE != null)
        {        
            $MEETING_INSIDE_PERFORMANCE = $request->MEETING_INSIDE_PERFORMANCE;                         
            $number =count($MEETING_INSIDE_PERFORMANCE);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $update_performancesub = new Meetting_inside_performancesub();    
                        $update_performancesub->MEETING_INSIDE_ID = $id;   
                        $update_performancesub->MEETING_INSIDE_PERFORMANCE_NAME = $MEETING_INSIDE_PERFORMANCE[$count];   
                        $update_performancesub->save(); 
                    }
        }
    
        Meetting_inside_professionsub::where('MEETING_INSIDE_ID','=',$id)->delete();
    
        if($request->MEETING_INSIDE_PROFESSION != '' || $request->MEETING_INSIDE_PROFESSION != null)
        {        
            $MEETING_INSIDE_PROFESSION = $request->MEETING_INSIDE_PROFESSION;                         
            $number =count($MEETING_INSIDE_PROFESSION);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $update_performancesub = new Meetting_inside_professionsub();    
                        $update_performancesub->MEETING_INSIDE_ID = $id;   
                        $update_performancesub->MEETING_INSIDE_PROFESSION_NAME = $MEETING_INSIDE_PROFESSION[$count];   
                        $update_performancesub->save(); 
                    }
        }
    
        return redirect()->route('mperson.inforperson_meetinginside');
    }


    public function inforperson_meetinginside_cancel(Request $request,$id)
    {

        $meetting_inside_type = DB::table('meetting_inside_type')->get();

        $infopresident = DB::table('hrd_person')->get();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $meetting_inside_type = DB::table('meetting_inside_type')->get();
        $location             = DB::table('grecord_org_location')->get();    
        $room          = DB::table('meetingroom_index')->get();
        $infopresident =  DB::table('hrd_person')->get();

        $meetinginside = DB::table('meetting_inside_index')
        ->leftJoin('hrd_person','meetting_inside_index.MEETING_INSIDE_PRESIDENT','=','hrd_person.ID')
        ->leftJoin('meetting_inside_type','meetting_inside_index.MEETING_INSIDE_TYPE','=','meetting_inside_type.MEETTINGSIDE_ID')
        ->leftjoin('grecord_status','meetting_inside_index.MEETING_STATUS','=','grecord_status.STATUS')
        ->leftjoin('meetingroom_index','meetting_inside_index.ROOM_ID','=','meetingroom_index.ROOM_ID')
        ->where('meetting_inside_index.MEETING_INSIDE_ID','=',$id)->first();


        $inside_usersub =  DB::table('meetting_inside_usersub') ->where('meetting_inside_usersub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_useroutsub =  DB::table('meetting_inside_useroutsub') ->where('meetting_inside_useroutsub.MEETING_INSIDE_ID','=',$id)->get();


        $inside_performance =  DB::table('meetting_inside_performancesub') ->where('meetting_inside_performancesub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_professionsub =  DB::table('meetting_inside_professionsub') ->where('meetting_inside_professionsub.MEETING_INSIDE_ID','=',$id)->get();



        return view('manager_person.inforperson_meetinginside_cancel', [
            'inside_usersubs' =>  $inside_usersub,
            'inside_useroutsubs' =>  $inside_useroutsub,
            'meetinginsides' =>  $meetinginside,
            'inside_performances' =>  $inside_performance,
            'inside_professionsubs' =>  $inside_professionsub,
            'rooms'                 => $room,
            'locations'             => $location,
            'meetting_inside_types' => $meetting_inside_type,
            'infopresidents'        => $infopresident,
             'displaydate_bigen'     => $displaydate_bigen,
            'displaydate_end'       => $displaydate_end,
            'status_check'          => $status,
            'search'                => $search,
            'budgets'               => $budget,
            'year_id'               => $year_id
        ]);
    }


    public function inforperson_meetinginside_updatecancel(Request $request)
    {
 
    $id = $request->MEETING_INSIDE_ID; 

      $updatecancel = Meetting_inside_index::find($id);
      $updatecancel->MEETING_STATUS = 'CANCEL'; 
      $updatecancel->MEETING_INSIDE_COMMENT = $request->MEETING_INSIDE_COMMENT;
      $updatecancel->save();
               
      return redirect()->route('mperson.inforperson_meetinginside');

}













    public function setinforperson_meetinginside_save(Request $request)
    {
        $add                    = new Meetting_inside_type();
        $add->MEETTINGSIDE_NAME = $request->MEETTINGSIDE_NAME;
        $add->save();

        return redirect()->route('setmperson.setinforperson_meetinginside');
    }

   

 //======================ฟังชัน====================//

 public function checkuserin(Request $request)
 {
     $idin   = $request->MEETING_INSIDE_ID;
     $userin = DB::table('meetting_inside_usersub')->wherewhere('MEETING_INSIDE_ID', '=', $idin)->first();
     echo $userin->MEETING_INSIDE_ID;

 }

 public function setinforperson_meetinginside(Request $request)
 {
     $search     = $request->get('search');
     $status     = $request->STATUS_CODE;
     $datebigin  = $request->get('DATE_BIGIN');
     $dateend    = $request->get('DATE_END');
     $yearbudget = $request->BUDGET_YEAR;

     if ($datebigin != '' && $dateend != '') {
         $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
         $date_arrary  = explode("-", $date_bigen_c);
         $y_sub_st     = $date_arrary[0];

         if ($y_sub_st >= 2500) {
             $y = $y_sub_st - 543;
         } else {
             $y = $y_sub_st;
         }

         $m                 = $date_arrary[1];
         $d                 = $date_arrary[2];
         $displaydate_bigen = $y . "-" . $m . "-" . $d;

         $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
         $date_arrary_e = explode("-", $date_end_c);

         $y_sub_e = $date_arrary_e[0];

         if ($y_sub_e >= 2500) {
             $y_e = $y_sub_e - 543;
         } else {
             $y_e = $y_sub_e;
         }
         $m_e             = $date_arrary_e[1];
         $d_e             = $date_arrary_e[2];
         $displaydate_end = $y_e . "-" . $m_e . "-" . $d_e;

         $from = date($displaydate_bigen);
         $to   = date($displaydate_end);
     }

     $year_id = $yearbudget;

     $infostatus      = DB::table('health_screen_status')->get();
     $meetting_inside = DB::table('meetting_inside_type')->get();

     return view('manager_person.setinforperson_meetinginside', [
         'infostatuss'      => $infostatus,
          'status_check'     => $status,
         'search'           => $search,
         'year_id'          => $year_id,
         'meetting_insides' => $meetting_inside
     ]);
 }




    public function avgbloodlower(Request $request)
    {

        $HEALTH_BODY_BLOOD11 = $request->HEALTH_BODY_BLOOD11;
        $HEALTH_BODY_BLOOD21 = $request->HEALTH_BODY_BLOOD21;

        $result = number_format(($HEALTH_BODY_BLOOD11 + $HEALTH_BODY_BLOOD21) / 2);

        return $result;
    }

    public function avgbloodtop(Request $request)
    {

        $HEALTH_BODY_BLOOD12 = $request->HEALTH_BODY_BLOOD12;
        $HEALTH_BODY_BLOOD22 = $request->HEALTH_BODY_BLOOD22;

        $result = number_format(($HEALTH_BODY_BLOOD12 + $HEALTH_BODY_BLOOD22) / 2);

        return $result;
    }

//=================================================

    public function checkcode(Request $request)
    {

        $HEALTH_SCREEN_LAB_ID = $request->HEALTH_SCREEN_LAB_ID;
        $result               = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_ID', '=', $HEALTH_SCREEN_LAB_ID)->first();

        return $result->HEALTH_SCREEN_LAB_CODE;
    }

    public function checkpice(Request $request)
    {

        $HEALTH_SCREEN_LAB_ID = $request->HEALTH_SCREEN_LAB_ID;
        $number               = $request->number;
        $result               = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_ID', '=', $HEALTH_SCREEN_LAB_ID)->first();

        $outpuet = '<input type="text" name="HEALTH_SCREEN_CON_PICE[]" id="HEALTH_SCREEN_CON_PICE' . $number . '" value="' . number_format($result->HEALTH_SCREEN_LAB_PICE, 2) . '" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;font-size: 13px;" onkeyup="checksummoney(' . $number . ');">';

        return $outpuet;
    }

    public function checksummoney(Request $request)
    {

        $SUP_TOTAL      = $request->get('SUP_TOTAL');
        $PRICE_PER_UNIT = $request->get('PRICE_PER_UNIT');

        $output = number_format(($SUP_TOTAL * $PRICE_PER_UNIT), 2);
        $resule = $output . '<input type="hidden" name="sum" id="sum" value="' . ($SUP_TOTAL * $PRICE_PER_UNIT) . '">';

        return $resule;

    }

    public function persondevreport(Request $request)
    {
        if(!empty($request->DATE_BIGIN) ){
            $datebigin = datepickerTodate($request->DATE_BIGIN);
            $dateend = datepickerTodate($request->DATE_END);
            $ID_PERSON = $request->ID_PERSON;
            $search    = $request->search;
            session([
                'manager_person.persondevreport.DATE_BIGIN'=> $datebigin,
                'manager_person.persondevreport.DATE_END'=> $dateend,
                'manager_person.persondevreport.ID_PERSON'=> $ID_PERSON,
                'manager_person.persondevreport.search'=> $search
                ]);
        }elseif(!empty(session('manager_person.persondevreport'))){
            $datebigin = session('manager_person.persondevreport.DATE_BIGIN');
            $dateend = session('manager_person.persondevreport.DATE_END');
            $ID_PERSON = session('manager_person.persondevreport.ID_PERSON');
            $search = session('manager_person.persondevreport.search');
        }else{
            $datebigin = date('Y-m-1');
            $dateend   = date('Y-m-d', strtotime(date('Y-m-1'). '+1month -1days'));
            $ID_PERSON = '';
            $search = '';
        }

            $datebigin_year = Carbon::createFromFormat('Y-m-d', $datebigin)->format('Y');
            if($datebigin_year >= 2500){
                $datebigin_month = Carbon::createFromFormat('Y-m-d', $datebigin)->format('-m-d');
                $datebigin = ($datebigin_year-543).$datebigin_month;
            }
            $dateend_year = Carbon::createFromFormat('Y-m-d', $dateend)->format('Y');
            if($dateend_year >= 2500){
                $dateend_month = Carbon::createFromFormat('Y-m-d', $dateend)->format('-m-d');
                $dateend = ($dateend_year-543).$dateend_month;
            }

            $from =  $datebigin;
            $to = $dateend;
            if ($ID_PERSON != '') {
                $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
                    , 'RECORD_LEVEL_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
                    , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK')
                    ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
                    ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
                    ->leftJoin('grecord_index_person', 'grecord_index.ID', '=', 'grecord_index_person.RECORD_ID')
                    ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
                    ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
                    ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
                    ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
                    ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
                    ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
                    ->WhereBetween('DATE_GO', [$from, $to])
                    ->where('grecord_index_person.HR_PERSON_ID', '=', $ID_PERSON)
                    ->where(function ($q) use ($search) {
                        $q->where('STATUS_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_TYPE_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_HEAD_USE', 'like', '%' . $search . '%');
                        $q->orwhere('LOCATION_ORG_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('USER_POST_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('grecord_index.ID', 'desc')
                    ->get();
            } else {
                $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
                    , 'RECORD_LEVEL_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
                    , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK', 'RECORD_USER_ID', 'POSITION_IN_WORK')
                    ->leftJoin('hrd_person', 'grecord_index.RECORD_USER_ID', '=', 'hrd_person.ID')
                    ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
                    ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
                    ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
                    ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
                    ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
                    ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
                    ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
                    ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
                    ->WhereBetween('DATE_GO', [$from, $to])
                    ->where(function ($q) use ($search) {
                        $q->where('STATUS_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_TYPE_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_HEAD_USE', 'like', '%' . $search . '%');
                        $q->orwhere('LOCATION_ORG_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('USER_POST_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('grecord_index.ID', 'desc')
                    ->get();

            }

        $grecordstatus = DB::table('grecord_status')->get();

        $m_budget = date("m");
        if ($m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $budget            = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id      = $yearbudget;
        $person_check = $ID_PERSON;
        $status       = '';
        $infoperson   = DB::table('hrd_person')
            ->where('HR_STATUS_ID', '<>', 5)
            ->where('HR_STATUS_ID', '<>', 6)
            ->where('HR_STATUS_ID', '<>', 7)
            ->where('HR_STATUS_ID', '<>', 8)
            ->get();

            $openform_function = Persondev_function::where('PERSONDEV_STATUS','=','True' )->first();         

            if ($openform_function != '') {            
                $code = $openform_function->PERSONDEV_CODE;     

            } else {                      
                $code = '';
            }

        return view('manager_person.persondevreport', [
            'inforrecordindexs' => $inforrecordindex,
            'grecordstatuss'    => $grecordstatus,
            'displaydate_bigen' => $datebigin,
            'displaydate_end'   => $dateend,
            'status_check'      => $status,
            'search'            => $search,
            'budgets'           => $budget,
            'year_id'           => $year_id,
            'infopersons'       => $infoperson,
            'person_check'      => $person_check,
            'codes'             => $code,
        ]);
    }

    public function persondevreport_search(Request $request)
    {
        $datebigin = $request->get('DATE_BIGIN');
        $dateend   = $request->get('DATE_END');
        $ID_PERSON = $request->get('ID_PERSON');
        $search    = $request->get('search');

        if ($datebigin != '' && $dateend != '') {
            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary  = explode("-", $date_bigen_c);
            $y_sub_st     = $date_arrary[0];

            if ($y_sub_st >= 2500) {
                $y = $y_sub_st - 543;
            } else {
                $y = $y_sub_st;
            }

            $m                 = $date_arrary[1];
            $d                 = $date_arrary[2];
            $displaydate_bigen = $y . "-" . $m . "-" . $d;

            $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e = explode("-", $date_end_c);

            $y_sub_e = $date_arrary_e[0];

            if ($y_sub_e >= 2500) {
                $y_e = $y_sub_e - 543;
            } else {
                $y_e = $y_sub_e;
            }
            $m_e             = $date_arrary_e[1];
            $d_e             = $date_arrary_e[2];
            $displaydate_end = $y_e . "-" . $m_e . "-" . $d_e;

            $from = date($displaydate_bigen);
            $to   = date($displaydate_end);
            if ($ID_PERSON != '') {

                $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
                    , 'RECORD_LEVEL_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
                    , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK')
                    ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
                    ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
                    ->leftJoin('grecord_index_person', 'grecord_index.ID', '=', 'grecord_index_person.RECORD_ID')
                    ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
                    ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
                    ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
                    ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
                    ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
                    ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
                    ->WhereBetween('DATE_GO', [$from, $to])
                    ->where('grecord_index_person.HR_PERSON_ID', '=', $ID_PERSON)
                    ->where(function ($q) use ($search) {
                        $q->where('STATUS_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_TYPE_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_HEAD_USE', 'like', '%' . $search . '%');
                        $q->orwhere('LOCATION_ORG_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('USER_POST_NAME', 'like', '%' . $search . '%');

                    })
                    ->orderBy('grecord_index.ID', 'desc')
                    ->get();
            } else {

                $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
                    , 'RECORD_LEVEL_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
                    , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK', 'RECORD_USER_ID', 'POSITION_IN_WORK')
                    ->leftJoin('hrd_person', 'grecord_index.RECORD_USER_ID', '=', 'hrd_person.ID')
                    ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
                    ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
                    ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
                    ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
                    ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
                    ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
                    ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
                    ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
                    ->WhereBetween('DATE_GO', [$from, $to])
                    ->where(function ($q) use ($search) {
                        $q->where('STATUS_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_TYPE_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_HEAD_USE', 'like', '%' . $search . '%');
                        $q->orwhere('LOCATION_ORG_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('USER_POST_NAME', 'like', '%' . $search . '%');

                    })
                    ->orderBy('grecord_index.ID', 'desc')
                    ->get();

            }

        }

        $grecordstatus = DB::table('grecord_status')->get();

        $m_budget = date("m");
        if ($m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $budget            = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id      = $yearbudget;
        $person_check = $ID_PERSON;
        $status       = '';
        $infoperson   = DB::table('hrd_person')
            ->where('HR_STATUS_ID', '<>', 5)
            ->where('HR_STATUS_ID', '<>', 6)
            ->where('HR_STATUS_ID', '<>', 7)
            ->where('HR_STATUS_ID', '<>', 8)
            ->get();

        return view('manager_person.persondevreport', [
            'inforrecordindexs' => $inforrecordindex,
            'grecordstatuss'    => $grecordstatus,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'budgets'           => $budget,
            'year_id'           => $year_id,
            'infopersons'       => $infoperson,
            'person_check'      => $person_check
        ]);
    }

    public function persondevreport_excel(Request $request, $datebegin, $dateen, $idperson, $search)
    {
        $from = $datebegin;
        $to   = $dateen;
        if ($search == 'null') {
            $search = '';
        }

        if ($idperson != 'null') {

            $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
                , 'RECORD_LEVEL_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
                , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK')
                ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
                ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
                ->leftJoin('grecord_index_person', 'grecord_index.ID', '=', 'grecord_index_person.RECORD_ID')
                ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
                ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
                ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
                ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
                ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
                ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
                ->WhereBetween('DATE_GO', [$from, $to])
                ->where('grecord_index_person.HR_PERSON_ID', '=', $idperson)
                ->where(function ($q) use ($search) {
                    $q->where('STATUS_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('RECORD_TYPE_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('RECORD_HEAD_USE', 'like', '%' . $search . '%');
                    $q->orwhere('LOCATION_ORG_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('USER_POST_NAME', 'like', '%' . $search . '%');

                })
                ->orderBy('grecord_index.ID', 'desc')
                ->get();
        } else {

            $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
                , 'RECORD_LEVEL_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
                , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK', 'RECORD_USER_ID', 'POSITION_IN_WORK')
                ->leftJoin('hrd_person', 'grecord_index.RECORD_USER_ID', '=', 'hrd_person.ID')
                ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
                ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
                ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
                ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
                ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
                ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
                ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
                ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
                ->WhereBetween('DATE_GO', [$from, $to])
                ->where(function ($q) use ($search) {
                    $q->where('STATUS_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('RECORD_TYPE_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('RECORD_HEAD_USE', 'like', '%' . $search . '%');
                    $q->orwhere('LOCATION_ORG_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('USER_POST_NAME', 'like', '%' . $search . '%');

                })
                ->orderBy('grecord_index.ID', 'desc')
                ->get();

        }

        return view('manager_person.persondevreport_excel', [
            'inforrecordindexs' => $inforrecordindex
        ]);
    }

    public static function grouppersundev($RECORD_ID)
    {
        $query = DB::table('grecord_index_person')->where('RECORD_ID', '=', $RECORD_ID)->get();

        $num = 1;
        foreach ($query as $row) {
            if ($num == 1) {
                $output = $row->HR_FULLNAME . "|";
            } else {
                $output .= $row->HR_FULLNAME . "|";
            }

            $num++;
        }

        return $output;
    }

    public function personmeettinginside(Request $request)
    {

        $mo = date('Y-m');

        $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
            , 'RECORD_LEVEL_NAME', 'RECORD_ORG_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
            , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK', 'RECORD_USER_ID', 'POSITION_IN_WORK')
            ->leftJoin('grecord_org', 'grecord_org.RECORD_ORG_ID', '=', 'grecord_index.RECORD_ORG_ID')
            ->leftJoin('hrd_person', 'grecord_index.RECORD_USER_ID', '=', 'hrd_person.ID')
            ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
            ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
            ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
            ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
            ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
            ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
            ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
            ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
            ->where('DATE_GO', 'like', $mo . '%')
            ->orderBy('grecord_index.ID', 'desc')
            ->get();

        $grecordstatus = DB::table('grecord_status')->get();

        $m_budget = date("m");
        if ($m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $budget            = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = $mo . '-01';

        $M = date('m');

        if ($M == 2) {
            if (date("Y") % 4 == 0) {
                $displaydate_end = $mo . '-29';
            } else {
                $displaydate_end = $mo . '-28';
            }

        } elseif ($M == 1 || $M == 3 || $M == 5 || $M == 7 || $M == 8 || $M == 10 || $M == 12) {
            $displaydate_end = $mo . '-31';
        } else {
            $displaydate_end = $mo . '-30';
        }

        $infoperson = DB::table('hrd_person')
            ->where('HR_STATUS_ID', '<>', 5)
            ->where('HR_STATUS_ID', '<>', 6)
            ->where('HR_STATUS_ID', '<>', 7)
            ->where('HR_STATUS_ID', '<>', 8)
            ->get();

        $status       = '';
        $search       = '';
        $person_check = '';
        $year_id      = $yearbudget;

        return view('manager_person.personmeettinginside', [
            'inforrecordindexs' => $inforrecordindex,
            'grecordstatuss'    => $grecordstatus,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'budgets'           => $budget,
            'year_id'           => $year_id,
            'infopersons'       => $infoperson,
            'person_check'      => $person_check
        ]);
    }

    public static function contperson($iddep)
    {

        $total = DB::table('meetting_inside_usersub')->where('MEETING_INSIDE_ID', '=', $iddep)->count();

        return $total;
    }

    //ข้อมูลการทำงาน
    public function jobdescriptions_personnel(Request $request){
        if($request->method() === "POST"){
            $budgetyear = $request->budgetyear;
            $job_descript = $request->job_descript;
            $person_id = $request->person_id;
            $data_search = json_encode_u([
                'budgetyear' => $budgetyear,
                'job_descript' => $job_descript,
                'person_id' => $person_id,
            ]);
            Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
        }else if(!empty(Cookie::get('data_search'))){
            $data = json_decode(Cookie::get('data_search'));
            $budgetyear = $data->budgetyear;
            $job_descript = $data->job_descript;
            $person_id = $data->person_id;
        }else{
            $budgetyear = 'all';
            $job_descript = 'all';
            $person_id = 'all';
        }

        $list_person_work = Infowork_job_person::getJobPersonByYearPersonJob($budgetyear,$job_descript,$person_id);
        $list_person_work_status = Infowork_job_person_status::all();
        $dropbudgetyear = getBudgetYearAmount();
        $dropjob_descript   = Infowork_job_descriptions::where('IWJD_ACTIVE',true)->get();
        $dropperson     = person::getPersonWork();
        return view('manager_person.jobdescriptions_personnel_view',compact(
            'dropbudgetyear',
            'dropjob_descript',
            'dropperson',
            'list_person_work',
            'budgetyear',
            'job_descript',
            'person_id',
            'list_person_work_status'
        ));
    }

    public function jobdescriptions_personnel_save(Request $request){
        $list_notadd = array(); //เก็บข้อมูลไอดีบุคคลที่พบรายชื่อแล้ว
        $job = Infowork_job_descriptions::find($request->job_descript);
        if(empty($job)){
            Session::flash('err','เกิดข้อผิดพลาด');
            Session::flash('err_msg','ไม่พบข้อมูล Job Descriptions');
            if(!empty($request->from_page) && $request->from_page == 'setup_infowork_job_descriptions'){
                return redirect(route('mperson.setinfo_jobd'));
            }else {
                return redirect(route('mperson.jobdescriptions_personnel'));
            } 
        }


        foreach ($request->person_id as $key => $person_id) {
            $query = Infowork_job_person::where('PERSON_ID', $person_id)
                                    ->where('IWJOB_D_ID', $request->job_descript)
                                    ->where('IWJP_BUDGETYEAR', $request->budgetyear)
                                    ->first();
            if(empty($query)){
                $Infowork_job_person = new Infowork_job_person();
                $Infowork_job_person->IWJOB_D_ID                = $request->job_descript;
                $Infowork_job_person->IWJOB_EXPECTED_RESULT     = $job->IWJD_EXPECTED_RESULT;
                $Infowork_job_person->PERSON_ID         = $person_id;
                $Infowork_job_person->IWJP_BUDGETYEAR   = $request->budgetyear;
                $Infowork_job_person->IWJOB_PERSON_STATUS_ID   = 1;
                $Infowork_job_person->IWJP_CREATED_ID   = Auth()->user()->PERSON_ID;
                $Infowork_job_person->save();
                $iwjd_set = Infowork_job_descriptions_set::select('infowork_kpi.*')
                ->leftJoin('infowork_kpi','infowork_kpi.IWKPI_ID','infowork_job_descriptions_set.IWKPI_ID')
                ->where('IWJOB_D_ID',$request->job_descript)
                ->get();
                foreach ($iwjd_set as $row) {
                    $Infowork_job_person_list = new Infowork_job_person_list();
                    $Infowork_job_person_list->IWJOB_PERSON_ID  = $Infowork_job_person->IWJOB_PERSON_ID;
                    $Infowork_job_person_list->IWKPI_ID         = $row->IWKPI_ID;
                    $Infowork_job_person_list->IWJPL_NUMBER_1   = $row->IWKPI_NUMBER_1;
                    $Infowork_job_person_list->IWJPL_NUMBER_2   = $row->IWKPI_NUMBER_2;
                    $Infowork_job_person_list->IWJPL_NUMBER_3   = $row->IWKPI_NUMBER_3;
                    $Infowork_job_person_list->IWJPL_NUMBER_4   = $row->IWKPI_NUMBER_4;
                    $Infowork_job_person_list->IWJPL_NUMBER_5   = $row->IWKPI_NUMBER_5;
                    $Infowork_job_person_list->IWJPL_SCORE_A    = $row->IWKPI_SCORE_A;
                    $Infowork_job_person_list->IWJPL_WEIGHT_B       = $row->IWKPI_WEIGHT_B;
                    $Infowork_job_person_list->IWJPL_MULTIPLY_AB    = $row->IWKPI_MULTIPLY_AB;
                    $Infowork_job_person_list->IWJPL_TARGET         = $row->IWKPI_TARGET;
                    $Infowork_job_person_list->IWJPL_TYPE_CALCULATE = $row->IWKPI_TYPE_CALCULATE;
                    $Infowork_job_person_list->save();
                }
            }else{
                $list_notadd[] = $person_id;
            }
        }
        if(!empty($list_notadd)){
            $listnodadd = Person::where(function ($q) use ($list_notadd){
                        foreach ($list_notadd as $key => $value) {
                            $q->orWhere('ID',$value);
                        }
                    })->get();
            Session::flash('scc_notify','เพิ่มข้อมูลสำเร็จบางรายการ');
            Session::flash('listnodadd',$listnodadd);
        }else{
            Session::flash('scc_notify','เพิ่มข้อมูลสำเร็จ');
        }
        if(!empty($request->from_page) && $request->from_page == 'setup_infowork_job_descriptions'){
            return redirect(route('mperson.setinfo_jobd'));
        }else {
            return redirect(route('mperson.jobdescriptions_personnel'));
        }
    }

    public static function count_job_of_person($budgetyear ,$job_id){
        $count = Infowork_job_person::where('IWJP_BUDGETYEAR',$budgetyear)->where('IWJOB_D_ID',$job_id)->count();
        return $count;
    }
    public function jobdescriptions_personnel_delete($id){
        $iwj_person = Infowork_job_person::find($id);
        if(empty($iwj_person)){
            Session::flash('err','เกิดข้อผิดพลาด');
            Session::flash('err_msg','ไม่พบข้อมูล');
            return redirect(route('mperson.jobdescriptions_personnel'));
        }
        // ตรวจสอบข้อมูลรมีการบันทึกประเมินแล้วหรือไม่
        if(!empty($iwj_person->IWJP_ASSESSOR_ID_1) || !empty($iwj_person->IWJP_ASSESSOR_ID_2) || $iwj_person->IWJOB_PERSON_STATUS_ID != 1){
            Session::flash('err','ไม่สามารถลบข้อมูลได้');
            Session::flash('err_msg','ข้อมูลถูกนำไปใช้แล้ว หรือได้รับการประเมินแล้ว');
            return redirect(route('mperson.jobdescriptions_personnel'));
        }
        // ตรวจสอบข้อมูลรายการมีการบันทึกข้อมูลรายเดือนแล้วหรือไม่
        $iwj_person_list = Infowork_job_person_list::where('IWJOB_PERSON_ID',$id)->get();
        foreach ($iwj_person_list as $row) {
            if( !empty($row->IWJPL_PERFORMANCE_10) ||
                !empty($row->IWJPL_PERFORMANCE_11) ||
                !empty($row->IWJPL_PERFORMANCE_12) ||
                !empty($row->IWJPL_PERFORMANCE_1) ||
                !empty($row->IWJPL_PERFORMANCE_2) ||
                !empty($row->IWJPL_PERFORMANCE_3) ||
                !empty($row->IWJPL_PERFORMANCE_4) ||
                !empty($row->IWJPL_PERFORMANCE_5) ||
                !empty($row->IWJPL_PERFORMANCE_6) ||
                !empty($row->IWJPL_PERFORMANCE_7) ||
                !empty($row->IWJPL_PERFORMANCE_8) ||
                !empty($row->IWJPL_PERFORMANCE_9) )
            {
                Session::flash('err','ไม่สามารถลบข้อมูลได้');
                Session::flash('err_msg','ข้อมูลถูกกำหนดผลงานรายเดือนแล้ว');
                return redirect(route('mperson.jobdescriptions_personnel'));
            }
        }
        Infowork_job_person::destroy($id);
        Infowork_job_person_list::where('IWJOB_PERSON_ID',$id)->delete();
        Session::flash('scc','ลบข้อมูลสำเร็จ');
        return redirect(route('mperson.jobdescriptions_personnel'));
    }

    public function jobdescriptions_personnel_edit($id){
        $job_person_list    = Infowork_job_person::getJobPersonByJobid($id);
        return view('manager_person.jobdescriptions_personnel_edit',compact('job_person_list'));
    }

    public function jobdescriptions_personnel_update(Request $request){
        $job_person_list    = Infowork_job_person::find($request->id);
        $list_id = $request->list_id;
        $number1 = $request->number1;
        $number2 = $request->number2;
        $number3 = $request->number3;
        $number4 = $request->number4;
        $number5 = $request->number5;
        $weight  = $request->weight;
        $target  = $request->target;
        $performance_10  = $request->performance_10;
        $performance_11  = $request->performance_11;
        $performance_12  = $request->performance_12;
        $performance_1  = $request->performance_1;
        $performance_2  = $request->performance_2;
        $performance_3  = $request->performance_3;
        $performance_4  = $request->performance_4;
        $performance_5  = $request->performance_5;
        $performance_6  = $request->performance_6;
        $performance_7  = $request->performance_7;
        $performance_8  = $request->performance_8;
        $performance_9  = $request->performance_9;
        
        $check6mont = true;
        $check12mont = true;
        if($job_person_list->IWJOB_PERSON_STATUS_ID == 2 || $job_person_list->IWJOB_PERSON_STATUS_ID == 3){
            $check6mont = false;
        }
        if($job_person_list->IWJOB_PERSON_STATUS_ID == 3){
            $check12mont = false;
        }
        foreach ($list_id as $key => $value) {
            $info_person_list = Infowork_job_person_list::find($value);
            $info_person_list->IWJPL_NUMBER_1 = $number1[$key];
            $info_person_list->IWJPL_NUMBER_2 = $number2[$key];
            $info_person_list->IWJPL_NUMBER_3 = $number3[$key];
            $info_person_list->IWJPL_NUMBER_4 = empty($number4[$key])?0:$number4[$key];
            $info_person_list->IWJPL_NUMBER_5 = empty($number5[$key])?0:$number5[$key];
            $score = 0;
            while (true) {
                    if(empty($number1[$key])){
                        break;
                    }else{
                        $score = 1;
                    }
                    if(empty($number2[$key])){
                        break;
                    }else{
                        $score = 2;
                    }
                    if(empty($number3[$key])){
                        break;
                    }else{
                        $score = 3;
                    }
                    if(empty($number4[$key])){
                        break;
                    }else{
                        $score = 4;
                    }
                    if(empty($number5[$key])){
                        break;
                    }else{
                        $score = 5;
                    }
                    break;
            }
            $info_person_list->IWJPL_SCORE_A        = $score;
            $info_person_list->IWJPL_WEIGHT_B       = $weight[$key];
            $info_person_list->IWJPL_MULTIPLY_AB    = $score * $weight[$key];
            $info_person_list->IWJPL_TARGET         = $target[$key];
            if($check6mont){
                $info_person_list->IWJPL_PERFORMANCE_10 = $performance_10[$key];
                $info_person_list->IWJPL_PERFORMANCE_11 = $performance_11[$key];
                $info_person_list->IWJPL_PERFORMANCE_12 = $performance_12[$key];
                $info_person_list->IWJPL_PERFORMANCE_1  = $performance_1[$key];
                $info_person_list->IWJPL_PERFORMANCE_2  = $performance_2[$key];
                $info_person_list->IWJPL_PERFORMANCE_3  = $performance_3[$key];
            }
            if($check12mont){
                $info_person_list->IWJPL_PERFORMANCE_4  = $performance_4[$key];
                $info_person_list->IWJPL_PERFORMANCE_5  = $performance_5[$key];
                $info_person_list->IWJPL_PERFORMANCE_6  = $performance_6[$key];
                $info_person_list->IWJPL_PERFORMANCE_7  = $performance_7[$key];
                $info_person_list->IWJPL_PERFORMANCE_8  = $performance_8[$key];
                $info_person_list->IWJPL_PERFORMANCE_9  = $performance_9[$key];
            }
            $info_person_list->save();
        }

        Session::flash('scc_notify',"อัพเดตข้อมูลสำเร็จ");
        return redirect(route('mperson.jobdescriptions_personnel_edit',$request->id));
    }

    public function jobdescriptions_personnel_estimate6($id){
        $job_person_list    = Infowork_job_person::getJobPersonByJobid($id);
        return view('manager_person.jobdescriptions_personnel_estimate6',compact('job_person_list'));
    }

    public function jobdescriptions_personnel_estimate6_update(Request $request){
        $job_person    = Infowork_job_person::find($request->id);
        if($job_person->IWJOB_PERSON_STATUS_ID == 2 || $job_person->IWJOB_PERSON_STATUS_ID == 3){
            Session::flash('err','ไม่สามารถประเมินรายการซ้ำได้');
            Session::flash('err_msg','รายการนี้ประเมิน 6 เดือนแรกแล้ว');
            return redirect(route('mperson.jobdescriptions_personnel'));
        }
        
        $list_id = $request->list_id;
        $weight  = $request->weight;
        $target  = $request->target;
        $performance_10  = $request->performance_10;
        $performance_11  = $request->performance_11;
        $performance_12  = $request->performance_12;
        $performance_1  = $request->performance_1;
        $performance_2  = $request->performance_2;
        $performance_3  = $request->performance_3;
        $num = 0;
        foreach ($list_id as $key => $value) {
            $info_person_list = Infowork_job_person_list::find($value);
            $info_person_list->IWJPL_NUMBER_1 = $request->number1[$key];
            $info_person_list->IWJPL_NUMBER_2 = $request->number2[$key];
            $info_person_list->IWJPL_NUMBER_3 = $request->number3[$key];
            $info_person_list->IWJPL_NUMBER_4 = empty($request->number4[$key])?0:$request->number4[$key];
            $info_person_list->IWJPL_NUMBER_5 = empty($request->number5[$key])?0:$request->number5[$key];
            // คำนวณคะแนนที่ได้ และคะแนนดิบที่ได้รับ
            $before     =   [$request->performance_10[$key], 
                        $request->performance_11[$key],
                        $request->performance_12[$key],
                        $request->performance_1[$key],
                        $request->performance_2[$key],
                        $request->performance_3[$key]];
            $_12month   =  [$request->performance_10[$key], 
                        $request->performance_11[$key],
                        $request->performance_12[$key],
                        $request->performance_1[$key],
                        $request->performance_2[$key],
                        $request->performance_3[$key],
                        $info_person_list->performance_4,
                        $info_person_list->performance_5,
                        $info_person_list->performance_6,
                        $info_person_list->performance_7,
                        $info_person_list->performance_8,
                        $info_person_list->performance_9];
            if($info_person_list->IWJPL_TYPE_CALCULATE == "calc_avg"){
                $result_before  = array_sum($before)/count($before);
                $result_12month = array_sum($_12month)/count($_12month);
            }else if($info_person_list->IWJPL_TYPE_CALCULATE == "calc_max"){
                $result_before  = max($before);
                $result_12month = max($_12month);
            }else if($info_person_list->IWJPL_TYPE_CALCULATE == "calc_last"){
                $result_before  = $before[count($before)-1];
                $result_12month = $_12month[count($_12month)-1];
            }else if($info_person_list->IWJPL_TYPE_CALCULATE == "calc_sum"){
                $result_before  = array_sum($before);
                $result_12month = array_sum($_12month);
            }else{
                $result_before  = array_sum($before)/count($before);
                $result_12month = array_sum($_12month)/count($_12month);
            }

            // คำนวณคะแนน
            $number1 = $info_person_list->IWJPL_NUMBER_1;
            $number2 = $info_person_list->IWJPL_NUMBER_2;
            $number3 = $info_person_list->IWJPL_NUMBER_3;
            $number4 = $info_person_list->IWJPL_NUMBER_4;
            $number5 = $info_person_list->IWJPL_NUMBER_5;
            if($number1 < $number2){
                // คำนวณ 6 เดือนแรก
                if($result_before <= $number1){
                    $score_before = 1 ;
                }elseif($result_before < $number2){
                    $score_before = 1 + (($result_before-$number1)/($number2 - $number1));
                }elseif($result_before < $number3){
                    $score_before = 2 + (($result_before-$number2)/($number3 - $number2));
                }elseif($result_before < $number4){
                    $score_before = 3 + (($result_before-$number3)/($number4 - $number3));
                }elseif($result_before < $number5){
                    $score_before = 4 + (($result_before-$number4)/($number5 - $number4));
                }elseif($result_before >= $number5){
                    $score_before = 5;
                }
                // คำนวณ 12 เดือน
                if($result_12month <= $number1){
                    $score_12month = 1 ;
                }elseif($result_12month < $number2){
                    $score_12month = 1 + (($result_12month-$number1)/($number2 - $number1));
                }elseif($result_12month < $number3){
                    $score_12month = 2 + (($result_12month-$number2)/($number3 - $number2));
                }elseif($result_12month < $number4){
                    $score_12month = 3 + (($result_12month-$number3)/($number4 - $number3));
                }elseif($result_12month < $number5){
                    $score_12month = 4 + (($result_12month-$number4)/($number5 - $number4));
                }elseif($result_12month >= $number5){
                    $score_12month = 5;
                }
            }else{
            // คำนวณ 6 เดือนแรก
                if($result_before >= $number1){
                    $score_before = 1 ;
                }elseif($result_before > $number2){
                    $score_before = 1 + (($number1-$result_before)/($number1 - $number2));
                }elseif($result_before > $number3){
                    $score_before = 2 + (($number2-$result_before)/($number2 - $number3));
                }elseif($result_before > $number4){
                    $score_before = 3 + (($number3-$result_before)/($number3 - $number4));
                }elseif($result_before > $number5){
                    $score_before = 4 + (($number4-$result_before)/($number4 - $number5));
                }elseif($result_before <= $number5){
                    $score_before = 5;
                }
                if($result_12month >= $number1){
                    $score_12month = 1 ;
                }elseif($result_12month > $number2){
                    $score_12month = 1 + (($result_12month-$number1)/($number2 - $number1));
                }elseif($result_12month > $number3){
                    $score_12month = 2 + (($result_12month-$number2)/($number3 - $number2));
                }elseif($result_12month > $number4){
                    $score_12month = 3 + (($result_12month-$number3)/($number4 - $number3));
                }elseif($result_12month > $number5){
                    $score_12month = 4 + (($result_12month-$number4)/($number5 - $number4));
                }elseif($result_12month <= $number5){
                    $score_12month = 5;
                }
            }

            $score = 0;
            while (true) {
                    if(empty($request->number1[$key])){
                        break;
                    }else{
                        $score = 1;
                    }
                    if(empty($request->number2[$key])){
                        break;
                    }else{
                        $score = 2;
                    }
                    if(empty($request->number3[$key])){
                        break;
                    }else{
                        $score = 3;
                    }
                    if(empty($request->number4[$key])){
                        break;
                    }else{
                        $score = 4;
                    }
                    if(empty($request->number5[$key])){
                        break;
                    }else{
                        $score = 5;
                    }
                    break;
            }
            $info_person_list->IWJPL_SCORE_A        = $score;
            $info_person_list->IWJPL_WEIGHT_B       = $weight[$key];
            $info_person_list->IWJPL_MULTIPLY_AB    = $score * $weight[$key];
            $info_person_list->IWJPL_TARGET = $target[$key];
            $info_person_list->IWJPL_PERFORMANCE_10 = $performance_10[$key];
            $info_person_list->IWJPL_PERFORMANCE_11 = $performance_11[$key];
            $info_person_list->IWJPL_PERFORMANCE_12 = $performance_12[$key];
            $info_person_list->IWJPL_PERFORMANCE_1 = $performance_1[$key];
            $info_person_list->IWJPL_PERFORMANCE_2 = $performance_2[$key];
            $info_person_list->IWJPL_PERFORMANCE_3 = $performance_3[$key];
            $info_person_list->IWJPL_PERFORMANCE_AVG_10_TO_3 = $result_before;
            $info_person_list->IWJPL_PERFORMANCE_AVG_4_TO_9  = 0;
            $info_person_list->IWJPL_PERFORMANCE_AVG         = $result_12month;
            $info_person_list->IWJPL_SCORE_RESULT_10_TO_3    = $score_before;
            $info_person_list->IWJPL_SCORE_RESULT_4_TO_9     = 0;
            $info_person_list->IWJPL_SCORE_RESULT_ALL        = $score_12month;
            $info_person_list->save();
        }
        $job_person->IWJP_ASSESSOR_ID_1 = Auth::user()->PERSON_ID;
        $job_person->IWJOB_PERSON_STATUS_ID = 2;
        $job_person->save();
        Session::flash('scc','ประเมิน 6 เดือนแรกสำเร็จ');
        return redirect(route('mperson.jobdescriptions_personnel'));
    }

    public function jobdescriptions_personnel_estimate12($id){
        $job_person_list    = Infowork_job_person::getJobPersonByJobid($id);
        return view('manager_person.jobdescriptions_personnel_estimate12',compact('job_person_list'));
    }

    public function jobdescriptions_personnel_estimate12_update(Request $request){
        $job_person    = Infowork_job_person::find($request->id);
        if($job_person->IWJOB_PERSON_STATUS_ID == 3){
            Session::flash('err','ไม่สามารถประเมินรายการซ้ำได้');
            Session::flash('err_msg','รายการนี้ประเมิน 6 เดือนหลังแล้ว');
            return redirect(route('mperson.jobdescriptions_personnel'));
        }
        if($job_person->IWJOB_PERSON_STATUS_ID != 2){
            Session::flash('err','ไม่สามารถประเมินได้');
            Session::flash('err_msg','กรุณาทำการประเมิน 6 เดือนแรกก่อน');
            return redirect(route('mperson.jobdescriptions_personnel'));
        }
        $list_id = $request->list_id;
        $number1 = $request->number1;
        $number2 = $request->number2;
        $number3 = $request->number3;
        $number4 = $request->number4;
        $number5 = $request->number5;
        $weight  = $request->weight;
        $target  = $request->target;
        $performance_4  = $request->performance_4;
        $performance_5  = $request->performance_5;
        $performance_6  = $request->performance_6;
        $performance_7  = $request->performance_7;
        $performance_8  = $request->performance_8;
        $performance_9  = $request->performance_9;
        foreach ($list_id as $key => $value) {
            $info_person_list = Infowork_job_person_list::find($value);
            $info_person_list->IWJPL_NUMBER_1 = $request->number1[$key];
            $info_person_list->IWJPL_NUMBER_2 = $request->number2[$key];
            $info_person_list->IWJPL_NUMBER_3 = $request->number3[$key];
            $info_person_list->IWJPL_NUMBER_4 = empty($request->number4[$key])?0:$request->number4[$key];
            $info_person_list->IWJPL_NUMBER_5 = empty($request->number5[$key])?0:$request->number5[$key];
            
                                // คำนวณคะแนนที่ได้ และคะแนนดิบที่ได้รับ
                                $after      =   [$request->performance_4[$key],
                                                $request->performance_5[$key],
                                                $request->performance_6[$key],
                                                $request->performance_7[$key],
                                                $request->performance_8[$key],
                                                $request->performance_9[$key]];
                                $_12month   =  [$info_person_list->performance_10, 
                                                $info_person_list->performance_11,
                                                $info_person_list->performance_12,
                                                $info_person_list->performance_1,
                                                $info_person_list->performance_2,
                                                $info_person_list->performance_3,
                                                $request->performance_4[$key],
                                                $request->performance_5[$key],
                                                $request->performance_6[$key],
                                                $request->performance_7[$key],
                                                $request->performance_8[$key],
                                                $request->performance_9[$key]];
                                if($info_person_list->IWJPL_TYPE_CALCULATE == "calc_avg"){
                                    $result_after   = array_sum($after)/count($after);
                                    $result_12month = array_sum($_12month)/count($_12month);
                                }else if($info_person_list->IWJPL_TYPE_CALCULATE == "calc_max"){
                                    $result_after   = max($after);
                                    $result_12month = max($_12month);
                                }else if($info_person_list->IWJPL_TYPE_CALCULATE == "calc_last"){
                                    $result_after   = $after[count($after)-1];
                                    $result_12month = $_12month[count($_12month)-1];
                                }else if($info_person_list->IWJPL_TYPE_CALCULATE == "calc_sum"){
                                    $result_after   = array_sum($after);
                                    $result_12month = array_sum($_12month);
                                }else{
                                    $result_after   = array_sum($after)/count($after);
                                    $result_12month = array_sum($_12month)/count($_12month);
                                }

                                // คำนวณคะแนน
                                $number1 = $info_person_list->IWJPL_NUMBER_1;
                                $number2 = $info_person_list->IWJPL_NUMBER_2;
                                $number3 = $info_person_list->IWJPL_NUMBER_3;
                                $number4 = $info_person_list->IWJPL_NUMBER_4;
                                $number5 = $info_person_list->IWJPL_NUMBER_5;
                                if($number1 < $number2){
                                    // คำนวณ 6 เดือนหลัง
                                    if($result_after <= $number1){
                                        $score_after = 1 ;
                                    }elseif($result_after < $number2){
                                        $score_after = 1 + (($result_after-$number1)/($number2 - $number1));
                                    }elseif($result_after < $number3){
                                        $score_after = 2 + (($result_after-$number2)/($number3 - $number2));
                                    }elseif($result_after < $number4){
                                        $score_after = 3 + (($result_after-$number3)/($number4 - $number3));
                                    }elseif($result_after < $number5){
                                        $score_after = 4 + (($result_after-$number4)/($number5 - $number4));
                                    }elseif($result_after >= $number5){
                                        $score_after = 5;
                                    }
                                    // คำนวณ 12 เดือน
                                    if($result_12month <= $number1){
                                        $score_12month = 1 ;
                                    }elseif($result_12month < $number2){
                                        $score_12month = 1 + (($result_12month-$number1)/($number2 - $number1));
                                    }elseif($result_12month < $number3){
                                        $score_12month = 2 + (($result_12month-$number2)/($number3 - $number2));
                                    }elseif($result_12month < $number4){
                                        $score_12month = 3 + (($result_12month-$number3)/($number4 - $number3));
                                    }elseif($result_12month < $number5){
                                        $score_12month = 4 + (($result_12month-$number4)/($number5 - $number4));
                                    }elseif($result_12month >= $number5){
                                        $score_12month = 5;
                                    }
                                }else{
                                    // คำนวณ 6 เดือนหลัง
                                    if($result_after >= $number1){
                                        $score_after = 1 ;
                                    }elseif($result_after > $number2){
                                        $score_after = 1 + (($number1-$result_after)/($number1 - $number2));
                                    }elseif($result_after > $number3){
                                        $score_after = 2 + (($number2-$result_after)/($number2 - $number3));
                                    }elseif($result_after > $number4){
                                        $score_after = 3 + (($number3-$result_after)/($number3 - $number4));
                                    }elseif($result_after > $number5){
                                        $score_after = 4 + (($number4-$result_after)/($number4 - $number5));
                                    }elseif($result_after <= $number5){
                                        $score_after = 5;
                                    }
                                    // คำนวณ 12 เดือน
                                    if($result_12month >= $number1){
                                        $score_12month = 1 ;
                                    }elseif($result_12month > $number2){
                                        $score_12month = 1 + (($result_12month-$number1)/($number2 - $number1));
                                    }elseif($result_12month > $number3){
                                        $score_12month = 2 + (($result_12month-$number2)/($number3 - $number2));
                                    }elseif($result_12month > $number4){
                                        $score_12month = 3 + (($result_12month-$number3)/($number4 - $number3));
                                    }elseif($result_12month > $number5){
                                        $score_12month = 4 + (($result_12month-$number4)/($number5 - $number4));
                                    }elseif($result_12month <= $number5){
                                        $score_12month = 5;
                                    }
                                }

            $score = 0;
            while (true) {
                    if(empty($request->number1[$key])){
                        break;
                    }else{
                        $score = 1;
                    }
                    if(empty($request->number2[$key])){
                        break;
                    }else{
                        $score = 2;
                    }
                    if(empty($request->number3[$key])){
                        break;
                    }else{
                        $score = 3;
                    }
                    if(empty($request->number4[$key])){
                        break;
                    }else{
                        $score = 4;
                    }
                    if(empty($request->number5[$key])){
                        break;
                    }else{
                        $score = 5;
                    }
                    break;
            }
            $info_person_list->IWJPL_SCORE_A        = $score;
            $info_person_list->IWJPL_WEIGHT_B       = $weight[$key];
            $info_person_list->IWJPL_MULTIPLY_AB    = $score * $weight[$key];
            $info_person_list->IWJPL_TARGET = $target[$key];
            $info_person_list->IWJPL_PERFORMANCE_4 = $performance_4[$key];
            $info_person_list->IWJPL_PERFORMANCE_5 = $performance_5[$key];
            $info_person_list->IWJPL_PERFORMANCE_6 = $performance_6[$key];
            $info_person_list->IWJPL_PERFORMANCE_7 = $performance_7[$key];
            $info_person_list->IWJPL_PERFORMANCE_8 = $performance_8[$key];
            $info_person_list->IWJPL_PERFORMANCE_9 = $performance_9[$key];
            $info_person_list->IWJPL_PERFORMANCE_AVG_4_TO_9  = $result_after;
            $info_person_list->IWJPL_PERFORMANCE_AVG         = $result_12month;
            $info_person_list->IWJPL_SCORE_RESULT_4_TO_9     = $score_after;
            $info_person_list->IWJPL_SCORE_RESULT_ALL        = $score_12month;
            $info_person_list->save();
        }
        
        $job_person->IWJP_ASSESSOR_ID_2 = Auth::user()->PERSON_ID;
        $job_person->IWJOB_PERSON_STATUS_ID = 3;
        $job_person->save();
        Session::flash('scc','ประเมิน 6 เดือนหลังสำเร็จ');
        return redirect(route('mperson.jobdescriptions_personnel'));
    }

    public function jobdescriptions_personnel_estimate($id,Request $request){
        if($request->method() === "POST"){
            $calc_type      = $request->calc_type;
            $estimate_type  = $request->estimate_type;
            $data_search = json_encode_u([
                'calc_type' => $calc_type,
                'estimate_type' => $estimate_type,
            ]);
            Cookie::queue('data_search_estimate', $data_search, 525600,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search_estimate'))){
            $data_search    = json_decode(Cookie::get('data_search_estimate'));
            $calc_type      = $data_search->calc_type;
            $estimate_type  = $data_search->estimate_type;
        }else{
            $calc_type      = "calc_avg";
            $estimate_type  = "estimate_all";
        }
        
        $estimate_type_dropdown = [
            "estimate_all"  => "ประเมินทุกรูปแบบ",
            "estimate_6_month_before"  => "ประเมิน 6 เดือนแรก",
            "estimate_6_month_after"  => "ประเมิน 6 เดือนหลัง",
            "estimate_12_month"  => "ประเมิน 12 เดือน",
        ];

        $job_person_list    = Infowork_job_person::getJobPersonByJobid($id);
        return view('manager_person.jobdescriptions_personnel_estimate',compact(
            'id',
            'job_person_list',
            'calc_type',
            'estimate_type_dropdown',
            'estimate_type'
        ));
    }
        
    public function kpi_view(){
        $infowork_kpi = Infowork_kpi::all();
        return view('manager_person.kpi_view')->with([
            'infowork_kpi' => $infowork_kpi, 
        ]);
    }

    public function kpi_add(){
        return view('manager_person.kpi_add');
    }

    public function kpi_save(Request $request){
        $infowork_kpi = new Infowork_kpi();
        $infowork_kpi->IWKPI_NAME = $request->IWKPI_NAME;
        $infowork_kpi->IWKPI_NUMBER_1 = (float)$request->IWKPI_NUMBER_1;
        $infowork_kpi->IWKPI_NUMBER_2 = (float)$request->IWKPI_NUMBER_2;
        $infowork_kpi->IWKPI_NUMBER_3 = (float)$request->IWKPI_NUMBER_3;
        $infowork_kpi->IWKPI_NUMBER_4 = (float)$request->IWKPI_NUMBER_4;
        $infowork_kpi->IWKPI_NUMBER_5 = (float)$request->IWKPI_NUMBER_5;
        $infowork_kpi->IWKPI_SCORE_A = (float)$request->IWKPI_SCORE_A;
        $infowork_kpi->IWKPI_WEIGHT_B = (float)$request->IWKPI_WEIGHT_B;
        $infowork_kpi->IWKPI_MULTIPLY_AB = (float)$request->IWKPI_SCORE_A * (float)$request->IWKPI_WEIGHT_B;
        $infowork_kpi->IWKPI_TARGET = (float)$request->IWKPI_TARGET;
        $infowork_kpi->IWKPI_TYPE_CALCULATE = $request->IWKPI_TYPE_CALCULATE;
        $infowork_kpi->IWKPI_ACTIVE = $request->IWKPI_ACTIVE?true:false;
        $infowork_kpi->save();
        Session::flash('scc','บันทึกข้อมูลสำเร็จ');
        return redirect(route('mperson.setinfo_kpi'));
    }
    
    public function kpi_edit($id){
        $infowork_kpi = Infowork_kpi::find($id);
        return view('manager_person.kpi_edit',compact('infowork_kpi'));
    }
    
    public function kpi_update(Request $request){
        $infowork_kpi = Infowork_kpi::find($request->id);
        $infowork_kpi->IWKPI_NAME = $request->IWKPI_NAME;
        $infowork_kpi->IWKPI_NUMBER_1 = (float)$request->IWKPI_NUMBER_1;
        $infowork_kpi->IWKPI_NUMBER_2 = (float)$request->IWKPI_NUMBER_2;
        $infowork_kpi->IWKPI_NUMBER_3 = (float)$request->IWKPI_NUMBER_3;
        $infowork_kpi->IWKPI_NUMBER_4 = (float)$request->IWKPI_NUMBER_4;
        $infowork_kpi->IWKPI_NUMBER_5 = (float)$request->IWKPI_NUMBER_5;
        $infowork_kpi->IWKPI_SCORE_A = (float)$request->IWKPI_SCORE_A;
        $infowork_kpi->IWKPI_WEIGHT_B = (float)$request->IWKPI_WEIGHT_B;
        $infowork_kpi->IWKPI_MULTIPLY_AB = (float)$request->IWKPI_SCORE_A * (float)$request->IWKPI_WEIGHT_B;
        $infowork_kpi->IWKPI_TARGET = (float)$request->IWKPI_TARGET;
        $infowork_kpi->IWKPI_TYPE_CALCULATE = $request->IWKPI_TYPE_CALCULATE;
        $infowork_kpi->IWKPI_ACTIVE = $request->IWKPI_ACTIVE?true:false;
        $infowork_kpi->save();
        Session::flash('scc','แก้ไขข้อมูลสำเร็จ');
        return redirect(route('mperson.setinfo_kpi'));
    }

    public function kpi_delete($id){
        if(!empty(Infowork_job_descriptions_set::where('IWKPI_ID',$id)->first())){
            Session::flash('err','ไม่สามารถลบข้อมูลได้');
            Session::flash('err_msg','ข้อมูลถูก <u>กำหนด KPI</u> ใน <b>job descriptions</b> แล้ว');
            return redirect(route('mperson.setinfo_kpi'));
        }
        if(!empty(Infowork_job_person_list::where('IWKPI_ID',$id)->first())){
            Session::flash('err','ไม่สามารถลบข้อมูลได้');
            Session::flash('err_msg','ข้อมูลถูกนำไปใช้ใน <b>Job descriptions of personnel</b> แล้ว');
            return redirect(route('mperson.setinfo_kpi'));
        }
        Infowork_kpi::destroy($id);
        Session::flash('scc','ลบข้อมูลสำเร็จ');
        return redirect(route('mperson.setinfo_kpi'));
    }
    
    public function job_descriptions_view(Request $request){
        if($request->method() === "POST"){
            $search      = $request->search;
            $data_search = json_encode_u([
                'search' => $search
            ]);
            Cookie::queue('data_search_estimate', $data_search, 120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search_estimate'))){
            $data_search    = json_decode(Cookie::get('data_search_estimate'));
            $search      = $data_search->search;
        }else{
            $search      = "";
        }
        $infowork_job_descriptions = Infowork_job_descriptions::where(
            function ($q) use ($search)
            {
                $q->where('IWJD_NAME','like', '%' . $search . '%');
                $q->orWhere('IWJD_POSITION','like', '%' . $search . '%');
            })->get();
        $list_person_work_status = Infowork_job_person_status::all();
        $dropbudgetyear = getBudgetYearAmount();
        $budgetyear = getBudgetYear();
        $dropjob_descript   = Infowork_job_descriptions::where('IWJD_ACTIVE',true)->get();
        $dropperson     = person::getPersonWork();
        return view('manager_person.job_descriptions_view',compact(
            'infowork_job_descriptions',
            'dropbudgetyear',
            'budgetyear',
            'dropjob_descript',
            'dropperson',
            'search'
        ));
    }

    public function ajax_setinfo_jobd_list_kpi(Request $request){
        $Infowork_job_descriptions_set = Infowork_job_descriptions_set::leftJoin('infowork_kpi','infowork_kpi.IWKPI_ID','infowork_job_descriptions_set.IWKPI_ID')
                                    ->where('infowork_job_descriptions_set.IWJOB_D_ID',$request->id)
                                    ->get();
        $number = 1;
        $html = '';
        if(count($Infowork_job_descriptions_set) == 0 ){
            $html = '<tr> <td colspan="11" class="text-center p-4" style="font-size:18px !important">ไม่พบข้อมูล กรุณาตั้งค่า "<b>กำหนด KPI</b>" ในคำสั่ง <u>ทำรายการ</u></td> </tr>';
        }else{
            foreach($Infowork_job_descriptions_set as $row){
                $html .= '<tr>
                    <td class="text-center">'.$number++.'</td>
                    <td>'.$row->IWKPI_NAME.'</td>
                    <td class="text-center">'.$row->IWKPI_NUMBER_1.'</td>
                    <td class="text-center">'.$row->IWKPI_NUMBER_2.'</td>
                    <td class="text-center">'.$row->IWKPI_NUMBER_3.'</td>
                    <td class="text-center">'.$row->IWKPI_NUMBER_4.'</td>
                    <td class="text-center">'.$row->IWKPI_NUMBER_5.'</td>
                    <td class="text-center">'.$row->IWKPI_SCORE_A.'</td>
                    <td class="text-center">'.$row->IWKPI_WEIGHT_B.'</td>
                    <td class="text-center">'.$row->IWKPI_MULTIPLY_AB.'</td>
                    <td class="text-center">'.$row->IWKPI_TARGET.'</td>
                </tr>';
            }
        }
        return $html;
    }

    public function job_descriptions_add(){
        $infoposition =  DB::table('hrd_position')->get();
        return view('manager_person.job_descriptions_add',compact('infoposition'));
    }

    public function job_descriptions_save(Request $request){
        $infowork_job_descriptions = new Infowork_job_descriptions();
        $infowork_job_descriptions->IWJD_NAME = $request->jobdescription_name;
        $infowork_job_descriptions->IWJD_EXPECTED_RESULT = $request->jobdescription_expected;
        $infowork_job_descriptions->IWJD_POSITION = $request->jobdesction_position;
        $infowork_job_descriptions->IWJD_ACTIVE = $request->jobdescription_active?true:false;
        $infowork_job_descriptions->save();
        Session::flash('scc','บันทึกข้อมูลสำเร็จ');
        return redirect(route('mperson.setinfo_jobd'));
    }

    public function job_descriptions_edit($id){
        $infowork_job_descriptions = Infowork_job_descriptions::find($id);
        $infoposition =  DB::table('hrd_position')->get();
        return view('manager_person.job_descriptions_edit',compact('infowork_job_descriptions','infoposition'));
    }

    public function job_descriptions_update(Request $request){
        $infowork_job_descriptions = Infowork_job_descriptions::find($request->id);
        $infowork_job_descriptions->IWJD_NAME = $request->jobdescription_name;
        $infowork_job_descriptions->IWJD_EXPECTED_RESULT = $request->jobdescription_expected;
        $infowork_job_descriptions->IWJD_POSITION = $request->jobdesction_position;
        $infowork_job_descriptions->IWJD_ACTIVE = $request->jobdescription_active?true:false;
        $infowork_job_descriptions->save();
        Session::flash('scc','แก้ไขข้อมูลสำเร็จ');
        return redirect(route('mperson.setinfo_jobd'));
    }

    public function job_descriptions_delete($id){
        
        if(!empty(Infowork_job_descriptions_set::where('IWJOB_D_ID',$id)->first())){
            Session::flash('err','ไม่สามารถลบข้อมูลได้');
            Session::flash('err_msg','ข้อมูลถูก "<b>กำหนด KPI</b>" ใน <u>job descriptions</u> แล้ว');
            return redirect(route('mperson.setinfo_jobd'));
        }

        if(!empty(Infowork_job_person::where('IWJOB_D_ID',$id)->first())){
            Session::flash('err','ไม่สามารถลบข้อมูลได้');
            Session::flash('err_msg','ข้อมูลถูกนำไปใช้ใน <b>Job descriptions of personnel</b> แล้ว');
            return redirect(route('mperson.setinfo_jobd'));
        }

        Infowork_job_descriptions::destroy($id);
        Session::flash('scc','ลบข้อมูลสำเร็จ');
        return redirect(route('mperson.setinfo_jobd'));
    }

    public function job_descriptions_set($id){
        $infowork_job_description = Infowork_job_descriptions::find($id);
        $infowork_job_descriptions_set = Infowork_job_descriptions_set::select('kpi.*')
                                ->leftJoin('infowork_kpi as kpi','kpi.IWKPI_ID','infowork_job_descriptions_set.IWKPI_ID')
                                ->where('IWJOB_D_ID',$id)->get();
        $infowork_kpi             = Infowork_kpi::where('IWKPI_ACTIVE',true)->get();
        $jobdescription_id = $id;
        return view('manager_person.job_descriptions_set',compact(
            'infowork_job_description',
            'infowork_job_descriptions_set',
            'infowork_kpi',
            'jobdescription_id'
        ));
    }

    public function job_descriptions_set_update(Request $request){
        Infowork_job_descriptions_set::where('IWJOB_D_ID',$request->jobdescription_id)->delete();
        foreach ($request->kpi_id as $value) {
            $info_set = new Infowork_job_descriptions_set(); 
            $info_set->IWJOB_D_ID = $request->jobdescription_id;
            $info_set->IWKPI_ID = $value;
            $info_set->save();
        }
        Session::flash('scc','อัพเดตข้อมูล kpi เรียบร้อย');
        return redirect(route('mperson.setinfo_jobd'));
    }

    public function permission_job_view()
    {
        $person     = Infowork_job_person_permission::getPersonList();
        $personel   = Person::getPersonWork();
        return view('manager_person.permission_job_view',compact(
            'person',
            'personel'
        ));
    }

    public function permission_job_save(Request $request)
    {
        $permission_person = new Infowork_job_person_permission();
        $permission_person->IWJOB_PERMIS_PERSON_ID = $request->person_id;
        $permission_person->save();
        Session::flash('scc','เพิ่มข้อมูลสำเร็จ');
        return redirect(route('mperson.permission_job'));
    }

    public function permission_job_delete($id)
    {
        Infowork_job_person_permission::destroy($id);
        Infowork_job_person_permission_list::where('IWJOB_PERMIS_ID',$id)->delete();
        Session::flash('scc','ลบข้อมูลสำเร็จ');
        return redirect(route('mperson.permission_job'));
    }

    public function permission_job_person_view($PERMIS_ID){
        $permission_person = Infowork_job_person_permission::getPerson($PERMIS_ID);
        $person = Infowork_job_person_permission_list::getPersonById($PERMIS_ID);
        $personel   = Person::getPersonWork();
        return view('manager_person.permission_job_person_view',compact(
            'person',
            'permission_person',
            'personel'
        ));
    }

    public function permission_job_person_save(Request $request){
        $permission_person_list = new Infowork_job_person_permission_list();
        $permission_person_list->IWJOB_PERMIS_ID                = $request->permis_id;
        $permission_person_list->IWJOB_PERMIS_LIST_PERSON_ID    = $request->person_id;
        $permission_person_list->save();
        Session::flash('scc','เพิ่มข้อมูลสำเร็จ');
        return redirect()->back();
    }

    public function permission_job_person_delete($id)
    {
        Infowork_job_person_permission_list::destroy($id);
        Session::flash('scc','ลบข้อมูลสำเร็จ');
        return redirect()->back();
    }


    // Manager person health check 

    public function healthCheck(){
        $users = DB::table('users')->get();
        
        return view('manager_person.health-check.main',[
            'users' => $users
        ]);
     }
 
     public function healthCheckForm(){
         return view('manager_person.health-check.form');
     }

     public function healthCheckFormBackup(){
         return view('manager_person.health-check.form-backup');
     }
 
     public function healthCheckResults(){
         return view('manager_person.health-check.results');
     }

     public function healthCheckReport(){
         return view('manager_person.health-check.report');
     }

     public function healthCheckReportTable($type){
         
         return view('manager_person.health-check.report-table',[
             'type' => $type
         ]);
     }


    // Manager person infor person 
     public function viewInforMation(Request $request,$id){

        $infoprevut =  DB::table('hrd_vut')->get();
        $inforpersonusereducatid =  Person::where('ID','=',$id)->first();
        $id = $inforpersonusereducatid->ID;

        $inforpersonusereducat =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$id)->first();

        $infoeducation = Education::leftJoin('hrd_vut','hrd_tr_edu.VUT_ID','=','hrd_vut.VUT_ID')
                                     ->where('PERSON_ID','=',$id)
                                     ->orderBy('hrd_tr_edu.ID', 'desc')  
                                     ->get();

         return view('manager_person.infor_person.information',[
            'inforpersonusereducat' => $inforpersonusereducat,
            'inforpersonusereducatid' => $inforpersonusereducatid,
            'infoprevuts' => $infoprevut,
            'infoeducations' => $infoeducation 
        ]);
     }


     public function saveinforperson(Request $request)
     {
         $request->validate([
             'VUT_ID' => 'required',
             'UNIVER_NAME' => 'required',
             'FAUCULTY' => 'required',
             'LAVEL' => 'required',
             'GRADE' => 'required',
             'START_DATE' => 'required',
             'CON_DATE' => 'required',
         ]);
     
        $checkstart= $request->START_DATE;
        $checkcon= $request->CON_DATE;
 
         if($checkstart != ''){
 
            
             $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
             $date_arrary_st=explode("-",$STARTDAY);  
             $y_sub_st = $date_arrary_st[0]; 
             
             if($y_sub_st >= 2500){
                 $y_st = $y_sub_st-543;
             }else{
                 $y_st = $y_sub_st;
             }
             $m_st = $date_arrary_st[1];
             $d_st = $date_arrary_st[2];  
             $displaystartdate= $y_st."-".$m_st."-".$d_st;
          
 
             }else{
             $displaystartdate= null;
         }
         
         if($checkcon != ''){
             $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
             $date_arrary=explode("-",$CONDAY); 
             
             $y_sub = $date_arrary[0]; 
             
             if($y_sub >= 2500){
                 $y = $y_sub-543;
             }else{
                 $y = $y_sub;
             }
                
             $m = $date_arrary[1];
             $d = $date_arrary[2];  
             $condate= $y."-".$m."-".$d;
             }else{
             $condate= null;
             }
 
             $addedu = new Education(); 
             $addedu->PERSON_ID = $request->PERSON_ID;
             $addedu->VUT_ID = $request->VUT_ID;
             $addedu->LAVEL = $request->LAVEL; 
             $addedu->GRADE = $request->GRADE;
             $addedu->UNIVER_NAME = $request->UNIVER_NAME;
             $addedu->START_DATE = $displaystartdate;
             $addedu->CON_DATE = $condate;
             $addedu->USER_EDIT_ID = $request->USER_EDIT_ID;
             $addedu->FAUCULTY = $request->FAUCULTY;
             $addedu->save();
 
             return redirect()->route('mperson.infoperson.view_information',['id'=>  $request->PERSON_ID]); 
        
     }


     public function editinforperson(Request $request)
     {
 

 
         $id = $request->ID; 
 
         $checkstart= $request->START_DATE_edit;
         $checkcon= $request->CON_DATE_edit;
 
     if($checkstart != ''){           
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         if($y_sub_st < 2500){
             $y_st = $y_sub_st;
         }else{
             $y_st = $y_sub_st-543;
         }
         
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $displaystartdate= $y_st."-".$m_st."-".$d_st;
         }else{
         $displaystartdate= null;
     }
     
     if($checkcon != ''){
         $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
         $date_arrary=explode("-",$CONDAY); 
         $y_sub = $date_arrary[0]; 
         if($y_sub < 2500){
             $y = $y_sub;    
         }else{
             $y = $y_sub-543;
         }     
         $m = $date_arrary[1];
         $d = $date_arrary[2];  
         $condate= $y."-".$m."-".$d;
         }else{
         $condate= null;
         }
  
       
 
         $educationedit = Education::find($id);
         $educationedit->START_DATE = $displaystartdate;
         $educationedit->CON_DATE = $condate;
         $educationedit->VUT_ID = $request->VUT_ID_edit;
         $educationedit->LAVEL = $request->LAVEL_edit; 
         $educationedit->GRADE = $request->GRADE_edit;
         $educationedit->UNIVER_NAME = $request->UNIVER_NAME_edit;
         $educationedit->USER_EDIT_ID = $request->USER_EDIT_ID;
         $educationedit->FAUCULTY = $request->FAUCULTY_edit;
         $educationedit->save();
         
        return redirect()->route('mperson.infoperson.view_information',['id'=>  $request->PERSON_ID]); 
     }


     public function destroyinforperson($id,$iduser) { 
                
        Education::destroy($id);         
        return redirect()->route('mperson.infoperson.view_information',['id'=>  $iduser]);     
    }

     

     public function viewWorkHistory(Request $request,$id){

        $inforpersonuserworkid =  Person::where('ID','=',$id)->first();
        $id = $inforpersonuserworkid->ID;

        
        $inforpersonuserwork =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$id)->first();

        $infowork= Work::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_work.DATEDO_WORK', 'desc')  
        ->get();

        
         return view('manager_person.infor_person.work_history',[
            'inforpersonuserwork' => $inforpersonuserwork,
            'inforpersonuserworkid' => $inforpersonuserworkid,
            'infoworks' => $infowork 
        ]);
     }

     public function saveworkhistory(Request $request)
     {
      
        
        $checkstart= $request->DATEDO_WORK;
        $checkcon= $request->DATEDO_EXIT;
 
         if($checkstart != ''){
 
            
             $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
             $date_arrary_st=explode("-",$STARTDAY);  
             $y_sub_st = $date_arrary_st[0]; 
             
             if($y_sub_st >= 2500){
                 $y_st = $y_sub_st-543;
             }else{
                 $y_st = $y_sub_st;
             }
             $m_st = $date_arrary_st[1];
             $d_st = $date_arrary_st[2];  
             $displaystartdate= $y_st."-".$m_st."-".$d_st;
          
 
             }else{
             $displaystartdate= null;
         }
         
         if($checkcon != ''){
             $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
             $date_arrary=explode("-",$CONDAY); 
             
             $y_sub = $date_arrary[0]; 
             
             if($y_sub >= 2500){
                 $y = $y_sub-543;
             }else{
                 $y = $y_sub;
             }
                
             $m = $date_arrary[1];
             $d = $date_arrary[2];  
             $condate= $y."-".$m."-".$d;
             }else{
             $condate= null;
             }
 
             $addwork = new Work(); 
             $addwork->PERSON_ID = $request->PERSON_ID;
 
             $addwork->DATEDO_WORK = $displaystartdate;
             $addwork->DATEDO_EXIT = $condate;
 
             $addwork->BECOURSE_EXIT = $request->BECOURSE_EXIT;
             $addwork->POSITION_WORK = $request->POSITION_WORK; 
             $addwork->LOCATION_WORK = $request->LOCATION_WORK;
             $addwork->USER_EDIT_ID = $request->USER_EDIT_ID;
             $addwork->SALARY = $request->SALARY;
           
             
    
             $addwork->save();
 
         

              return redirect()->route('mperson.infoperson.view_workhistory',['id'=>  $request->PERSON_ID]);  
 
        
     }




     public function editworkhistory(Request $request)
     {
 
      
 
         $id = $request->ID; 
 
         $checkstart= $request->DATEDO_WORK_edit;
         $checkcon= $request->DATEDO_EXIT_edit;
 
     if($checkstart != ''){           
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         if($y_sub_st < 2500){
             $y_st = $y_sub_st;
         }else{
             $y_st = $y_sub_st-543;
         }
         
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $displaystartdate= $y_st."-".$m_st."-".$d_st;
         }else{
         $displaystartdate= null;
     }
     
     if($checkcon != ''){
         $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
         $date_arrary=explode("-",$CONDAY); 
         $y_sub = $date_arrary[0]; 
         if($y_sub < 2500){
             $y = $y_sub;    
         }else{
             $y = $y_sub-543;
         }     
         $m = $date_arrary[1];
         $d = $date_arrary[2];  
         $condate= $y."-".$m."-".$d;
         }else{
         $condate= null;
         }
  
         $workedit = Work::find($id);
             $workedit->DATEDO_WORK = $displaystartdate;
             $workedit->DATEDO_EXIT = $condate;
 
             $workedit->BECOURSE_EXIT = $request->BECOURSE_EXIT_edit;
             $workedit->POSITION_WORK = $request->POSITION_WORK_edit; 
             $workedit->LOCATION_WORK = $request->LOCATION_WORK_edit;
             $workedit->USER_EDIT_ID = $request->USER_EDIT_ID;
             $workedit->SALARY = $request->SALARY_edit; 
             $workedit->save();
         
             return redirect()->route('mperson.infoperson.view_workhistory',['id'=>  $request->PERSON_ID]);  
 
     }

     public function destroyworkhistory($id,$iduser) { 
                
        Work::destroy($id);         
        return redirect()->route('mperson.infoperson.view_workhistory',['id'=>  $iduser]);    
    }









     public function viewAward(Request $request,$id){

        $inforeward= Reward::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_reward.ID', 'desc')  
        ->get();

         return view('manager_person.infor_person.award',[
            'id' => $id, 
            'inforewards' => $inforeward 
        ]);
     }

     public function saveawardy(Request $request)
     {
        
        
         $id = $request->ID; 
 
         $checkRECEIVE= $request->DATE_RECEIVE;
         $checkSTART= $request->START_DATE;
         $checkEND= $request->END_DATE;

        if($checkRECEIVE != ''){
            $CONDAY = Carbon::createFromFormat('d/m/Y', $checkRECEIVE)->format('Y-m-d');
            $date_arrary=explode("-",$CONDAY); 
            $y_sub = $date_arrary[0]; 
            if($y_sub < 2500){
                $y = $y_sub;    
            }else{
                $y = $y_sub-543;
            }     
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $condate= $y."-".$m."-".$d;
            }else{
            $condate= null;
            }


        if($checkSTART != ''){
            $CONDAY = Carbon::createFromFormat('d/m/Y', $checkSTART)->format('Y-m-d');
            $date_arrary=explode("-",$CONDAY); 
            $y_sub = $date_arrary[0]; 
            if($y_sub < 2500){
                $y = $y_sub;    
            }else{
                $y = $y_sub-543;
            }     
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $displaystartdate= $y."-".$m."-".$d;
            }else{
            $displaystartdate= null;
            }

            if($checkEND != ''){
                $CONDAY = Carbon::createFromFormat('d/m/Y', $checkEND)->format('Y-m-d');
                $date_arrary=explode("-",$CONDAY); 
                $y_sub = $date_arrary[0]; 
                if($y_sub < 2500){
                    $y = $y_sub;    
                }else{
                    $y = $y_sub-543;
                }     
                $m = $date_arrary[1];
                $d = $date_arrary[2];  
                $enddate= $y."-".$m."-".$d;
                }else{
                $enddate= null;
                }

                   
            $addaward = new Reward(); 
            $addaward->PERSON_ID = $request->PERSON_ID;
            $addaward->REWARD_NAME = $request->REWARD_NAME;    
            $addaward->DATE_RECEIVE = $condate;
            $addaward->START_DATE = $displaystartdate;
            $addaward->END_DATE = $enddate;
            $addaward->COMMENTS = $request->COMMENTS;
            $addaward->USER_EDIT_ID = $request->USER_EDIT_ID;
            $addaward->save();

            
    

            return redirect()->route('mperson.infoperson.view_award',[
                'id' => $request->PERSON_ID,
            ]);
     }

     public function editawardy(Request $request)
     {
     $id = $request->ID; 
 
        $checkgive= $request->DATE_RECEIVE_edit;
        $checkstart= $request->START_DATE_edit;
        $checkcon= $request->END_DATE_edit;
 
        if($checkgive != ''){
     
         $GIVEDAY = Carbon::createFromFormat('d/m/Y', $checkgive)->format('Y-m-d');
         $date_arrary_g=explode("-",$GIVEDAY);  
         $y_sub_g = $date_arrary_g[0]; 
         
         if($y_sub_g < 2500){
            $y_g = $y_sub_g;    
         }else{
            $y_g = $y_sub_g-543;
         }
         $m_g = $date_arrary_g[1];
         $d_g = $date_arrary_g[2];  
         $displaygivedate= $y_g."-".$m_g."-".$d_g;
      
 
         }else{
         $displaygivedate= null;
     }

    if($checkstart != ''){           
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        if($y_sub_st < 2500){
            $y_st = $y_sub_st;
        }else{
            $y_st = $y_sub_st-543;
        }
        
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $displaystartdate= $y_st."-".$m_st."-".$d_st;
        }else{
        $displaystartdate= null;
    }
    
    if($checkcon != ''){
        $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
        $date_arrary=explode("-",$CONDAY); 
        $y_sub = $date_arrary[0]; 
        if($y_sub < 2500){
            $y = $y_sub;    
        }else{
            $y = $y_sub-543;
        }     
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $condate= $y."-".$m."-".$d;
        }else{
        $condate= null;
        }
 
        $rewardedit = Reward::find($id);
       
            $rewardedit->REWARD_NAME = $request->REWARD_NAME_edit; 
            $rewardedit->DATE_RECEIVE = $displaygivedate;
            $rewardedit->START_DATE = $displaystartdate;
            $rewardedit->END_DATE = $condate;
            $rewardedit->COMMENTS = $request->COMMENTS;
        
            $rewardedit->save();

            return redirect()->route('mperson.infoperson.view_award',[
                'id' => $request->PERSON_ID,
            ]);

    }
    public function desawardy($id,$iduser) { 
                
        Reward::destroy($id);         
        return redirect()->route('mperson.infoperson.view_award',[
            'id' => $iduser
        ]);    
    }


     public function viewRegalia(Request $request,$id){
        
        $inforegalia = Hrd_regalia::where('HRD_REGALIA_ID','=',$id)
        ->orderBy('id', 'desc')  
        ->get();
        
        $budget = DB::table('budget_year')->get();

        

        return view('manager_person.infor_person.regalia',[
            'id' => $id, 
            'inforegalias' => $inforegalia,
            'budget' => $budget  
        ]);

     }
     public function saveregalia(Request $request)
     {

            $checkstart= $request->DAY_OF_RECEIPT;
            $checkcon= $request->ANNOUNCEMENT_DATE;
 
            if($checkstart != ''){
 
            
             $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
             $date_arrary_st=explode("-",$STARTDAY);  
             $y_sub_st = $date_arrary_st[0]; 
             
             if($y_sub_st >= 2500){
                 $y_st = $y_sub_st-543;
             }else{
                 $y_st = $y_sub_st;
             }
             $m_st = $date_arrary_st[1];
             $d_st = $date_arrary_st[2];  
             $displaystartdate= $y_st."-".$m_st."-".$d_st;
          
 
             }else{
             $displaystartdate= null;
         }
         
         if($checkcon != ''){
             $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
             $date_arrary=explode("-",$CONDAY); 
             
             $y_sub = $date_arrary[0]; 
             
             if($y_sub >= 2500){
                 $y = $y_sub-543;
             }else{
                 $y = $y_sub;
             }
                
             $m = $date_arrary[1];
             $d = $date_arrary[2];  
             $condate= $y."-".$m."-".$d;
             }else{
             $condate= null;
             }
             

            $addregalia = new Hrd_regalia(); 
            $addregalia->HRD_REGALIA_ID = $request->PERSON_ID;
            $addregalia->YEAR_OF_RECEIPT = $request->YEAR_OF_RECEIPT;
            $addregalia->DAY_OF_RECEIPT = $displaystartdate;
            $addregalia->ANNOUNCEMENT_DATE = $condate;
            $addregalia->BADGE = $request->BADGE;
            $addregalia->POSITION = $request->POSITION;
            $addregalia->AGENCY = $request->AGENCY;
            $addregalia->VOLUME = $request->VOLUME;
            $addregalia->DUTY = $request->DUTY;
            $addregalia->NO = $request->NO;
            $addregalia->BADGE_R_G_L = $request->BADGE_R_G_L;
            $addregalia->BADGE_R_G_D = $request->BADGE_R_G_D;

            $addregalia->save();

            return redirect()->route('mperson.infoperson.view_regalia',[
                'id' => $request->PERSON_ID,
            ]);
     }





     public function editregalia(Request $request)
     {
        $id = $request->ID;

        $checkstart= $request->DAY_OF_RECEIPT_EDIT;
        $checkcon= $request->ANNOUNCEMENT_DATE_EDIT;

    if($checkstart != ''){           
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        if($y_sub_st < 2500){
            $y_st = $y_sub_st;
        }else{
            $y_st = $y_sub_st-543;
        }
        
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $displaystartdate= $y_st."-".$m_st."-".$d_st;
        }else{
        $displaystartdate= null;
    }
    
    if($checkcon != ''){
        $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
        $date_arrary=explode("-",$CONDAY); 
        $y_sub = $date_arrary[0]; 
        if($y_sub < 2500){
            $y = $y_sub;    
        }else{
            $y = $y_sub-543;
        }     
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $condate= $y."-".$m."-".$d;
        }else{
        $condate= null;
        }
             

            $editregalia = Hrd_regalia::find($id);

            $editregalia->HRD_REGALIA_ID = $request->PERSON_ID;
            $editregalia->YEAR_OF_RECEIPT = $request->YEAR_OF_RECEIPT_EDIT;
            $editregalia->DAY_OF_RECEIPT = $displaystartdate;
            $editregalia->ANNOUNCEMENT_DATE = $condate;
            $editregalia->BADGE = $request->BADGE_EDIT;
            $editregalia->POSITION = $request->POSITION_edit;
            $editregalia->AGENCY = $request->AGENCY_edit;
            $editregalia->VOLUME = $request->VOLUME_edit;
            $editregalia->DUTY = $request->DUTY_edit;
            $editregalia->NO = $request->NO_edit;
            $editregalia->BADGE_R_G_L = $request->BADGE_R_G_L_edit;
            $editregalia->BADGE_R_G_D = $request->BADGE_R_G_L_edit;

            

            $editregalia->save();

            return redirect()->route('mperson.infoperson.view_regalia',[
                'id' => $request->PERSON_ID,
            ]);
     }
     public function desregalia ($id,$iduser) { 
                
        Hrd_regalia::destroy($id);           
        return redirect()->route('mperson.infoperson.view_regalia',[
            'id' => $iduser
        ]);    
    }



     public function viewExpertise(Request $request,$id){
         $infoexpert= Expert::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_expert.ID', 'desc')  
        ->get();

         return view('manager_person.infor_person.expertise',[
            'id' => $id, 
            'infoexpert' => $infoexpert  
        ]);
     }
     public function saveexpertise(Request $request)
     {
        
            $id = $request->ID; 

            $addaward = new Expert(); 
            $addaward->PERSON_ID = $request->PERSON_ID;
            $addaward->EXPERT_NAME = $request->EXPERT_NAME;
            $addaward->EXPERT_DETAIL = $request->EXPERT_DETAIL;
            $addaward->EXPERT_EXAM = $request->EXPERT_EXAM;


            $addaward->USER_EDIT_ID = $request->USER_EDIT_ID;
            // date เป็นฟังก์ชั่นของ php ส่วนนี้เป็นการยัดเวลาปัจจุบันลงไปใน db 

            $addaward->DATE_TIME_SAVE = date('Y-m-d H:i:s');
            $addaward->save();

            return redirect()->route('mperson.infoperson.view_expertise',[
                'id' => $request->PERSON_ID,
            ]);
     }

     public function editexpertise(Request $request)
     {
        
            $id = $request->ID; 

            $editaward = Expert::find($id);
            $editaward->PERSON_ID = $request->PERSON_ID;
            $editaward->EXPERT_NAME = $request->EXPERT_NAME_EDIT;
            $editaward->EXPERT_DETAIL = $request->EXPERT_DETAIL_EDIT;
            $editaward->EXPERT_EXAM = $request->EXPERT_EXAM_EDIT;
            $editaward->save();

            return redirect()->route('mperson.infoperson.view_expertise',[
                'id' => $request->PERSON_ID,
            ]);
     }
     public function desexpertise($id,$iduser) { 
                
        Expert::destroy($id);          
        return redirect()->route('mperson.infoperson.view_expertise',[
            'id' => $iduser
        ]);    
    }
     



     public function viewNameChange(Request $request,$iduser){
         $email = Auth::user()->email;
         $inforpersonuserchangeid =  Person::where('ID','=',$iduser)->first();
         $id = $inforpersonuserchangeid->ID;
 
         
         $inforpersonuserchange =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
         ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
         ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
         ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
         ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
         ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
         ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
         ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
         ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
         ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
         ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
         ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
         ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
         ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
         ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
         ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
         ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
         ->where('hrd_person.ID','=',$iduser)->first();
 
         $infochangename= Changename::where('PERSON_ID','=',$id)
         ->orderBy('hrd_tr_changename.ID', 'desc')  
         ->get();
       
 
         return view('manager_person.infor_person.name_change',[
             'inforpersonuserchange' => $inforpersonuserchange,
             'inforpersonuserchangeid' => $inforpersonuserchangeid,
             'infochangename' => $infochangename 
         ]);
     }

     public function savenamechange(Request $request)
     {
        $id = $request->ID; 
 
         $checkRECEIVE= $request->DATE_CHANGE;

        if($checkRECEIVE != ''){
            $CONDAY = Carbon::createFromFormat('d/m/Y', $checkRECEIVE)->format('Y-m-d');
            $date_arrary=explode("-",$CONDAY); 
            $y_sub = $date_arrary[0]; 
            if($y_sub < 2500){
                $y = $y_sub;    
            }else{
                $y = $y_sub-543;
            }     
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $condate= $y."-".$m."-".$d;
            }else{
            $condate= null;
            }

                   
            $addchangename = new Changename();     
            $addchangename->PERSON_ID = $request->PERSON_ID;
            $addchangename->DATE_CHANGE = $condate;
            $addchangename->NAMEOLD = $request->NAMEOLD;
            $addchangename->NAMENEW = $request->NAMENEW;
            $addchangename->USER_EDIT_ID = $request->USER_EDIT_ID;
            $addchangename->DATE_TIME_SAVE = date('Y-m-d H:i:s');
            $addchangename->save();


            return redirect()->route('mperson.infoperson.view_namechange',[
                'id' => $request->PERSON_ID,
            ]);
            
     }
     public function editnamechange(Request $request)
     {
     $id = $request->ID; 
 
        $checkgive= $request->DATE_CHANGE_EDIT;
 
        if($checkgive != ''){
     
         $GIVEDAY = Carbon::createFromFormat('d/m/Y', $checkgive)->format('Y-m-d');
         $date_arrary_g=explode("-",$GIVEDAY);  
         $y_sub_g = $date_arrary_g[0]; 
         
         if($y_sub_g < 2500){
            $y_g = $y_sub_g;    
         }else{
            $y_g = $y_sub_g-543;
         }
         $m_g = $date_arrary_g[1];
         $d_g = $date_arrary_g[2];  
         $displaygivedate= $y_g."-".$m_g."-".$d_g;
 
        $editnamechange = Changename::find($id);
       
        $editnamechange->PERSON_ID = $request->PERSON_ID;
        $editnamechange->DATE_CHANGE = $displaygivedate;
        $editnamechange->NAMEOLD = $request->NAMEOLD_EDIT;
        $editnamechange->NAMENEW = $request->NAMENEW_EDIT;
        
            $editnamechange->save();

            return redirect()->route('mperson.infoperson.view_namechange',[
                'id' => $request->PERSON_ID,
            ]);

    }
}
public function desnamechange($id,$iduser) { 
                
    Changename::destroy($id);         

    return redirect()->route('mperson.infoperson.view_namechange',[
        'id' => $iduser
    ]);    
}




     public function viewUpMoney(Request $request,$iduser){
        $inforpersonusersalaryid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonusersalaryid->ID;

        
        $inforpersonusersalary =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $inmoney= Salary::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_salary.ID', 'desc')  
        ->get();

      
       $infoposition = DB::table('hrd_position')->get();

       $infolevel = DB::table('hrd_level')->get();


        return view('manager_person.infor_person.up_money',[
            'infolevels' => $infolevel,
            'infopositions' => $infoposition,
            'inforpersonusersalary' => $inforpersonusersalary,
            'inforpersonusersalaryid' => $inforpersonusersalaryid,
            'infomoneys' => $inmoney 
        ]);
     }
     public function saveupmoney(Request $request)
     {
        $id = $request->ID; 
 
         $checkRECEIVE= $request->DATE_CHANGE;

        if($checkRECEIVE != ''){
            $CONDAY = Carbon::createFromFormat('d/m/Y', $checkRECEIVE)->format('Y-m-d');
            $date_arrary=explode("-",$CONDAY); 
            $y_sub = $date_arrary[0]; 
            if($y_sub < 2500){
                $y = $y_sub;    
            }else{
                $y = $y_sub-543;
            }     
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $condate= $y."-".$m."-".$d;
            }else{
            $condate= null;
            }

                   
            $addupmoney = new Salary(); 
            $addupmoney->PERSON_ID = $request->PERSON_ID;
            $addupmoney->DATE_CHANGE = $condate;

            $addupmoney->SALARY_NUMBER = $request->SALARY_NUMBER;   
            $addupmoney->SALARYNEW = $request->SALARYNEW; 
            $addupmoney->COMMENT = $request->COMMENT;

            
            $addupmoney->POSITION_ID = $request->POSITION_ID;
            $nameposition = DB::table('hrd_position')->where('HR_POSITION_ID','=',$request->POSITION_ID)->first();
            $addupmoney->POSITION_IN_WORK = $nameposition->HR_POSITION_NAME;

            $addupmoney->LAVEL_ID = $request->LAVEL_ID;
            $namelevel = DB::table('hrd_level')->where('HR_LEVEL_ID','=',$request->LAVEL_ID)->first();
            $addupmoney->LAVEL_NAME = $namelevel->HR_LEVEL_NAME;
            $addupmoney->USER_EDIT_ID = $request->USER_EDIT_ID;
            $addupmoney->save();

            $editupmoney = Person::find($request->PERSON_ID);
            $editupmoney->HR_SALARY = $request->SALARYNEW;
            $editupmoney->save();



            return redirect()->route('mperson.infoperson.view_upmoney',[
                'id' => $request->PERSON_ID,
            ]);
            
     }
     public function editupmoney(Request $request)
    {

        $id = $request->ID; 

        $checkstart= $request->DATE_CHANGE_edit;
      

    if($checkstart != ''){           
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        if($y_sub_st < 2500){
            $y_st = $y_sub_st;
        }else{
            $y_st = $y_sub_st-543;
        }
        
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $displaystartdate= $y_st."-".$m_st."-".$d_st;
        }else{
        $displaystartdate= null;
    }
  
        $editupmoney = Salary::find($id);
    
        $editupmoney->DATE_CHANGE = $displaystartdate;

        $editupmoney->SALARY_NUMBER = $request->SALARY_NUMBER_edit; 
        $editupmoney->SALARYNEW = $request->SALARYNEW_edit; 
        $editupmoney->COMMENT = $request->COMMENT;

          
        $editupmoney->POSITION_ID = $request->POSITION_ID_edit;
        $nameposition = DB::table('hrd_position')->where('HR_POSITION_ID','=',$request->POSITION_ID_edit)->first();
        $editupmoney->POSITION_IN_WORK = $nameposition->HR_POSITION_NAME;

        $editupmoney->LAVEL_ID = $request->LAVEL_ID_edit;
        $namelevel = DB::table('hrd_level')->where('HR_LEVEL_ID','=',$request->LAVEL_ID_edit)->first();
        $editupmoney->LAVEL_NAME = $namelevel->HR_LEVEL_NAME;
        $editupmoney->USER_EDIT_ID = $request->USER_EDIT_ID;
        $editupmoney->save();

            return redirect()->route('mperson.infoperson.view_upmoney',[
                'id' => $request->PERSON_ID,
            ]); 

    }
    public function desupmoney($id,$iduser) { 

        Salary::destroy($id); 
        return redirect()->route('mperson.infoperson.view_upmoney',[
            'id' => $iduser
        ]); 
           
    }




     public function viewLeadershipTeam(Request $request,$ID){

        $infoteamlistleader = Teamlist::leftjoin('hrd_team_position', 'hrd_team_position.TEAM_POSITION_ID', '=' ,'hrd_team_list.TEAM_POSITION_ID')
        ->leftjoin( 'hrd_team', 'hrd_team.HR_TEAM_ID', '=' ,'hrd_team_list.TEAM_ID')
        ->where( 'PERSON_ID', '=', $ID)
        ->get();



         return view('manager_person.infor_person.leadership_team',[
             'ID' => $ID,
             'infoteamlistleaders' => $infoteamlistleader
         ]);
     }
     public function viewSpecializedTraining(Request $request,$id){

        $infotraining= Trainspacial::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_train_spacial.ID', 'desc')  
        ->get();

         return view('manager_person.infor_person.specialized_training',[
            'id' => $id, 
            'infotrainings' => $infotraining 
        ]);
     }
     public function pecialized_training_save(Request $request){
        $checkstart= $request->DATE_BEGIN;
        $checkcon= $request->DATE_END;
 
         if($checkstart != ''){
 
            
             $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
             $date_arrary_st=explode("-",$STARTDAY);  
             $y_sub_st = $date_arrary_st[0]; 
             
             if($y_sub_st >= 2500){
                 $y_st = $y_sub_st-543;
             }else{
                 $y_st = $y_sub_st;
             }
             $m_st = $date_arrary_st[1];
             $d_st = $date_arrary_st[2];  
             $displaystartdate= $y_st."-".$m_st."-".$d_st;
          
 
             }else{
             $displaystartdate= null;
         }
         
         if($checkcon != ''){
             $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
             $date_arrary=explode("-",$CONDAY); 
             
             $y_sub = $date_arrary[0]; 
             
             if($y_sub >= 2500){
                 $y = $y_sub-543;
             }else{
                 $y = $y_sub;
             }
                
             $m = $date_arrary[1];
             $d = $date_arrary[2];  
             $condate= $y."-".$m."-".$d;
             }else{
             $condate= null;
             }
 
             $addtrain = new Trainspacial(); 
             $addtrain->PERSON_ID = $request->PERSON_ID;
             $addtrain->DATE_BEGIN = $displaystartdate;
             $addtrain->DATE_END = $condate;
             $addtrain->TRAIN_NAME = $request->TRAIN_NAME;
             $addtrain->SCHOOL_NAME = $request->SCHOOL_NAME; 
             $addtrain->USER_EDIT_ID = $request->USER_EDIT_ID;
           
             $addtrain->save();

             return redirect()->route('mperson.infoperson.view_specialized_training',[
                'id' => $request->PERSON_ID,
            ]);
     }
     public function pecialized_training_edit(Request $request){
     $id = $request->ID; 

        $checkstart= $request->DATE_BEGIN_edit;
        $checkcon= $request->DATE_END_edit;

    if($checkstart != ''){           
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        if($y_sub_st < 2500){
            $y_st = $y_sub_st;
        }else{
            $y_st = $y_sub_st-543;
        }
        
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $displaystartdate= $y_st."-".$m_st."-".$d_st;
        }else{
        $displaystartdate= null;
    }
    
    if($checkcon != ''){
        $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
        $date_arrary=explode("-",$CONDAY); 
        $y_sub = $date_arrary[0]; 
        if($y_sub < 2500){
            $y = $y_sub;    
        }else{
            $y = $y_sub-543;
        }     
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $condate= $y."-".$m."-".$d;
        }else{
        $condate= null;
        }
 
      

        $trainedit = Trainspacial::find($id);
        $trainedit->DATE_BEGIN = $displaystartdate;
        $trainedit->DATE_END = $condate;
        $trainedit->TRAIN_NAME = $request->TRAIN_NAME_edit;
        $trainedit->SCHOOL_NAME = $request->SCHOOL_NAME_edit; 
        $trainedit->USER_EDIT_ID = $request->USER_EDIT_ID;
        $trainedit->save();
        
            return redirect()->route('mperson.infoperson.view_specialized_training',[
                'id' => $request->PERSON_ID,
            ]); 

        }
        public function pecialized_training_des($id,$iduser) { 
            Trainspacial::destroy($id);

            return redirect()->route('mperson.infoperson.view_specialized_training',[
                'id' => $iduser
            ]);      
        }







     public function viewAssemblySheet(Request $request,$id){
        $infoassemblysheet= Occu::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_occu_card.ID', 'desc')  
        ->get();
        

         return view('manager_person.infor_person.assembly_sheet',[
            'id' => $id, 
            'infoassemblysheets' => $infoassemblysheet 
        ]);
     }
     public function assemblysave(Request $request){
        $checkstart= $request->DATE_RECEIVE;
        $checkcon= $request->DATE_END;
        
         if($checkstart != ''){
 
            
             $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
             $date_arrary_st=explode("-",$STARTDAY);  
             $y_sub_st = $date_arrary_st[0]; 
             
             if($y_sub_st >= 2500){
                 $y_st = $y_sub_st-543;
             }else{
                 $y_st = $y_sub_st;
             }
             $m_st = $date_arrary_st[1];
             $d_st = $date_arrary_st[2];  
             $displaystartdate= $y_st."-".$m_st."-".$d_st;
          
 
             }else{
             $displaystartdate= null;
         }
         
         if($checkcon != ''){
             $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
             $date_arrary=explode("-",$CONDAY); 
             
             $y_sub = $date_arrary[0]; 
             
             if($y_sub >= 2500){
                 $y = $y_sub-543;
             }else{
                 $y = $y_sub;
             }
                
             $m = $date_arrary[1];
             $d = $date_arrary[2];  
             $condate= $y."-".$m."-".$d;
             }else{
             $condate= null;
             }
 
             $addoccu = new Occu(); 
            $addoccu->PERSON_ID = $request->PERSON_ID;
            $addoccu->DATE_RECEIVE = $displaystartdate;
            $addoccu->DATE_END = $condate;
            $addoccu->CARD_CODE = $request->CARD_CODE;
            $addoccu->COMMENT = $request->COMMENT;
            $addoccu->USER_EDIT_ID = $request->USER_EDIT_ID;

            $addoccu->DATE_TIME_SAVE = date('Y-m-d H:i:s');
           
            $addoccu->save();
           

             return redirect()->route('mperson.infoperson.view_assembly_sheet',[
                'id' => $request->PERSON_ID,
            ]);
     }

     public function assemblyedit(Request $request)
    {

        $id = $request->ID; 
        

        $checkstart= $request->DATE_RECEIVE_edit;
        $checkcon= $request->DATE_END_edit;

    if($checkstart != ''){           
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        if($y_sub_st < 2500){
            $y_st = $y_sub_st;
        }else{
            $y_st = $y_sub_st-543;
        }
        
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $displaystartdate= $y_st."-".$m_st."-".$d_st;
        }else{
        $displaystartdate= null;
    }
    
    if($checkcon != ''){
        $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
        $date_arrary=explode("-",$CONDAY); 
        $y_sub = $date_arrary[0]; 
        if($y_sub < 2500){
            $y = $y_sub;    
        }else{
            $y = $y_sub-543;
        }     
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $condate= $y."-".$m."-".$d;
        }else{
        $condate= null;
        }
        
        $editassembly = Occu::find($id);
        $editassembly->DATE_RECEIVE = $displaystartdate;
        $editassembly->DATE_END = $condate;
        $editassembly->CARD_CODE = $request->CARD_CODE_EDIT;
        $editassembly->COMMENT = $request->EDIT_COMMENT;
        $editassembly->USER_EDIT_ID = $request->USER_EDIT_ID;
        $editassembly->save();

            return redirect()->route('mperson.infoperson.view_assembly_sheet',[
                'id' => $request->PERSON_ID,
            ]);
    }
    public function assemblydes($id,$iduser) { 
                
        Occu::destroy($id);  
        
        return redirect()->route('mperson.infoperson.view_assembly_sheet',[ 
            'id' => $iduser
        ]);  
    }

     public function viewIdCard(Request $request,$iduser){

        $inforpersonusercardidid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonusercardidid->ID;

        $inforpersonusercard =  Person::select('hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $infocard = Cid::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_cid_card.ID', 'desc')  
        ->get();

       //dd($infoeducation);
        return view('manager_person.infor_person.idcard',[
            'inforpersonusercard' => $inforpersonusercard,
            'inforpersonusercardidid' => $inforpersonusercardidid,
            'infocards' => $infocard 
        ]);
     }
     public function createcard(Request $request,$iduser)
     {
         //$email = Auth::user()->email;
         
         
         $inforpersonusercardid =  Person::where('ID','=',$iduser)->first();
         
         
         $id = $inforpersonusercardid->ID;
 
         $inforpersonusercard =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
         ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
         ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
         ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
         ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
         ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
         ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
         ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
         ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
         ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
         ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
         ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
         ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
         ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
         ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
         ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
         ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
         ->where('hrd_person.ID','=',$iduser)->first();
 
 
        //dd($infoeducation);
         return view('manager_person.infor_person.id_card_add',[
             'inforpersonusercard' => $inforpersonusercard,
             'inforpersonusercardid' => $inforpersonusercardid,

           
         ]);
        }

     public function cardsave(Request $request){


        $checkstart= $request->DATE_RECEIVE;
        $checkcon= $request->DATE_END;

        if($checkstart != ''){

           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $displaystartdate= $y_st."-".$m_st."-".$d_st;
         

            }else{
            $displaystartdate= null;
        }
        
        if($checkcon != ''){
            $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
            $date_arrary=explode("-",$CONDAY); 
            
            $y_sub = $date_arrary[0]; 
            
            if($y_sub >= 2500){
                $y = $y_sub-543;
            }else{
                $y = $y_sub;
            }
               
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $condate= $y."-".$m."-".$d;
            }else{
            $condate= null;
            }

            $addcard = new Cid(); 
            $addcard->PERSON_ID = $request->PERSON_ID;
            $addcard->CARD_CODE = $request->CARD_CODE;
       
            $addcard->DATE_RECEIVE = $displaystartdate;
            $addcard->DATE_END = $condate;
            $addcard->COMMENT = $request->COMMENT;

            $addcard->USER_EDIT_ID = $request->USER_EDIT_ID;


            if($request->hasFile('picture')){
                
                $file = $request->file('picture');  
                $contents = $file->openFile()->fread($file->getSize());
                $addcard->IMG = $contents;   

            }
       
            $addcard->save();
            
            return redirect()->route('mperson.infoperson.view_idcard',[
                'id' => $request->PERSON_ID,
            ]);

        }
        public function cardedit(Request $request,$id,$iduser)
    {
       // return $request->all();
    
       $id_in= $request->id;
       
      // dd($id_in);

      // $email = Auth::user()->email;
       $inforpersonusercid =  Person::where('ID','=',$iduser)->first();
       
      

       $inforpersonusereducat =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
       ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
       ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
       ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
       ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
       ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
       ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
       ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
       ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
       ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
       ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
       ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
       ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
       ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
       ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
       ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
       ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
       ->where('hrd_person.ID','=',$iduser)->first();

       $inforcid = Cid::where('ID','=',$id_in)
       ->first();

        return view('manager_person.infor_person.id_card_edit',[
            'inforpersonusereducat' => $inforpersonusereducat,
            'inforpersonusercid' => $inforpersonusercid,
            'inforcid' => $inforcid
        ]);

    }
    public function cardupdate(Request $request)
    {
        $id = $request->ID; 
        

        $checkstart= $request->DATE_RECEIVE;
        $checkcon= $request->DATE_END;

    if($checkstart != ''){           
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        if($y_sub_st < 2500){
            $y_st = $y_sub_st;
        }else{
            $y_st = $y_sub_st-543;
        }
        
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $displaystartdate= $y_st."-".$m_st."-".$d_st;
        }else{
        $displaystartdate= null;
    }
    
    if($checkcon != ''){
        $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
        $date_arrary=explode("-",$CONDAY); 
        $y_sub = $date_arrary[0]; 
        if($y_sub < 2500){
            $y = $y_sub;    
        }else{
            $y = $y_sub-543;
        }     
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $condate= $y."-".$m."-".$d;
        }else{
        $condate= null;
        }
 
      

        $cidedit = Cid::find($id);
        $cidedit->CARD_CODE = $request->CARD_CODE;
       
        $cidedit->DATE_RECEIVE = $displaystartdate;
        $cidedit->DATE_END = $condate;
        $cidedit->COMMENT = $request->COMMENT;

        $cidedit->USER_EDIT_ID = $request->USER_EDIT_ID;

        if($request->hasFile('picture')){
            //$newFileName = $picid.'.'.$request->picture->extension();
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $cidedit->IMG = $contents;   
            //$request->picture->storeAs('images',$newFileName,'public');
            //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
        }

    
        $cidedit->save();

        // return redirect()->route('mperson.infoperson.view_idcard',[
        //     'id' => $request->PERSON_ID,
        // ]);

        return redirect()->route('mperson.infoperson.view_idcard',[
            'id' => $request->PERSON_ID,
        ]);

    }
    public function carddes($id,$iduser) { 
                
        Cid::destroy($id);         
        //return redirect()->action('CidController@infousercid');  
        return redirect()->route('mperson.infoperson.view_idcard',[ 
            'id' => $iduser
        ]);    
    }

     public function viewVehicle(Request $request,$iduser){
        $inforpersonuservehicle =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuservehicle->ID;

        $inforpersonuservehi =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $inforvehicle = Official::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_official_card.ID', 'desc')  
        ->get();

    //    dd($inforpersonuservehi);
        return view('manager_person.infor_person.vehicle',[
            'inforpersonuservehi' => $inforpersonuservehi,
            'inforpersonuservehicle' => $inforpersonuservehicle,
            'inforvehicles' => $inforvehicle
        ]);
     }
     public function createvehicle(Request $request,$iduser)
     {
         //$email = Auth::user()->email;
         $inforpersonuserofficialid =  Person::where('ID','=',$iduser)->first();
         $id = $inforpersonuserofficialid->ID;
 
         $inforpersonusereducat =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
         ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
         ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
         ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
         ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
         ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
         ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
         ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
         ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
         ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
         ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
         ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
         ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
         ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
         ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
         ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
         ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
         ->where('hrd_person.ID','=',$iduser)->first();
 
 
        // dd($infoeducation);
         return view('manager_person.infor_person.vehicle_add',[
             'inforpersonusereducat' => $inforpersonusereducat,
             'inforpersonuserofficialid' => $inforpersonuserofficialid
           
         ]);
 
     }
     public function vehiclesave(Request $request)
    {
       // return $request->all();
    
       $checkstart= $request->DATE_RECEIVE;
       $checkcon= $request->DATE_END;

        if($checkstart != ''){

           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $displaystartdate= $y_st."-".$m_st."-".$d_st;
         

            }else{
            $displaystartdate= null;
        }
        
        if($checkcon != ''){
            $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
            $date_arrary=explode("-",$CONDAY); 
            
            $y_sub = $date_arrary[0]; 
            
            if($y_sub >= 2500){
                $y = $y_sub-543;
            }else{
                $y = $y_sub;
            }
               
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $condate= $y."-".$m."-".$d;
            }else{
            $condate= null;
            }

            $addofficial = new Official(); 
            $addofficial->PERSON_ID = $request->PERSON_ID;
            $addofficial->CARD_CODE = $request->CARD_CODE;      
            $addofficial->DATE_RECEIVE = $displaystartdate;
            $addofficial->DATE_END = $condate;
            $addofficial->COMMENT = $request->COMMENT;
            $addofficial->USER_EDIT_ID = $request->USER_EDIT_ID; 
            
            if($request->hasFile('picture')){
                //$newFileName = $picid.'.'.$request->picture->extension();
                
                $file = $request->file('picture');  
                $contents = $file->openFile()->fread($file->getSize());
                $addofficial->IMG = $contents;   
                //$request->picture->storeAs('images',$newFileName,'public');
                //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
            }

            // dd($addofficial);
         
            
            $addofficial->save();

           // dd($addedu);
            //return redirect()->action('OfficialController@infouserofficial'); 
            return redirect()->route('mperson.infoperson.view_vehicle',[ 
                'id' => $request->PERSON_ID,
            ]);

    }
    public function vehicleedit (Request $request,$id,$iduser)
    {
       // return $request->all();
    
       $id_in= $request->id;
      // dd($id_in);

      // $email = Auth::user()->email;
       $inforpersonuserofficialid =  Person::where('ID','=',$iduser)->first();
      

       $inforpersonusereducat =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
       ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
       ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
       ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
       ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
       ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
       ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
       ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
       ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
       ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
       ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
       ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
       ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
       ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
       ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
       ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
       ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
       ->where('hrd_person.ID','=',$iduser)->first();

       $inforofficial = Official::where('ID','=',$id_in)
       ->first();


        //dd($inforofficial);
        return view('manager_person.infor_person.vehicle_edit',[
        'inforpersonusereducat' => $inforpersonusereducat,
        'inforpersonuserofficialid' => $inforpersonuserofficialid,
        'inforofficial' => $inforofficial 
        ]);

    }
    public function vehicleupdate(Request $request)
    {
        $id = $request->ID; 

        $checkstart= $request->DATE_RECEIVE;
        $checkcon= $request->DATE_END;

    if($checkstart != ''){           
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        if($y_sub_st < 2500){
            $y_st = $y_sub_st;
        }else{
            $y_st = $y_sub_st-543;
        }
        
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $displaystartdate= $y_st."-".$m_st."-".$d_st;
        }else{
        $displaystartdate= null;
    }
    
    if($checkcon != ''){
        $CONDAY = Carbon::createFromFormat('d/m/Y', $checkcon)->format('Y-m-d');
        $date_arrary=explode("-",$CONDAY); 
        $y_sub = $date_arrary[0]; 
        if($y_sub < 2500){
            $y = $y_sub;    
        }else{
            $y = $y_sub-543;
        }     
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $condate= $y."-".$m."-".$d;
        }else{
        $condate= null;
        }
 
      

        $officialedit = Official::find($id);
        $officialedit->CARD_CODE = $request->CARD_CODE;      
        $officialedit->DATE_RECEIVE = $displaystartdate;
        $officialedit->DATE_END = $condate;
        $officialedit->COMMENT = $request->COMMENT;
        $officialedit->USER_EDIT_ID = $request->USER_EDIT_ID;

        if($request->hasFile('picture')){
            //$newFileName = $picid.'.'.$request->picture->extension();
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $officialedit->IMG = $contents;   
            //$request->picture->storeAs('images',$newFileName,'public');
            //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
        }
       
        //dd($educationedit);
    
        $officialedit->save();
        
            //
            //return redirect()->action('OfficialController@infouserofficial'); 
            return redirect()->route('mperson.infoperson.view_vehicle',[
                'id' => $request->PERSON_ID,
            ]);
    }
    public function vehicledes($id,$iduser) { 
                
        Official::destroy($id);         
        //return redirect()->action('OfficialController@infouserofficial'); 
        return redirect()->route('mperson.infoperson.view_vehicle',['id'=>  $iduser]);    
    }

     


     public function viewFamilyHistory(Request $request,$id){
        $infofamily= Family::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_family.ID', 'desc')  
        ->get();

         return view('manager_person.infor_person.family_history',[
            'id' => $id, 
            'infofamilys' => $infofamily 
        ]);
     }
     public function familysave(Request $request)
    {

            $savefamily = new Family(); 
            $savefamily->PERSON_ID = $request->PERSON_ID;

            $savefamily->NAME = $request->NAME;
            $savefamily->TYPE = $request->TYPE; 
            $savefamily->CID = $request->CID;
            $savefamily->ADDRESS = $request->ADDRESS;
            $savefamily->PHONE = $request->PHONE;
            $savefamily->USER_EDIT_ID = $request->USER_EDIT_ID;

            $savefamily->DATE_TIME_SAVE = date('Y-m-d H:i:s');
           
            $savefamily->save();

            return redirect()->route('mperson.infoperson.view_family_history',[ 
                'id' => $request->PERSON_ID,
            ]);

    }
    public function familyedit(Request $request)
    {

        $id = $request->ID; 


        $editfamily = Family::find($id);
        $editfamily->NAME = $request->NAME_edit;
        $editfamily->TYPE = $request->TYPE_edit; 
        $editfamily->CID = $request->CID_edit;
        $editfamily->ADDRESS = $request->ADDRESS_edit;
        $editfamily->PHONE = $request->PHONE_edit;
        $editfamily->USER_EDIT_ID = $request->USER_EDIT_ID;

        $editfamily->save();

        return redirect()->route('mperson.infoperson.view_family_history',[ 
            'id' => $request->PERSON_ID,
        ]);

    }
    public function familydes($id,$iduser) { 
                
        Family::destroy($id);     
        return redirect()->route('mperson.infoperson.view_family_history',[ 
            'id' => $iduser
        ]);  
    }

     public function viewDiscipline(Request $request,$id){
        $infodiscipline= Hrddisciplinary::where('PERSON_ID','=',$id) 
        ->orderBy('DISCIPLINARY_ID', 'desc')  
        ->get();

         return view('manager_person.infor_person.discipline',[
            'id' => $id, 
            'infodisciplines' => $infodiscipline 
        ]);
     }
     public function disciplinesave(Request $request)
    {

       $checksdate= $request->DISCIPLINARY_DATE;

       if($checksdate != ''){

           
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $checksdate)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $discipdate= $y_st."-".$m_st."-".$d_st;
     

        }else{
        $discipdate= null;
    }


            $adddiscip = new Hrddisciplinary(); 
            $adddiscip->DISCIPLINARY_DATE = $discipdate;
            $adddiscip->PERSON_ID = $request->PERSON_ID;
            $adddiscip->DISCIPLINARY_DETAIL = $request->DISCIPLINARY_DETAIL;
            $adddiscip->DISCIPLINARY_BLAME = $request->DISCIPLINARY_BLAME;
            $adddiscip->DISCIPLINARY_NUMBER = $request->DISCIPLINARY_NUMBER;
            $adddiscip->DISCIPLINARY_REMARK = $request->DISCIPLINARY_REMARK;
          
            $adddiscip->save();

            return redirect()->route('mperson.infoperson.view_discipline',[ 
                'id' => $request->PERSON_ID,
            ]);

    }
    public function disciplineedit(Request $request)
    {

        $id = $request->DISCIPLINARY_ID; 
     
       
        $checksdate= $request->DISCIPLINARY_DATE_edit;

        if($checksdate != ''){
 
            
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $checksdate)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $discipdate= $y_st."-".$m_st."-".$d_st;
      
 
         }else{
         $discipdate= null;
     }
        
        $editdiscip = Hrddisciplinary::find($id);

        // dd($discipdate);
        $editdiscip->DISCIPLINARY_DATE = $discipdate;
        $editdiscip->PERSON_ID = $request->PERSON_ID;
        $editdiscip->DISCIPLINARY_DETAIL = $request->DISCIPLINARY_DETAIL_edit;
        $editdiscip->DISCIPLINARY_BLAME = $request->DISCIPLINARY_BLAME_edit;
        $editdiscip->DISCIPLINARY_NUMBER = $request->DISCIPLINARY_NUMBER_edit;
        $editdiscip->DISCIPLINARY_REMARK = $request->DISCIPLINARY_REMARK_edit;
          
            $editdiscip->save();

            return redirect()->route('mperson.infoperson.view_discipline',[ 
                'id' => $request->PERSON_ID,
            ]);


    }
    public function disciplinedes($id,$iduser) { 
                
        Hrddisciplinary::destroy($id);         
        return redirect()->route('mperson.infoperson.view_discipline',[ 
            'id' => $iduser
        ]);   
    }

     public function viewSignature(Request $request,$iduser){
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        $inforpersonusereducat =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $inforsignal = Hrdsignature::where('PERSON_ID','=',$id)
        ->orderBy('ID', 'desc')  
        ->get();
        

       //dd($infoeducation);
        return view('manager_person.infor_person.signature',[
            'inforpersonusereducat' => $inforpersonusereducat,
            'inforpersonuserid' => $inforpersonuserid,
            'inforsignals' => $inforsignal 
        ]);
     }
     public function signaturecreate(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        $inforpersonusersignature =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();


       //dd($infoeducation);
        return view('manager_person.infor_person.signature_add',[
            'inforpersonusersignature' => $inforpersonusersignature,
            'inforpersonuserid' => $inforpersonuserid
          
        ]);

    }


    public function signaturesave(Request $request)
    {
    
     

            $addsignature = new Hrdsignature(); 
            $addsignature->PERSON_ID = $request->PERSON_ID;
            $addsignature->REMARK = $request->REMARK;      

            
            if($request->hasFile('picture')){
                $newFileName = 'signature_'.$request->PERSON_ID.'.'.$request->picture->extension();
                
                $file = $request->file('picture');  
                $contents = $file->openFile()->fread($file->getSize());
                $addsignature->IMG = $contents;   

                $request->picture->storeAs('images',$newFileName,'public');
                $addsignature->FILE_NAME = $newFileName; 
            }
         
            
            $addsignature->save();

            return redirect()->route('mperson.infoperson.view_signature',[ 
                'id' => $request->PERSON_ID,
            ]);

    }
    public function signatureedit(Request $request,$id,$iduser)
    {
        $id_in= $request->id;
      
       $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
      

       $inforpersonusereducat =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
       ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
       ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
       ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
       ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
       ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
       ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
       ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
       ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
       ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
       ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
       ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
       ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
       ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
       ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
       ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
       ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
       ->where('hrd_person.ID','=',$iduser)->first();

       $inforsignature = Hrdsignature::where('ID','=',$id_in)
       ->first();


        //dd($inforofficial);
        return view('manager_person.infor_person.signature_edit',[
        'inforpersonusereducat' => $inforpersonusereducat,
        'inforpersonuserid' => $inforpersonuserid,
        'inforsignature' => $inforsignature 
        ]);

    }
    public function signatureupdate(Request $request)
    {
     
 
      
        $id = $request->ID; 

        $editsignature = Hrdsignature::find($id);
        $editsignature->REMARK = $request->REMARK;      

            
            if($request->hasFile('picture')){
                $newFileName = 'signature_'.$request->PERSON_ID.'.'.$request->picture->extension();
                
                $file = $request->file('picture');  
                $contents = $file->openFile()->fread($file->getSize());
                $editsignature->IMG = $contents;   

                $request->picture->storeAs('images',$newFileName,'public');
                $editsignature->FILE_NAME = $newFileName; 
            }
         
            
            $editsignature->save();
        
            
            return redirect()->route('mperson.infoperson.view_signature',[ 
                'id' => $request->PERSON_ID,
            ]);
    }
    public function signaturedes($id,$iduser) { 
                
        Hrdsignature::destroy($id);         
        return redirect()->route('mperson.infoperson.view_signature',['id'=>  $iduser]);
  
    }



     //คำสั่งแนบไฟล์
     public function viewFlieperson($id){
        $infouserfile = Hrdfileperson::where('PERSON_ID','=',$id)
        ->orderBy('hrd_tr_file.ID', 'desc')  
        ->get();

        $inforpersonuserid =  Person::where('ID','=',$id)->first();

        return view('manager_person.infor-person.fileperson',[
            'infouserfile' => $infouserfile,
            'inforpersonuserid' => $inforpersonuserid,
        ]);
    }
   

    public function viewFlieperson_save(Request $request){
        $id = $request->PERSON_ID;

        $addfile = new Hrdfileperson(); 
        $addfile->PERSON_ID = $request->PERSON_ID;
        $addfile->FILE_NAME = $request->FILE_NAME;
        $addfile->DATE_SAVE = date('Y-m-d');

        if($request->hasFile('FILE_PERSON')){
            $maxid = Hrdfileperson::max('ID');
            $idfile = $maxid+1;
            $newFileName = 'fileperson_'.$idfile.'.'.$request->FILE_PERSON->extension();
            $request->FILE_PERSON->storeAs('filepreson',$newFileName,'public');
            $addfile->FILE_PERSON = $newFileName;
        }

        $addfile->save();

        return redirect()->route('manager_person.inforperson.view_fileperson',[
            'id' => $id,
        ])->with('success', "บันทึกข้อมูลเรียบร้อย");
    }

    public function viewFlieperson_update(Request $request)
    {
            $id = $request->PERSON_ID_EDIT;
            $id_file = $request->ID; 

            $updatefile = Hrdfileperson::find($id_file);
            $updatefile->PERSON_ID = $request->PERSON_ID_EDIT;
            $updatefile->FILE_NAME = $request->FILE_NAME_EDIT;

            if($request->hasFile('FILE_PERSON_EDIT')){
                $newFileName = 'fileperson_'.$id_file.'.'.$request->FILE_PERSON_EDIT->extension();
                $request->FILE_PERSON_EDIT->storeAs('filepreson',$newFileName,'public');
                $updatefile->FILE_PERSON = $newFileName;
            }

            $updatefile->save();

            return redirect()->route('manager_person.inforperson.view_fileperson',[
                'id' => $id,
            ])->with('success', "แก้ไขข้อมูลเรียบร้อย");
    }

    public function viewFlieperson_destroy($id_file,$id) { 

        Hrdfileperson::destroy($id_file);    

        return redirect()->route('manager_person.inforperson.view_fileperson',[
            'id'=>  $id
        ])->with('success', "ลบข้อมูลเรียบร้อย"); 
    }




    
}
