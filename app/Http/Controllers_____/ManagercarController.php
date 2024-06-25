<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Vehiclecarindex;
use App\Models\Vehiclecarreserve;
use App\Models\Vehiclecarindexperson;
use App\Models\Vehiclecarindexetc;
use App\Models\Vehiclecarindexwork;
use App\Models\Vehiclecarindexregroup;
use App\Models\Vehiclecaraccessorydetail;
use App\Models\Vehiclecaractdetail;
use App\Models\Vehiclecarinsudetail;
use App\Models\Vehiclecartaxdetail;
use App\Models\Vehiclecaraccessoryasset;

use App\Models\Vehiclecarcheckdetail;
use App\Models\Carname_formtree;
use App\Models\Carfunctioncheck;

use App\Models\Assetcare;
use App\Models\Assetcaredetailetc;
use App\Models\Assetcarelist;
use App\Models\Vehiclecarposition;

use App\Models\Vehiclecarrefer;
use App\Models\Vehiclecarrefernurse;
use App\Models\Vehiclecarfanciness;
use App\Models\Vehiclecarreferwork;
use App\Models\Vehiclecarreferequipment;
use App\Models\Informrepairindex;
use App\Http\Controllers\Report\CarReportController;
use App\Models\Openform_car;
use PDF;

date_default_timezone_set("Asia/Bangkok");

class ManagercarController extends Controller
{
    public function dashboard()
    {
        $data['budgetyear'] = getBudgetYear();
        $data['budgetyear_dropdown'] = getBudgetYearAmount();
        if(!empty($_GET['budgetyear'])){
            $data['budgetyear'] = $_GET['budgetyear'];
        }
        $year = $data['budgetyear'];
        $year_ad = $year - 543;

        $carreport = new CarReportController();
        $data['amount_carreserve'] = $carreport->countCarReserveBystatus_year('LASTAPP',$year_ad);
        $data['amount_refer'] = $carreport->countCarReferBytype_year(1,$year_ad);
        $data['amount_ems'] = $carreport->countCarReferBytype_year(2,$year_ad);
        $data['amount_transfer'] = $carreport->countCarReferBytype_year(3,$year_ad);
        $data['carreserv_M'] = $carreport->countCarReserveBystatus_year_M('LASTAPP',$year_ad);
        $data['refer_M'] = $carreport->countCarReferBytype_year_M(1,$year_ad);
        $data['ems_M'] = $carreport->countCarReferBytype_year_M(2,$year_ad);
        $data['transfer_M'] = $carreport->countCarReferBytype_year_M(3,$year_ad);
        $countWorkdriver = $carreport->countWorkPersonDriverBystatus_year('LASTAPP',$year_ad);
        $data['Workdriver'][] = array('พนักงานขับรถ','จำนวนที่ขับ');
        foreach($countWorkdriver as $row){
            $data['Workdriver'][] = array($carreport->getNameByperson_id($row->CAR_DRIVER_SET_ID),$row->count);
        }
        $countWorkdriverRefer = $carreport->countWorkPersonDriverReferByyear($year_ad);
        $data['WorkdriverRefer'][] = array('พนักงานขับรถ','จำนวนที่ขับ');
        foreach($countWorkdriverRefer as $row){
            $data['WorkdriverRefer'][] = array($carreport->getNameByperson_id($row->DRIVER_ID),$row->count);
        }
        $data['money_M'] = $carreport->sumOilConsumptionBystatus_year_M($year_ad);
        $countRequestReserveCar = $carreport->countRequestcarReserveBydepartment_sub_sub('LASTAPP',$year_ad,10); // ลิมิตของหน่วยงาน
        $data['RequestReserveCar'][] = array('หน่วยงาน','จำนวนการใช้งาน');
        foreach($countRequestReserveCar as $row){
            $data['RequestReserveCar'][] = array($row->HR_DEPARTMENT_SUB_SUB_NAME,$row->count);
        }
        $ReserveUseTop= $carreport->countReserveUseByyear($year_ad,10);
        $data['ReserveUseTop'][] = array('ยานพาหนะทั่วไป','จำนวนการใช้งาน');
        foreach($ReserveUseTop as $row){
            $data['ReserveUseTop'][] = array($row->CAR_REG,$row->count);
        }
        return view('manager_car.dashboard_car',$data);
    }

    public function carcalendar()
    {


        $infocarnimal1 = DB::table('vehicle_car_reserve')
        ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
        ->where('vehicle_car_reserve.STATUS','=','REGROUP')
        ->orwhere('vehicle_car_reserve.STATUS','=','SUCCESS')
        ->orwhere('vehicle_car_reserve.STATUS','=','LASTAPP')
        ->orwhere('vehicle_car_reserve.STATUS','=','RECERVE')
        ->get();



        $infocarrefer = DB::table('vehicle_car_refer')
        ->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID')
        ->where('vehicle_car_refer.STATUS','<>','CANCEL')
        ->get();
        
    
        return view('manager_car.carcalendar_car',[
            'infocarnimal1s' => $infocarnimal1,
            'infocarrefers' => $infocarrefer   
        ]);
    }



    
    public function deatailcalendar(Request $request)
    {

                    function DateThai($strDate)
            {
            $strYear = date("Y",strtotime($strDate))+543;
            $strMonth= date("n",strtotime($strDate));
            $strDay= date("j",strtotime($strDate));

            $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            $strMonthThai=$strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear";
            }

            function formatetime($strtime)
            {
                $H = substr($strtime,0,5);
                return $H;
                }

   if($request->type=='nomal'){
        $infocarnimal = Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
        ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
        ->leftJoin('hrd_person','vehicle_car_reserve.RESERVE_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('RESERVE_ID','=',$request->id)
        ->first();


 
        if($infocarnimal->CAR_DRIVER_SET_ID != '' || $infocarnimal->CAR_DRIVER_SET_ID != null){
            $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('hrd_person.ID','=',$infocarnimal->CAR_DRIVER_SET_ID)->first();
            
            $CAR_DRIVER_NAME = $CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME;
            $CAR_DRIVER_PHONE = $CAR_DRIVER->HR_PHONE;
            $CAR_DRIVER_IMAGE = $CAR_DRIVER->HR_IMAGE;
            
            }else{
                $CAR_DRIVER_NAME = '';
                $CAR_DRIVER_PHONE = '';
                $CAR_DRIVER_IMAGE = '';
            }

       
        $infonomalwork=  DB::table('vehicle_car_index_work')->where('CARWORK_RESERVE_ID','=',$request->id)->get();

        $regroup = DB::table('vehicle_car_index_regroup')
        ->leftJoin('vehicle_car_reserve','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_index_regroup.RESERVE_ID')
        ->where('RESERVE_ID_SUB','=',$request->id)->first(); 

        if($regroup!= '' || $regroup !=null){
            $detailregroup = $regroup->RESERVE_NAME;
        }else{
            $detailregroup = '';
        }


        $output='    
        <div id="detail_car" class="modal fade edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
          <div class="modal-header">
           
          <div class="row">
          <div><h4  style="font-family: \'Kanit\', sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;รายละเอียด&nbsp;&nbsp;'.formatetime($infocarnimal->RESERVE_BEGIN_TIME).' น '.$infocarnimal->LOCATION_ORG_NAME.'';
          if($infocarnimal->STATUS == 'REGROUP'){
            $output.=' >> เดินทางร่วมกับรายการ '.$detailregroup;
          }
          $output.='</h4></div>
          </div>
              </div>
              <div class="modal-body" >
                 
      
                         <div class="row push" style="font-family: \'Kanit\', sans-serif;">
      
                                      <div class="col-sm-9">
      
                                          <div class="row push">
                                              <div class="col-lg-2" align="right">
                                              <label>ขอใช้รถ :</label>
                                              </div> 
                                              <div class="col-lg-8" align="left">
                                              '.$infocarnimal->RESERVE_NAME.'
                                              </div> 
                                          </div>    
                                          <div class="row push">
                                              <div class="col-lg-2" align="right">
                                              <label>สถานที่ไป :</label>
                                              </div> 
                                              <div class="col-lg-8" align="left">
                                              '.$infocarnimal->LOCATION_ORG_NAME.'
                                              </div> 
                                          </div>    
                                          <div class="row push">
                                              <div class="col-lg-2" align="right">
                                              <label>ผู้ขอ :</label>
                                              </div> 
                                              <div class="col-lg-6" align="left">
                                              '.$infocarnimal->HR_PREFIX_NAME.''.$infocarnimal->HR_FNAME.' '.$infocarnimal->HR_LNAME.'
                                              </div> 
                                              <div class="col-lg-1" align="right">
                                              <label>โทร :</label>
                                              </div> 
                                              <div class="col-lg-3" align="left">
                                                '.$infocarnimal->HR_PHONE.'
                                              </div> 
                                          </div>    
                                          <div class="row push">
                                              <div class="col-lg-2" align="right">
                                              <label>วันที่ :</label>
                                              </div> 
                                              <div class="col-lg-6" align="left">
                                              '.DateThai($infocarnimal->RESERVE_BEGIN_DATE).'
                                              </div> 
                                              <div class="col-lg-1" align="right">
                                              <label>เวลา :</label>
                                              </div> 
                                              <div class="col-lg-3" align="left">
                                              '.formatetime($infocarnimal->RESERVE_BEGIN_TIME).'
                                              </div> 
                                          </div>    
      
                                      </div>
      
                                      <div class="col-sm-3">
      
                                      <div class="form-group">
                              
                                      <img src="data:image/png;base64,'. chunk_split(base64_encode($infocarnimal->HR_IMAGE)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="100px" width="100px"/>
                                      </div>
                                    
                                      </div>
                          </div>
                          <BR>
                      
                          <div class="row push" style="font-family: \'Kanit\', sans-serif;">
                            
                                      <div class="col-sm-9">
      
                                      <div class="row push">
                                              <div class="col-lg-2" align="right">
                                              <label>ยานพาหนะ :</label>
                                              </div> 
                                              <div class="col-lg-2" align="left">
                                              '.$infocarnimal->CAR_REG.'
                                              </div> 
                                              <div class="col-lg-2" align="right">
                                              <label>รายละเอียด :</label>
                                              </div> 
                                              <div class="col-lg-6" align="left">
                                              '.$infocarnimal->CAR_DETAIL.'
                                              </div> 
                                          </div> 
                                          <div class="row push">
                                              <div class="col-lg-2" align="right">
                                              <label>พนักงานขับรถ :</label>
                                              </div> 
                                              <div class="col-lg-6" align="left">
                                              '.$CAR_DRIVER_NAME.'
                                              </div> 
                                              <div class="col-lg-1" align="right">
                                              <label>โทร :</label>
                                              </div> 
                                              <div class="col-lg-3" align="left">
                                              '.$CAR_DRIVER_PHONE.'
                                              </div> 
                                          </div>    
                                        
                                          <div class="row push">
                                              <div class="col-lg-2" align="right">
                                              <label>สถานที่นัด :</label>
                                              </div> 
                                              <div class="col-lg-6" align="left">
                                              '.$infocarnimal->APPOINT_LOCATE_NAME.'
                                              </div> 
                                              <div class="col-lg-1" align="right">
                                              <label>เวลา :</label>
                                              </div> 
                                              <div class="col-lg-3" align="left">
                                              '.formatetime($infocarnimal->APPOINT_TIME).'
                                              </div> 
                                          </div> 
                                          <div class="row push">
                                              <div class="col-lg-2" align="right">
                                              <label>งานฝาก :</label>
                                              </div> 
                                              <div class="col-lg-10" align="left">';
                                              foreach ($infonomalwork as $work) {
                                                $output.= $work->CARWORK_LOCATION_ID.' :: '.$work->CARWORK_DETAIL.'<br>';
                                              } 
                                              
                                              $output.='</div> 
                                            
                                          </div>  
                                          <div class="row push">
                                              <div class="col-lg-2" align="right">
                                              <label>หมายเหตุ :</label>
                                              </div> 
                                              <div class="col-lg-10" align="left">
                                              '.$infocarnimal->COMMENT.'
                                              </div> 
                                            
                                          </div>    
           
         
      
                                      </div>
      
                                      <div class="col-sm-3">
      
                                      <img src="data:image/png;base64,'. chunk_split(base64_encode($CAR_DRIVER_IMAGE)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="100px" width="100px"/>
                                      </div>
                                      </div>
      
             
                 
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
        }else{
            

            $infocarrefer = DB::table('vehicle_car_refer')->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID')
            ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
            ->leftJoin('hrd_person','vehicle_car_refer.USER_REQUEST_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('vehicle_car_refer.ID','=',$request->id)
            ->first();

            $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->where('hrd_person.ID','=',$infocarrefer->DRIVER_ID)->first();


                $inforefework=  DB::table('vehicle_car_refer_work')->where('REFER_ID','=',$request->id)->get();


            $output='    
            <div id="detail_car" class="modal fade edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
            
            <div class="row">
            <div><h4  style="font-family: \'Kanit\', sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;รายละเอียดรถพยาบาล&nbsp;&nbsp;</h4></div>
            </div>
                </div>
                <div class="modal-body" >
                    
        
                            <div class="row push" style="font-family: \'Kanit\', sans-serif;">
        
                                        <div class="col-sm-9">
        
                                            
                                            <div class="row push">
                                                <div class="col-lg-2" align="right">
                                                <label>สถานที่ไป :</label>
                                                </div> 
                                                <div class="col-lg-8" align="left">
                                                '.$infocarrefer->LOCATION_ORG_NAME.'
                                                </div> 
                                            </div>    
                                            <div class="row push">
                                                <div class="col-lg-2" align="right">
                                                <label>ผู้ขอ :</label>
                                                </div> 
                                                <div class="col-lg-6" align="left">
                                                '.$infocarrefer->HR_PREFIX_NAME.''.$infocarrefer->HR_FNAME.' '.$infocarrefer->HR_LNAME.'
                                                </div> 
                                                <div class="col-lg-1" align="right">
                                                <label>โทร :</label>
                                                </div> 
                                                <div class="col-lg-3" align="left">
                                                '.$infocarrefer->HR_PHONE.'
                                                </div> 
                                            </div>    
                                            <div class="row push">
                                            <div class="col-lg-2" align="right">
                                            <label>วันที่ :</label>
                                            </div> 
                                            <div class="col-lg-6" align="left">
                                            '.DateThai($infocarrefer->OUT_DATE).'
                                            </div> 
                                            <div class="col-lg-1" align="right">
                                            <label>เวลา :</label>
                                            </div> 
                                            <div class="col-lg-3" align="left">
                                            '.formatetime($infocarrefer->OUT_TIME).'
                                            </div> 
                                        </div>    

                                    </div>

                                    <div class="col-sm-3">

                                    <div class="form-group">
                            
                                    <img src="data:image/png;base64,'. chunk_split(base64_encode($infocarrefer->HR_IMAGE)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="100px" width="100px"/>
                                    </div>
                                    
                                    </div>
                            </div>
                            <BR>
                        
                            <div class="row push" style="font-family: \'Kanit\', sans-serif;">
                                
                                        <div class="col-sm-9">
        
                                        <div class="row push">
                                        <div class="col-lg-2" align="right">
                                        <label>ยานพาหนะ :</label>
                                        </div> 
                                        <div class="col-lg-2" align="left">
                                        '.$infocarrefer->CAR_REG.'
                                        </div> 
                                        <div class="col-lg-2" align="right">
                                        <label>รายละเอียด :</label>
                                        </div> 
                                        <div class="col-lg-6" align="left">
                                        '.$infocarrefer->CAR_DETAIL.'
                                        </div> 
                                    </div> 
                                    <div class="row push">
                                        <div class="col-lg-2" align="right">
                                        <label>พนักงานขับรถ :</label>
                                        </div> 
                                        <div class="col-lg-6" align="left">
                                        '.$CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME.'
                                        </div> 
                                        <div class="col-lg-1" align="right">
                                        <label>โทร :</label>
                                        </div> 
                                        <div class="col-lg-3" align="left">
                                        '.$CAR_DRIVER->HR_PHONE.'
                                        </div> 
                                    </div>    
                                            
                                        
                                            <div class="row push">
                                                <div class="col-lg-2" align="right">
                                                <label>งานฝาก :</label>
                                                </div> 
                                                <div class="col-lg-10" align="left">';
                                                foreach ($inforefework as $refework) {
                                                    $output.= $refework->CARWORK_REFER_LOCATION_ID.' :: '.$refework->CARWORK_REFER_DETAIL.'<br>';
                                                } 
                                                
                                                $output.='</div> 
                                                
                                            </div>  
                                            <div class="row push">
                                                <div class="col-lg-2" align="right">
                                                <label>หมายเหตุ :</label>
                                                </div> 
                                                <div class="col-lg-10" align="left">
                                                '.$infocarrefer->COMMENT.'
                                                </div> 
                                                
                                            </div>    
            
            
        
                                        </div>
        
                                        <div class="col-sm-3">

                                        <div class="form-group">
                            
                                        <img src="data:image/png;base64,'. chunk_split(base64_encode($CAR_DRIVER->HR_IMAGE)) .'"  height="100px" width="100px"/>
                                        </div>
        
                                        
                                        </div>
                                        </div>
        
                
                    
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

            }
                
                echo $output;
        
    
  
    }

    public function carinfonomal(Request $request)
    {
        if(!empty($request->_token)){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            session([
                'manager_car.carinfonomal.search' => $search,
                'manager_car.carinfonomal.status' => $status,
                'manager_car.carinfonomal.datebigin' => $datebigin,
                'manager_car.carinfonomal.dateend' => $dateend,
                'manager_car.carinfonomal.yearbudget' => $yearbudget,
            ]);
        }elseif(!empty(session('manager_car.carinfonomal'))){
            $search = session('manager_car.carinfonomal.search');
            $status = session('manager_car.carinfonomal.status');
            $datebigin = session('manager_car.carinfonomal.datebigin');
            $dateend = session('manager_car.carinfonomal.dateend');
            $yearbudget = session('manager_car.carinfonomal.yearbudget');
        }else{
            $search = '';
            $status = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
            $yearbudget = getBudgetyear();
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
        $y_sub_st = $date_arrary[0];
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_bigen= $y."-".$m."-".$d;
  
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c); 
        $y_sub_e = $date_arrary_e[0];
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];  
        $displaydate_end= $y_e."-".$m_e."-".$d_e;





        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);
      
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);



