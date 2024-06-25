<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class AuthenmobileController extends Controller
{ 
    public function getmobile(Request $request)
    { 
        $datashow_ = DB::connection('mysql3')->select('   
                SELECT o.vn,o.hn,ptname(o.hn,1) ptname
                ,ce2be(o.vstdate) vstdate 
                ,ptt.pttype inscl 
                 ,vp.claimcode authencode,v.pdx 
                ,sum(oo.sum_price) money_hosxp,ptt.paidst
                ,v.discount_money,v.rcpt_money
                ,v.income-v.discount_money-v.rcpt_money debit 
                ,v.rcpno_list rcpno
                
                from ovst o
                join vn_stat v on v.vn=o.vn
                join patient pt on pt.hn=o.hn
                join opitemrece oo on oo.vn=o.vn
                join drugitems d on d.icode=oo.icode
                left join pttype ptt on ptt.pttype=o.pttype
                LEFT JOIN visit_pttype_authen_report vp on vp.personalId = v.cid and v.vstdate =vp.claimDate
                where o.vstdate BETWEEN "'.$newDate.'" AND "'.$datenow.'"                
                and oo.icode IN("3011002","3009749")
                and oo.an 
                group by a.an; 
        ');
               
        return view('dashboard.check_kradookdetail', [ 
            'datashow_'      =>  $datashow_,
            'newDate'        =>  $newDate,
            'datenow'        =>  $datenow,
        ]);
    }
    public function getmobile_api(Request $request)
    {
        // date_default_timezone_set('UTC');
    
        $date_now = date('Y-m-d');
        $date_start = "2023-04-19";
        $date_end = "2023-04-19";
        $cid = "1719900498111";
        // $date = date_create("2013-03-15");
        // $dates = $date_format($date,'Y-m-d');
        // dd($date_now);

        // $url = "https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=$date_now&claimDateTo=$date_now&page=0&size=100000";
        // $url = "https://authenservice.nhso.go.th/authencode/api/erm-reg-claim?claimStatus=E&claimDateFrom=$date_now&claimDateTo=$date_now&page=0&size=1000&sort=claimDate,desc";

        $url = "https://authenucws.nhso.go.th/authencodestatus/api/check-authen-status?personalId=1719900498111&serviceDate=2023-04-25&serviceCode=PG0060001";
        // $url = "https://test.nhso.go.th/authencodestatus/api/check-authen-status?personalId=$cid&serviceDate=$date_now&serviceCode=PG0060001";

        // dd($url);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=2023-01-05&claimDateTo=2023-01-05&page=0&size=1000',
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer 3045bba2-3cac-4a74-ad7d-ac6f7b187479',
                    'Cookie: TS01e80146=013bd252cb5d83368791ff1a3dd19b54b2574fe71aee1e5361edc23ac970fdc40ac00ad6e928b56e49bfaa6b3f22a5b1326eecdd1d'
                ),
        ));
 
        $response = curl_exec($curl);
        curl_close($curl);
        // dd($curl);
        $contents = $response;
        dd($contents);
        $result = json_decode($contents, true);

        @$content = $result['content']; 
        // dd($content);
        // @$transId = $content['transId']; 
        // @$content = explode($content['content']);
        // $transId=$transId[0];
        // $hmain=$hmain[1];
 
        foreach ($content as $key => $value) {
            $transId = $value['transId'];   
            $pid = $value['pid'];   
            $titleName = $value['titleName'];

            isset( $value['fname'] ) ? $fname = $value['fname'] : $fname = "";
            isset( $value['lname'] ) ? $lname = $value['lname'] : $lname = "";
            isset( $value['claimCode'] ) ? $claimCode = $value['claimCode'] : $claimCode = "";
            isset( $value['claimType'] ) ? $claimType = $value['claimType'] : $claimType = "";
            isset( $value['claimTypeName'] ) ? $claimTypeName = $value['claimTypeName'] : $claimTypeName = "";
         
            isset( $value['claimStatus'] ) ? $claimStatus = $value['claimStatus'] : $claimStatus = "";
            isset( $value['hospName'] ) ? $hospName = $value['hospName'] : $hospName = "";
            isset( $value['hospCode'] ) ? $hospCode = $value['hospCode'] : $hospCode = "";
            isset( $value['claimAuthen'] ) ? $claimAuthen = $value['claimAuthen'] : $claimAuthen = "";
            isset( $value['fullName'] ) ? $fullName = $value['fullName'] : $fullName = "";
            isset( $value['daysBetweenClaimDateAndSysdate'] ) ? $daysBetweenClaimDateAndSysdate = $value['daysBetweenClaimDateAndSysdate'] : $daysBetweenClaimDateAndSysdate = "";
            isset( $value['cancelable'] ) ? $cancelable = $value['cancelable'] : $cancelable = "";
            

            $claimDate = explode("T",$value['claimDate']);
            $checkdate = $claimDate[0];
            $checktime = $claimDate[1];

            // dd($claimDate);
 
                $datenow = date("Y-m-d");
               
                    $checktransId = Visit_pttype_authen_report::where('transId','=',$transId)->count();
                    if ($checktransId > 0) { 
                            Visit_pttype_authen_report::where('transId', $transId)
                                ->update([
                           
                                    'claimAuthen'                        => $claimAuthen,  
                                    'date_data'                          => $datenow
                                ]); 
                    } else {
                       
                            $data_add = Visit_pttype_authen_report::create([
                                'transId'                          => $transId,
                                'titleName'                         => $titleName,
                                'fname'                            => $fname,
                                'lname'                            => $lname,
                                'personalId'                       => $pid,
                                'patientName'                      => $fullName, 
                                'claimStatus'                      => $claimStatus,                            
                                'claimCode'                        => $claimCode,
                                'claimType'                        => $claimType,
                                'claimTypeName'                    => $claimTypeName,
                                'hmain'                           => $hospCode, 
                                'hname'                           => $hospName, 
                                'claimDate'                       => $checkdate,
                                'claimTime'                        => $checktime,
                                'claimAuthen'                        => $claimAuthen,                                
                                'date_data'                        => $datenow
                        ]);
                        $data_add->save();
                    }   
        }
        return view('authen.checkauthen_autospsch',[
            'response'  => $response,
            'result'  => $result, 
        ]); 
    
        
    }
    
}
