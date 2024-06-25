<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeetReportController extends Controller
{
    public static function count_meeting($yearbudget,$room_id)
    {
        return DB::table('meetingroom_service')
        ->where('YEAR_ID',$yearbudget)
        ->where('ROOM_ID',$room_id)
        ->where(function ($q)
        {
            $q->where('STATUS','SUCCESS')
            ->orwhere('STATUS','LASTAPP');
        })
        ->count();
    }
    public function count_meetingBySubmitdate($year,$room_id)
    {
        return DB::table('meetingroom_service')
        ->whereBetween('SUBMIT_DATE_TIME', [(date('Y') - 1) . '-10-01', date('Y') . '-09-30'])
        ->where('ROOM_ID',$room_id)
        ->count();
    }
    public function count_meetingservice_M($year){
        $arr['1'] = DB::table('meetingroom_service')->whereMonth('SUBMIT_DATE_TIME','01')->whereYear('SUBMIT_DATE_TIME',$year)->count();
        $arr['2'] = DB::table('meetingroom_service')->whereMonth('SUBMIT_DATE_TIME','02')->whereYear('SUBMIT_DATE_TIME',$year)->count();
        $arr['3'] = DB::table('meetingroom_service')->whereMonth('SUBMIT_DATE_TIME','03')->whereYear('SUBMIT_DATE_TIME',$year)->count();
        $arr['4'] = DB::table('meetingroom_service')->whereMonth('SUBMIT_DATE_TIME','04')->whereYear('SUBMIT_DATE_TIME',$year)->count();
        $arr['5'] = DB::table('meetingroom_service')->whereMonth('SUBMIT_DATE_TIME','05')->whereYear('SUBMIT_DATE_TIME',$year)->count();
        $arr['6'] = DB::table('meetingroom_service')->whereMonth('SUBMIT_DATE_TIME','06')->whereYear('SUBMIT_DATE_TIME',$year)->count();
        $arr['7'] = DB::table('meetingroom_service')->whereMonth('SUBMIT_DATE_TIME','07')->whereYear('SUBMIT_DATE_TIME',$year)->count();
        $arr['8'] = DB::table('meetingroom_service')->whereMonth('SUBMIT_DATE_TIME','08')->whereYear('SUBMIT_DATE_TIME',$year)->count();
        $arr['9'] = DB::table('meetingroom_service')->whereMonth('SUBMIT_DATE_TIME','09')->whereYear('SUBMIT_DATE_TIME',$year)->count();
        $arr['10'] = DB::table('meetingroom_service')->whereMonth('SUBMIT_DATE_TIME','10')->whereYear('SUBMIT_DATE_TIME',$year-1)->count();
        $arr['11'] = DB::table('meetingroom_service')->whereMonth('SUBMIT_DATE_TIME','11')->whereYear('SUBMIT_DATE_TIME',$year-1)->count();
        $arr['12'] = DB::table('meetingroom_service')->whereMonth('SUBMIT_DATE_TIME','12')->whereYear('SUBMIT_DATE_TIME',$year-1)->count();
        return $arr;
    }
    public function getServiceroomByday($customdate = '+0day',$meetroom_id = 'all')
    {
        if ($meetroom_id == 'all') {
            return DB::table('meetingroom_service')->leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','meetingroom_service.ROOM_ID')
            ->where('meetingroom_service.DATE_BEGIN',date('Y-m-d',strtotime($customdate)))
            ->where(function ($q){
                $q->where('meetingroom_service.STATUS','SUCCESS')
                ->orWhere('meetingroom_service.STATUS','REQUEST')
                ->orWhere('meetingroom_service.STATUS','LASTAPP');
            })
            ->get();
        }else{
            return DB::table('meetingroom_service')->leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','meetingroom_service.ROOM_ID')
            ->where('meetingroom_service.DATE_BEGIN',date('Y-m-d',strtotime($customdate)))
            ->where('meetingroom_index.ROOM_ID',$meetroom_id)
            ->where(function ($q){
                $q->where('meetingroom_service.STATUS','SUCCESS')
                ->orWhere('meetingroom_service.STATUS','REQUEST')
                ->orWhere('meetingroom_service.STATUS','LASTAPP');
            })
            ->get();
        }
        
    }
    public function getServiceroom_month_ByID($meetroom_id)
    {
        if ($meetroom_id == 'all') {
            return DB::table('meetingroom_service')->leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','meetingroom_service.ROOM_ID')
        ->whereMonth('meetingroom_service.DATE_BEGIN',date('m'))
        ->where(function ($q)
        {
            $q->where('meetingroom_service.STATUS','SUCCESS')
            ->orwhere('meetingroom_service.STATUS','LASTAPP')
            ->orwhere('meetingroom_service.STATUS','REQUEST');
        })
        ->orderBy('meetingroom_service.DATE_BEGIN', 'desc')->get();
        }else{
            return DB::table('meetingroom_service')->leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','meetingroom_service.ROOM_ID')
        ->whereMonth('meetingroom_service.DATE_BEGIN',date('m'))
        ->where(function ($q)
            {
                $q->where('meetingroom_service.STATUS','SUCCESS')
                ->orwhere('meetingroom_service.STATUS','LASTAPP')
                ->orwhere('meetingroom_service.STATUS','REQUEST');
            })
        ->where('meetingroom_service.ROOM_ID', $meetroom_id)
        ->orderBy('meetingroom_service.DATE_BEGIN', 'desc')->get();

        }
    }
    public function getServiceroomByID($meetroom_id)
    {
        if ($meetroom_id == 'all') {
            return DB::table('meetingroom_service')->leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
            ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
            ->where(function ($q)
            {
                $q->where('meetingroom_service.STATUS','SUCCESS')
                ->orwhere('meetingroom_service.STATUS','LASTAPP')
                ->orwhere('meetingroom_service.STATUS','REQUEST');
            })
            ->orderBy('meetingroom_service.ID', 'desc')
            ->get();
        }else{
            return DB::table('meetingroom_service')->leftJoin('meetingroom_index', 'meetingroom_index.ROOM_ID', '=', 'meetingroom_service.ROOM_ID')
            ->leftJoin('meetingroom_service_status', 'meetingroom_service_status.STATUS_CODE', '=', 'meetingroom_service.STATUS')
            ->where(function ($q)
            {
                $q->where('meetingroom_service.STATUS','SUCCESS')
                ->orwhere('meetingroom_service.STATUS','LASTAPP')
                ->orwhere('meetingroom_service.STATUS','REQUEST');
            })
            ->where('meetingroom_service.ROOM_ID', $meetroom_id)
            ->orderBy('meetingroom_service.ID', 'desc')
            ->get();

        }
    }
}