            if($status == null){
                $infocarnomal = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where(function($q) use ($search){
                    $q->where('CAR_REG','like','%'.$search.'%');
                    $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%');  
                    $q->orwhere('RESERVE_NAME','like','%'.$search.'%');
                    $q->orwhere('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('RESERVE_BEGIN_DATE',[$from,$to]) 
                ->orderBy('RESERVE_BEGIN_DATE','desc')
                ->orderBy('PRIORITY_ID','desc')
                ->get();
            }else{
                $infocarnomal = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where('STATUS','=',$status)
                ->where(function($q) use ($search){
                    $q->where('CAR_REG','like','%'.$search.'%');
                    $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%');  
                    $q->orwhere('RESERVE_NAME','like','%'.$search.'%');
                    $q->orwhere('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_NAME','like','%'.$search.'%');

                })
                ->WhereBetween('RESERVE_BEGIN_DATE',[$from,$to]) 
                ->orderBy('RESERVE_BEGIN_DATE','desc')
                ->orderBy('PRIORITY_ID','desc')
                ->get();
            }
      
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $infocar_sendstatus = DB::table('vehicle_car_request_status')->get();

        $openform_function = Openform_car::where('OPENFORMCAR_STATUS','=','True' )->first();
        // dd($openform_function->OPENFORMCAR_CODE);
        if ($openform_function != '') {       
            $code = $openform_function->OPENFORMCAR_CODE;  
        } else {                      
            $code = '';
        }

        return view('manager_car.carinfonomal',[
            'infocarnomals' => $infocarnomal,
            'infocar_sendstatuss' => $infocar_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
            'codes'=>$code,
            ]);
    
    }


    public function infocarnomalsearch(Request $request)
    {
      
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if($search==''){
            $search="";
        }


        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_bigen= $y."-".$m."-".$d;
  
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c); 

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }

        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];  
        $displaydate_end= $y_e."-".$m_e."-".$d_e;



        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);




      
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

            if($status == null){

                $infocarnomal = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where(function($q) use ($search){
                    $q->where('CAR_REG','like','%'.$search.'%');
                    $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%');  
                    $q->orwhere('RESERVE_NAME','like','%'.$search.'%');
                    $q->orwhere('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_NAME','like','%'.$search.'%');
                    

                })
                ->WhereBetween('RESERVE_BEGIN_DATE',[$from,$to]) 
                ->orderBy('RESERVE_BEGIN_DATE','desc')
                ->orderBy('PRIORITY_ID','desc')
                ->get();


            }else{

                $infocarnomal = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where('STATUS','=',$status)
                ->where(function($q) use ($search){
                    $q->where('CAR_REG','like','%'.$search.'%');
                    $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%');  
                    $q->orwhere('RESERVE_NAME','like','%'.$search.'%');
                    $q->orwhere('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_NAME','like','%'.$search.'%');

                })
                ->WhereBetween('RESERVE_BEGIN_DATE',[$from,$to]) 
                ->orderBy('RESERVE_BEGIN_DATE','desc')
                ->orderBy('PRIORITY_ID','desc')
                ->get();
            }    
      
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;
        $infocar_sendstatus = DB::table('vehicle_car_request_status')->get();

        $openform_function = Openform_car::where('OPENFORMCAR_STATUS','=','True' )->first();
        if ($openform_function != '') {       
            $code = $openform_function->OPENFORMCAR_CODE;  
        } else {                      
            $code = '';
        }

        return view('manager_car.carinfonomal',[
            'infocarnomals' => $infocarnomal,
            'infocar_sendstatuss' => $infocar_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
            'codes'=>$code,
            ]);
    }

    public function carinfonomalapp(Request $request,$id)
    {

        $priority =  DB::table('vehicle_car_priority')->get();

        $location =  DB::table('grecord_org_location')->get();


        $driver =  DB::table('vehicle_car_driver')
        ->leftJoin('hrd_person','vehicle_car_driver.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('vehicle_car_driver.ACTIVE','=','true')->get();

        $car =  DB::table('vehicle_car_index')->where('CAR_TYPE_ID','<>',2)->get();

        $PERSONALL =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->get();

        $infonomalapp =  DB::table('vehicle_car_reserve')
        ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_REQUEST_ID','=','vehicle_car_index.CAR_ID')
        ->where('RESERVE_ID','=',$id)
        ->first();


        $infonomalreserve =  DB::table('vehicle_car_reserve')->where('RESERVE_BEGIN_DATE','=',$infonomalapp->RESERVE_BEGIN_DATE)->where('RESERVE_ID','<>',$id)->where('STATUS','=','RECERVE')->get();
        $infonomalreserve2 =  DB::table('vehicle_car_reserve')->where('RESERVE_BEGIN_DATE','=',$infonomalapp->RESERVE_BEGIN_DATE)->where('RESERVE_ID','<>',$id)->where('STATUS','=','RECERVE')->orwhere('STATUS','=','REGROUP')->get();

        $countreferperson=  DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->count();
        $inforeferperson=  DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->get();


        $countreferpersonetc =  DB::table('vehicle_car_index_etc')->where('RESERVE_ID','=',$id)->count();
        $inforeferpersonetc=  DB::table('vehicle_car_index_etc')->where('RESERVE_ID','=',$id)->get();

        $infoappointlocate=  DB::table('vehicle_car_appoint_locate')->get();  
        
        $countnomalwork=  DB::table('vehicle_car_index_work')->where('CARWORK_RESERVE_ID','=',$id)->count();
        $infonomalwork=  DB::table('vehicle_car_index_work')->where('CARWORK_RESERVE_ID','=',$id)->get();

        $countnomalregroup=  DB::table('vehicle_car_index_regroup')->where('RESERVE_ID','=',$id)->count();
        $infonomalregroup=  DB::table('vehicle_car_index_regroup')->where('RESERVE_ID','=',$id)->get();
        

        if($infonomalapp->CAR_SET_ID != '' || $infonomalapp->CAR_SET_ID !=null){

            $carset =  DB::table('vehicle_car_index')->where('CAR_ID','=',$infonomalapp->CAR_SET_ID)->first();
            $carset_CAR_ID = $carset->CAR_ID;
            $carset_CAR_REG =  $carset->CAR_REG;
            $carset_CAR_DETAIL = $carset->CAR_DETAIL;

        }else{

            $carset_CAR_ID = '';
            $carset_CAR_REG = '';
            $carset_CAR_DETAIL = '';

        }


        $regroup = DB::table('vehicle_car_index_regroup')
        ->leftJoin('vehicle_car_reserve','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_index_regroup.RESERVE_ID')
        ->where('RESERVE_ID_SUB','=',$id)->first(); 

        if($regroup!= '' || $regroup !=null){
            $detailregroup = $regroup->RESERVE_NAME;
        }else{
            $detailregroup = '';
        }

        return view('manager_car.carinfonomal_app',[
            'locations' => $location,
            'drivers' => $driver, 
            'cars' => $car, 
            'PERSONALLs' => $PERSONALL,
            'prioritys' =>  $priority,
            'infonomalapp' =>  $infonomalapp,
            'countreferperson' => $countreferperson,
            'inforeferpersons' =>  $inforeferperson,
            'countreferpersonetc' => $countreferpersonetc,
            'inforeferpersonetcs' =>  $inforeferpersonetc,
            'infonomalreserves' =>  $infonomalreserve,
            'infoappointlocates' =>  $infoappointlocate,
            'countnomalwork' =>  $countnomalwork,
            'infonomalworks' =>  $infonomalwork,
            'countnomalregroup' =>  $countnomalregroup,
            'infonomalregroups' =>  $infonomalregroup,  
            'infonomalreserve2s' =>  $infonomalreserve2,
            'carset_CAR_ID' =>  $carset_CAR_ID,
            'carset_CAR_REG' =>  $carset_CAR_REG,
            'carset_CAR_DETAIL' =>  $carset_CAR_DETAIL,
            'detailregroup' =>  $detailregroup,

        ]);
    
  
    }


    

    public function updateinfonomalapp(Request $request)
    {
        $BOOK_REFER_DATE_1 = $request->RESERVE_BEGIN_DATE;
        $BOOK_REFER_DATE_2 = $request->RESERVE_END_DATE;
 
        $BOOK_REFER_DATE_3 = $request->BOOK_DATE_REG;
        $BOOK_REFER_DATE_4 = $request->APPOINT_DATE;
        $BOOK_REFER_DATE_5 = $request->BACK_DATE;
 
        if($BOOK_REFER_DATE_1 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_1)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOK_REFER_DATE_1= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOK_REFER_DATE_1= null;
     }
 
     if($BOOK_REFER_DATE_2 != ''){
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_2)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $BOOK_REFER_DATE_2= $y_st."-".$m_st."-".$d_st;
         }else{
         $BOOK_REFER_DATE_2= null;
     }
       
 
     if($BOOK_REFER_DATE_3 != ''){
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_3)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $BOOK_REFER_DATE_3= $y_st."-".$m_st."-".$d_st;
         }else{
         $BOOK_REFER_DATE_3= null;
     }


     if($BOOK_REFER_DATE_4 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_4)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_4= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_4= null;
    }



    if($BOOK_REFER_DATE_5 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_5)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_5= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_5= null;
    }
 
             $RESERVE_ID = $request->RESERVE_ID;
 
             $addcarnomal = Vehiclecarreserve::find($RESERVE_ID); 

 
             $addcarnomal->RESERVE_NAME = $request->RESERVE_NAME;
             $addcarnomal->RESERVE_LOCATION_ID = $request->RESERVE_LOCATION_ID;
 
             if($request->CAR_DRIVER_ID == ''){
                $addcarnomal->CAR_DRIVER_ID = '';
                $addcarnomal->CAR_DRIVER_NAME  = '';
             }else{

                $addcarnomal->CAR_DRIVER_ID = $request->CAR_DRIVER_ID;
                //----------------------------------
                $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                ->where('hrd_person.ID','=',$request->CAR_DRIVER_ID)->first();
                $addcarnomal->CAR_DRIVER_NAME    = $CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME;
 
                //----------------------------------
 

             }
              
 
             $addcarnomal->RESERVE_BEGIN_DATE = $BOOK_REFER_DATE_1;
             $addcarnomal->RESERVE_BEGIN_TIME = $request->RESERVE_BEGIN_TIME;
             $addcarnomal->RESERVE_END_DATE = $BOOK_REFER_DATE_2;
             $addcarnomal->RESERVE_END_TIME = $request->RESERVE_END_TIME;
 
             $addcarnomal->LEADER_PERSON_ID = $request->LEADER_PERSON_ID;
                //----------------------------------
                $LEADER_PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                ->where('hrd_person.ID','=',$request->LEADER_PERSON_ID)->first();
                $addcarnomal->LEADER_PERSON_NAME  = $LEADER_PERSON->HR_PREFIX_NAME.''.$LEADER_PERSON->HR_FNAME.' '.$LEADER_PERSON->HR_LNAME;
                $addcarnomal->LEADER_PERSON_POSITION = $LEADER_PERSON->HR_POSITION_NAME;
                //----------------------------------
 
           
             
             $addcarnomal->PRIORITY_ID = $request->PRIORITY_ID;
             $addcarnomal->RESERVE_COMMENT = $request->RESERVE_COMMENT;
             $addcarnomal->CAR_REQUEST_ID = $request->CAR_REQUEST_ID;
             $addcarnomal->CAR_OWNER = $request->CAR_OWNER;
 //-------------------------------------------------------------------------

             $addcarnomal->STATUS = $request->STATUS;
             $addcarnomal->CAR_DRIVER_SET_ID = $request->CAR_DRIVER_SET_ID;
             $addcarnomal->CAR_SET_ID = $request->CAR_REQUEST_ID;
          
             $addcarnomal->CAR_NUMBER_BEGIN  = $request->CAR_NUMBER_BEGIN;
             $addcarnomal->OIL_PRICE_PER_LIT  = $request->OIL_PRICE_PER_LIT;
          
             $addcarnomal->APPOINT_DATE  = $BOOK_REFER_DATE_4;
             $addcarnomal->APPOINT_TIME  = $request->APPOINT_TIME;
             $addcarnomal->APPOINT_LOCATE_ID  = $request->APPOINT_LOCATE_ID;

             $addcarnomal->CAR_NUMBER_BACK  = $request->CAR_NUMBER_BACK;
             $addcarnomal->OIL_IN_BATH  = $request->OIL_IN_BATH;
             $addcarnomal->OIL_IN_LIT  = $request->OIL_IN_LIT;
             $addcarnomal->BACK_DATE  = $BOOK_REFER_DATE_5;
             $addcarnomal->BACK_TIME  = $request->BACK_TIME;
             $addcarnomal->DISTANCE  = $request->DISTANCE;
             $addcarnomal->COMMENT  = $request->COMMENT;

 
           
             $addcarnomal->save();
 
 
             Vehiclecarindexregroup::where('RESERVE_ID','=',$RESERVE_ID)->delete();   

             Vehiclecarindexperson::where('RESERVE_ID','=',$RESERVE_ID)->delete(); 
             Vehiclecarindexetc::where('RESERVE_ID','=',$RESERVE_ID)->delete(); 
             Vehiclecarindexwork::where('CARWORK_RESERVE_ID','=',$RESERVE_ID)->delete(); 
             
  
              //----------------------------------

            

              if($request->RESERVE_ID_SUB[0] != '' || $request->RESERVE_ID_SUB[0] != null){
                $RESERVE_ID_SUB = $request->RESERVE_ID_SUB;
                $number_re =count($RESERVE_ID_SUB);
                $count_re  = 0;
              
                for($count_re = 0; $count_re < $number_re; $count_re++)
                {  
                  //echo $row3[$count_3]."<br>";
                 
                   //dd($RESERVE_ID_SUB[$count_re]);
                   $add_re  = new Vehiclecarindexregroup();
                   $add_re->RESERVE_ID = $RESERVE_ID;
                   $add_re->RESERVE_ID_SUB = $RESERVE_ID_SUB[$count_re];
                   $add_re->save(); 


                   $addcarnomal_re = Vehiclecarreserve::find($RESERVE_ID_SUB[$count_re]); 
                   $addcarnomal_re->STATUS = 'REGROUP';
                   $addcarnomal_re->CAR_DRIVER_SET_ID = $request->CAR_DRIVER_SET_ID;
                   $addcarnomal_re->CAR_SET_ID = $request->CAR_REQUEST_ID;
          
                   $addcarnomal_re->CAR_NUMBER_BEGIN  = $request->CAR_NUMBER_BEGIN;
                   $addcarnomal_re->OIL_PRICE_PER_LIT  = $request->OIL_PRICE_PER_LIT;
          
                   $addcarnomal_re->APPOINT_DATE  = $BOOK_REFER_DATE_4;
                   $addcarnomal_re->APPOINT_TIME  = $request->APPOINT_TIME;
                   $addcarnomal_re->APPOINT_LOCATE_ID  = $request->APPOINT_LOCATE_ID;

                   $addcarnomal_re->CAR_NUMBER_BACK  = $request->CAR_NUMBER_BACK;
                   $addcarnomal_re->OIL_IN_BATH  = $request->OIL_IN_BATH;
                   $addcarnomal_re->OIL_IN_LIT  = $request->OIL_IN_LIT;
                   $addcarnomal_re->BACK_DATE  = $BOOK_REFER_DATE_5;
                   $addcarnomal_re->BACK_TIME  = $request->BACK_TIME;
                   $addcarnomal_re->DISTANCE  = $request->DISTANCE;
                   $addcarnomal_re->COMMENT  = $request->COMMENT;

                   $addcarnomal_re   ->save();  
         
                }
            }

 
             if($request->PERSON_ID[0] != '' || $request->PERSON_ID[0] != null){
                 $PERSON_ID = $request->PERSON_ID;
                 $number_3 =count($PERSON_ID);
                 $count_3 = 0;
                 for($count_3 = 0; $count_3 < $number_3; $count_3++)
                 {  
                   //echo $row3[$count_3]."<br>";
                  
                    $add_3 = new Vehiclecarindexperson();
                    $add_3->RESERVE_ID = $RESERVE_ID;
 
 
                    $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                    ->where('hrd_person.ID','=',$PERSON_ID[$count_3])->first();
 
                    $add_3->HR_PERSON_ID =  $PERSON->ID;
                    $add_3->HR_FULLNAME =  $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;
                    $add_3->HR_POSITION =  $PERSON->POSITION_IN_WORK;
                    $add_3->HR_DEPARTMENT_ID = $PERSON->HR_DEPARTMENT_ID;
                    $add_3->HR_LEVEL = $PERSON->HR_LEVEL_ID;
 
                    $add_3->save(); 
                  
          
          
                 }
             }
 
 
             if($request->PERSON_OTHER[0] != '' || $request->PERSON_OTHER[0] != null){
                 $PERSON_OTHER = $request->PERSON_OTHER;
                 $number_4 =count($PERSON_OTHER);
                 $count_4 = 0;
                 for($count_4 = 0; $count_4 < $number_4; $count_4++)
                 {  
                   //echo $row3[$count_3]."<br>";
                  
                    $add_4 = new Vehiclecarindexetc();
                    $add_4->RESERVE_ID = $RESERVE_ID;
                    $add_4->FULLNAME = $PERSON_OTHER[$count_4];
 
                    $add_4->save(); 
                  
          
                 }
             }
 
             if($request->CARWORK_LOCATION_ID[0] != '' || $request->CARWORK_LOCATION_ID[0] != null){
 
                 $CARWORK_LOCATION_ID = $request->CARWORK_LOCATION_ID;
                 $CARWORK_DETAIL = $request->CARWORK_DETAIL;
                 $CARWORK_RESERVE_CHECK = $request->CARWORK_RESERVE_CHECK;
                 $CARWORK_RESERVE_COMMENT = $request->CARWORK_RESERVE_COMMENT;
 
                 $number_5 =count($CARWORK_LOCATION_ID);
                 $count_5 = 0;
                 for($count_5 = 0; $count_5 < $number_5; $count_5++)
                 {  
                   //echo $row3[$count_3]."<br>";
                  
                    $add_5 = new Vehiclecarindexwork();
                    $add_5->CARWORK_RESERVE_ID = $RESERVE_ID;
                    $add_5->CARWORK_LOCATION_ID = $CARWORK_LOCATION_ID[$count_5];
                    $add_5->CARWORK_DETAIL = $CARWORK_DETAIL[$count_5];
                    $add_5->CARWORK_RESERVE_CHECK = $CARWORK_RESERVE_CHECK[$count_5];
                    $add_5->CARWORK_RESERVE_COMMENT = $CARWORK_RESERVE_COMMENT[$count_5];
 
                    $add_5->save(); 
                  
          
                 }
             }
 
 


             //แจ้งเตือนเมื่อมีการจัดสรร


             function DateThailinecar($strDate)
             {
               $strYear = date("Y",strtotime($strDate))+543;
               $strMonth= date("n",strtotime($strDate));
               $strDay= date("j",strtotime($strDate));
       
               $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
               $strMonthThai=$strMonthCut[$strMonth];
               return "$strDay $strMonthThai $strYear";
               }
               function formatetime($strtime)
               {
                   $H = substr($strtime,0,5);
                   return $H;
                   }
       
                   
      
       
        
             $header = "จัดสรรรถยนต์";
             
            

              $infocarnimal = Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
              ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
              ->leftJoin('hrd_person','vehicle_car_reserve.RESERVE_PERSON_ID','=','hrd_person.ID')
              ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
              ->leftJoin('vehicle_car_appoint_locate','vehicle_car_appoint_locate.APPOINT_LOCATE_ID','=','vehicle_car_reserve.APPOINT_LOCATE_ID')
              ->where('RESERVE_ID','=',$RESERVE_ID)
              ->first();
      
       
              $datebegin = DateThailinecar($infocarnimal->RESERVE_BEGIN_DATE); 
       
              $timebegin = formatetime($infocarnimal->RESERVE_BEGIN_TIME);

              $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
              ->where('hrd_person.ID','=',$infocarnimal->CAR_DRIVER_SET_ID)->first();

              $appointtime =  formatetime($infocarnimal->APPOINT_TIME);

              if($infocarnimal->STATUS == 'SUCCESS'){
                $textresult = 'อนุมัติ';
              }else if($infocarnimal->STATUS == 'REGROUP'){
                $textresult = 'อนุมัติร่วม';
              }else if($infocarnimal->STATUS == 'CANCEL'){
                $textresult = 'ยกเลิก';
              }else{
                $textresult = 'ร้องขอ';
             }

             if($infocarnimal->CAR_DRIVER_SET_ID == ''){
                $driver = '';   
                $phone ='';
                 }else{
                $driver = $CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME;
                $phone = $CAR_DRIVER->HR_PHONE;    
                 }   

             $message = $header.
                 "\n"."ขอใช้รถ : " . $infocarnimal->RESERVE_NAME .
                 "\n"."สถานที่ไป : " . $infocarnimal->LOCATION_ORG_NAME .
                 "\n"."ผู้ขอ : " .$infocarnimal->HR_PREFIX_NAME.''.$infocarnimal->HR_FNAME.' '.$infocarnimal->HR_LNAME.
                 "\n"."วันที่ : " . $datebegin  .
                 "\n"."เวลา : " . $timebegin .
                 "\n"."ยานพาหนะ : " . $infocarnimal->CAR_REG .  
                 "\n"."พขร. : " .$driver.    
                 "\n"."สถานที่นัดหมาย : " .$infocarnimal->APPOINT_LOCATE_NAME.  
                 "\n"."โทร : " .$phone.    
                 "\n"."ผลการอนุมัติ : " . $textresult ;    
                 
           
                
               
         
                     $name = DB::table('hrd_person')->where('ID','=',$infocarnimal->RESERVE_PERSON_ID)->first();        
                     if($name == null){
                        $test = '';
                     }else{
                        $test =$name->HR_LINE;
                     }
                     
                   
                     $chOne = curl_init();
                     curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                     curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                     curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                     curl_setopt( $chOne, CURLOPT_POST, 1);
                     curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                     curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                     curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                     $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                     curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                     curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                     $result = curl_exec( $chOne );
                     if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                     else { $result_ = json_decode($result, true);
                     echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                     curl_close( $chOne );

//---------------ส่ง พขร.
$header2 = "พขร. ปฏิบัติงาน";
$message2 = $header2.
"\n"."ขอใช้รถ : " . $infocarnimal->RESERVE_NAME .
"\n"."สถานที่ไป : " . $infocarnimal->LOCATION_ORG_NAME .
"\n"."ผู้ขอ : " .$infocarnimal->HR_PREFIX_NAME.''.$infocarnimal->HR_FNAME.' '.$infocarnimal->HR_LNAME.
"\n"."วันที่ : " . $datebegin  .
"\n"."เวลา : " . $timebegin .
"\n"."ยานพาหนะ : " . $infocarnimal->CAR_REG .               
"\n"."พขร. : " .$driver.
"\n"."สถานที่นัดหมาย : " .$infocarnimal->APPOINT_LOCATE_NAME.     
"\n"."โทร : " .$phone.   
"\n"."ผลการอนุมัติ : " . $textresult ;             


                    $name2 = DB::table('hrd_person')->where('ID','=',$infocarnimal->CAR_DRIVER_SET_ID)->first();  
                    
                    if($name2 == null){
                        $test2 ='';
                    }else{
                        $test2 =$name2->HR_LINE;
                    }
                    
                    
                   

                     $chOne2 = curl_init();
                     curl_setopt( $chOne2, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                     curl_setopt( $chOne2, CURLOPT_SSL_VERIFYHOST, 0);
                     curl_setopt( $chOne2, CURLOPT_SSL_VERIFYPEER, 0);
                     curl_setopt( $chOne2, CURLOPT_POST, 1);
                     curl_setopt( $chOne2, CURLOPT_POSTFIELDS, $message2);
                     curl_setopt( $chOne2, CURLOPT_POSTFIELDS, "message=$message2");
                     curl_setopt( $chOne2, CURLOPT_FOLLOWLOCATION, 1);
                     $headers2 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test2.'', );
                     curl_setopt($chOne2, CURLOPT_HTTPHEADER, $headers2);
                     curl_setopt( $chOne2, CURLOPT_RETURNTRANSFER, 1);
                     $result2 = curl_exec( $chOne2 );
                     if(curl_error($chOne2)) { echo 'error:' . curl_error($chOne2); }
                     else { $result_ = json_decode($result2, true);
                     echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                     curl_close( $chOne2 );
       


            return redirect()->route('mcar.carinfonomal'); 

    }

    public function carinforefer(Request $request)
    {        
        if(!empty($request->_token)){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            session([
                'manager_car.carinforefer.search' => $search,
                'manager_car.carinforefer.status' => $status,
                'manager_car.carinforefer.datebigin' => $datebigin,
                'manager_car.carinforefer.dateend' => $dateend,
                'manager_car.carinforefer.yearbudget' => $yearbudget,
            ]);
        }elseif(!empty(session('manager_car.carinforefer'))){
            $search = session('manager_car.carinforefer.search');
            $status = session('manager_car.carinforefer.status');
            $datebigin = session('manager_car.carinforefer.datebigin');
            $dateend = session('manager_car.carinforefer.dateend');
            $yearbudget = session('manager_car.carinforefer.yearbudget');
        }else{
            $search = '';
            $status = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
            $yearbudget = getBudgetyear();
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
        $y_sub_st = $date_arrary[0];
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_bigen= $y."-".$m."-".$d;
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c); 
        $y_sub_e = $date_arrary_e[0];
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];  
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

            if($status == null){
                $inforefer = DB::table('vehicle_car_refer')
                ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
                ->where(function($q) use ($search){
                    $q->where('CAR_REG','like','%'.$search.'%');
                    $q->orwhere('DRIVER_NAME','like','%'.$search.'%');  
                    $q->orwhere('USER_REQUEST_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('OUT_DATE',[$from,$to]) 
                ->orderBy('vehicle_car_refer.ID', 'desc')  
                ->get();
            }else{
                $inforefer = DB::table('vehicle_car_refer')
                ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
                ->where('REFER_TYPE_ID','=',$status)
                ->where(function($q) use ($search){
                    $q->where('CAR_REG','like','%'.$search.'%');
                    $q->orwhere('DRIVER_NAME','like','%'.$search.'%');  
                    $q->orwhere('USER_REQUEST_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('OUT_DATE',[$from,$to]) 
                ->orderBy('vehicle_car_refer.ID', 'desc')  
                ->get();
            }


        $inforefer_sendstatus = DB::table('vehicle_car_refer_type')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        return view('manager_car.carinforefer',[
            'inforefers' => $inforefer,
            'inforefer_sendstatuss' => $inforefer_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }


    function carinforefer_pdf(Request $request,$id)
    {
                    $orgname =  DB::table('info_org')
                    ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->first();
                
                    
                    // $inforcar = DB::table('vehicle_car_reserve')
                    // ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                    // ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                    // ->where('RESERVE_ID','=',$id)->first();

                    $inforefer = DB::table('vehicle_car_refer')
                    ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
                    ->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID')
                    ->where('ID','=',$id)->first();
                    
                    $iduser = $inforefer->USER_REQUEST_ID;

                    $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                    ->where('hrd_person.ID','=',$iduser)->first();
                
                    // $idcon = $inforcar->LEADER_PERSON_ID;

                    // $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    // ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                    // ->where('hrd_person.ID','=',$idcon)->first();
                
                
                    $indexperson = DB::table('vehicle_car_index_person')
                    ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index_person.HR_PERSON_ID')
                    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                    ->where('RESERVE_ID','=',$id)->get();
                
                
                    $indexpersoncount = DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->count();
            
                $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
                $orgname =  DB::table('info_org')
                ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();
                
                $debsub =  DB::table('hrd_department_sub')
                ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
                ->first();
                
                
                $siginper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforefer->USER_REQUEST_ID)->first();
                
                // $siginsub = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforefer->LEADER_PERSON_ID)->first();
                
                $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
                
                $sigincardriver = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforefer->DRIVER_ID)->first();
                
                
                if($siginper !== null){
                    $sigper =  $siginper->FILE_NAME;
                }else{ $sigper = '';}
                
                // if($siginsub !== null){
                //     $sigsub =  $siginsub->FILE_NAME;
                // }else{ $sigsub = '';}
                
                if($sigin !== null){
                    $sig =  $sigin->FILE_NAME;
                }else{ $sig = '';}
                
                if($sigincardriver !== null){
                    $sigdriver =  $sigincardriver->FILE_NAME;
                }else{ $sigdriver = '';}
                
                $func = DB::table('vehicle_car_function')->where('CAR_FUNCTION_STATUS','=','True')->first();
                
                if ($func == null || $func == '') {
                    $f = 'ใบขออนุญาตใช้รถยนต์';
                } else {
                    $f = $func->CAR_FUNCTION_NAME;
                }
                
                $funccheck = DB::table('vehicle_car_functioncheck')->where('CAR_FUNCTIONCHECK_STATUS','=','True')->first();
                
                if ($funccheck == null || $funccheck == '') {
                $funch = 'Notopen';
                } else {
                    $funch = $funccheck->CAR_FUNCTIONCHECK_NAMEENG;
                }
                
                $infoper =  Person::get();

                $funcgleave = DB::table('gleave_function')->where('ACTIVE','=','True')->first();
                
                $pdf = PDF::loadView('manager_car.carinforefer_pdf',[
                    'inforefer' => $inforefer,
                    'orgname' => $orgname,
                    'funcgleave' => $funcgleave,
                    'inforperson' => $inforperson,
                    'indexpersons' => $indexperson,
                    'indexpersoncount' => $indexpersoncount,
                    'sig' => $sig,
                    'sigper' => $sigper,
                    'checksig' => $checksig,
                    'sigdriver' => $sigdriver,
                    'func' => $func,
                    'f' => $f,
                    'funch' => $funch,
                    'infoper' => $infoper,
                    ]);
                    return @$pdf->stream();
    }






    public function infocarrefersearch(Request $request)
    {
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_bigen= $y."-".$m."-".$d;
  
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c); 

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }

        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];  
        $displaydate_end= $y_e."-".$m_e."-".$d_e;

        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);

        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

            if($status == null){

                $inforefer = DB::table('vehicle_car_refer')
                ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
                ->where(function($q) use ($search){
                    $q->where('CAR_REG','like','%'.$search.'%');
                    $q->orwhere('DRIVER_NAME','like','%'.$search.'%');  
                    $q->orwhere('USER_REQUEST_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('OUT_DATE',[$from,$to]) 
                ->orderBy('vehicle_car_refer.ID', 'desc')  
                ->get();
            }else{
                $inforefer = DB::table('vehicle_car_refer')
                ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
                ->where('REFER_TYPE_ID','=',$status)
                ->where(function($q) use ($search){
                    $q->where('CAR_REG','like','%'.$search.'%');
                    $q->orwhere('DRIVER_NAME','like','%'.$search.'%');  
                    $q->orwhere('USER_REQUEST_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('OUT_DATE',[$from,$to]) 
                ->orderBy('vehicle_car_refer.ID', 'desc')  
                ->get();

            }   
        $inforefer_sendstatus = DB::table('vehicle_car_refer_type')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        return view('manager_car.carinforefer',[
            'inforefers' => $inforefer,
            'inforefer_sendstatuss' => $inforefer_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }




    public function carinforeferapp(Request $request,$id)
    {

        $refertype  =  DB::table('vehicle_car_refer_type')->get(); 

        $location =  DB::table('grecord_org_location')->get();

        $equipment =  DB::table('vehicle_car_equipment')->get();

        

        $driver =  DB::table('vehicle_car_driver')
        ->leftJoin('hrd_person','vehicle_car_driver.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('vehicle_car_driver.ACTIVE','=','true')->get();

        $car =  DB::table('vehicle_car_index')->where('CAR_STYLE_ID','=',1)->get();

        $PERSONALL =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->get();

        $nationality =  DB::table('hrd_nationality')->get();

        $citizenship =  DB::table('hrd_citizenship')->get();


        $inforeferapp =  DB::table('vehicle_car_refer')
        ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
        ->where('ID','=',$id)
        ->first();
  
        $countrefernurse=  DB::table('vehicle_car_refer_nurse')->where('REFER_ID','=',$id)->count();
        $inforefernurse=  DB::table('vehicle_car_refer_nurse')->where('REFER_ID','=',$id)->get();

        $countreferwork=  DB::table('vehicle_car_refer_work')->where('REFER_ID','=',$id)->count();
        $inforefework=  DB::table('vehicle_car_refer_work')->where('REFER_ID','=',$id)->get();

        $countreferequ=  DB::table('vehicle_car_refer_equipment')->where('REFER_ID','=',$id)->count();
        $inforeferequ=  DB::table('vehicle_car_refer_equipment')->where('REFER_ID','=',$id)->get();


        return view('manager_car.carinforefer_app',[
            'locations' => $location,
            'drivers' => $driver, 
            'cars' => $car, 
            'PERSONALLs' => $PERSONALL,  
            'nationalitys' => $nationality, 
            'citizenships' => $citizenship,
            'refertypes' => $refertype, 
            'equipments' => $equipment,
            'inforeferapp' => $inforeferapp,
            'countrefernurse' => $countrefernurse,
            'inforefernurses' => $inforefernurse,
            'countreferwork' => $countreferwork,
            'inforefeworks' => $inforefework,
            'countreferwork' => $countreferwork,
            'inforefeworks' => $inforefework,
            'countreferequ' => $countreferequ,
            'inforeferequs' => $inforeferequ,

           
         
            
        ]);
    
  
    }


    

    public function updateinforeferapp(Request $request)
    {
      
        
       $BOOK_REFER_DATE_1 = $request->OUT_DATE;
       $BOOK_REFER_DATE_2 = $request->BACK_DATE;

       if($BOOK_REFER_DATE_1 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_1)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_1= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_1= null;
    }

    if($BOOK_REFER_DATE_2 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_2)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_2= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_2= null;
    }
      

           $idrefer = $request->REFER_ID;
         
   
            $addcarrefer = Vehiclecarrefer::find($idrefer); 

        
            $addcarrefer->OUT_DATE = $BOOK_REFER_DATE_1;
            $addcarrefer->OUT_TIME = $request->OUT_TIME;
            $addcarrefer->BACK_DATE = $BOOK_REFER_DATE_2;
            $addcarrefer->BACK_TIME = $request->BACK_TIME;

            $addcarrefer->REFER_LOCATION_GO_ID = $request->REFER_LOCATION_GO_ID;

            
            $addcarrefer->DRIVER_ID = $request->DRIVER_ID;
            //----------------------------------
            $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->DRIVER_ID)->first();
            $addcarrefer->DRIVER_NAME    = $CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME;

            //----------------------------------
            
            $addcarrefer->CAR_GO_MILE = $request->CAR_GO_MILE;
            $addcarrefer->ADD_OIL_BATH = $request->ADD_OIL_BATH;
            $addcarrefer->ADD_OIL_LIT = $request->ADD_OIL_LIT;
            $addcarrefer->CAR_BACK_MILE = $request->CAR_BACK_MILE;
            $addcarrefer->ORG_ID = $request->ORG_ID;
            $addcarrefer->COMMENT = $request->COMMENT;

            $addcarrefer->HOS_FULLNAME = $request->HOS_FULLNAME;
            $addcarrefer->HOS_AGE = $request->HOS_AGE;
            $addcarrefer->HOS_HN = $request->HOS_HN;
            $addcarrefer->HOS_CID = $request->HOS_CID;
            
            $addcarrefer->NATIONNALITY_ID = $request->NATIONNALITY_ID;
            $addcarrefer->CITIZENSHIP_ID = $request->CITIZENSHIP_ID;

            $addcarrefer->REFER_TYPE_ID = $request->REFER_TYPE_ID;

            $addcarrefer->HOS_HOSPNAME = $request->HOS_HOSPNAME;


            $addcarrefer->save();           
             //----------------------------------


             Vehiclecarrefernurse::where('REFER_ID','=',$idrefer)->delete(); 
             Vehiclecarreferwork::where('REFER_ID','=',$idrefer)->delete(); 
             Vehiclecarreferequipment::where('REFER_ID','=',$idrefer)->delete(); 

             $REFER_ID =  $idrefer;

            if($request->PERSON_ID != '' || $request->PERSON_ID != null){
                $PERSON_ID = $request->PERSON_ID;
                $number_3 =count($PERSON_ID);
                $count_3 = 0;
                for($count_3 = 0; $count_3 < $number_3; $count_3++)
                {  
                 
                    if($PERSON_ID[$count_3] <> '' && $PERSON_ID[$count_3] <> null){
                   $add_3 = new Vehiclecarrefernurse();
                   $add_3->REFER_ID = $REFER_ID;

                   $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                   ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                   ->where('hrd_person.ID','=',$PERSON_ID[$count_3])->first();
                  
                 
                    $add_3->NURSE_HR_ID =  $PERSON->ID;
                    $add_3->NURSE_HR_NAME =  $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;
                    $add_3->NURSE_HR_POSITION =  $PERSON->POSITION_IN_WORK;
                    $add_3->save(); 
                    }
               
         
                }
            }


            if($request->CARWORK_REFER_DETAIL != '' || $request->CARWORK_REFER_DETAIL != null){

                $CARWORK_REFER_LOCATION_ID = $request->CARWORK_REFER_LOCATION_ID;
                $CARWORK_REFER_DETAIL = $request->CARWORK_REFER_DETAIL;
                $CARWORK_CHECK = $request->CARWORK_CHECK;
                $CARWORK_COMMENT = $request->CARWORK_COMMENT;

                $number_4 =count($CARWORK_REFER_LOCATION_ID);
                $count_4 = 0;
                for($count_4 = 0; $count_4 < $number_4; $count_4++)
                {  
                 
                   $add_4 = new Vehiclecarreferwork();
                   $add_4->REFER_ID = $REFER_ID;
                   $add_4->CARWORK_REFER_LOCATION_ID = $CARWORK_REFER_LOCATION_ID[$count_4];
                   $add_4->CARWORK_REFER_DETAIL = $CARWORK_REFER_DETAIL[$count_4];
                   $add_4->CARWORK_CHECK = $CARWORK_CHECK[$count_4]; 
                   $add_4->CARWORK_COMMENT = $CARWORK_COMMENT[$count_4];

                   $add_4->save(); 
                 
         
                }
            }

            
            if($request->EQUIPMENT_ID != '' || $request->EQUIPMENT_ID != null){

                $EQUIPMENT_ID = $request->EQUIPMENT_ID;
                $EQUIPMENT_AMOUNT = $request->EQUIPMENT_AMOUNT;
                $EQUIPMENT_CHECK = $request->EQUIPMENT_CHECK;
                $EQUIPMENT_AMOUNT_BACK = $request->EQUIPMENT_AMOUNT_BACK;
                $EQUIPMENT_COMMENT = $request->EQUIPMENT_COMMENT;

                $number_5 =count($EQUIPMENT_ID);
                $count_5= 0;

                for($count_5 = 0; $count_5 < $number_5; $count_5++)
                {  
                 
                   $add_5 = new Vehiclecarreferequipment();
                   $add_5->REFER_ID = $REFER_ID;
                   $add_5->EQUIPMENT_ID = $EQUIPMENT_ID[$count_5];
                   $add_5->EQUIPMENT_AMOUNT = $EQUIPMENT_AMOUNT[$count_5];  
                   $add_5->EQUIPMENT_CHECK = $EQUIPMENT_CHECK[$count_5];  
                   $add_5->EQUIPMENT_AMOUNT_BACK = $EQUIPMENT_AMOUNT_BACK[$count_5];
                   $add_5->EQUIPMENT_COMMENT = $EQUIPMENT_COMMENT[$count_5];
                   $add_5->save(); 
                 
         
                }
            }



            return redirect()->route('mcar.carinforefer'); 

    }

     //==========================แจ้งยกเลิก=======================================
     public function cancelrefer(Request $request,$id)
     {
 
         $infocarrefer = DB::table('vehicle_car_refer')->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID')
         ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
         ->leftJoin('hrd_person','vehicle_car_refer.USER_REQUEST_ID','=','hrd_person.ID')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->where('vehicle_car_refer.ID','=',$id)
         ->first();
         
         $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->where('hrd_person.ID','=',$infocarrefer->DRIVER_ID)->first();
 
        

 
             return view('manager_car.carinforefercancel',[
          
                 'infocarrefer' => $infocarrefer,
                 'CAR_DRIVER' => $CAR_DRIVER,
                 'REFER_ID' => $id,
           
                 
             ]);
         }
 
         public function updatecancelrefer(Request $request)
         {
               $REFER_ID = $request->REFER_ID; 

                 $addcarrefer = Vehiclecarrefer::find($REFER_ID);
                 $addcarrefer->STATUS = 'CANCEL';
                 $addcarrefer->save();
     
                 return redirect()->route('mcar.carinforefer');
         }

    public function infomationcar(Request $request)
    {
        if(!empty($request->_token)){
            $search = $request->search;
            session([
                'manager_car.infomationcar.search' => $search
            ]);
        }elseif(!empty(session('manager_car.infomationcar'))){
            $search = session('manager_car.infomationcar.search');
        }else{
            $search = '';
        }
            $infocar = DB::table('vehicle_car_index')
            ->leftJoin('supplies_brand','supplies_brand.BRAND_ID','=','vehicle_car_index.CAR_BRAND_ID')
            ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index.CAR_PERSON_ID')
            ->leftJoin('vehicle_car_status','vehicle_car_status.CAR_STATUS_ID','=','vehicle_car_index.CAR_STATUS_ID')
            ->leftJoin('vehicle_car_type','vehicle_car_type.CAR_TYPE_ID','=','vehicle_car_index.CAR_TYPE_ID')
            ->leftJoin('vehicle_car_style','vehicle_car_style.CAR_STYLE_ID','=','vehicle_car_index.CAR_STYLE_ID')
            ->leftJoin('vehicle_car_power','vehicle_car_power.CAR_POWER_ID_NAME','=','vehicle_car_index.CAR_POWER_ID')
            ->leftJoin('supplies_color','supplies_color.COLOR_ID','=','vehicle_car_index.CAR_COLOR')
            ->where(function($q) use ($search){
                $q->where('CAR_REG','like','%'.$search.'%');
                $q->orwhere('BRAND_NAME','like','%'.$search.'%');  
                $q->orwhere('CAR_COLOR','like','%'.$search.'%');
                $q->orwhere('CAR_DETAIL','like','%'.$search.'%');    
            })
            ->orderBy('vehicle_car_index.CAR_ID', 'desc')    
            ->get();
        return view('manager_car.infomationcar',[
            'infocars' => $infocar,
            'search' => $search
        ]);
    }


    public function infocarindexsearch(Request $request)
    {
        $search = $request->search;
            $infocar = DB::table('vehicle_car_index')
            ->leftJoin('supplies_brand','supplies_brand.BRAND_ID','=','vehicle_car_index.CAR_BRAND_ID')
            ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index.CAR_PERSON_ID')
            ->leftJoin('vehicle_car_status','vehicle_car_status.CAR_STATUS_ID','=','vehicle_car_index.CAR_STATUS_ID')
            ->leftJoin('vehicle_car_type','vehicle_car_type.CAR_TYPE_ID','=','vehicle_car_index.CAR_TYPE_ID')
            ->leftJoin('vehicle_car_style','vehicle_car_style.CAR_STYLE_ID','=','vehicle_car_index.CAR_STYLE_ID')
            ->leftJoin('vehicle_car_power','vehicle_car_power.CAR_POWER_ID_NAME','=','vehicle_car_index.CAR_POWER_ID')
            ->leftJoin('supplies_color','supplies_color.COLOR_ID','=','vehicle_car_index.CAR_COLOR')
            ->where(function($q) use ($search){
                $q->where('CAR_REG','like','%'.$search.'%');
                $q->orwhere('BRAND_NAME','like','%'.$search.'%');  
                $q->orwhere('CAR_COLOR','like','%'.$search.'%');
                $q->orwhere('CAR_DETAIL','like','%'.$search.'%');    
            })
            ->orderBy('vehicle_car_index.CAR_ID', 'desc')    
            ->get();
        return view('manager_car.infomationcar',[
            'infocars' => $infocar,
            'search' => $search,
        ]);
    }

    public function createinfocar()
    {


        $driver =  DB::table('vehicle_car_driver')
        ->leftJoin('hrd_person','vehicle_car_driver.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('vehicle_car_driver.ACTIVE','=','true')->get();

        $carstatus =  DB::table('vehicle_car_status')->get();
        $cartype =  DB::table('vehicle_car_type')->get();
        $carstyle =  DB::table('vehicle_car_style')->get();
        $carpower =  DB::table('vehicle_car_power')->get();

        $carbrand =  DB::table('supplies_brand')->get();

        $carmechinbrand =  DB::table('vehicle_car_mechin_brand')->get();

        return view('manager_car.infomationcar_add',[
            'drivers' => $driver,
            'carstatuss'=>  $carstatus,
            'cartypes'=>  $cartype,
            'carstyles' =>  $carstyle,
            'carpowers' =>  $carpower,
            'carbrands' => $carbrand,
            'carmechinbrands'  => $carmechinbrand,
        ]);
    
  
    }


    public function saveinfocar(Request $request)
    {
      

            $addinfocar = new Vehiclecarindex(); 
            $addinfocar->ARTICLE_NAME = $request->ARTICLE_NAME;
            $addinfocar->CAR_REG = $request->CAR_REG;
            $addinfocar->CAR_DETAIL = $request->CAR_DETAIL;
            $addinfocar->CAR_PERSON_ID = $request->CAR_PERSON_ID;
            $addinfocar->CAR_STATUS_ID = $request->CAR_STATUS_ID;
            $addinfocar->CAR_TYPE_ID = $request->CAR_TYPE_ID;
            $addinfocar->CAR_STYLE_ID = $request->CAR_STYLE_ID;
            $addinfocar->CAR_BRAND_ID = $request->BRAND_ID;
            $addinfocar->CAR_POWER_ID = $request->CAR_POWER_ID;
            $addinfocar->CAR_MODELS_YEAR = $request->CAR_MODELS_YEAR;
            $addinfocar->CAR_FOMATS = $request->CAR_FOMATS;
            $addinfocar->CAR_MACHIN_BRAND_ID = $request->CAR_MACHIN_BRAND_ID;
            $addinfocar->CAR_COLOR = $request->CAR_COLOR;
            $addinfocar->CAR_SIT = $request->CAR_SIT;
            $addinfocar->CAR_NUM_BODY = $request->CAR_NUM_BODY;
            $addinfocar->CAR_NUM_BODY_ADDR = $request->CAR_NUM_BODY_ADDR;
            $addinfocar->CAR_MACHIN_NUM = $request->CAR_MACHIN_NUM;
            $addinfocar->CAR_MACHIN_ADDR = $request->CAR_MACHIN_ADDR;
            $addinfocar->CAR_HORSE = $request->CAR_HORSE;
            $addinfocar->CAR_CC = $request->CAR_CC;
            $addinfocar->CAR_GASS_NUM = $request->CAR_GASS_NUM;
            $addinfocar->CAR_SUP = $request->CAR_SUP;
            $addinfocar->CAR_PLOW = $request->CAR_PLOW;
            $addinfocar->CAR_LO = $request->CAR_LO;
            $addinfocar->CAR_WEIGHT = $request->CAR_WEIGHT;
            $addinfocar->CAR_SUM_WEIGHT = $request->CAR_SUM_WEIGHT;


            
         if($request->hasFile('picture')){
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinfocar->CAR_IMG = $contents;   
; 
        }


            $addinfocar->save();

            return redirect()->route('mcar.infomationcar'); 

    }


    public function editinfocar(Request $request,$idcar)
    {


        $infocaredit = DB::table('vehicle_car_index')
        ->leftJoin('supplies_brand','supplies_brand.BRAND_ID','=','vehicle_car_index.CAR_BRAND_ID')
        ->where('CAR_ID','=',$idcar)  
        ->first();



        $driver =  DB::table('vehicle_car_driver')
        ->leftJoin('hrd_person','vehicle_car_driver.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('vehicle_car_driver.ACTIVE','=','true')->get();

        $carstatus =  DB::table('vehicle_car_status')->get();
        $cartype =  DB::table('vehicle_car_type')->get();
        $carstyle =  DB::table('vehicle_car_style')->get();
        $carpower =  DB::table('vehicle_car_power')->get();
        $color =  DB::table('supplies_color')->get();

        $carbrand =  DB::table('supplies_brand')->get();

        $carmechinbrand =  DB::table('vehicle_car_mechin_brand')->get();

        return view('manager_car.infomationcar_edit',[
            'infocaredit'  => $infocaredit,
            'drivers' => $driver,
            'carstatuss'=>  $carstatus,
            'cartypes'=>  $cartype,
            'carstyles' =>  $carstyle,
            'carpowers' =>  $carpower,
            'carbrands' => $carbrand,
            'carmechinbrands'  => $carmechinbrand,
            'colors'  => $color,
        ]);
    
  
    }


    public function updateinfocar(Request $request)
    {
      
        $carid =  $request->CAR_ID;

            $updateinfocar = Vehiclecarindex::find($carid); 
            $updateinfocar->AR_NUM = $request->AR_NUM;
            $updateinfocar->ARTICLE_NAME = $request->ARTICLE_NAME;
            $updateinfocar->CAR_REG = $request->CAR_REG;
            $updateinfocar->CAR_DETAIL = $request->CAR_DETAIL;
            $updateinfocar->CAR_PERSON_ID = $request->CAR_PERSON_ID;
            $updateinfocar->CAR_STATUS_ID = $request->CAR_STATUS_ID;
            $updateinfocar->CAR_TYPE_ID = $request->CAR_TYPE_ID;
            $updateinfocar->CAR_STYLE_ID = $request->CAR_STYLE_ID;
            $updateinfocar->CAR_BRAND_ID = $request->BRAND_ID;
            $updateinfocar->CAR_POWER_ID = $request->CAR_POWER_ID;
            $updateinfocar->CAR_MODELS_YEAR = $request->CAR_MODELS_YEAR;
            $updateinfocar->CAR_FOMATS = $request->CAR_FOMATS;
            $updateinfocar->CAR_MACHIN_BRAND_ID = $request->CAR_MACHIN_BRAND_ID;
            $updateinfocar->CAR_COLOR = $request->CAR_COLOR;
            $updateinfocar->CAR_SIT = $request->CAR_SIT;
            $updateinfocar->CAR_NUM_BODY = $request->CAR_NUM_BODY;
            $updateinfocar->CAR_NUM_BODY_ADDR = $request->CAR_NUM_BODY_ADDR;
            $updateinfocar->CAR_MACHIN_NUM = $request->CAR_MACHIN_NUM;
            $updateinfocar->CAR_MACHIN_ADDR = $request->CAR_MACHIN_ADDR;
            $updateinfocar->CAR_HORSE = $request->CAR_HORSE;
            $updateinfocar->CAR_CC = $request->CAR_CC;
            $updateinfocar->CAR_GASS_NUM = $request->CAR_GASS_NUM;
            $updateinfocar->CAR_SUP = $request->CAR_SUP;
            $updateinfocar->CAR_PLOW = $request->CAR_PLOW;
            $updateinfocar->CAR_LO = $request->CAR_LO;
            $updateinfocar->CAR_WEIGHT = $request->CAR_WEIGHT;
            $updateinfocar->CAR_SUM_WEIGHT = $request->CAR_SUM_WEIGHT;


            
         if($request->hasFile('picture')){
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $updateinfocar->CAR_IMG = $contents;   
     
        }
       
            $updateinfocar->save();

            return redirect()->route('mcar.infomationcar'); 

    }


    
    public function repairinfocar(Request $request,$idcar)
    {


        $infocarrepair = DB::table('vehicle_car_index')
        ->leftJoin('supplies_brand','supplies_brand.BRAND_ID','=','vehicle_car_index.CAR_BRAND_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index.CAR_PERSON_ID')
        ->leftJoin('vehicle_car_status','vehicle_car_status.CAR_STATUS_ID','=','vehicle_car_index.CAR_STATUS_ID')
        ->leftJoin('vehicle_car_type','vehicle_car_type.CAR_TYPE_ID','=','vehicle_car_index.CAR_TYPE_ID')
        ->leftJoin('vehicle_car_style','vehicle_car_style.CAR_STYLE_ID','=','vehicle_car_index.CAR_STYLE_ID')
        ->leftJoin('vehicle_car_power','vehicle_car_power.CAR_POWER_ID_NAME','=','vehicle_car_index.CAR_POWER_ID')
        ->where('CAR_ID','=',$idcar)  
        ->first();

        $detailaccessory = Vehiclecaraccessorydetail::leftJoin('vehicle_car_accessory','vehicle_car_accessory.ACCESSORY_ID','=','vehicle_car_accessory_detail.ACCESSORY_ID')
        ->select('vehicle_car_accessory_detail.ID','ACCESSORY_NAME','ACCESSORY_AMOUNT','ACCESSORY_DATE','HR_FNAME','HR_LNAME','vehicle_car_accessory_detail.ACCESSORY_ID')
       ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_accessory_detail.ACCESSORY_PERSON_ID')
       ->where('CAR_ID','=',$idcar)
       ->orderBy('vehicle_car_accessory_detail.ID', 'desc') 
       ->get();

       $detailaccessoryasset = Vehiclecaraccessoryasset::select('ARTICLE_NUM','ARTICLE_NAME','ASSET_AMOUNT','RECEIVE_DATE','HR_FNAME','HR_LNAME','vehicle_car_accessory_asset.ASSET_ID','vehicle_car_accessory_asset.ID','ARTICLE_ID')
       ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_accessory_asset.ASSET_PERSON_ID')
       ->leftJoin('asset_article','asset_article.ARTICLE_ID','=','vehicle_car_accessory_asset.ASSET_ID')
       ->where('CAR_ID','=',$idcar)
       ->orderBy('vehicle_car_accessory_asset.ID', 'desc') 
       ->get();

       $detailact = Vehiclecaractdetail::leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_act_detail.ACT_PERSON_ID')
       ->where('CAR_ID','=',$idcar)
       ->orderBy('vehicle_car_act_detail.ACT_ID', 'desc') 
       ->get();

       $detailinsu = Vehiclecarinsudetail::leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_insu_detail.INSU_PERSON_ID')
       ->where('CAR_ID','=',$idcar)
       ->orderBy('vehicle_car_insu_detail.INSU_ID', 'desc') 
       ->get();

       $detailtax = Vehiclecartaxdetail::leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_tax_detail.TAX_PERSON_ID')
       ->where('CAR_ID','=',$idcar)
       ->orderBy('vehicle_car_tax_detail.TAX_ID', 'desc') 
       ->get();

       $carasset = DB::table('vehicle_car_accessory')->get(); 
       
       $assetarticle = DB::table('asset_article')->get(); 

       $detailcarcheck = Assetcare::where('ARTICLE_ID','=',$infocarrepair->ARTICLE_ID)
       ->orderBy('asset_care.ID', 'desc') 
       ->get();


       $detailplan = Assetcarelist::where('ARTICLE_ID','=',$infocarrepair->ARTICLE_ID)
       ->orderBy('CARE_LIST_ID', 'desc') 
       ->get();


    
       

       //-------------------------------------------------------

       $assetcarecheck = DB::table('asset_care_check')->get(); 

       $assetcaredetail = DB::table('asset_care_list')->where('ARTICLE_ID','=',$infocarrepair->ARTICLE_ID)->get(); 
     
       $leader = DB::table('gleave_leader')->get(); 
       
       if($request->type_check == '' || $request->type_check == null){
        $type_check = '';
       }else{
        $type_check = $request->type_check;
       }
       


       $infohisrepair = Informrepairindex::where('informrepair_index.ARTICLE_ID','=',$infocarrepair->ARTICLE_ID)
       ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informrepair_index.ARTICLE_ID')   
       ->orderBy('informrepair_index.ID', 'desc')     
       ->get();

        return view('manager_car.infomationcar_repair',[
            'infohisrepairs' => $infohisrepair,
            'infocarrepair'  => $infocarrepair,
            'detailaccessorys'  => $detailaccessory,
            'carassets'  => $carasset,
            'detailacts'  => $detailact,
            'detailinsus'  => $detailinsu,
            'detailtaxs'  => $detailtax,
            'detailaccessoryassets'  => $detailaccessoryasset,
            'assetcarechecks'  => $assetcarecheck,
            'assetcaredetails'  => $assetcaredetail,
            'leaders' => $leader,
            'type_check' => $type_check,
            'detailcarchecks' => $detailcarcheck,
            'assetarticles' => $assetarticle,
            'detailplans' => $detailplan,
          
        ]);
    
  
    }
    

function saveaccessory(Request $request)
    {  

        function DateThai($strDate)
{
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));

  $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
  }

        $ACCESSORY_SAVE = $request->ACCESSORY_DATE; 

        if($ACCESSORY_SAVE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE= null;
        }

        $addaccessory = new Vehiclecaraccessorydetail(); 
        $addaccessory->CAR_ID = $request->CAR_ID;
        $addaccessory->ACCESSORY_PERSON_ID = $request->ACCESSORY_PERSON_ID;
        $addaccessory->ACCESSORY_ID = $request->ACCESSORY_ID;
        $addaccessory->ACCESSORY_AMOUNT = $request->ACCESSORY_AMOUNT;
        $addaccessory->ACCESSORY_DATE = $ACCESSORY_SAVE;
        $addaccessory->save();

        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $request->CAR_ID,
            'type_check' => '',
        ]); 

    }
    
    

  
    function savecheckcar(Request $request)
    {  
    
    
        $CHECK_DATE_SAVE = $request->CHECK_DATE; 

        if($CHECK_DATE_SAVE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $CHECK_DATE_SAVE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $CHECK_DATE_SAVE= $y_st."-".$m_st."-".$d_st;
            }else{
            $CHECK_DATE_SAVE= null;
        }

        $addcheck = new Assetcare(); 
        //-------
 
        $addcheck->ARTICLE_ID = $request->ARTICLE_ID; 

        $CHECK_ARTICLE=  DB::table('asset_article')
        ->where('ARTICLE_ID','=',$request->ARTICLE_ID)->first();

        $addcheck->SUP_FSN = $CHECK_ARTICLE->SUP_FSN;
        $addcheck->YEAR_ID = $CHECK_ARTICLE->YEAR_ID;
        $addcheck->ARTICLE_NUM = $CHECK_ARTICLE->ARTICLE_NUM;
        $addcheck->ARTICLE_NAME = $CHECK_ARTICLE->ARTICLE_NAME;
        $addcheck->ARTICLE_PROP = $CHECK_ARTICLE->ARTICLE_PROP;
   
            //-------


        $addcheck->CARE_DATE = $CHECK_DATE_SAVE;
        $addcheck->CARE_TIME_BEGIN = $request->CHECK_TIME_BIGIN;
        $addcheck->CARE_TIME_END = $request->CHECK_TIME_END;

    
        $addcheck->CARE_HR_ID = $request->CHECK_PERSON_ID;

        $CHECK_HR_NAME=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->where('hrd_person.ID','=',$request->CHECK_PERSON_ID)->first();

        $addcheck->CARE_HR_NAME    = $CHECK_HR_NAME->HR_PREFIX_NAME.''.$CHECK_HR_NAME->HR_FNAME.' '.$CHECK_HR_NAME->HR_LNAME;
 

        $addcheck->CARE_LEADER_HR_ID = $request->CHECK_LEADER_ID;
        $CHECK_LEADER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->where('hrd_person.ID','=',$request->CHECK_LEADER_ID)->first();
        $addcheck->CARE_LEADER_HR_NAME    = $CHECK_LEADER->HR_PREFIX_NAME.''.$CHECK_LEADER->HR_FNAME.' '.$CHECK_LEADER->HR_LNAME;
       
        $addcheck->CARE_COMMENT = $request->CHECK_COMMENT;
        $addcheck->DATE_TIME_SAVE = date('Y-m-d H:i:s'); 

        $addcheck->CARE_CHECK_TYPE = $request->CARE_CHECK_TYPE;
   
        
        
        $addcheck->CARE_ANS_ID = '1';
        $addcheck->save();
     
        //---------------------------------------------------
        $CARE_ID = DB::table('asset_care')->max('ID');

        if($request->CARE_NAME != '' || $request->CARE_NAME != null){

          
            $CARE_NAME = $request->CARE_NAME;
            $CHECK_CARE_MILE = $request->CHECK_CARE_MILE;
            $CHECK_CARE_REMARK = $request->CHECK_CARE_REMARK;
            $CHECK_CARE_RESULT = $request->CHECK_CARE_RESULT;
            

            $number =count($CARE_NAME);
            $count= 0;

         
            for($count = 0; $count < $number; $count++)
            {            
               $add = new Assetcaredetailetc();
               $add->CARE_ID = $CARE_ID;
               $add->CARE_NAME = $CARE_NAME[$count];
               $add->CARE_ANS_DETAIL_ID = $CHECK_CARE_RESULT[$count];  
               $add->CARE_MILE = $CHECK_CARE_MILE[$count];  
               $add->COMMENT = $CHECK_CARE_REMARK[$count];

               $add->save(); 
             
     
            }
        }


        $check = DB::table('asset_care_detail_etc')
        ->where('CARE_ID','=',$CARE_ID)
        ->where('CARE_ANS_DETAIL_ID','=',2)
        ->count();
        
        if($check !=0){
            $upadtecheck = Assetcare::find($CARE_ID); 
            $upadtecheck->CARE_ANS_ID = '2';
            $upadtecheck->save(); 

        }
        


        $type_check = $request->type_check; 

        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $request->CAR_ID,
            'type_check' => $request->type_check,
        ]); 


    }
    

  function updatecheckcar(Request $request)
    {  
       $id = $request->ID;
    
        $CHECK_DATE_SAVE = $request->CHECK_DATE; 

        if($CHECK_DATE_SAVE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $CHECK_DATE_SAVE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $CHECK_DATE_SAVE= $y_st."-".$m_st."-".$d_st;
            }else{
            $CHECK_DATE_SAVE= null;
        }

        $update = Assetcare::find($id);   
        $update->ARTICLE_ID = $request->ARTICLE_ID; 

        $CHECK_ARTICLE=  DB::table('asset_article')
        ->where('ARTICLE_ID','=',$request->ARTICLE_ID)->first();

        $update->SUP_FSN = $CHECK_ARTICLE->SUP_FSN;
        $update->YEAR_ID = $CHECK_ARTICLE->YEAR_ID;
        $update->ARTICLE_NUM = $CHECK_ARTICLE->ARTICLE_NUM;
        $update->ARTICLE_NAME = $CHECK_ARTICLE->ARTICLE_NAME;
        $update->ARTICLE_PROP = $CHECK_ARTICLE->ARTICLE_PROP;
   
        $update->CARE_DATE = $CHECK_DATE_SAVE;
        $update->CARE_TIME_BEGIN = $request->CHECK_TIME_BIGIN;
        $update->CARE_TIME_END = $request->CHECK_TIME_END;

    
        $update->CARE_HR_ID = $request->CHECK_PERSON_ID;

        $CHECK_HR_NAME=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->where('hrd_person.ID','=',$request->CHECK_PERSON_ID)->first();
        
        $update->CARE_HR_NAME    = $CHECK_HR_NAME->HR_PREFIX_NAME.''.$CHECK_HR_NAME->HR_FNAME.' '.$CHECK_HR_NAME->HR_LNAME;
 

        $update->CARE_LEADER_HR_ID = $request->CHECK_LEADER_ID;
        $CHECK_LEADER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->where('hrd_person.ID','=',$request->CHECK_LEADER_ID)->first();
        $update->CARE_LEADER_HR_NAME    = $CHECK_LEADER->HR_PREFIX_NAME.''.$CHECK_LEADER->HR_FNAME.' '.$CHECK_LEADER->HR_LNAME;
       
        $update->CARE_COMMENT = $request->CHECK_COMMENT;
        $update->DATE_TIME_SAVE = date('Y-m-d H:i:s'); 
        $update->CARE_CHECK_TYPE = $request->CARE_CHECK_TYPE;  
        $update->CARE_ANS_ID = '1';
        $update->save();
        
        $type_check = $request->type_check; 

        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $request->CAR_ID,
            'type_check' => $request->type_check,
        ]); 


    }

    function infomationcar_destroy(Request $request,$id,$idcar)
    {
        $type_check = 'checkcar';

        Assetcare::destroy($id);
        DB::table('asset_care_detail_etc')->where('CARE_ID','=',$id)->delete();

        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $idcar,
            'type_check' => $type_check,
        ]); 
    }
    
    
