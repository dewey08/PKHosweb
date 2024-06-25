<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Report\MeetReportController;
use App\Models\Meetingroomarticlelist;
use App\Models\Meetingroombudget;
use App\Models\Meetingroomfoodlist;
use App\Models\Meetingroomindex;
use App\Models\Meetingroomservice;
use App\Models\Meetingroom_styleroom;
use App\Models\Permislist;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

date_default_timezone_set("Asia/Bangkok");

class ManagermeetController extends Controller
{

    public function dashboard()
    {
        $data['yearbudget'] = (date('m') > 9) ? date('Y') + 544 : date('Y') + 543;
        for ($i = 0; $i < 10; $i++) {
            $data['year_'][$i] = $data['yearbudget'] - $i;
        }
        $year_ad = getBudgetyear() - 543;
        $data['serviceroom_today']   = DB::table('meetingroom_service')->where('DATE_TIME_REQUEST','like', date('Y-m-d').'%')->count();
        $data['serviceroom_month']   = DB::table('meetingroom_service')->whereMonth('DATE_TIME_REQUEST', date('m'))->whereYear('DATE_TIME_REQUEST', date('Y'))->count();
        $data['serviceroom_year']    = DB::table('meetingroom_service')->whereBetween('DATE_TIME_REQUEST', [($year_ad - 1) . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        $totalrequest                = $data['serviceroom_year'];
        $successrequest              = DB::table('meetingroom_service')->whereBetween('SUBMIT_DATE_TIME', [($year_ad - 1) . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        $data['serviceroom_percent'] = ($totalrequest != 0) ? number_format($successrequest / $totalrequest * 100, 2) : 'N/A';
        $data['yearbudget_select']   = (empty($_GET['yearbudget_select'])) ? $data['yearbudget'] : $_GET['yearbudget_select'];
        $year                        = $data['yearbudget_select'] - 543;
        $meetreport                  = new MeetReportController();
        $data['meetingservice_m']    = $meetreport->count_meetingservice_M($year);
        $data['roomservices']        = DB::table('meetingroom_index')->get();
        foreach ($data['roomservices'] as $value) {
            $data['rooms'][$value->ROOM_ID]['name']   = $value->ROOM_NAME;
            $data['rooms'][$value->ROOM_ID]['amount'] = $meetreport->count_meetingBySubmitdate($year, $value->ROOM_ID);
        }
        $data['service_day']      = $meetreport->getServiceroomByday();
        $data['service_tomorrow'] = $meetreport->getServiceroomByday('+1day');
        
        return view('manager_meet.dashboard_meet', $data);
    }

    public function infomeet()
    {
        $infoservice = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
            ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
            ->orderBy('meetingroom_service.ID', 'desc')
            ->get();
        $inforoomindex = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
            ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
            ->leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
            ->orderBy('meetingroom_service.ID', 'desc')
            ->get();
        $infostatus = DB::table('meetingroom_service_status')->get();

        return view('manager_meet.managemeet', [
            'infoservices'   => $infoservice,
            'inforoomindexs' => $inforoomindex,
            'infostatuss'    => $infostatus

        ]);
    }

    public function meetcalendar()
    {
        if(!empty($_GET['meetroom']) && !empty($_GET['meetname']) ){
            $meetroom['id'] =  $_GET['meetroom'];
            $meetroom['name'] =  $_GET['meetname'];
        }else{
          $meetroom['id'] =  'all';
          $meetroom['name'] =  'ทั้งหมด';
        }
        $data['meetroom'] = $meetroom;
        $data['roomservices'] = DB::table('meetingroom_index')->get();
        $meetReport = new MeetReportController();
        $data['service_day']      = $meetReport->getServiceroomByday('+0day',$meetroom['id']);
        $data['service_tomorrow'] = $meetReport->getServiceroomByday('+1day',$meetroom['id']);
        $data['infoservices'] = $meetReport->getServiceroomByID($meetroom['id']);
        $data['service_month'] = $meetReport->getServiceroom_month_ByID($meetroom['id']);
        return view('manager_meet.meetcalendar', $data);
    }

    public function deatailcalendar(Request $request)
    {

        function DateThai($strDate)
        {
            $strYear  = date("Y", strtotime($strDate)) + 543;
            $strMonth = date("n", strtotime($strDate));
            $strDay   = date("j", strtotime($strDate));

            $strMonthCut  = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
            $strMonthThai = $strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear";
        }

        $infoservice = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
            ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
            ->where('meetingroom_service.ID', '=', $request->id)
            ->first();

        $output = '
          <div id="detail_meet" class="modal fade edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">

            <div class="row">
            <div><h4  style="font-family: \'Kanit\', sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;รายละเอียด&nbsp;&nbsp;' . $infoservice->SERVICE_STORY . '</h4></div>
            </div>
                </div>
                <div class="modal-body" >


                          <div class="row push" style="font-family: \'Kanit\', sans-serif;">

                                        <div class="col-sm-9">

                                            <div class="row push">
                                                <div class="col-lg-2" align="right">
                                                <label>เรื่อง :</label>
                                                </div>
                                                <div class="col-lg-8" align="left">
                                              ' . $infoservice->SERVICE_STORY . '
                                                </div>
                                            </div>
                                            <div class="row push">
                                                <div class="col-lg-2" align="right">
                                                <label>ห้อง :</label>
                                                </div>
                                                <div class="col-lg-8" align="left">
                                                ' . $infoservice->ROOM_NAME . '
                                                </div>
                                            </div>
                                            <div class="row push">
                                                <div class="col-lg-2" align="right">
                                                <label>ผู้จอง :</label>
                                                </div>
                                                <div class="col-lg-6" align="left">
                                                ' . $infoservice->PERSON_REQUEST_NAME . '
                                                </div>
                                                <div class="col-lg-1" align="right">
                                                <label>โทร :</label>
                                                </div>
                                                <div class="col-lg-3" align="left">
                                                ' . $infoservice->PERSON_REQUEST_PHONE . '
                                                </div>
                                            </div>
                                            <div class="row push">
                                                <div class="col-lg-2" align="right">
                                                <label>วันที่จอง :</label>
                                                </div>
                                                <div class="col-lg-6" align="left">
                                                ' . DateThai($infoservice->DATE_BEGIN) . '
                                                </div>
                                                <div class="col-lg-1" align="right">
                                                <label>เวลา :</label>
                                                </div>
                                                <div class="col-lg-3" align="left">
                                                ' . date("H:i", strtotime("$infoservice->TIME_BEGIN")) . '
                                                </div>
                                            </div>
                                            <div class="row push">
                                            <div class="col-lg-2" align="right">
                                            <label>ถึงวันที่ :</label>
                                            </div>
                                            <div class="col-lg-6" align="left">
                                            ' . DateThai($infoservice->DATE_END) . '
                                            </div>
                                            <div class="col-lg-1" align="right">
                                            <label>เวลา :</label>
                                            </div>
                                            <div class="col-lg-3" align="left">
                                            ' . date("H:i", strtotime("$infoservice->TIME_END")) . '
                                            </div>
                                        </div>

                                        </div>

                                        <div class="col-sm-3">

                                        <div class="form-group">
                                        <img src="data:image/png;base64,' . chunk_split(base64_encode($infoservice->IMG1)) . '"  height="200px" width="200px"/>
                                        </div>

                                        </div>
                            </div>
                            <BR>




                </div>
                <div class="modal-footer">
                <div align="right">

                <button type="button" class="btn btn-hero-sm btn-hero-danger" data-dismiss="modal" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;">ปิดหน้าต่าง</button>
                </div>
                </div>
                </form>
        </body>


            </div>
          </div>
        </div>
          ';

        echo $output;
    }

    //========================================================================

    public static function checkver($id_user)
    {
        $count = Permislist::where('PERSON_ID', '=', $id_user)
            ->where('PERMIS_ID', '=', 'GME001')
            ->count();

        return $count;
    }

    public static function countver($id_user)
    {
        $count = Meetingroomservice::where('STATUS', '=', 'REQUEST')
            ->count();
        return $count;
    }

    public function infomeetcheck(Request $request)
    {
        if(!empty($request->_token)){
            $search     = $request->get('search');
            $status     = $request->STATUS_CODE;
            $datebigin  = $request->get('DATE_BIGIN');
            $dateend    = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            session([
                'manager_meet.managemeetcheck.search' => $search,
                'manager_meet.managemeetcheck.status' => $status,
                'manager_meet.managemeetcheck.datebigin' => $datebigin,
                'manager_meet.managemeetcheck.dateend' => $dateend,
                'manager_meet.managemeetcheck.yearbudget' => $yearbudget,
            ]);
        }elseif(!empty(session('manager_meet.managemeetcheck'))){
            $search = session('manager_meet.managemeetcheck.search');
            $status = session('manager_meet.managemeetcheck.status');
            $datebigin = session('manager_meet.managemeetcheck.datebigin');
            $dateend = session('manager_meet.managemeetcheck.dateend');
            $yearbudget = session('manager_meet.managemeetcheck.yearbudget');
        }else{
            $search = '';
            $status = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
            $yearbudget = getBudgetyear();
        }
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

        $date              = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks   = strtotime($displaydate_end);
        $dates             = strtotime($date);

        $from = date($displaydate_bigen);
        $to   = date($displaydate_end);

        if ($status == null) {

            $inforoomindex = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
                ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
                ->leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
                ->where(function ($q) use ($search) {
                    $q->where('ROOM_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('SERVICE_STORY', 'like', '%' . $search . '%');
                })
                ->WhereBetween('DATE_BEGIN', [$from, $to])
                ->orderBy('meetingroom_service.ID', 'desc')
                ->get();

        } elseif ($status == 'REANDFORM') {

            $inforoomindex = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
                ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
                ->leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
                ->where(function ($q) use ($search) {
                    $q->where('ROOM_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('SERVICE_STORY', 'like', '%' . $search . '%');
                })
                ->where('meetingroom_service.STATUS', '=', 'REQUEST')
                ->orwhere('meetingroom_service.STATUS', '=', 'INFORM')
                ->WhereBetween('DATE_BEGIN', [$from, $to])
                ->orderBy('meetingroom_service.ID', 'desc')
                ->get();

        } else {

            $inforoomindex = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
                ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
                ->leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
                ->where(function ($q) use ($search) {
                    $q->where('ROOM_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('SERVICE_STORY', 'like', '%' . $search . '%');
                })
                ->where('STATUS', '=', $status)
                ->WhereBetween('DATE_BEGIN', [$from, $to])
                ->orderBy('meetingroom_service.ID', 'desc')
                ->get();

        }

        $budget     = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id    = $yearbudget;
        $infostatus = DB::table('meetingroom_service_status')->get();

        return view('manager_meet.managemeetcheck', [
            'inforoomindexs'    => $inforoomindex,
            'infostatuss'       => $infostatus,
            'budgets'           => $budget,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'year_id'           => $year_id
        ]);
    }

    function managemeet_pdfmeet(Request $request,$id)
{
    $orgname =  DB::table('info_org')
    ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $leader =  DB::table('gleave_leader')
    ->leftJoin('hrd_person','gleave_leader.LEADER_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $budgetyear = DB::table('budget_year')->where('ACTIVE', '=', true)->get();

    $infoobjective = DB::table('meetingroom_objective')->get();
    $infotime      = DB::table('meetingroom_time')->get();
    $infoarticle   = DB::table('meetingroom_article')->get();
  
    $infofood      = DB::table('meetingroom_food')->get();
    $infofoodtime  = DB::table('meetingroom_food_time')->get();

    $inforoomservice = Meetingroomservice::leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
    ->leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
        ->where('ID', '=', $id)->first();


    $articlelist   = DB::table('meetingroom_article_list')->leftJoin('meetingroom_article', 'meetingroom_article.ARTICLE_ID', '=', 'meetingroom_article_list.ARTICLE_ID')->where('SERVICE_ID', '=', $id)->get();
    $countinfoequipment = DB::table('meetingroom_article_list')->where('SERVICE_ID', '=', $id)->count();

    $infofoodlist      = DB::table('meetingroom_food_list')
    ->leftJoin('meetingroom_food', 'meetingroom_food.FOOD_ID', '=', 'meetingroom_food_list.FOOD_ID')
    ->leftJoin('meetingroom_food_time', 'meetingroom_food_time.FOOD_TIME_ID', '=', 'meetingroom_food_list.FOOD_TIME_ID')
    ->where('SERVICE_ID', '=', $id)->get();

    $countinfofoodlist = DB::table('meetingroom_food_list')->where('SERVICE_ID', '=', $id)->count();
    $infoequipment     = DB::table('meetingroom_equipment')->where('ROOM_ID', '=', $id)->get();

    $mbbudget = DB::table('meetingroom_budget')->where('SERVICE_ID', '=', $id)->get();

    $inforoom   = DB::table('meetingroom_index')
    ->leftJoin('hrd_person','meetingroom_index.ROOM_PERSON_ID','=','hrd_person.ID')
    ->leftJoin('hrd_position','hrd_position.HR_POSITION_ID','=','hrd_person.HR_POSITION_ID')
    ->where('ROOM_ID', '=', $inforoomservice->ROOM_ID)->first();

    $infoper = DB::table('meetingroom_index')
    ->leftJoin('hrd_person','meetingroom_index.ROOM_PERSON_ID','=','hrd_person.ID')
    ->leftJoin('hrd_position','hrd_position.HR_POSITION_ID','=','hrd_person.HR_POSITION_ID')
    ->where('ROOM_ID', '=', $inforoomservice->ROOM_ID)->get();

    $checksigno = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->first();
    $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();

    $debsub =  DB::table('hrd_department_sub')
    ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
    ->first();

    $siginsub = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$debsub->LEADER_HR_ID)->first();
    $siginpo = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
    $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$leader->LEADER_ID)->first();
    $siginper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforoomservice->PERSON_REQUEST_ID)->first();
    $siginadper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforoom->ROOM_PERSON_ID)->first();

    if($siginsub !== null){
        $sigsub =  $siginsub->FILE_NAME;
    }else{ $sigsub = '';}

    if($siginpo !== null){
        $sigpo =  $siginpo->FILE_NAME;
    }else{ $sigpo = '';}

    if($sigin !== null){
        $sig =  $sigin->FILE_NAME;
    }else{ $sig = '';}

    if($siginper !== null){
        $sigpe =  $siginper->FILE_NAME;
    }else{ $sigpe = '';}

    if($siginadper !== null){
        $siginad =  $siginadper->FILE_NAME;
    }else{ $siginad = '';}

    $pdf = PDF::loadView('manager_meet.managemeet_pdfmeet',[
        'idroom'             => $id,
        'inforooms'          => $inforoom,
        'budgetyears'        => $budgetyear,
        'infotimes'          => $infotime,
        'infoobjectives'     => $infoobjective,
        'infoarticles'       => $infoarticle,
        'infofoods'          => $infofood,
        'infofoodtimes'      => $infofoodtime,
        'infoequipments'     => $infoequipment,
        'infofoodlists'      => $infofoodlist,
        'inforoomservice'    => $inforoomservice,
        'countinfoequipment' => $countinfoequipment,
        'articlelist'        => $articlelist,
        'countinfofoodlist'  => $countinfofoodlist,
        'mbbudgets'          => $mbbudget,
        'orgname' => $orgname,
        'checksig' => $checksig,
        'checksigno' => $checksigno,
        'sig' => $sig,
        'sigpo' => $sigpo,
        'sigpe' => $sigpe,
        'sigsub' => $sigsub,
        'siginad' => $siginad,
        'leader' => $leader,
        'infoper'=> $infoper,
        ]);
        return @$pdf->stream();
    }


    public function infomeetchecklast(Request $request, $id)
    {

        $inforoomindex = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
            ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
            ->leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
            ->where('meetingroom_service.ID', '=', $id)
            ->first();

        $infostatus = DB::table('meetingroom_service_status')->get();

        return view('manager_meet.managemeetchecklast', [
             'inforoomindex' => $inforoomindex,
            'infostatuss'   => $infostatus,
            'inforecordid'  => $id
        ]);
    }

    public function managemeet_infomeet(Request $request)
    {

        $inforoomindex = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
            ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
            ->leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
            ->get();

        $infostatus = DB::table('meetingroom_service_status')->get();

        $inforoom = Meetingroomindex::where('ROOM_STATUS_ID', '=', '1')
            ->orderBy('ROOM_ID', 'asc')
            ->get();

        return view('manager_meet.managemeet_infomeet', [
            'inforoomindex' => $inforoomindex,
            'infostatuss'   => $infostatus,
            'inforooms'     => $inforoom
        ]);
    }

    public function managemeet_addmeet(Request $request,$idroom,$iduser)
    {
        
        $inforpersonuserid = Person::where('ID', '=', $iduser)->first();
        $id                = $inforpersonuserid->ID;

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

        $infostatus = DB::table('meetingroom_service_status')->get();

        $inforoom   = DB::table('meetingroom_index')->get();
        $budgetyear = DB::table('budget_year')->where('ACTIVE', '=', true)->get();

        $infoobjective = DB::table('meetingroom_objective')->get();
        $infotime      = DB::table('meetingroom_time')->get();
        $infoarticle   = DB::table('meetingroom_article')->get();
        $infofood      = DB::table('meetingroom_food')->get();
        $infofoodtime  = DB::table('meetingroom_food_time')->get();
        $infoequipment = DB::table('meetingroom_equipment')->where('ROOM_ID', '=', $idroom)->get();

        $testSql = DB::table('meetingroom_service')->where('id', '=', $iduser)->first();
        $person_request_id = $testSql->PERSON_REQUEST_ID;

        $selectStyles = DB::table('meetingroom_service')->leftJoin('meetingroom_stylerooms', 'meetingroom_service.ROOM_STYLEROOM_ID' ,'=', 'meetingroom_stylerooms.id')
        ->where('PERSON_REQUEST_ID', '=' ,$person_request_id)->first();

        $style_rooms = DB::table('meetingroom_stylerooms')->where('STYLEROOM_STATUS', '=', 'true')->get();
  


        
        return view('manager_meet.managemeet_addmeet', [
            'inforpersonuser'   => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforooms'         => $inforoom,
            'infostatuss'       => $infostatus,
            'budgetyears'       => $budgetyear,
            'infotimes'         => $infotime,
            'infoobjectives'    => $infoobjective,
            'infoarticles'      => $infoarticle,
            'infofoods'         => $infofood,
            'infofoodtimes'     => $infofoodtime,
            'infoequipments'    => $infoequipment,
            'idroom'            => $idroom,
            'iduser'            => $iduser,
            'style_rooms'       => $style_rooms
        ]);
    }

    public function managemeet_save(Request $request)
    {

        function DateThai($strDate)
        {
            $strYear  = date("Y", strtotime($strDate)) + 543;
            $strMonth = date("n", strtotime($strDate));
            $strDay   = date("j", strtotime($strDate));

            $strMonthCut  = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
            $strMonthThai = $strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear";
        }

        $DATE_BEGIN = $request->DATE_BEGIN;

        if ($DATE_BEGIN != '') {

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $DATE_BEGIN)->format('Y-m-d');
            $date_arrary  = explode("-", $date_bigen_c);

            $y_sub_g = $date_arrary[0];

            if ($y_sub_g >= 2500) {
                $y = $y_sub_g - 543;
            } else {
                $y = $y_sub_g;
            }

            $m          = $date_arrary[1];
            $d          = $date_arrary[2];
            $DATE_BEGIN = $y . "-" . $m . "-" . $d;
        } else {
            $DATE_BEGIN = null;
        }

        $DATE_END = $request->DATE_END;

        if ($DATE_END != '') {

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $DATE_END)->format('Y-m-d');
            $date_arrary  = explode("-", $date_bigen_c);

            $y_sub_g = $date_arrary[0];

            if ($y_sub_g >= 2500) {
                $y = $y_sub_g - 543;
            } else {
                $y = $y_sub_g;
            }

            $m        = $date_arrary[1];
            $d        = $date_arrary[2];
            $DATE_END = $y . "-" . $m . "-" . $d;
        } else {
            $DATE_END = null;
        }

        //=======เช็คบันทึกซ้ำ
        $checkloopsave = DB::table('meetingroom_service')
            ->where('PERSON_REQUEST_ID', '=', $request->PERSON_REQUEST_ID)
            ->where('DATE_TIME_REQUEST', '=', $request->DATE_TIME_REQUEST)
            ->count();

        if ($checkloopsave == 0) {

            $addroomservice                    = new Meetingroomservice();
            $addroomservice->DATE_TIME_REQUEST = $request->DATE_TIME_REQUEST;
            $addroomservice->SERVICE_STORY     = $request->SERVICE_STORY;
            $addroomservice->YEAR_ID           = $request->YEAR_ID;
            $addroomservice->GROUP_FOCUS       = $request->GROUP_FOCUS;
            $addroomservice->TOTAL_PEOPLE      = $request->TOTAL_PEOPLE;
            $addroomservice->ROOM_ID           = $request->ROOM_ID;

            $addroomservice->SERVICE_FOR = $request->SERVICE_FOR;

            $addroomservice->TIME_SC_ID = $request->TIME_SC_ID;

            $addroomservice->TIME_BEGIN = $request->TIME_BEGIN;
            $addroomservice->TIME_END   = $request->TIME_END;

            $addroomservice->DATE_BEGIN = $DATE_BEGIN;
            $addroomservice->DATE_END   = $DATE_END;

            $addroomservice->PERSON_REQUEST_PHONE = $request->PERSON_REQUEST_PHONE;

            $addroomservice->PERSON_REQUEST_ID       = $request->PERSON_REQUEST_ID;
            $addroomservice->PERSON_REQUEST_NAME     = $request->PERSON_REQUEST_NAME;
            $addroomservice->PERSON_REQUEST_POSITION = $request->PERSON_REQUEST_POSITION;
            $addroomservice->PERSON_REQUEST_DEP      = $request->PERSON_REQUEST_DEP;
            $addroomservice->STATUS                  = 'REQUEST';
            $addroomservice->ROOM_STYLEROOM_NAME     = $request->STYLEROOM_NAME;
            $addroomservice->ROOM_STYLEROOM_DETAIL     = $request->STYLEROOM_DETAIL;

            $addroomservice->save();

            $idservice = Meetingroomservice::max('ID');

            if ($request->FOOD_ID != '' || $request->FOOD_ID != null) {

                $FOOD_ID      = $request->FOOD_ID;
                $FOOD_TIME_ID = $request->FOOD_TIME_ID;
                $FOOD_TOTAL   = $request->FOOD_TOTAL;

                $number_1 = count($FOOD_ID);
                $count_1  = 0;

                for ($count_1 = 0; $count_1 < $number_1; $count_1++) {
                    $foodid = $FOOD_ID[$count_1];

                    $infofood = DB::table('meetingroom_food')->where('FOOD_ID', '=', $foodid)->first();

                    $add_1               = new Meetingroomfoodlist();
                    $add_1->SERVICE_ID   = $idservice;
                    $add_1->FOOD_ID      = $foodid;
                    $add_1->TOTAL        = $FOOD_TOTAL[$count_1];
                    $add_1->FOOD_PRICE   = $infofood->FOOD_PRICE;
                    $add_1->FOOD_UNIT    = $infofood->FOOD_UNIT;
                    $add_1->FOOD_TYPE_ID = $infofood->FOOD_TYPE_ID;
                    $add_1->FOOD_TIME_ID = $FOOD_TIME_ID[$count_1];

                    $add_1->save();

                }

            }

            if ($request->ARTICLE_ID != '' || $request->ARTICLE_ID != null) {

                $ARTICLE_ID    = $request->ARTICLE_ID;
                $ARTICLE_TOTAL = $request->ARTICLE_TOTAL;

                $number_2 = count($ARTICLE_ID);
                $count_2  = 0;
                for ($count_2 = 0; $count_2 < $number_2; $count_2++) {

                    $add_2             = new Meetingroomarticlelist();
                    $add_2->SERVICE_ID = $idservice;
                    $add_2->ARTICLE_ID = $ARTICLE_ID[$count_2];
                    $add_2->TOTAL      = $ARTICLE_TOTAL[$count_2];

                    $add_2->save();

                }
            }

            if ($request->MB_NAME != '' || $request->MB_NAME != null) {
                $MB_NAME  = $request->MB_NAME;
                $MB_PRICE = $request->MB_PRICE;

                $number_5 = count($MB_NAME);
                $count_5  = 0;
                for ($count_5 = 0; $count_5 < $number_5; $count_5++) {

                    $add_2             = new Meetingroombudget();
                    $add_2->SERVICE_ID = $idservice;
                    $add_2->MB_NAME    = $MB_NAME[$count_5];
                    $add_2->MB_PRICE   = $MB_PRICE[$count_5];
                    $add_2->save();
                }
            }

            $inforoom = DB::table('meetingroom_index')->where('ROOM_ID', '=', $request->ROOM_ID)->first();

            $header       = "ระบบจองห้องประชุม";
            $servicestory = $request->SERVICE_STORY;
            $roomname     = $inforoom->ROOM_NAME;
            $person       = $request->PERSON_REQUEST_NAME;
            $groupfocus   = $request->GROUP_FOCUS;
            $totalpeopel  = $request->TOTAL_PEOPLE . ' คน';
            $datebegin    = DateThai($DATE_BEGIN) . ' ' . date("H:i", strtotime("$request->TIME_BEGIN"));
            $dateend      = DateThai($DATE_END) . ' ' . date("H:i", strtotime("$request->TIME_END"));

            $message = $header .
                "\n" . "เรื่อง : " . $servicestory .
                "\n" . "ห้อง : " . $roomname .
                "\n" . "ผู้จอง : " . $person .
                "\n" . "ผู้เข้าประชุม : " . $groupfocus .
                "\n" . "จำนวน : " . $totalpeopel .
                "\n" . "วันที่จอง : " . $datebegin .
                "\n" . "ถึงวันที่ : " . $dateend;

            $name = DB::table('line_token')->where('ID_LINE_TOKEN', '=', 1)->first();

            $test = $name->LINE_TOKEN;

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

        }

        return redirect()->route('meeting.informeetcheck');
    }

//----------------------------แก้ไข--------------------------
    public function managemeet_editmeet(Request $request, $id)
    {

        $inforoom   = DB::table('meetingroom_index')->get();
        $budgetyear = DB::table('budget_year')->where('ACTIVE', '=', true)->get();

        $infoobjective = DB::table('meetingroom_objective')->get();
        $infotime      = DB::table('meetingroom_time')->get();
        $infoarticle   = DB::table('meetingroom_article')->get();
        $articlelist   = DB::table('meetingroom_article_list')->where('SERVICE_ID', '=', $id)->get();
        $infofood      = DB::table('meetingroom_food')->get();
        $infofoodtime  = DB::table('meetingroom_food_time')->get();

        $inforoomservice = Meetingroomservice::leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
            ->where('ID', '=', $id)->first();

        $countinfoequipment = DB::table('meetingroom_article_list')->where('SERVICE_ID', '=', $id)->count();

        $infofoodlist      = DB::table('meetingroom_food_list')->where('SERVICE_ID', '=', $id)->get();
        $countinfofoodlist = DB::table('meetingroom_food_list')->where('SERVICE_ID', '=', $id)->count();
        $infoequipment     = DB::table('meetingroom_equipment')->where('ROOM_ID', '=', $id)->get();

        $mbbudget = DB::table('meetingroom_budget')->where('SERVICE_ID', '=', $id)->get();

        $testSql = DB::table('meetingroom_service')->where('id', '=', $id)->first();
        $person_request_id = $testSql->PERSON_REQUEST_ID;

        $selectStyles = DB::table('meetingroom_service')->leftJoin('meetingroom_stylerooms', 'meetingroom_service.ROOM_STYLEROOM_ID' ,'=', 'meetingroom_stylerooms.id')
        ->where('PERSON_REQUEST_ID', '=' ,$person_request_id)->first();

        $style_rooms = DB::table('meetingroom_stylerooms')->where('STYLEROOM_STATUS', '=', 'true')->get();


        return view('manager_meet.managemeet_editmeet', [
            'idroom'             => $id,
            'inforooms'          => $inforoom,
            'budgetyears'        => $budgetyear,
            'infotimes'          => $infotime,
            'infoobjectives'     => $infoobjective,
            'infoarticles'       => $infoarticle,
            'infofoods'          => $infofood,
            'infofoodtimes'      => $infofoodtime,
            'infoequipments'     => $infoequipment,
            'infofoodlists'      => $infofoodlist,
            'inforoomservice'    => $inforoomservice,
            'countinfoequipment' => $countinfoequipment,
            'articlelist'        => $articlelist,
            'countinfofoodlist'  => $countinfofoodlist,
            'mbbudgets'          => $mbbudget,
            'style_rooms'        => $style_rooms,
            'selectStyles'       => $selectStyles
        ]);
    }

    public function managemeet_update(Request $request)
    {

        $idservice = $request->ID_SERVICE;

        $DATE_BEGIN = $request->DATE_BEGIN;
        if ($DATE_BEGIN != '') {

            $GIVEDAY       = Carbon::createFromFormat('d/m/Y', $DATE_BEGIN)->format('Y-m-d');
            $date_arrary_g = explode("-", $GIVEDAY);
            $y_sub_g       = $date_arrary_g[0];

            if ($y_sub_g >= 2500) {
                $y_g = $y_sub_g - 543;
            } else {
                $y_g = $y_sub_g;
            }
            $m_g        = $date_arrary_g[1];
            $d_g        = $date_arrary_g[2];
            $DATE_BEGIN = $y_g . "-" . $m_g . "-" . $d_g;

        } else {
            $DATE_BEGIN = null;
        }

        $DATE_END = $request->DATE_END;
        if ($DATE_END != '') {

            $GIVEDAY       = Carbon::createFromFormat('d/m/Y', $DATE_END)->format('Y-m-d');
            $date_arrary_g = explode("-", $GIVEDAY);
            $y_sub_g       = $date_arrary_g[0];

            if ($y_sub_g >= 2500) {
                $y_g = $y_sub_g - 543;
            } else {
                $y_g = $y_sub_g;
            }
            $m_g      = $date_arrary_g[1];
            $d_g      = $date_arrary_g[2];
            $DATE_END = $y_g . "-" . $m_g . "-" . $d_g;

        } else {
            $DATE_END = null;
        }

        $updateroomservice                = Meetingroomservice::find($idservice);
        $updateroomservice->SERVICE_STORY = $request->SERVICE_STORY;
        $updateroomservice->YEAR_ID       = $request->YEAR_ID;
        $updateroomservice->GROUP_FOCUS   = $request->GROUP_FOCUS;
        $updateroomservice->TOTAL_PEOPLE  = $request->TOTAL_PEOPLE;
        $updateroomservice->ROOM_ID       = $request->ROOM_ID;
        $updateroomservice->SERVICE_FOR   = $request->SERVICE_FOR;
        $updateroomservice->TIME_SC_ID    = $request->TIME_SC_ID;

        $updateroomservice->TIME_BEGIN = $request->TIME_BEGIN;
        $updateroomservice->TIME_END   = $request->TIME_END;

        $updateroomservice->DATE_BEGIN = $DATE_BEGIN;
        $updateroomservice->DATE_END   = $DATE_END;

        $updateroomservice->PERSON_REQUEST_PHONE = $request->PERSON_REQUEST_PHONE;

        $updateroomservice->PERSON_REQUEST_ID       = $request->PERSON_REQUEST_ID;
        $updateroomservice->PERSON_REQUEST_NAME     = $request->PERSON_REQUEST_NAME;
        $updateroomservice->PERSON_REQUEST_POSITION = $request->PERSON_REQUEST_POSITION;
        $updateroomservice->PERSON_REQUEST_DEP      = $request->PERSON_REQUEST_DEP;
        $updateroomservice->ROOM_STYLEROOM_NAME     = $request->ROOM_STYLEROOM_NAME;
        $updateroomservice->ROOM_STYLEROOM_DETAIL   = $request->ROOM_STYLEROOM_DETAIL;
        $updateroomservice->save();

        Meetingroomfoodlist::where('SERVICE_ID', '=', $idservice)->delete();

        if ($request->FOOD_ID != '' || $request->FOOD_ID != null) {

            $FOOD_ID      = $request->FOOD_ID;
            $FOOD_TIME_ID = $request->FOOD_TIME_ID;
            $FOOD_TOTAL   = $request->FOOD_TOTAL;

            $number_1 = count($FOOD_ID);
            $count_1  = 0;

            for ($count_1 = 0; $count_1 < $number_1; $count_1++) {
                $foodid = $FOOD_ID[$count_1];

                $infofood = DB::table('meetingroom_food')->where('FOOD_ID', '=', $foodid)->first();

                $add_1               = new Meetingroomfoodlist();
                $add_1->SERVICE_ID   = $idservice;
                $add_1->FOOD_ID      = $foodid;
                $add_1->TOTAL        = $FOOD_TOTAL[$count_1];
                $add_1->FOOD_PRICE   = $infofood->FOOD_PRICE;
                $add_1->FOOD_UNIT    = $infofood->FOOD_UNIT;
                $add_1->FOOD_TYPE_ID = $infofood->FOOD_TYPE_ID;
                $add_1->FOOD_TIME_ID = $FOOD_TIME_ID[$count_1];
                $add_1->save();
            }
        }

        Meetingroomarticlelist::where('SERVICE_ID', '=', $idservice)->delete();

        if ($request->ARTICLE_ID != '' || $request->ARTICLE_ID != null) {
            $ARTICLE_ID    = $request->ARTICLE_ID;
            $ARTICLE_TOTAL = $request->ARTICLE_TOTAL;

            $number_3 = count($ARTICLE_ID);
            $count_3  = 0;
            for ($count_3 = 0; $count_3 < $number_3; $count_3++) {

                $add_3             = new Meetingroomarticlelist();
                $add_3->SERVICE_ID = $idservice;
                $add_3->ARTICLE_ID = $ARTICLE_ID[$count_3];
                $add_3->TOTAL      = $ARTICLE_TOTAL[$count_3];

                $add_3->save();

            }

        }
        Meetingroombudget::where('SERVICE_ID', '=', $idservice)->delete();

        if ($request->MB_NAME != '' || $request->MB_NAME != null) {
            $MB_NAME  = $request->MB_NAME;
            $MB_PRICE = $request->MB_PRICE;

            $number_5 = count($MB_NAME);
            $count_5  = 0;
            for ($count_5 = 0; $count_5 < $number_5; $count_5++) {

                $add_2             = new Meetingroombudget();
                $add_2->SERVICE_ID = $idservice;
                $add_2->MB_NAME    = $MB_NAME[$count_5];
                $add_2->MB_PRICE   = $MB_PRICE[$count_5];
                $add_2->save();
            }
        }

        return redirect()->route('meeting.informeetcheck');

    }

    public function infomeetsearch(Request $request)
    {
        $search     = $request->get('search');
        $status     = $request->STATUS_CODE;
        $datebigin  = $request->get('DATE_BIGIN');
        $dateend    = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if ($search == '') {
            $search = "";
        }

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

        $date              = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks   = strtotime($displaydate_end);
        $dates             = strtotime($date);

        $from = date($displaydate_bigen);
        $to   = date($displaydate_end);

        if ($status == null) {

            $inforoomindex = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
                ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
                ->leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
                ->where(function ($q) use ($search) {
                    $q->where('ROOM_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('SERVICE_STORY', 'like', '%' . $search . '%');
                })
                ->WhereBetween('DATE_BEGIN', [$from, $to])
                ->orderBy('meetingroom_service.ID', 'desc')
                ->get();

        } elseif ($status == 'REANDFORM') {

            $inforoomindex = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
                ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
                ->leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
                ->where(function ($q) use ($search) {
                    $q->where('ROOM_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('SERVICE_STORY', 'like', '%' . $search . '%');
                })
                ->where('meetingroom_service.STATUS', '=', 'REQUEST')
                ->orwhere('meetingroom_service.STATUS', '=', 'INFORM')
                ->WhereBetween('DATE_BEGIN', [$from, $to])
                ->orderBy('meetingroom_service.ID', 'desc')
                ->get();

        } else {

            $inforoomindex = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
                ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
                ->leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
                ->where(function ($q) use ($search) {
                    $q->where('ROOM_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('SERVICE_STORY', 'like', '%' . $search . '%');
                })
                ->where('STATUS', '=', $status)
                ->WhereBetween('DATE_BEGIN', [$from, $to])
                ->orderBy('meetingroom_service.ID', 'desc')
                ->get();

        }

        $budget     = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id    = $yearbudget;
        $infostatus = DB::table('meetingroom_service_status')->get();

        return view('manager_meet.managemeetcheck', [
            'inforoomindexs'    => $inforoomindex,
            'infostatuss'       => $infostatus,
            'budgets'           => $budget,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'year_id'           => $year_id

        ]);
    }

    public function meet(Request $request, $id)
    {
        $inforoomindex = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
            ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
            ->leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
            ->where('meetingroom_service.ID', '=', $id)
            ->first();

        return view('manager_meet/managemeetcheck', [
            'inforoomindex' => $inforoomindex,
            'inforecordid'  => $id
        ]);
    }

    public function updatemeet(Request $request)
    {

        function DateThai($strDate)
        {
            $strYear  = date("Y", strtotime($strDate)) + 543;
            $strMonth = date("n", strtotime($strDate));
            $strDay   = date("j", strtotime($strDate));

            $strMonthCut  = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
            $strMonthThai = $strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear";
        }

        $id    = $request->ID;
        $check = $request->SUBMIT;
        if ($check == 'approved') {
            $statuscode = 'SUCCESS';
            $textresult = 'จัดสรร';
        } else {
            $statuscode = 'NOTSUCCESS';
            $textresult = 'ไม่จัดสรร';
        }

        $updatever                 = Meetingroomservice::find($id);
        $updatever->SUBMIT_COMMENT = $request->SUBMIT_COMMENT;
        $updatever->STATUS         = $statuscode;

        $updatever->SUBMIT_PERSON_ID = $request->PERSON_ID;
        $addinforperson              = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->where('hrd_person.ID', '=', $request->PERSON_ID)->first();

        $updatever->SUBMIT_DATE_TIME = date('Y-m-d H:i:s');

        $updatever->save();

//-----------------------แจ้งเตือนผู้ขอจอง
        $inforoomservice = DB::table('meetingroom_service')->where('ID', '=', $id)->first();

        $inforoom = DB::table('meetingroom_index')->where('ROOM_ID', '=', $inforoomservice->ROOM_ID)->first();

        $header       = "การจองห้องประชุม";
        $servicestory = $inforoomservice->SERVICE_STORY;
        $roomname     = $inforoom->ROOM_NAME;
        $person       = $inforoomservice->PERSON_REQUEST_NAME;
        $groupfocus   = $inforoomservice->GROUP_FOCUS;
        $totalpeopel  = $inforoomservice->TOTAL_PEOPLE . ' คน';
        $datebegin    = DateThai($inforoomservice->DATE_BEGIN) . ' ' . date("H:i", strtotime("$inforoomservice->TIME_BEGIN"));
        $dateend      = DateThai($inforoomservice->DATE_END) . ' ' . date("H:i", strtotime("$inforoomservice->TIME_END"));

        $name = DB::table('hrd_person')->where('ID', '=', $inforoomservice->PERSON_REQUEST_ID)->first();
        if($name == null){
            $test = '';
         }else{
            $test =$name->HR_LINE;
         }
   


        $products =DB::table('meetingroom_article_list')
        ->leftjoin('meetingroom_article','meetingroom_article.ARTICLE_ID','=','meetingroom_article_list.ARTICLE_ID')
        ->where('SERVICE_ID','=', $id)->get();
    
        $foods =DB::table('meetingroom_food_list')
        ->leftjoin('meetingroom_food','meetingroom_food.FOOD_ID','=','meetingroom_food_list.FOOD_ID')
        ->where('SERVICE_ID','=', $id)->get();
 
        

        $message = $header .
            "\n" . "เรื่อง : " . $servicestory .
            "\n" . "ห้อง : " . $roomname .
            "\n" . "ผู้จอง : " . $person .
            "\n" . "ผู้เข้าประชุม : " . $groupfocus .
            "\n" . "จำนวน : " . $totalpeopel .
            "\n" . "วันที่จอง : " . $datebegin .
            "\n" . "ถึงวันที่ : " . $dateend .
            "\n" . "ผลการอนุมัติ : " . $textresult.
            "\n" .  "อุปกรณ์ : "; 
            foreach ($products as $product){ 
                $message.="\n"." - " . $product->ARTICLE_NAME ." จำนวน ".$product->TOTAL;
                    }
                $message.="\n"."อาหาร : "; 
                foreach ($foods as $food){ 
                $message.="\n"." - " . $food->FOOD_NAME ." จำนวน ".$food->TOTAL." ".$food->FOOD_UNIT;
                }

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


        $name_group = DB::table('line_token')->where('ID_LINE_TOKEN','=',1)->first();        
        $sending =$name_group->LINE_TOKEN;
  
  $chOne_2 = curl_init();
  curl_setopt( $chOne_2, CURLOPT_URL, "https://notify-api.line.me/api/notify");
  curl_setopt( $chOne_2, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt( $chOne_2, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt( $chOne_2, CURLOPT_POST, 1);
  curl_setopt( $chOne_2, CURLOPT_POSTFIELDS, $message);
  curl_setopt( $chOne_2, CURLOPT_POSTFIELDS, "message=$message");
  curl_setopt( $chOne_2, CURLOPT_FOLLOWLOCATION, 1);
  $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sending.'', );
  curl_setopt($chOne_2, CURLOPT_HTTPHEADER, $headers);
  curl_setopt( $chOne_2, CURLOPT_RETURNTRANSFER, 1);
  $result = curl_exec( $chOne_2 );
  if(curl_error($chOne_2)) { echo 'error:' . curl_error($chOne_2); }
  else { $result_ = json_decode($result, true);
  echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
  curl_close( $chOne_2 );

        return redirect()->route('meeting.informeetcheck');
    }

    public function cancel(Request $request, $id)
    {

        $inforoomindex = Meetingroomservice::leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
            ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
            ->leftJoin('meetingroom_objective', 'meetingroom_objective.OBJECTIVE_ID', '=', 'meetingroom_service.SERVICE_FOR')
            ->where('meetingroom_service.ID', '=', $id)
            ->first();

        return view('manager_meet.managemeetcheckcancel', [
             'inforoomindex' => $inforoomindex,
            'inforecordid'  => $id
        ]);
    }

    public function updatecancel(Request $request)
    {
        $id                           = $request->ID;
        $updatecancel                 = Meetingroomservice::find($id);
        $updatecancel->CANCEL_COMMENT = $request->CANCEL_COMMENT;
        $updatecancel->STATUS         = 'CANCEL';

        $updatecancel->CANCEL_PERSON_ID = $request->PERSON_ID;
        $addinforperson                 = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->where('hrd_person.ID', '=', $request->PERSON_ID)->first();

        $updatecancel->CANCEL_DATE_TIME = date('Y-m-d H:i:s');
        $updatecancel->save();


        //-----------------------แจ้งเตือนผู้ขอจอง
        $inforoomservice = DB::table('meetingroom_service')->where('ID', '=', $id)->first();

        $inforoom = DB::table('meetingroom_index')->where('ROOM_ID', '=', $inforoomservice->ROOM_ID)->first();

        $header       = "การจองห้องประชุม";
        $servicestory = $inforoomservice->SERVICE_STORY;
        $roomname     = $inforoom->ROOM_NAME;
        $person       = $inforoomservice->PERSON_REQUEST_NAME;
        $groupfocus   = $inforoomservice->GROUP_FOCUS;
        $totalpeopel  = $inforoomservice->TOTAL_PEOPLE . ' คน';
        $datebegin    = DateThai($inforoomservice->DATE_BEGIN) . ' ' . date("H:i", strtotime("$inforoomservice->TIME_BEGIN"));
        $dateend      = DateThai($inforoomservice->DATE_END) . ' ' . date("H:i", strtotime("$inforoomservice->TIME_END"));

        $name = DB::table('hrd_person')->where('ID', '=', $inforoomservice->PERSON_REQUEST_ID)->first();
        $test = $name->HR_LINE;


        $products =DB::table('meetingroom_article_list')
        ->leftjoin('meetingroom_article','meetingroom_article.ARTICLE_ID','=','meetingroom_article_list.ARTICLE_ID')
        ->where('SERVICE_ID','=', $id)->get();
    
        $foods =DB::table('meetingroom_food_list')
        ->leftjoin('meetingroom_food','meetingroom_food.FOOD_ID','=','meetingroom_food_list.FOOD_ID')
        ->where('SERVICE_ID','=', $id)->get();
 
        

        $message = $header .
            "\n" . "เรื่อง : " . $servicestory .
            "\n" . "ห้อง : " . $roomname .
            "\n" . "ผู้จอง : " . $person .
            "\n" . "ผู้เข้าประชุม : " . $groupfocus .
            "\n" . "จำนวน : " . $totalpeopel .
            "\n" . "วันที่จอง : " . $datebegin .
            "\n" . "ถึงวันที่ : " . $dateend .
            "\n" . "ผลการอนุมัติ : " .'ยกเลิก'.
            "\n" .  "อุปกรณ์ : "; 
            foreach ($products as $product){ 
                $message.="\n"." - " . $product->ARTICLE_NAME ." จำนวน ".$product->TOTAL;
                    }
                $message.="\n"."อาหาร : "; 
                foreach ($foods as $food){ 
                $message.="\n"." - " . $food->FOOD_NAME ." จำนวน ".$food->TOTAL." ".$food->FOOD_UNIT;
                }

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


        $name_group = DB::table('line_token')->where('ID_LINE_TOKEN','=',1)->first();        
        $sending =$name_group->LINE_TOKEN;
  
  $chOne_2 = curl_init();
  curl_setopt( $chOne_2, CURLOPT_URL, "https://notify-api.line.me/api/notify");
  curl_setopt( $chOne_2, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt( $chOne_2, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt( $chOne_2, CURLOPT_POST, 1);
  curl_setopt( $chOne_2, CURLOPT_POSTFIELDS, $message);
  curl_setopt( $chOne_2, CURLOPT_POSTFIELDS, "message=$message");
  curl_setopt( $chOne_2, CURLOPT_FOLLOWLOCATION, 1);
  $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sending.'', );
  curl_setopt($chOne_2, CURLOPT_HTTPHEADER, $headers);
  curl_setopt( $chOne_2, CURLOPT_RETURNTRANSFER, 1);
  $result = curl_exec( $chOne_2 );
  if(curl_error($chOne_2)) { echo 'error:' . curl_error($chOne_2); }
  else { $result_ = json_decode($result, true);
  echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
  curl_close( $chOne_2 );


        return redirect()->route('meeting.informeetcheck');
    }

}
