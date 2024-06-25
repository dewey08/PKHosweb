<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Operate_time;
use App\Models\Hrd_person;
use App\Models\m_registerdata;
use App\Models\Checkin_export;
use App\Exports\Checkinexport;
use PDF;
use Excel;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image; 
use Auth;
use Illuminate\Support\Facades\Storage;
 
date_default_timezone_set("Asia/Bangkok");

class UserstimerController extends Controller
{
    public function user_timeindex(Request $request)
    { 
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $iduser = Auth::user()->id; 
        $debsubsub = Auth::user()->dep_subsubtrueid; 
        $userid = $request->userid; 

        if ($startdate == '') {
            $datashow_ = DB::connection('mysql6')->select(' 
                SELECT p.ID,c.CHEACKIN_DATE
                ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "1" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKINTIME
                ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "2" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKOUTTIME
                ,CONCAT(f.HR_PREFIX_NAME,p.HR_FNAME," ",p.HR_LNAME) as hrname,hp.HR_POSITION_NAME,ct.CHECKIN_TYPE_NAME
                ,hs.HR_DEPARTMENT_SUB_NAME,d.HR_DEPARTMENT_SUB_SUB_NAME,d.HR_DEPARTMENT_SUB_ID,ot.OPERATE_TYPE_ID,ot.OPERATE_TYPE_NAME
                ,ot.OPERATE_TYPE_NAME,c.CHECKIN_TYPE_ID,hs.HR_DEPARTMENT_SUB_NAME,d.HR_DEPARTMENT_SUB_SUB_NAME,ot.OPERATE_TYPE_NAME,d.HR_DEPARTMENT_SUB_SUB_ID
                FROM checkin_index c
                LEFT JOIN checkin_type ct on ct.CHECKIN_TYPE_ID=c.CHECKIN_TYPE_ID
                LEFT JOIN hrd_person p on p.ID=c.CHECKIN_PERSON_ID
                LEFT JOIN hrd_department_sub_sub d on d.HR_DEPARTMENT_SUB_SUB_ID=p.HR_DEPARTMENT_SUB_SUB_ID
                LEFT JOIN hrd_department_sub hs on hs.HR_DEPARTMENT_SUB_ID=p.HR_DEPARTMENT_SUB_ID
                LEFT JOIN operate_job j on j.OPERATE_JOB_ID=c.OPERATE_JOB_ID
                LEFT JOIN operate_type ot on ot.OPERATE_TYPE_ID=j.OPERATE_JOB_TYPE_ID
                LEFT JOIN hrd_prefix f on f.HR_PREFIX_ID=p.HR_PREFIX_ID
                LEFT JOIN hrd_position hp on hp.HR_POSITION_ID=p.HR_POSITION_ID
                WHERE c.CHEACKIN_DATE = CURDATE() 
                AND c.CHECKIN_PERSON_ID = "'.$iduser.'"
                
                GROUP BY p.ID,j.OPERATE_JOB_ID,c.CHEACKIN_DATE
                ORDER BY c.CHEACKIN_DATE,p.ID,ot.OPERATE_TYPE_ID            
            ');
            // AND c.CHECKIN_PERSON_ID = "'.$userid.'"
            // AND d.HR_DEPARTMENT_SUB_SUB_ID = "'.$debsubsub.'"
        } else {
            $datashow_ = DB::connection('mysql6')->select(' 
                SELECT p.ID,c.CHEACKIN_DATE
                ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "1" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKINTIME
                ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "2" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKOUTTIME
                ,CONCAT(f.HR_PREFIX_NAME,p.HR_FNAME," ",p.HR_LNAME) as hrname,hp.HR_POSITION_NAME,c.CHECKIN_TYPE_ID,ct.CHECKIN_TYPE_NAME
                ,hs.HR_DEPARTMENT_SUB_NAME,d.HR_DEPARTMENT_SUB_SUB_NAME,d.HR_DEPARTMENT_SUB_ID
                ,ot.OPERATE_TYPE_NAME,hs.HR_DEPARTMENT_SUB_NAME,d.HR_DEPARTMENT_SUB_SUB_NAME,ot.OPERATE_TYPE_NAME,d.HR_DEPARTMENT_SUB_SUB_ID,ot.OPERATE_TYPE_ID,ot.OPERATE_TYPE_NAME
                FROM checkin_index c
                LEFT JOIN checkin_type ct on ct.CHECKIN_TYPE_ID=c.CHECKIN_TYPE_ID
                LEFT JOIN hrd_person p on p.ID=c.CHECKIN_PERSON_ID
                LEFT JOIN hrd_department_sub_sub d on d.HR_DEPARTMENT_SUB_SUB_ID=p.HR_DEPARTMENT_SUB_SUB_ID
                LEFT JOIN hrd_department_sub hs on hs.HR_DEPARTMENT_SUB_ID=p.HR_DEPARTMENT_SUB_ID
                LEFT JOIN operate_job j on j.OPERATE_JOB_ID=c.OPERATE_JOB_ID
                LEFT JOIN operate_type ot on ot.OPERATE_TYPE_ID=j.OPERATE_JOB_TYPE_ID
                LEFT JOIN hrd_prefix f on f.HR_PREFIX_ID=p.HR_PREFIX_ID
                LEFT JOIN hrd_position hp on hp.HR_POSITION_ID=p.HR_POSITION_ID
                WHERE c.CHEACKIN_DATE BETWEEN "'.$startdate.'" and "'.$enddate.'"                
                AND c.CHECKIN_PERSON_ID = "'.$iduser.'"
                GROUP BY p.ID,j.OPERATE_JOB_ID,c.CHEACKIN_DATE
                ORDER BY c.CHEACKIN_DATE,p.ID,ot.OPERATE_TYPE_ID          
            ');
            // AND d.HR_DEPARTMENT_SUB_SUB_ID = "'.$debsubsub.'"
            Operate_time::truncate();
            Checkin_export::where('userid', '=', $iduser)->delete();
            foreach ($datashow_ as $key => $value) {  
                
                $start = strtotime($value->CHEACKINTIME);
                $end = strtotime($value->CHEACKOUTTIME);

                if ($end == '') {
                    $tot = ''; 
                }elseif ($start == '') { 
                    $tot = ''; 
                }elseif ($end < $start) { 
                    $tot = ''; 
                } else {
                    $tot_ = ($end - $start) / 3600; 
                    $tot = number_format($tot_,2);
                }
    
                $date1 = date_create($value->CHEACKINTIME);
                $date2 = date_create($value->CHEACKOUTTIME);
                
                $diff = date_diff($date1, $date2);
                $totalhr = $diff->format('%R%H ชม.');

                Operate_time::insert([
                    'operate_time_date'        => $value->CHEACKIN_DATE,
                    'operate_time_personid'    => $value->ID,
                    'operate_time_person'      => $value->hrname,
                    'operate_time_typeid'      => $value->CHECKIN_TYPE_ID,
                    'operate_time_typename'    => $value->CHECKIN_TYPE_NAME,
                    'operate_time_in'          => $value->CHEACKINTIME,
                    'operate_time_out'         => $value->CHEACKOUTTIME,
                    'operate_time_otin'        => '',
                    'operate_time_otout'       => '',
                    'totaltime_narmal'         => $tot,
                    'totaltime_ot'             => '' 
                ]);                
          
                
                Checkin_export::insert([
                    'checkindate'              => $value->CHEACKIN_DATE,
                    'userid'                   => $value->ID,
                    'ptname'                   => $value->hrname,
                    'checkin_type'             => $value->OPERATE_TYPE_ID,
                    'checkin_typename'         => $value->OPERATE_TYPE_NAME,
                    'checkin_time'             => $value->CHEACKINTIME,
                    'checkout_time'            => $value->CHEACKOUTTIME,
                    'userid_save'              => Auth::user()->id  
                ]); 
            }     
        }               
        $data = User::all();
        return view('user_time.user_timeindex', [
            'datashow_'        => $datashow_,
            'startdate'        => $startdate,
            'enddate'          => $enddate,  
            'data'             => $data, 
            'userid'             => $userid, 
        ]);
    }
    // public function user_timeindex_excel(Request $request)
    public function user_timeindex_excel(Request $request)
    { 
        // $export = DB::connection('mysql')->select('
        //     SELECT * FROM operate_time
        // '); 
        $startdate = $request->startdate;
        $enddate = $request->enddate; 

        $deb = Auth::user()->dep_id;  
        $debsub = Auth::user()->dep_subid; 
        $debsubsub = Auth::user()->dep_subsubtrueid; 

        $debname_ = DB::connection('mysql6')->table('hrd_department')->where('HR_DEPARTMENT_ID', '=', $deb)->first();
        $debsubname_ = DB::connection('mysql6')->table('hrd_department_sub')->where('HR_DEPARTMENT_SUB_ID', '=', $debsub)->first();
        $debsubsubname_ = DB::connection('mysql6')->table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID', '=', $debsubsub)->first();
        $org_ = DB::connection('mysql')->table('orginfo')->where('orginfo_id', '=', 1)->first();

        $export = DB::connection('mysql6')->select(' 
                SELECT p.ID,c.CHEACKIN_DATE
                ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "1" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKINTIME
                ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "2" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKOUTTIME
                ,CONCAT(f.HR_PREFIX_NAME,p.HR_FNAME," ",p.HR_LNAME) as hrname,hp.HR_POSITION_NAME,c.CHECKIN_TYPE_ID,ct.CHECKIN_TYPE_NAME
                ,h.HR_DEPARTMENT_NAME,hs.HR_DEPARTMENT_SUB_NAME,d.HR_DEPARTMENT_SUB_SUB_NAME,d.HR_DEPARTMENT_SUB_ID
                ,ot.OPERATE_TYPE_NAME,hs.HR_DEPARTMENT_SUB_NAME,d.HR_DEPARTMENT_SUB_SUB_NAME,ot.OPERATE_TYPE_NAME,d.HR_DEPARTMENT_SUB_SUB_ID
                FROM checkin_index c
                LEFT JOIN checkin_type ct on ct.CHECKIN_TYPE_ID=c.CHECKIN_TYPE_ID
                LEFT JOIN hrd_person p on p.ID=c.CHECKIN_PERSON_ID

                LEFT JOIN hrd_department h on h.HR_DEPARTMENT_ID = p.HR_DEPARTMENT_ID
                LEFT JOIN hrd_department_sub hs on hs.HR_DEPARTMENT_SUB_ID=p.HR_DEPARTMENT_SUB_ID
                LEFT JOIN hrd_department_sub_sub d on d.HR_DEPARTMENT_SUB_SUB_ID=p.HR_DEPARTMENT_SUB_SUB_ID
                 
                LEFT JOIN operate_job j on j.OPERATE_JOB_ID=c.OPERATE_JOB_ID
                LEFT JOIN operate_type ot on ot.OPERATE_TYPE_ID=j.OPERATE_JOB_TYPE_ID
                LEFT JOIN hrd_prefix f on f.HR_PREFIX_ID=p.HR_PREFIX_ID
                LEFT JOIN hrd_position hp on hp.HR_POSITION_ID=p.HR_POSITION_ID
                WHERE c.CHEACKIN_DATE BETWEEN "'.$startdate.'" and "'.$enddate.'"  
                AND d.HR_DEPARTMENT_SUB_SUB_ID = "'.$debsubsub.'"
                GROUP BY p.ID,j.OPERATE_JOB_ID,c.CHEACKIN_DATE
                ORDER BY c.CHEACKIN_DATE,p.ID,ot.OPERATE_TYPE_ID            
        ');  

         
        return view('user_time.user_timeindex_excel', [
            'export'           => $export,
            'debname'          => $debname_->HR_DEPARTMENT_NAME,
            'debsubname'       => $debsubname_->HR_DEPARTMENT_SUB_NAME,  
            'debsubsubname'    => $debsubsubname_->HR_DEPARTMENT_SUB_SUB_NAME,
            'org'              => $org_->orginfo_name,  
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
        ]);
    }
    public function user_timeindex_nurh(Request $request)
    { 
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $debsubsub = Auth::user()->dep_subsubtrueid; 
        $iduser = Auth::user()->id; 
        if ($startdate == '') {
            $datashow_ = DB::connection('mysql6')->select('  
                SELECT p.ID,c.CHEACKIN_DATE
                    ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "1" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKINTIME
                    ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "2" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKOUTTIME
                    ,CONCAT(f.HR_PREFIX_NAME,p.HR_FNAME," ",p.HR_LNAME) as hrname
                    ,h.HR_DEPARTMENT_ID ,hs.HR_DEPARTMENT_SUB_ID ,d.HR_DEPARTMENT_SUB_SUB_ID ,ot.OPERATE_TYPE_ID,ot.OPERATE_TYPE_NAME
                    ,c.CHECKIN_TYPE_ID,ct.CHECKIN_TYPE_NAME
                    FROM checkin_index c
                    LEFT JOIN checkin_type ct on ct.CHECKIN_TYPE_ID=c.CHECKIN_TYPE_ID
                    LEFT JOIN hrd_person p on p.ID=c.CHECKIN_PERSON_ID
                    LEFT JOIN hrd_department h on h.HR_DEPARTMENT_ID=p.HR_DEPARTMENT_ID
                    LEFT JOIN hrd_department_sub hs on hs.HR_DEPARTMENT_SUB_ID=p.HR_DEPARTMENT_SUB_ID
                    LEFT JOIN hrd_department_sub_sub d on d.HR_DEPARTMENT_SUB_SUB_ID=p.HR_DEPARTMENT_SUB_SUB_ID
                    LEFT JOIN operate_job j on j.OPERATE_JOB_ID=c.OPERATE_JOB_ID
                    LEFT JOIN operate_type ot on ot.OPERATE_TYPE_ID=j.OPERATE_JOB_TYPE_ID
                    LEFT JOIN hrd_prefix f on f.HR_PREFIX_ID=p.HR_PREFIX_ID
                    WHERE c.CHEACKIN_DATE = CURDATE() 
                    AND c.CHECKIN_PERSON_ID = "'.$iduser.'"
                    GROUP BY p.ID,ot.OPERATE_TYPE_ID,c.CHEACKIN_DATE
                    ORDER BY c.CHEACKIN_DATE,p.ID,ot.OPERATE_TYPE_ID
            ');
            // AND p.HR_POSITION_ID = "4"
            // AND d.HR_DEPARTMENT_SUB_SUB_ID = "'.$debsubsub.'"
        } else {
            $datashow_ = DB::connection('mysql6')->select(' 
                 SELECT p.ID,c.CHEACKIN_DATE
                    ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "1" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKINTIME
                    ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "2" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKOUTTIME
                    ,CONCAT(f.HR_PREFIX_NAME,p.HR_FNAME," ",p.HR_LNAME) as hrname
                    ,h.HR_DEPARTMENT_ID ,hs.HR_DEPARTMENT_SUB_ID ,d.HR_DEPARTMENT_SUB_SUB_ID ,ot.OPERATE_TYPE_ID,ot.OPERATE_TYPE_NAME
                    ,c.CHECKIN_TYPE_ID,ct.CHECKIN_TYPE_NAME
                    FROM checkin_index c
                    LEFT JOIN checkin_type ct on ct.CHECKIN_TYPE_ID=c.CHECKIN_TYPE_ID
                    LEFT JOIN hrd_person p on p.ID=c.CHECKIN_PERSON_ID
                    LEFT JOIN hrd_department h on h.HR_DEPARTMENT_ID=p.HR_DEPARTMENT_ID
                    LEFT JOIN hrd_department_sub hs on hs.HR_DEPARTMENT_SUB_ID=p.HR_DEPARTMENT_SUB_ID
                    LEFT JOIN hrd_department_sub_sub d on d.HR_DEPARTMENT_SUB_SUB_ID=p.HR_DEPARTMENT_SUB_SUB_ID
                    LEFT JOIN operate_job j on j.OPERATE_JOB_ID=c.OPERATE_JOB_ID
                    LEFT JOIN operate_type ot on ot.OPERATE_TYPE_ID=j.OPERATE_JOB_TYPE_ID
                    LEFT JOIN hrd_prefix f on f.HR_PREFIX_ID=p.HR_PREFIX_ID
                    WHERE c.CHEACKIN_DATE BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                    AND c.CHECKIN_PERSON_ID = "'.$iduser.'"
                    GROUP BY p.ID,ot.OPERATE_TYPE_ID,c.CHEACKIN_DATE
                    ORDER BY c.CHEACKIN_DATE,p.ID,ot.OPERATE_TYPE_ID
            ');
            //  AND p.HR_POSITION_ID = "4"
            Operate_time::truncate();
            Checkin_export::where('userid', '=', $iduser)->delete();
            foreach ($datashow_ as $key => $value) {  
                
                $start = strtotime($value->CHEACKINTIME);
                $end = strtotime($value->CHEACKOUTTIME);

                if ($end == '') {
                    $tot = ''; 
                }elseif ($start == '') { 
                    $tot = ''; 
                }elseif ($end < $start) { 
                    $tot = ''; 
                } else {
                    $tot_ = ($end - $start) / 3600; 
                    $tot = number_format($tot_,2);
                }
    
                $date1 = date_create($value->CHEACKINTIME);
                $date2 = date_create($value->CHEACKOUTTIME);
                
                $diff = date_diff($date1, $date2);
                $totalhr = $diff->format('%R%H ชม.');

                Operate_time::insert([
                    'operate_time_date'        => $value->CHEACKIN_DATE,
                    'operate_time_personid'    => $value->ID,
                    'operate_time_person'      => $value->hrname,
                    'operate_time_typeid'      => $value->OPERATE_TYPE_ID,
                    'operate_time_typename'    => $value->OPERATE_TYPE_NAME,
                    'operate_time_in'          => $value->CHEACKINTIME,
                    'operate_time_out'         => $value->CHEACKOUTTIME,
                    'operate_time_otin'        => '',
                    'operate_time_otout'       => '',
                    'totaltime_narmal'         => $tot,
                    'totaltime_ot'             => '' 
                ]);   
                Checkin_export::insert([
                    'checkindate'              => $value->CHEACKIN_DATE,
                    'userid'                   => $value->ID,
                    'ptname'                   => $value->hrname,
                    'checkin_type'             => $value->OPERATE_TYPE_ID,
                    'checkin_typename'         => $value->OPERATE_TYPE_NAME,
                    'checkin_time'             => $value->CHEACKINTIME,
                    'checkout_time'            => $value->CHEACKOUTTIME,
                    'userid_save'              => Auth::user()->id  
                ]);              
            }
            
        } 
        return view('user_time.user_timeindex_nurh', [
            'datashow_'        => $datashow_,
            'startdate'        => $startdate,
            'enddate'          => $enddate,  
        ]);
    }
    public function user_timeindex_nurh_excel(Request $request,$startdate,$enddate)
    { 
        // $export = DB::connection('mysql')->select('
        //     SELECT * FROM operate_time
        // ');
        $deb = Auth::user()->dep_id;  
        $debsub = Auth::user()->dep_subid; 
        $debsubsub = Auth::user()->dep_subsubtrueid; 

        $debname_ = DB::connection('mysql6')->table('hrd_department')->where('HR_DEPARTMENT_ID', '=', $deb)->first();
        $debsubname_ = DB::connection('mysql6')->table('hrd_department_sub')->where('HR_DEPARTMENT_SUB_ID', '=', $debsub)->first();
        $debsubsubname_ = DB::connection('mysql6')->table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID', '=', $debsubsub)->first();
        $org_ = DB::connection('mysql')->table('orginfo')->where('orginfo_id', '=', 1)->first();

        if ($startdate == '') {
                $export = DB::connection('mysql6')->select('                      
                    SELECT p.ID,c.CHEACKIN_DATE
                        ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "1" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKINTIME
                        ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "2" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKOUTTIME
                        ,CONCAT(f.HR_PREFIX_NAME,p.HR_FNAME," ",p.HR_LNAME) as hrname
                        ,h.HR_DEPARTMENT_ID ,hs.HR_DEPARTMENT_SUB_ID ,d.HR_DEPARTMENT_SUB_SUB_ID ,ot.OPERATE_TYPE_ID,ot.OPERATE_TYPE_NAME
                        FROM checkin_index c
                        LEFT JOIN hrd_person p on p.ID=c.CHECKIN_PERSON_ID
                        LEFT JOIN hrd_department h on h.HR_DEPARTMENT_ID=p.HR_DEPARTMENT_ID
                        LEFT JOIN hrd_department_sub hs on hs.HR_DEPARTMENT_SUB_ID=p.HR_DEPARTMENT_SUB_ID
                        LEFT JOIN hrd_department_sub_sub d on d.HR_DEPARTMENT_SUB_SUB_ID=p.HR_DEPARTMENT_SUB_SUB_ID
                        LEFT JOIN operate_job j on j.OPERATE_JOB_ID=c.OPERATE_JOB_ID
                        LEFT JOIN operate_type ot on ot.OPERATE_TYPE_ID=j.OPERATE_JOB_TYPE_ID
                        LEFT JOIN hrd_prefix f on f.HR_PREFIX_ID=p.HR_PREFIX_ID
                        WHERE c.CHEACKIN_DATE = CURDATE()
                        
                        AND d.HR_DEPARTMENT_SUB_SUB_ID = "'.$debsubsub.'"
                        GROUP BY p.ID,ot.OPERATE_TYPE_ID,c.CHEACKIN_DATE
                        ORDER BY c.CHEACKIN_DATE,p.ID,ot.OPERATE_TYPE_ID
            ');
            // AND p.HR_POSITION_ID = "4"
        } else {
            $export = DB::connection('mysql6')->select('                      
                SELECT p.ID,c.CHEACKIN_DATE
                    ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "1" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKINTIME
                    ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(c.CHEACKIN_TIME) WHERE c.CHECKIN_TYPE_ID = "2" AND c.CHECKIN_PERSON_ID = p.ID)),",",1) AS CHEACKOUTTIME
                    ,CONCAT(f.HR_PREFIX_NAME,p.HR_FNAME," ",p.HR_LNAME) as hrname
                    ,h.HR_DEPARTMENT_ID ,hs.HR_DEPARTMENT_SUB_ID ,d.HR_DEPARTMENT_SUB_SUB_ID ,ot.OPERATE_TYPE_ID,ot.OPERATE_TYPE_NAME
                    FROM checkin_index c
                    LEFT JOIN hrd_person p on p.ID=c.CHECKIN_PERSON_ID
                    LEFT JOIN hrd_department h on h.HR_DEPARTMENT_ID=p.HR_DEPARTMENT_ID
                    LEFT JOIN hrd_department_sub hs on hs.HR_DEPARTMENT_SUB_ID=p.HR_DEPARTMENT_SUB_ID
                    LEFT JOIN hrd_department_sub_sub d on d.HR_DEPARTMENT_SUB_SUB_ID=p.HR_DEPARTMENT_SUB_SUB_ID
                    LEFT JOIN operate_job j on j.OPERATE_JOB_ID=c.OPERATE_JOB_ID
                    LEFT JOIN operate_type ot on ot.OPERATE_TYPE_ID=j.OPERATE_JOB_TYPE_ID
                    LEFT JOIN hrd_prefix f on f.HR_PREFIX_ID=p.HR_PREFIX_ID
                    WHERE c.CHEACKIN_DATE BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                   
                    AND d.HR_DEPARTMENT_SUB_SUB_ID = "'.$debsubsub.'"
                    GROUP BY p.ID,ot.OPERATE_TYPE_ID,c.CHEACKIN_DATE
                    ORDER BY c.CHEACKIN_DATE,p.ID,ot.OPERATE_TYPE_ID
        ');
        }
        
                  
         
        return view('user_time.user_timeindex_nurh_excel', [
            'export'           => $export,
            'debname'          => $debname_->HR_DEPARTMENT_NAME,
            'debsubname'       => $debsubname_->HR_DEPARTMENT_SUB_NAME,  
            'debsubsubname'    => $debsubsubname_->HR_DEPARTMENT_SUB_SUB_NAME,
            'org'              => $org_->orginfo_name,  
            'startdate'        => $startdate,
            'enddate'          => $enddate,  
        ]);
    }

    public function user_exportexcel(Request $request)
    {
        return Excel::download(new Checkinexport,'User_export.xlsx');
    }
    
}