function saveasset(Request $request)
    {  

        function DateThai($strDate)
    {
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));

    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
    }  
        $addasset = new Vehiclecaraccessoryasset(); 
        $addasset->CAR_ID = $request->CAR_ID;
        $addasset->ASSET_ID = $request->ASSET_ID;
        $addasset->ASSET_AMOUNT = $request->ASSET_AMOUNT;
        $addasset->ASSET_PERSON_ID = $request->ASSET_PERSON_ID;
        $addasset->save();


        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $request->CAR_ID,
            'type_check' => 'assetin',
        ]); 
    }


    function editasset(Request $request)
    {  
    
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
    
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
        }  

             $id = $request->ID;

 
            $updateasset = Vehiclecaraccessoryasset::find($id);
            $updateasset->CAR_ID = $request->CAR_ID;
            $updateasset->ASSET_ID = $request->ASSET_ID;
            $updateasset->ASSET_AMOUNT = $request->ASSET_AMOUNT;
            $updateasset->ASSET_PERSON_ID = $request->ASSET_PERSON_ID;
            $updateasset->save();
    
    
            return redirect()->route('mcar.repairinfocar',[
                'idcar' => $request->CAR_ID,
                'type_check' => 'assetin',
            ]); 
    
             
    }


    

    function destroyasset($idcar,$idref) { 
                
        Vehiclecaraccessoryasset::destroy($idref);         
        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $idcar,
            'type_check' => 'assetin',
        ]); 
      
    }

    //-------------------------------------


    function saveact(Request $request)
    {  

                    function DateThai($strDate)
            {
            $strYear = date("Y",strtotime($strDate))+543;
            $strMonth= date("n",strtotime($strDate));
            $strDay= date("j",strtotime($strDate));

            $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            $strMonthThai=$strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear";
            }

        $ACCESSORY_SAVE = $request->ACT_BEGIN_DATE; 

        if($ACCESSORY_SAVE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE= null;
        }

        $ACCESSORY_SAVE2 = $request->ACT_END_DATE;

        if($ACCESSORY_SAVE2 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE2)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE2= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE2= null;
        }

        $addact = new Vehiclecaractdetail(); 
        $addact->CAR_ID = $request->CAR_ID;
        $addact->ACT_COMPANY = $request->ACT_COMPANY;
        $addact->ACT_INSURANCE = $request->ACT_INSURANCE;
        $addact->ACT_CHIP = $request->ACT_CHIP;
        $addact->ACT_BEGIN_DATE = $ACCESSORY_SAVE;
        $addact->ACT_END_DATE = $ACCESSORY_SAVE2;
        $addact->ACT_END_TIME = $request->ACT_END_TIME;
        $addact->ACT_PERSON_ID = $request->ACT_PERSON_ID;
        $addact->ACT_AGENT = $request->ACT_AGENT;
        $addact->ACT_AGENT_TEL = $request->ACT_AGENT_TEL;
        $addact->save();

        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $request->CAR_ID,
            'type_check' => 'checkact',
        ]); 


    }


    function editact(Request $request)
    {  

        function DateThai($strDate)
{
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));

  $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
  }

        $ACCESSORY_SAVE = $request->ACT_BEGIN_DATE; 

        if($ACCESSORY_SAVE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE= null;
        }

        $ACCESSORY_SAVE2 = $request->ACT_END_DATE;

        if($ACCESSORY_SAVE2 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE2)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE2= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE2= null;
        }

        
        $id = $request->ACT_ID;
           
       
        $updateact = Vehiclecaractdetail::find($id);
        $updateact->CAR_ID = $request->CAR_ID;
        $updateact->ACT_COMPANY = $request->ACT_COMPANY;
        $updateact->ACT_INSURANCE = $request->ACT_INSURANCE;
        $updateact->ACT_CHIP = $request->ACT_CHIP;
        $updateact->ACT_BEGIN_DATE = $ACCESSORY_SAVE;
        $updateact->ACT_END_DATE = $ACCESSORY_SAVE2;
        $updateact->ACT_END_TIME = $request->ACT_END_TIME;
        $updateact->ACT_PERSON_ID = $request->ACT_PERSON_ID;
        $updateact->ACT_AGENT = $request->ACT_AGENT;
        $updateact->ACT_AGENT_TEL = $request->ACT_AGENT_TEL;

      

        $updateact->save();

        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $request->CAR_ID,
            'type_check' => 'checkact',
        ]); 

    }



    function destroyact($idcar,$idref) { 
                
        Vehiclecaractdetail::destroy($idref);         
        //return redirect()->action('SalaryController@infousersalary'); 
        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $idcar,
            'type_check' => 'checkact',
        ]); 
      
    }

  //------------------------------------------------------------  
    function saveinsu(Request $request)
    {  
        //return $request->all(); 

        function DateThai($strDate)
{
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));

  $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
  }

        $ACCESSORY_SAVE = $request->INSU_BEGIN_DATE; 

        if($ACCESSORY_SAVE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE= null;
        }

        $ACCESSORY_SAVE2 = $request->INSU_END_DATE;

        if($ACCESSORY_SAVE2 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE2)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE2= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE2= null;
        }

        $addinsu = new Vehiclecarinsudetail(); 
        $addinsu->CAR_ID = $request->CAR_ID;
        $addinsu->INSU_COMPANY = $request->INSU_COMPANY;
        $addinsu->INSU_INSURANCE = $request->INSU_INSURANCE;
        $addinsu->INSU_BEGIN_DATE = $ACCESSORY_SAVE;
        $addinsu->INSU_END_DATE = $ACCESSORY_SAVE2;
        $addinsu->INSU_PERSON_ID = $request->INSU_PERSON_ID;
        $addinsu->INSU_AGENT = $request->INSU_AGENT;
        $addinsu->INSU_AGENT_TEL = $request->INSU_AGENT_TEL;
        $addinsu->INSU_CHIP = $request->INSU_CHIP;
        $addinsu->INSU_END_TIME = $request->INSU_END_TIME;
        $addinsu->save();

     /*  $details = Vehiclecarinsudetail::leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_insu_detail.INSU_PERSON_ID')
       ->where('CAR_ID','=',$request->CAR_ID)
       ->orderBy('vehicle_car_insu_detail.INSU_ID', 'desc') 
       ->get();
      
       $output ='<table class="table">
       <thead>
         <tr>
         <th scope="col">ชื่อบริษัท</th>
         <th scope="col">กรมธรรม์</th>
         <th scope="col">เบี้ยประกัน</th>
         <th scope="col">คุ้มครองวันที่</th>
         <th scope="col">คุ้มครองถึงวันที่</th>
         <th scope="col">เวลา</th>
         <th scope="col">ตัวแทน</th>
         <th scope="col">โทร</th>
         <th scope="col">ผู้บันทึก</th>
           <th    width="12%">คำสั่ง</th> 
         </tr>
       </thead><tbody>';
       foreach($details as $detail){
        $output.='   <tr><td>'.$detail->INSU_COMPANY.'</td>
                    <td>'.$detail->INSU_INSURANCE.'</td>
                    <td>'.$detail->INSU_CHIP.'</td>
                    <td>'.DateThai($detail->INSU_BEGIN_DATE).'</td>
                    <td>'.DateThai($detail->INSU_END_DATE).'</td> 
                    <td>'.$detail->INSU_END_TIME.'</td>
                    <td>'.$detail->INSU_AGENT.'</td>
                    <td>'.$detail->INSU_AGENT_TEL.'</td>
                    <td>'.$detail->HR_FNAME.' '.$detail->HR_LNAME.'</td>
                    <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">
                                    ทำรายการ
                                </button>
                                <div class="dropdown-menu" style="width:10px">

                                    <a class="dropdown-item" href="" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">แก้ไขข้อมูล</a>
                                    
                                    <a class="dropdown-item"  href="" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">ลบ</a>
                                   
                                </div>
                        </div>
                    
                    </td>
                    
                    </td></tr>';
       }

       $output.='</tbody></table>';
      
       echo $output;*/

       return redirect()->route('mcar.repairinfocar',[
        'idcar' => $request->CAR_ID,
        'type_check' => 'checkinsu',
    ]); 



    }


    function editinsu(Request $request)
    {  
        //return $request->all(); 

        function DateThai($strDate)
{
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));

  $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
  }

        $ACCESSORY_SAVE = $request->INSU_BEGIN_DATE; 

        if($ACCESSORY_SAVE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE= null;
        }

        $ACCESSORY_SAVE2 = $request->INSU_END_DATE;

        if($ACCESSORY_SAVE2 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE2)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE2= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE2= null;
        }

        
        $id = $request->INSU_ID;
           
        $updateinsu = Vehiclecarinsudetail::find($id);
        $updateinsu->CAR_ID = $request->CAR_ID;
        $updateinsu->INSU_COMPANY = $request->INSU_COMPANY;
        $updateinsu->INSU_INSURANCE = $request->INSU_INSURANCE;
        $updateinsu->INSU_BEGIN_DATE = $ACCESSORY_SAVE;
        $updateinsu->INSU_END_DATE = $ACCESSORY_SAVE2;
        $updateinsu->INSU_PERSON_ID = $request->INSU_PERSON_ID;
        $updateinsu->INSU_AGENT = $request->INSU_AGENT;
        $updateinsu->INSU_AGENT_TEL = $request->INSU_AGENT_TEL;
        $updateinsu->INSU_CHIP = $request->INSU_CHIP;
        $updateinsu->INSU_END_TIME = $request->INSU_END_TIME;
        $updateinsu->save();

     /*  $details = Vehiclecarinsudetail::leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_insu_detail.INSU_PERSON_ID')
       ->where('CAR_ID','=',$request->CAR_ID)
       ->orderBy('vehicle_car_insu_detail.INSU_ID', 'desc') 
       ->get();
      
       $output ='<table class="table">
       <thead>
         <tr>
         <th scope="col">ชื่อบริษัท</th>
         <th scope="col">กรมธรรม์</th>
         <th scope="col">เบี้ยประกัน</th>
         <th scope="col">คุ้มครองวันที่</th>
         <th scope="col">คุ้มครองถึงวันที่</th>
         <th scope="col">เวลา</th>
         <th scope="col">ตัวแทน</th>
         <th scope="col">โทร</th>
         <th scope="col">ผู้บันทึก</th>
           <th    width="12%">คำสั่ง</th> 
         </tr>
       </thead><tbody>';
       foreach($details as $detail){
        $output.='   <tr><td>'.$detail->INSU_COMPANY.'</td>
                    <td>'.$detail->INSU_INSURANCE.'</td>
                    <td>'.$detail->INSU_CHIP.'</td>
                    <td>'.DateThai($detail->INSU_BEGIN_DATE).'</td>
                    <td>'.DateThai($detail->INSU_END_DATE).'</td> 
                    <td>'.$detail->INSU_END_TIME.'</td>
                    <td>'.$detail->INSU_AGENT.'</td>
                    <td>'.$detail->INSU_AGENT_TEL.'</td>
                    <td>'.$detail->HR_FNAME.' '.$detail->HR_LNAME.'</td>
                    <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">
                                    ทำรายการ
                                </button>
                                <div class="dropdown-menu" style="width:10px">

                                    <a class="dropdown-item" href="" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">แก้ไขข้อมูล</a>
                                    
                                    <a class="dropdown-item"  href="" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">ลบ</a>
                                   
                                </div>
                        </div>
                    
                    </td>
                    
                    </td></tr>';
       }

       $output.='</tbody></table>';
      
       echo $output;*/

       return redirect()->route('mcar.repairinfocar',[
        'idcar' => $request->CAR_ID,
        'type_check' => 'checkinsu',
    ]); 



    }

    

    function destroyinsu($idcar,$idref) { 
                
        Vehiclecarinsudetail::destroy($idref);         
        //return redirect()->action('SalaryController@infousersalary'); 
        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $idcar,
            'type_check' => 'checkinsu',
        ]); 
      
    }


//------------------------------------------------------------ 

    function savetax(Request $request)
    {  
        //return $request->all(); 

        function DateThai($strDate)
{
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));

  $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
  }

        $ACCESSORY_SAVE = $request->TAX_BEGIN_DATE; 

        if($ACCESSORY_SAVE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE= null;
        }

        $ACCESSORY_SAVE2 = $request->TAX_END_DATE;

        if($ACCESSORY_SAVE2 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE2)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE2= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE2= null;
        }

        $addtax = new Vehiclecartaxdetail(); 
        $addtax->CAR_ID = $request->CAR_ID;
        $addtax->TAX_BILL = $request->TAX_BILL;
        $addtax->TAX_PRICE = $request->TAX_PRICE;
        $addtax->TAX_BEGIN_DATE = $ACCESSORY_SAVE;
        $addtax->TAX_END_DATE = $ACCESSORY_SAVE2;
        $addtax->TAX_PERSON_ID = $request->TAX_PERSON_ID;
        $addtax->save();

      /* $details = Vehiclecartaxdetail::leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_tax_detail.TAX_PERSON_ID')
       ->where('CAR_ID','=',$request->CAR_ID)
       ->orderBy('vehicle_car_tax_detail.TAX_ID', 'desc') 
       ->get();
      
       $output ='<table class="table">
       <thead>
         <tr>
         <th scope="col">เลขที่ใบเสร็จรับเงิน</th>
         <th scope="col">ค่าภาษี</th>
         <th scope="col">วันที่เสียภาษี</th>
         <th scope="col">วันที่ครบกำหนด</th>
         <th scope="col">ผู้บันทึก</th>
        <th    width="12%">คำสั่ง</th> 
         </tr>
       </thead><tbody>';
       foreach($details as $detail){
        $output.='   <tr><td>'.$detail->TAX_BILL.'</td>
                    <td>'.$detail->TAX_PRICE.'</td>
                    <td>'.DateThai($detail->TAX_BEGIN_DATE).'</td>
                    <td>'.DateThai($detail->TAX_END_DATE).'</td> 
                    <td>'.$detail->HR_FNAME.' '.$detail->HR_LNAME.'</td>
                    <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">
                                    ทำรายการ
                                </button>
                                <div class="dropdown-menu" style="width:10px">

                                    <a class="dropdown-item" href="" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">แก้ไขข้อมูล</a>
                                    
                                    <a class="dropdown-item"  href="" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">ลบ</a>
                                   
                                </div>
                        </div>
                    
                    </td>
                    
                    </td></tr>';
       }

       $output.='</tbody></table>';
      
       echo $output;*/

       return redirect()->route('mcar.repairinfocar',[
        'idcar' => $request->CAR_ID,
        'type_check' => 'checktax',
    ]); 

    }

    function edittax(Request $request)
    {  
        //return $request->all(); 

        function DateThai($strDate)
{
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));

  $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
  }

        $ACCESSORY_SAVE = $request->TAX_BEGIN_DATE; 

        if($ACCESSORY_SAVE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE= null;
        }

        $ACCESSORY_SAVE2 = $request->TAX_END_DATE;

        if($ACCESSORY_SAVE2 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_SAVE2)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_SAVE2= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_SAVE2= null;
        }

        $id = $request->TAX_ID;
        $updatetax = Vehiclecartaxdetail::find($id);
        $updatetax->CAR_ID = $request->CAR_ID;
        $updatetax->TAX_BILL = $request->TAX_BILL;
        $updatetax->TAX_PRICE = $request->TAX_PRICE;
        $updatetax->TAX_BEGIN_DATE = $ACCESSORY_SAVE;
        $updatetax->TAX_END_DATE = $ACCESSORY_SAVE2;
        $updatetax->TAX_PERSON_ID = $request->TAX_PERSON_ID;
        $updatetax->save();

      /* $details = Vehiclecartaxdetail::leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_tax_detail.TAX_PERSON_ID')
       ->where('CAR_ID','=',$request->CAR_ID)
       ->orderBy('vehicle_car_tax_detail.TAX_ID', 'desc') 
       ->get();
      
       $output ='<table class="table">
       <thead>
         <tr>
         <th scope="col">เลขที่ใบเสร็จรับเงิน</th>
         <th scope="col">ค่าภาษี</th>
         <th scope="col">วันที่เสียภาษี</th>
         <th scope="col">วันที่ครบกำหนด</th>
         <th scope="col">ผู้บันทึก</th>
        <th    width="12%">คำสั่ง</th> 
         </tr>
       </thead><tbody>';
       foreach($details as $detail){
        $output.='   <tr><td>'.$detail->TAX_BILL.'</td>
                    <td>'.$detail->TAX_PRICE.'</td>
                    <td>'.DateThai($detail->TAX_BEGIN_DATE).'</td>
                    <td>'.DateThai($detail->TAX_END_DATE).'</td> 
                    <td>'.$detail->HR_FNAME.' '.$detail->HR_LNAME.'</td>
                    <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">
                                    ทำรายการ
                                </button>
                                <div class="dropdown-menu" style="width:10px">

                                    <a class="dropdown-item" href="" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">แก้ไขข้อมูล</a>
                                    
                                    <a class="dropdown-item"  href="" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">ลบ</a>
                                   
                                </div>
                        </div>
                    
                    </td>
                    
                    </td></tr>';
       }

       $output.='</tbody></table>';
      
       echo $output;*/

       return redirect()->route('mcar.repairinfocar',[
        'idcar' => $request->CAR_ID,
        'type_check' => 'checktax',
    ]); 

    }



    function destroytax($idcar,$idref) { 
                
        Vehiclecartaxdetail::destroy($idref);         
        //return redirect()->action('SalaryController@infousersalary'); 
        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $idcar,
            'type_check' => 'checktax',
        ]); 
      
    }


    //-----------------------------------------------------------------
    
function editaccessory(Request $request)
    {  
    
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));

        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

        $ACCESSORY_EDIT = $request->ACCESSORY_DATE; 

        if($ACCESSORY_EDIT != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ACCESSORY_EDIT)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $ACCESSORY_EDIT= $y_st."-".$m_st."-".$d_st;
            }else{
            $ACCESSORY_EDIT= null;
        }

             
        $id = $request->ID;
        $updateaccessory= Vehiclecaraccessorydetail::find($id);
        $updateaccessory->ACCESSORY_PERSON_ID = $request->ACCESSORY_PERSON_ID;
        $updateaccessory->ACCESSORY_ID = $request->ACCESSORY_ID;
        $updateaccessory->ACCESSORY_AMOUNT = $request->ACCESSORY_AMOUNT;
        $updateaccessory->ACCESSORY_DATE = $ACCESSORY_EDIT;
        $updateaccessory->save();

      
      
        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $request->CAR_ID,
            'type_check' => '',
        ]); 
      

     
      /*  $details = Vehiclecaraccessorydetail::leftJoin('vehicle_car_accessory','vehicle_car_accessory.ACCESSORY_ID','=','vehicle_car_accessory_detail.ACCESSORY_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_accessory_detail.ACCESSORY_PERSON_ID')
        ->where('CAR_ID','=',$request->CAR_ID)
        ->orderBy('vehicle_car_accessory_detail.ID', 'desc') 
        ->get();
       
        $output ='<table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
        <thead style="background-color: #FFEBCD;">
          <tr>
            <th scope="col">อุปกรณ์</th>
            <th scope="col">จำนวน</th>
            <th scope="col">วันที่ได้รับ</th>
            <th scope="col">ผู้บันทึก</th>
            <th    width="12%">คำสั่ง</th> 
          </tr>
        </thead><tbody>';
        foreach($details as $detail){
         $output.='   <tr><td class="text-font text-pedding">'.$detail->ACCESSORY_NAME.'</td>
                     <td class="text-font text-pedding">'.$detail->ACCESSORY_AMOUNT.'</td>
                     <td class="text-font text-pedding">'.DateThai($detail->ACCESSORY_DATE).'</td>
                     <td class="text-font text-pedding">'.$detail->HR_FNAME.' '.$detail->HR_LNAME.'</td>
                     <td>
                     <div class="dropdown">
                         <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">
                                     ทำรายการ
                                 </button>
                                 <div class="dropdown-menu" style="width:10px">
 
                                 <a class="dropdown-item" href=""  data-toggle="modal" data-target="#editasset'.$detail->ASSET_ID.'" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">แก้ไขข้อมูล</a>                                                                                                                        
                                 <a class="dropdown-item"  href="#" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;"  onclick="return confirm("ต้องการที่จะยกเลิกการแก้ไขข้อมูล ?")">ลบ</a>
                                    
                                 </div>
                         </div>
                     
                     </td>
                     
                     
                     </tr>';
        }
 
        $output.='</tbody></table>';
       
        echo $output;*/

         
      
    }



    function destroyaccessory($idcar,$idref) { 
                
        Vehiclecaraccessorydetail::destroy($idref);         
        //return redirect()->action('SalaryController@infousersalary'); 
        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $idcar,
            'type_check' => '',
        ]); 
      
    }


    function detailcheck(Request $request)
    {  
        //return $request->all(); 

        function DateThai($strDate)
        {
          $strYear = date("Y",strtotime($strDate))+543;
          $strMonth= date("n",strtotime($strDate));
          $strDay= date("j",strtotime($strDate));
        
          $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
          $strMonthThai=$strMonthCut[$strMonth];
          return "$strDay $strMonthThai $strYear";
          }

        $detailcarcheck = Assetcare::where('ID','=',$request->id) 
        ->first();


        if($detailcarcheck->CARE_ANS_ID == 1){
        $check = 'ปกติ';
            }else{
        $check = 'ผิดปกติ';
        }

            if($detailcarcheck->CARE_CHECK_TYPE == 1){
                $type = 'ตรวจเช็คตามแผน';
            }else if($detailcarcheck->CARE_CHECK_TYPE == 2){
                $type = 'ตรวจเช็คอื่นๆ';
            }else{
                $type = 'เปลี่ยนอะไหล่';
            }

        $output='<div class="row">
        <div class="col-sm-1">
        <label >วันที่ตรวจ</label>
        </div>
        <div class="col-sm-2"> 
        '.DateThai($detailcarcheck->CARE_DATE).'
        </div>
        <div class="col-sm-2">
        <label >ผลการตรวจ</label>
        </div>
        <div class="col-sm-2"> 
        '.$check.'
        </div>
        <div class="col-sm-2">
        <label >ผู้ตรวจเช็คอุปกรณ์</label>
        </div>
        <div class="col-sm-2"> 
        '.$detailcarcheck->CARE_HR_NAME.'
        </div>
        </div>
        <div class="row">
        <div class="col-sm-1">
        <label >เวลา</label>
        </div>
        <div class="col-sm-2"> 
        '.$detailcarcheck->CARE_TIME_BEGIN.' - '.$detailcarcheck->CARE_TIME_END.'
        </div>
        <div class="col-sm-2">
        <label >ประเภท</label>
        </div>
        <div class="col-sm-2"> 
        '.$type.'
        </div>
        <div class="col-sm-2">
        <label >หัวหน้ารับรอง</label>
        </div>
        <div class="col-sm-2"> 
        '.$detailcarcheck->CARE_LEADER_HR_NAME.'
        </div>
        </div>
        <br><br>';

       $details = Assetcaredetailetc::leftJoin('asset_care_ans_detail','asset_care_ans_detail.CARE_ANS_DETAIL_ID','=','asset_care_detail_etc.CARE_ANS_DETAIL_ID')
       ->where('CARE_ID','=',$request->id)
       ->orderBy('asset_care_detail_etc.ID', 'desc') 
       ->get();

      
       $output.='<table class="table">
       <thead>
         <tr style="background-color: #FFEBCD;">
         <th style="border: 1px solid black;" scope="col">รายการตรวจ</th>
         <th style="border: 1px solid black;" scope="col">ผลการตรวจ</th>
         <th style="border: 1px solid black;" scope="col">เลขไมล์</th>
         <th style="border: 1px solid black;" scope="col">หมายเหตุ</th>
        
       
         </tr>
       </thead><tbody>';
       foreach($details as $detail){
        $output.='   <tr><td>'.$detail->CARE_NAME.'</td>
                    <td>'.$detail->CARE_ANS_DETAIL_NAME.'</td>
                    <td>'.$detail->CARE_MILE.'</td>
                    <td>'.$detail->COMMENT.'</td> 
                   
                  </tr>';
       }

       $output.='</tbody></table>';
      
       echo $output;
    }

//-------------------------------------------------------

    function saveplan(Request $request)
    {  
 

        $addplan = new Assetcarelist(); 
        $addplan->CARE_LIST_NAME = $request->PLAN_CARE_LIST_NAME;
        $addplan->ARTICLE_ID = $request->PLAN_ARTICLE_ID;
        $addplan->save();

        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $request->CAR_ID,
            'type_check' => 'checkplan',
        ]); 
    

     /*  $details = Assetcarelist::where('ARTICLE_ID','=',$request->PLAN_ARTICLE_ID)
       ->orderBy('CARE_LIST_ID', 'desc') 
       ->get();
      
       $output ='<table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
       <thead style="background-color: #FFEBCD;">
         <tr>
         <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" >รายการบำรุงรักษา</th>
                                
         <th   class="text-font" style="border-color:#F0FFFF;text-align: center;"   width="12%">คำสั่ง</th> 
         </tr>
       </thead><tbody>';
       foreach($details as $detail){
        $output.='   <tr><td>'.$detail->CARE_LIST_NAME.'</td>
 
                    <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">
                                    ทำรายการ
                                </button>
                                <div class="dropdown-menu" style="width:10px">

                                    <a class="dropdown-item" href="" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">แก้ไขข้อมูล</a>
                                    
                                    <a class="dropdown-item"  href="" style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;">ลบ</a>
                                   
                                </div>
                        </div>
                    
                    </td>
                    
                    </td></tr>';
       }

       $output.='</tbody></table>';
      
       echo $output;*/
    }
    

    function editplan(Request $request)
    {  
 
        $id = $request->CARE_LIST_ID;

        $updateplan = Assetcarelist::find($id);
        $updateplan->CARE_LIST_NAME = $request->PLAN_CARE_LIST_NAME;
        $updateplan->ARTICLE_ID = $request->PLAN_ARTICLE_ID;
        $updateplan->save();

        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $request->CAR_ID,
            'type_check' => 'checkplan',
        ]); 
    }


    function destroyplan($idcar,$idref) { 
                
        Assetcarelist::destroy($idref);         
        //return redirect()->action('SalaryController@infousersalary'); 
        return redirect()->route('mcar.repairinfocar',[
            'idcar' => $idcar,
            'type_check' => 'checkplan',
        ]); 
      
    }
    
    
    //=================================================================

    function activeinfocar(Request $request)
    {  
        //return $request->all(); 
        $id = $request->idcar;
        $active = Vehiclecarindex::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }

    
    public function destroyinfocar($idcar) { 
                
        Vehiclecarindex::destroy($idcar);         
        //return redirect()->action('SalaryController@infousersalary'); 
        return redirect()->route('mcar.infomationcar');    
    }

    

    public function report()
    {


        return view('manager_car.report_car');
    
  
    }



    public function infomationcarreport(Request $request)
    {
        if(!empty($request->_token)){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $yearbudget = $request->YEAR_ID;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_car.infomationcarreport.search' => $search,
                'manager_car.infomationcarreport.status' => $status,
                'manager_car.infomationcarreport.datebigin' => $datebigin,
                'manager_car.infomationcarreport.dateend' => $dateend,
                'manager_car.infomationcarreport.yearbudget' => $yearbudget,
            ]);
        }elseif(!empty(session('manager_car.infomationcarreport'))){
            $search = session('manager_car.infomationcarreport.search');
            $status = session('manager_car.infomationcarreport.status');
            $datebigin = session('manager_car.infomationcarreport.datebigin');
            $dateend = session('manager_car.infomationcarreport.dateend');
            $yearbudget = session('manager_car.infomationcarreport.yearbudget');
        }else{
            $search = '';
            $status = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
            $yearbudget = getBudgetyear();
        }
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
        $y_sub_st = $date_arrary[0];
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);
        $y_sub_e = $date_arrary_e[0];
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
            if($status == null){

                // $infocar = Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                // ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','BACK_DATE','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where(function($q) use ($search){
                    $q->where('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_SET_NAME','like','%'.$search.'%');
                    $q->orwhere('COMMENT','like','%'.$search.'%');
                })
                ->where('RESERVE_BEGIN_DATE','>=', $displaydate_bigen)
                ->where('RESERVE_BEGIN_DATE','<=', $displaydate_end)
                ->get();
            }else{
                // $inforefer = DB::table('vehicle_car_refer')
                // ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
                // $infocar = Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                // ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','BACK_DATE','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where('CAR_SET_ID','=',$status)
                ->where(function($q) use ($search){
                    $q->where('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_SET_NAME','like','%'.$search.'%');
                    $q->orwhere('COMMENT','like','%'.$search.'%');
                })
                ->where('RESERVE_BEGIN_DATE','>=', $displaydate_bigen)
                ->where('RESERVE_BEGIN_DATE','<=', $displaydate_end)
                ->get();
            }
       
        $year_id = $yearbudget;
        $infocar_sendstatus = DB::table('vehicle_car_index')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        return view('manager_car.carreport',[
            'infocars' => $infocar,
            'infocar_sendstatuss' => $infocar_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'year_id'=> $year_id,
            'budgets'=> $budget,
            'search'=> $search]);
    }
    public function carposition(Request $request)
    {    
        $infocar = DB::table('vehicle_car_index')->get();
        
        $infocar_position = DB::table('vehicle_car_position')->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $infoposition = DB::table('hrd_position')->where('HR_POSITION_CHECK_HOLIDAY','=','True')->get();

        return view('manager_car.carposition',[
            'infocar_position' => $infocar_position,
            'infoposition' => $infoposition,
            'infocar' => $infocar,
           ]);
    }
    public function carposition_save(Request $request)
    {    
        $add = new Vehiclecarposition();

        $poid = $request->POSITION_ID;
        $idpo = DB::table('hrd_position')->where('HR_POSITION_ID','=',$poid)->first();

        $add->POSITION_ID = $idpo->HR_POSITION_ID;
        $add->POSITION_NAME = $idpo->HR_POSITION_NAME;

        $carid = $request->CAR_ID;
        $idcar = DB::table('vehicle_car_index')->where('CAR_ID','=',$carid)->first();

        $add->CAR_ID = $idcar->CAR_ID;
        $add->CAR_REG = $idcar->CAR_REG;
        $add->ARTICLE_ID = $idcar->ARTICLE_ID;

        $add->save();

        return redirect()->route('mcar.carposition');
    }

    public function carposition_update(Request $request)
    {    
        $id = $request->CAR_POSITION_ID;

        // Vehiclecarposition::where('CAR_POSITION_ID','=',$id)->delete();

        $update = Vehiclecarposition::find($id);

        $poid = $request->POSITION_ID;
        $idpo = DB::table('hrd_position')->where('HR_POSITION_ID','=',$poid)->first();

        $update->POSITION_ID = $idpo->HR_POSITION_ID;
        $update->POSITION_NAME = $idpo->HR_POSITION_NAME;

        $carid = $request->CAR_ID;
        $idcar = DB::table('vehicle_car_index')->where('CAR_ID','=',$carid)->first();

        $update->CAR_ID = $idcar->CAR_ID;
        $update->CAR_REG = $idcar->CAR_REG;
        $update->ARTICLE_ID = $idcar->ARTICLE_ID;

        $update->save();

        return redirect()->route('mcar.carposition');
    }

    public function carposition_delete(Request $request,$id)
    { 
        Vehiclecarposition::where('CAR_POSITION_ID','=',$id)->delete();
        
        return redirect()->route('mcar.carposition');
    }
    public function reportcarposition(Request $request)
    {    
        $infocar = DB::table('vehicle_car_index')->get();
        $infocar_position = Vehiclecarposition::select('supplies_soldout.SOLDOUT_DATE','vehicle_car_index.ARTICLE_NAME','supplies_brand.BRAND_NAME','asset_article.YEAR_ID','vehicle_car_index.CAR_CC','vehicle_car_index.CAR_REG','vehicle_car_position.POSITION_NAME','asset_article.PRICE_PER_UNIT','asset_article.RECEIVE_DATE','asset_article.EXPIRE_DATE')
        ->leftjoin('vehicle_car_index','vehicle_car_position.CAR_ID','=','vehicle_car_index.CAR_ID')
        ->leftjoin('asset_article','vehicle_car_index.AR_NUM','=','asset_article.ARTICLE_NUM')
        ->leftjoin('supplies_brand','supplies_brand.BRAND_ID','=','asset_article.BRAND_ID')
        ->leftjoin('supplies_model','supplies_model.MODEL_ID','=','asset_article.MODEL_ID')
        ->leftjoin('supplies_soldout','supplies_soldout.SOLDOUT_ARTICLE_ID','=','vehicle_car_position.ARTICLE_ID')
        ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $infoposition = DB::table('hrd_position')->where('HR_POSITION_CHECK_HOLIDAY','=','True')->get();

        return view('manager_car.reportcarposition',[
            'infocar_position' => $infocar_position,
            'infoposition' => $infoposition,
            'infocar' => $infocar,
           ]);
    }

    public function excelcarposition()
    {
        $infocar_position = Vehiclecarposition::select('supplies_soldout.SOLDOUT_DATE','vehicle_car_index.ARTICLE_NAME','supplies_brand.BRAND_NAME','asset_article.YEAR_ID','vehicle_car_index.CAR_CC','vehicle_car_index.CAR_REG','vehicle_car_position.POSITION_NAME','asset_article.PRICE_PER_UNIT','asset_article.RECEIVE_DATE','asset_article.EXPIRE_DATE')
        ->leftjoin('vehicle_car_index','vehicle_car_position.CAR_ID','=','vehicle_car_index.CAR_ID')
        ->leftjoin('asset_article','vehicle_car_index.AR_NUM','=','asset_article.ARTICLE_NUM')
        ->leftjoin('supplies_brand','supplies_brand.BRAND_ID','=','asset_article.BRAND_ID')
        ->leftjoin('supplies_model','supplies_model.MODEL_ID','=','asset_article.MODEL_ID')
        ->leftjoin('supplies_soldout','supplies_soldout.SOLDOUT_ARTICLE_ID','=','vehicle_car_position.ARTICLE_ID')
        ->get();

        $orgname =  DB::table('info_org')
            ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->first();

        return view('manager_car.excelcarposition',[
            'infocar_position' => $infocar_position,
            'orgname' => $orgname,
        ]);
    
    }
   
   

    public function reportcartwo(Request $request)
    {    
        $infocar = DB::table('vehicle_car_index')->get();

        $infocar_position = DB::table('vehicle_car_index')
        // ->select('SOLDOUT_DATE ,vehicle_car_index.ARTICLE_NAME','supplies_brand.BRAND_NAME','asset_article.YEAR_ID','vehicle_car_index.CAR_CC','vehicle_car_index.CAR_REG','vehicle_car_position.POSITION_NAME','asset_article.PRICE_PER_UNIT','asset_article.RECEIVE_DATE','asset_article.EXPIRE_DATE','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME')
        ->leftjoin('supplies_soldout','supplies_soldout.SOLDOUT_ARTICLE_ID','=','vehicle_car_index.ARTICLE_ID')
        ->leftjoin('vehicle_car_position','vehicle_car_position.CAR_ID','=','vehicle_car_index.CAR_ID')        
        ->leftjoin('asset_article','vehicle_car_index.AR_NUM','=','asset_article.ARTICLE_NUM')
        ->leftjoin('supplies_brand','supplies_brand.BRAND_ID','=','asset_article.BRAND_ID')
        ->leftjoin('supplies_model','supplies_model.MODEL_ID','=','asset_article.MODEL_ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
        ->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $infoposition = DB::table('hrd_position')->where('HR_POSITION_CHECK_HOLIDAY','=','True')->get();

        return view('manager_car.reportcartwo',[
            'infocar_position' => $infocar_position,
            'infoposition' => $infoposition,
            'infocar' => $infocar,
           ]);
    }
   
    public function excelcartwo()
    {
        $infocar_position = DB::table('vehicle_car_index')
        // ->select('vehicle_car_index.ARTICLE_NAME','supplies_brand.BRAND_NAME','asset_article.YEAR_ID','vehicle_car_index.CAR_CC','vehicle_car_index.CAR_REG','vehicle_car_position.POSITION_NAME','asset_article.PRICE_PER_UNIT','asset_article.RECEIVE_DATE','asset_article.EXPIRE_DATE','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME')
        ->leftjoin('supplies_soldout','supplies_soldout.SOLDOUT_ARTICLE_ID','=','vehicle_car_index.ARTICLE_ID')
        ->leftjoin('vehicle_car_position','vehicle_car_position.CAR_ID','=','vehicle_car_index.CAR_ID')        
        ->leftjoin('asset_article','vehicle_car_index.AR_NUM','=','asset_article.ARTICLE_NUM')
        ->leftjoin('supplies_brand','supplies_brand.BRAND_ID','=','asset_article.BRAND_ID')
        ->leftjoin('supplies_model','supplies_model.MODEL_ID','=','asset_article.MODEL_ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
        ->get();

        $orgname =  DB::table('info_org')
            ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->first();

        return view('manager_car.excelcartwo',[
            'infocar_position' => $infocar_position,
            'orgname' => $orgname,
        ]);
    
    }
   
    public function reportcarfour(Request $request)
    {
        if(!empty($request->_token)){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $yearbudget = $request->YEAR_ID;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_car.infomationcarreport.search' => $search,
                'manager_car.infomationcarreport.status' => $status,
                'manager_car.infomationcarreport.datebigin' => $datebigin,
                'manager_car.infomationcarreport.dateend' => $dateend,
                'manager_car.infomationcarreport.yearbudget' => $yearbudget,
            ]);
        }elseif(!empty(session('manager_car.infomationcarreport'))){
            $search = session('manager_car.infomationcarreport.search');
            $status = session('manager_car.infomationcarreport.status');
            $datebigin = session('manager_car.infomationcarreport.datebigin');
            $dateend = session('manager_car.infomationcarreport.dateend');
            $yearbudget = session('manager_car.infomationcarreport.yearbudget');
        }else{
            $search = '';
            $status = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
            $yearbudget = getBudgetyear();
        }
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
        $y_sub_st = $date_arrary[0];
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);
        $y_sub_e = $date_arrary_e[0];
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
            if($status == null){

                $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','BACK_DATE','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where(function($q) use ($search){
                    $q->where('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_SET_NAME','like','%'.$search.'%');
                    $q->orwhere('COMMENT','like','%'.$search.'%');
                })
                ->where('RESERVE_BEGIN_DATE','>=', $displaydate_bigen)
                ->where('RESERVE_BEGIN_DATE','<=', $displaydate_end)
                ->get();
            }else{
               
                $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','BACK_DATE','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where('CAR_SET_ID','=',$status)
                ->where(function($q) use ($search){
                    $q->where('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_SET_NAME','like','%'.$search.'%');
                    $q->orwhere('COMMENT','like','%'.$search.'%');
                })
                ->where('RESERVE_BEGIN_DATE','>=', $displaydate_bigen)
                ->where('RESERVE_BEGIN_DATE','<=', $displaydate_end)
                ->get();
            }
       
        $year_id = $yearbudget;
        $infocar_sendstatus = DB::table('vehicle_car_index')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        return view('manager_car.reportcarfour',[
            'infocars' => $infocar,
            'infocar_sendstatuss' => $infocar_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'year_id'=> $year_id,
            'budgets'=> $budget,
            'search'=> $search]);
    }
   
   
    public function reportcarfoursearch(Request $request)
    {
        if(!empty($request->_token)){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $yearbudget = $request->YEAR_ID;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_car.infomationcarreport.search' => $search,
                'manager_car.infomationcarreport.status' => $status,
                'manager_car.infomationcarreport.datebigin' => $datebigin,
                'manager_car.infomationcarreport.dateend' => $dateend,
                'manager_car.infomationcarreport.yearbudget' => $yearbudget,
            ]);
        }elseif(!empty(session('manager_car.infomationcarreport'))){
            $search = session('manager_car.infomationcarreport.search');
            $status = session('manager_car.infomationcarreport.status');
            $datebigin = session('manager_car.infomationcarreport.datebigin');
            $dateend = session('manager_car.infomationcarreport.dateend');
            $yearbudget = session('manager_car.infomationcarreport.yearbudget');
        }else{
            $search = '';
            $status = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
            $yearbudget = getBudgetyear();
        }
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
        $y_sub_st = $date_arrary[0];
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);
        $y_sub_e = $date_arrary_e[0];
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
            if($status == null){

                $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','BACK_DATE','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME','BACK_TIME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where(function($q) use ($search){
                    $q->where('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_SET_NAME','like','%'.$search.'%');
                    $q->orwhere('COMMENT','like','%'.$search.'%');
                })
                ->where('RESERVE_BEGIN_DATE','>=', $displaydate_bigen)
                ->where('RESERVE_BEGIN_DATE','<=', $displaydate_end)
                ->get();
            }else{
               
                $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','BACK_DATE','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME','BACK_TIME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where('CAR_SET_ID','=',$status)
                ->where(function($q) use ($search){
                    $q->where('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_SET_NAME','like','%'.$search.'%');
                    $q->orwhere('COMMENT','like','%'.$search.'%');
                })
                ->where('RESERVE_BEGIN_DATE','>=', $displaydate_bigen)
                ->where('RESERVE_BEGIN_DATE','<=', $displaydate_end)
                ->get();
            }
       
        $year_id = $yearbudget;
        $infocar_sendstatus = DB::table('vehicle_car_index')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $regcar = DB::table('vehicle_car_index')->where('CAR_ID','=',$status)->first();

        return view('manager_car.reportcarfoursearch',[
            'infocars' => $infocar,
            'infocar_sendstatuss' => $infocar_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'year_id'=> $year_id,
            'budgets'=> $budget,
            'regcars'=> $regcar,
            'search'=> $search]);
    }
    public function excelcarfour(Request $request,$id)
    {
        if(!empty($request->_token)){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $yearbudget = $request->YEAR_ID;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_car.infomationcarreport.search' => $search,
                'manager_car.infomationcarreport.status' => $status,
                'manager_car.infomationcarreport.datebigin' => $datebigin,
                'manager_car.infomationcarreport.dateend' => $dateend,
                'manager_car.infomationcarreport.yearbudget' => $yearbudget,
            ]);
                }elseif(!empty(session('manager_car.infomationcarreport'))){
                    $search = session('manager_car.infomationcarreport.search');
                    $status = session('manager_car.infomationcarreport.status');
                    $datebigin = session('manager_car.infomationcarreport.datebigin');
                    $dateend = session('manager_car.infomationcarreport.dateend');
                    $yearbudget = session('manager_car.infomationcarreport.yearbudget');
                }else{
                    $search = '';
                    $status = '';
                    $datebigin = date('1/m/Y');
                    $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
                    $yearbudget = getBudgetyear();
                }
                $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
                $date_arrary=explode("-",$date_bigen_c);
                $y_sub_st = $date_arrary[0];
                if($y_sub_st >= 2500){
                    $y = $y_sub_st-543;
                }else{
                    $y = $y_sub_st;
                }
                $m = $date_arrary[1];
                $d = $date_arrary[2];
                $displaydate_bigen= $y."-".$m."-".$d;
                $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
                $date_arrary_e=explode("-",$date_end_c);
                $y_sub_e = $date_arrary_e[0];
                if($y_sub_e >= 2500){
                    $y_e = $y_sub_e-543;
                }else{
                    $y_e = $y_sub_e;
                }
                $m_e = $date_arrary_e[1];
                $d_e = $date_arrary_e[2];
                $displaydate_end= $y_e."-".$m_e."-".$d_e;
                $date = date('Y-m-d');
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
            if($status == null){

                $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','BACK_DATE','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME','BACK_TIME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where(function($q) use ($search){
                    $q->where('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_SET_NAME','like','%'.$search.'%');
                    $q->orwhere('COMMENT','like','%'.$search.'%');
                })
                ->where('RESERVE_BEGIN_DATE','>=', $displaydate_bigen)
                ->where('RESERVE_BEGIN_DATE','<=', $displaydate_end)
                ->get();
            }else{
               
                $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','BACK_DATE','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME','BACK_TIME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where('CAR_SET_ID','=',$id)
                ->where(function($q) use ($search){
                    $q->where('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_SET_NAME','like','%'.$search.'%');
                    $q->orwhere('COMMENT','like','%'.$search.'%');
                })
                ->where('RESERVE_BEGIN_DATE','>=', $displaydate_bigen)
                ->where('RESERVE_BEGIN_DATE','<=', $displaydate_end)
                ->get();
            }
       
        $year_id = $yearbudget;
        $infocar_sendstatus = DB::table('vehicle_car_index')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $regcar = DB::table('vehicle_car_index')->where('CAR_ID','=',$id)->first();

        return view('manager_car.excelcarfour',[
            'infocars' => $infocar,
            'infocar_sendstatuss' => $infocar_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'year_id'=> $year_id,
            'budgets'=> $budget,
            'regcars'=> $regcar,
            'search'=> $search,
            // 'id' => $id
        ]);
    }
   
    function pdfcarfour(Request $request,$id)
    {
        if(!empty($request->_token)){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            // $status = $id;
            // $status = $id;
            $yearbudget = $request->YEAR_ID;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_car.infomationcarreport.search' => $search,
                'manager_car.infomationcarreport.status' => $status,
                'manager_car.infomationcarreport.datebigin' => $datebigin,
                'manager_car.infomationcarreport.dateend' => $dateend,
                'manager_car.infomationcarreport.yearbudget' => $yearbudget,
            ]);
                }elseif(!empty(session('manager_car.infomationcarreport'))){
                    $search = session('manager_car.infomationcarreport.search');
                    $status = session('manager_car.infomationcarreport.status');
                    $datebigin = session('manager_car.infomationcarreport.datebigin');
                    $dateend = session('manager_car.infomationcarreport.dateend');
                    $yearbudget = session('manager_car.infomationcarreport.yearbudget');
                }else{
                    $search = '';
                    $status = '';
                    $datebigin = date('1/m/Y');
                    $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
                    $yearbudget = getBudgetyear();
                }
                $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
                $date_arrary=explode("-",$date_bigen_c);
                $y_sub_st = $date_arrary[0];
                if($y_sub_st >= 2500){
                    $y = $y_sub_st-543;
                }else{
                    $y = $y_sub_st;
                }
                $m = $date_arrary[1];
                $d = $date_arrary[2];
                $displaydate_bigen= $y."-".$m."-".$d;
                $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
                $date_arrary_e=explode("-",$date_end_c);
                $y_sub_e = $date_arrary_e[0];
                if($y_sub_e >= 2500){
                    $y_e = $y_sub_e-543;
                }else{
                    $y_e = $y_sub_e;
                }
                $m_e = $date_arrary_e[1];
                $d_e = $date_arrary_e[2];
                $displaydate_end= $y_e."-".$m_e."-".$d_e;
                $date = date('Y-m-d');
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
            if($status == null){

                $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','BACK_DATE','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME','BACK_TIME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where(function($q) use ($search){
                    $q->where('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_SET_NAME','like','%'.$search.'%');
                    $q->orwhere('COMMENT','like','%'.$search.'%');
                })
                ->where('RESERVE_BEGIN_DATE','>=', $displaydate_bigen)
                ->where('RESERVE_BEGIN_DATE','<=', $displaydate_end)
                ->get();
            }else{
               
                $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','BACK_DATE','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME','BACK_TIME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where('CAR_SET_ID','=',$id)
                ->where(function($q) use ($search){
                    $q->where('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_SET_NAME','like','%'.$search.'%');
                    $q->orwhere('COMMENT','like','%'.$search.'%');
                })
                ->where('RESERVE_BEGIN_DATE','>=', $displaydate_bigen)
                ->where('RESERVE_BEGIN_DATE','<=', $displaydate_end)
                ->get();
            }
       
        $year_id = $yearbudget;
        $infocar_sendstatus = DB::table('vehicle_car_index')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $regcar = DB::table('vehicle_car_index')->where('CAR_ID','=',$id)->first();
    
    $pdf = PDF::loadView('manager_car.pdfcarfour',[
        'infocars' => $infocar,
        'infocar_sendstatuss' => $infocar_sendstatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'year_id'=> $year_id,
        'budgets'=> $budget,
        'regcars'=> $regcar,
        'search'=> $search,
        ]);
        
        $pdf->setPaper('a4', 'landscape');
        return @$pdf->stream();
    }


    public function reportcarsix(Request $request)
    {
        if(!empty($request->_token)){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $yearbudget = $request->YEAR_ID;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_car.infomationcarreport.search' => $search,
                'manager_car.infomationcarreport.status' => $status,
                'manager_car.infomationcarreport.datebigin' => $datebigin,
                'manager_car.infomationcarreport.dateend' => $dateend,
                'manager_car.infomationcarreport.yearbudget' => $yearbudget,
            ]);
        }elseif(!empty(session('manager_car.infomationcarreport'))){
            $search = session('manager_car.infomationcarreport.search');
            $status = session('manager_car.infomationcarreport.status');
            $datebigin = session('manager_car.infomationcarreport.datebigin');
            $dateend = session('manager_car.infomationcarreport.dateend');
            $yearbudget = session('manager_car.infomationcarreport.yearbudget');
        }else{
            $search = '';
            $status = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
            $yearbudget = getBudgetyear();
        }
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
        $y_sub_st = $date_arrary[0];
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);
        $y_sub_e = $date_arrary_e[0];
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
          
       
        $year_id = $yearbudget;
        $infocar_sendstatus = DB::table('vehicle_car_index')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        return view('manager_car.reportcarsix',[
            'infocar_sendstatuss' => $infocar_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'year_id'=> $year_id,
            'budgets'=> $budget,
            'search'=> $search]);
    }


 public function reportcarsixsearch(Request $request)
    {
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $yearbudget = $request->YEAR_ID;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');

        // dd($status);

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
            $y_sub_st = $date_arrary[0];
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }
            $m = $date_arrary[1];
            $d = $date_arrary[2];

        $displaydate_bigen= $y."-".$m."-".$d;
            $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c);
            $y_sub_e = $date_arrary_e[0];
            if($y_sub_e >= 2500){
                $y_e = $y_sub_e-543;
            }else{
                $y_e = $y_sub_e;
            }
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];

        $displaydate_end= $y_e."-".$m_e."-".$d_e;
            $date = date('Y-m-d');
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
 

            $idarticle = DB::table('asset_article')->where('ARTICLE_ID','=',$status)->first();

           
                $infohisrepair = Informrepairindex::leftjoin('asset_article','informrepair_index.ARTICLE_ID','=','asset_article.ARTICLE_ID') 
                ->leftjoin('vehicle_car_index','asset_article.ARTICLE_ID','=','vehicle_car_index.ARTICLE_ID') 
                ->leftjoin('vehicle_car_reserve','vehicle_car_index.CAR_ID','=','vehicle_car_reserve.CAR_SET_ID')                                   
                ->where('informrepair_index.ARTICLE_ID','=',$idarticle->ARTICLE_ID) 
                ->get();
               
       
        $year_id = $yearbudget;
        $infocar_sendstatus = DB::table('vehicle_car_index')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $regcar = DB::table('vehicle_car_index')->where('CAR_ID','=',$status)->first();

        return view('manager_car.reportcarsixsearch',[
            'infohisrepair' => $infohisrepair,
            'infocar_sendstatuss' => $infocar_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'year_id'=> $year_id,
            'budgets'=> $budget,
            'regcars'=> $regcar,
            'search'=> $search
        ]);
    }



    public function carname_formtree(Request $request)
    {    
        $infocar = DB::table('vehicle_car_index')->get();
        $infocar_position = DB::table('vehicle_car_position')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $infoposition = DB::table('hrd_position')->where('HR_POSITION_CHECK_HOLIDAY','=','True')->get();

        $func = DB::table('vehicle_car_function')->where('CAR_FUNCTION_STATUS','=','True')->get();
        $functionform = DB::table('vehicle_car_function')->get();
        // $functionform = DB::table('vehicle_car_functioncheck')->get();

        return view('manager_car.carname_formtree',[
            'infocar_position' => $infocar_position,
            'infoposition' => $infoposition,
            'infocar' => $infocar,
            'functionform' => $functionform,
           ]);
    }
    public function carname_formtree_save(Request $request)
    { 
            $add = new Carname_formtree(); 
            $add->CAR_FUNCTION_NAME = $request->CAR_FUNCTION_NAME;

            $add->save();


            return redirect()->route('mcar.carname_formtree'); 
        }

    function switchactive_form(Request $request)
    {  
        //return $request->all(); 
        $id = $request->idfunc;
        $active = Carname_formtree::find($id);
        $active->CAR_FUNCTION_STATUS = $request->onoff;
        $active->save();
    }



    public function carformfunction_driver(Request $request)
    {    
        $infocar = DB::table('vehicle_car_index')->get();
        $infocar_position = DB::table('vehicle_car_position')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $infoposition = DB::table('hrd_position')->where('HR_POSITION_CHECK_HOLIDAY','=','True')->get();

        $func = DB::table('vehicle_car_functioncheck')->where('CAR_FUNCTIONCHECK_STATUS','=','True')->get();
        $functionform = DB::table('vehicle_car_functioncheck')->get();

        return view('manager_car.carformfunction_driver',[
            'infocar_position' => $infocar_position,
            'infoposition' => $infoposition,
            'infocar' => $infocar,
            'functionform' => $functionform,
           ]);
    }
    function carformfunction_driver_switchactive(Request $request)
    {  
        //return $request->all(); 
        $id = $request->idfunc;
        $active = Carfunctioncheck::find($id);
        $active->CAR_FUNCTIONCHECK_STATUS = $request->onoff;
        $active->save();
    }







   
    public function infomationcarreportsearch(Request $request)
    {

        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $yearbudget = $request->YEAR_ID;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');

        if($search==''){
            $search="";
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;

        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
    

      

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

            if($status == null){
                // $infocar = Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                // ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','BACK_DATE','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where(function($q) use ($search){
                    $q->where('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_SET_NAME','like','%'.$search.'%');
                    $q->orwhere('COMMENT','like','%'.$search.'%');
                   
                })
                ->where('RESERVE_BEGIN_DATE','>=', $displaydate_bigen)
                ->where('RESERVE_BEGIN_DATE','<=', $displaydate_end)
                ->get();
        

            }else{

                // $infocar = Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                // ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','BACK_DATE','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->where('CAR_SET_ID','=',$status)
                ->where(function($q) use ($search){
                    $q->where('RESERVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CAR_DRIVER_SET_NAME','like','%'.$search.'%');
                    $q->orwhere('COMMENT','like','%'.$search.'%');
                   
                })
                ->where('RESERVE_BEGIN_DATE','>=', $displaydate_bigen)
                ->where('RESERVE_BEGIN_DATE','<=', $displaydate_end)
                ->get();

            }
    

       
        $year_id = $yearbudget;
        $infocar_sendstatus = DB::table('vehicle_car_index')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();




        return view('manager_car.carreport',[
            'infocars' => $infocar,
            'infocar_sendstatuss' => $infocar_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'year_id'=> $year_id,
            'budgets'=> $budget,
            'search'=> $search]);
    
    }
   
    public function excelcar()
    {

        // $infocar = Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
        // ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
        $infocar = Vehiclecarreserve::select('RESERVE_PERSON_ID','RESERVE_ID','STATUS','PRIORITY_ID','CAR_REG','FANCINESS_SCORE','CAR_NUMBER_BEGIN','CAR_NUMBER_BACK','RESERVE_BEGIN_DATE','RESERVE_BEGIN_TIME','BACK_DATE','RESERVE_END_DATE','RESERVE_END_TIME','LOCATION_ORG_NAME','RESERVE_NAME','RESERVE_PERSON_NAME','vehicle_car_reserve.created_at','CAR_DRIVER_NAME','HR_FNAME','HR_LNAME')
        ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
        ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
        ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
        ->get();


        return view('manager_car.excelcar',[
            'infocars' => $infocar]);
    
    }


    //---------------เพิ่มรถจากทรัพย์สิน---
    
    
    
    public function infocaraddasset()
    {

        $infoassets = DB::table('asset_article')->where('TYPE_ID','=','26')->get();
 
        foreach ($infoassets as $infoasset) {
            
            $checkcar = DB::table('vehicle_car_index')->where('AR_NUM','=',$infoasset->ARTICLE_NUM)->count();


            if($checkcar == 0){

                $ar_id = $infoasset->ARTICLE_ID;
                $anum = DB::table('asset_article')->where('ARTICLE_ID','=',$ar_id)->first();

                $addinfocar = new Vehiclecarindex(); 
                $addinfocar->AR_NUM = $anum->ARTICLE_NUM;

                $addinfocar->ARTICLE_ID = $anum->ARTICLE_ID;
                $addinfocar->ARTICLE_NUM = $anum->ARTICLE_NUM;

                $addinfocar->CAR_DETAIL = $infoasset->ARTICLE_NAME;
                $addinfocar->ARTICLE_NAME = $infoasset->ARTICLE_PROP;
                $addinfocar->CAR_PERSON_ID = $infoasset->PERSON_ID;
                $addinfocar->CAR_COLOR = $infoasset->COLOR_ID;
                $addinfocar->CAR_BRAND_ID = $infoasset->BRAND_ID;

                $addinfocar->CAR_IMG = $infoasset->IMG;

                $addinfocar->save();

            }


    }

     

        return redirect()->route('mcar.infomationcar'); 

    
  
    }


    ///===============================ฟังชันแสดงข้อมูล========
    public static function detailrepair($id_car)
    {

     
        $infocarrepair = DB::table('vehicle_car_index')
        ->where('CAR_ID','=',$id_car)  
        ->first();

        $max = Informrepairindex::where('informrepair_index.ARTICLE_ID','=',$infocarrepair->ARTICLE_ID)
        ->max('informrepair_index.ID');

        $infomation = Informrepairindex::leftjoin('asset_article','asset_article.ARTICLE_ID','=','informrepair_index.ARTICLE_ID')
        ->where('informrepair_index.ARTICLE_ID','=',$infocarrepair->ARTICLE_ID)
        ->where('informrepair_index.ID','=',$max)
        ->first();
        // dd($infomation->TECH_RECEIVE_DATE);
    
            $resultdate = $max;

            if($infomation <> null){
                $resultdate = $infomation->TECH_RECEIVE_DATE;
            }else{
                $resultdate = '';
            }
       
 
     return $resultdate;
    }

    public static function detailact($id_car)
    {

        $detailact = Vehiclecaractdetail::where('CAR_ID','=',$id_car)
        ->orderBy('ACT_ID', 'desc') 
        ->first();

        if($detailact <> null){
            $resultact = $detailact->ACT_END_DATE;
        }else{
            $resultact = '';
        }
         
 

     return $resultact;
    }

    public static function detailtax($id_car)
    {

        
       $detailtax = Vehiclecartaxdetail::where('CAR_ID','=',$id_car)
       ->orderBy('vehicle_car_tax_detail.TAX_ID', 'desc') 
       ->first();
       
       if($detailtax <> null){
        $resulttax= $detailtax->TAX_END_DATE;
    }else{
        $resulttax = '';
    }

     return $resulttax;
    }

    public static function detailinsurance($id_car)
    {
        $detailinsu = Vehiclecarinsudetail::where('CAR_ID','=',$id_car)
        ->orderBy('vehicle_car_insu_detail.INSU_ID', 'desc') 
        ->first();
    

     if($detailinsu <> null){
        $resultinsu = $detailinsu->INSU_END_DATE;
    }else{
        $resultinsu = '';
    }

     return $resultinsu;
    }


//=============================================//

public function openform_car()
{   
    $openform = DB::table('openform_car')->get();

    return view('manager_car.openform_car',[
        'openforms' =>  $openform,        
    ]);
}
public function openform_car_add()
{   
    $openform = DB::table('openform_car')->get();

    return view('manager_car.openform_car_add',[
        'openforms' =>  $openform,        
    ]);
}
public function openform_car_save(Request $request)
{  
    $add= new Openform_car();
    $add->OPENFORMCAR_CODE = $request->OPENFORMCAR_CODE;
    $add->OPENFORMCAR_NAME = $request->OPENFORMCAR_NAME;
    $add->save();
    // Toastr::success('บันทึกข้อมูลสำเร็จ');
    return redirect()->route('mcar.openform_car');
}

public function openform_car_edit(Request $request,$id)
{
    $openform = Openform_car::where('OPENFORMCAR_ID','=',$id)->first();

    return view('manager_car.openform_car_edit',[
        'openforms' =>  $openform, 
    ]);
}
public function openform_car_update(Request $request)
{      
    $id = $request->OPENFORMCAR_ID;
    $updat = Openform_car::find($id);       
    $updat->OPENFORMCAR_CODE = $request->OPENFORMCAR_CODE;    
    $updat->OPENFORMCAR_NAME = $request->OPENFORMCAR_NAME;     
    $updat->save();
    // Toastr::success('แก้ไขข้อมูลสำเร็จ');
    return redirect()->route('mcar.openform_car');
}
public function openform_car_destroy($id)
{
    Openform_car::destroy($id);
    // Toastr::success('ลบข้อมูลสำเร็จ');
    return redirect()->route('mcar.openform_car');
}

function openform_car_switchactive(Request $request)
{  
    $id = $request->idfunc;
    $active = Openform_car::find($id);
    $active->OPENFORMCAR_STATUS = $request->onoff;
    $active->save();
}

//=============================================//

function amountdistance(Request $request)
{
   
  $beginnum = $request->get('beginnum');
  $endnum = $request->get('endnum');
 

  if($beginnum == '' || $endnum == ''){
       $amountdis = 0;
  }else{
    $amountdistotal = $endnum - $beginnum;
     
    if( $amountdistotal < 0){
        $amountdis = 0;
    }else{
        $amountdis =  $amountdistotal;
    }
    
  }

    $output =  '<input name="DISTANCE" id="DISTANCE" class="form-control input-sm"  value="'.$amountdis.'">';

echo $output;
    
}



}
