<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookReportController extends Controller
{
    public function countBookindex_M($year)
    {
        $arr[1] =  DB::table('gbook_index')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','01')->count();
        $arr[2] =  DB::table('gbook_index')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','02')->count();
        $arr[3] =  DB::table('gbook_index')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','03')->count();
        $arr[4] =  DB::table('gbook_index')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','04')->count();
        $arr[5] =  DB::table('gbook_index')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','05')->count();
        $arr[6] =  DB::table('gbook_index')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','06')->count();
        $arr[7] =  DB::table('gbook_index')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','07')->count();
        $arr[8] =  DB::table('gbook_index')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','08')->count();
        $arr[9] =  DB::table('gbook_index')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','09')->count();
        $arr[10] =  DB::table('gbook_index')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','10')->count();
        $arr[11] =  DB::table('gbook_index')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','11')->count();
        $arr[12] =  DB::table('gbook_index')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','12')->count();
        return $arr;
    }
    public function countBooksend_M($year)
    {
        $arr[1] =  DB::table('gbook_index_inside')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','01')->count();
        $arr[2] =  DB::table('gbook_index_inside')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','02')->count();
        $arr[3] =  DB::table('gbook_index_inside')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','03')->count();
        $arr[4] =  DB::table('gbook_index_inside')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','04')->count();
        $arr[5] =  DB::table('gbook_index_inside')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','05')->count();
        $arr[6] =  DB::table('gbook_index_inside')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','06')->count();
        $arr[7] =  DB::table('gbook_index_inside')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','07')->count();
        $arr[8] =  DB::table('gbook_index_inside')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','08')->count();
        $arr[9] =  DB::table('gbook_index_inside')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','09')->count();
        $arr[10] =  DB::table('gbook_index_inside')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','10')->count();
        $arr[11] =  DB::table('gbook_index_inside')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','11')->count();
        $arr[12] =  DB::table('gbook_index_inside')->whereYear('DATE_SAVE',$year)->whereMonth('DATE_SAVE','12')->count();
        return $arr;
    }
    public function countReceivebookUrgent($year)
    {
        $data = DB::table('gbook_instant')->get();
        foreach ($data as $value) {
            $arr[$value->INSTANT_ID]['name'] = $value->INSTANT_NAME;
            $arr[$value->INSTANT_ID]['value'] = DB::table('gbook_index')->where('BOOK_URGENT_ID',$value->INSTANT_ID)
            ->whereBetween('DATE_SAVE',[$year . '-01-01', $year . '-12-31'])->count();
        }
        return $arr;
    }
    public function countTypeebookreceive($year)
    {
        $data = DB::table('gbook_type')->get();
        foreach ($data as $value) {
            $arr[$value->BOOK_TYPE_ID]['name'] = $value->BOOK_TYPE_NAME;
            $arr[$value->BOOK_TYPE_ID]['value'] = DB::table('gbook_index')->where('BOOK_TYPE_ID',$value->BOOK_TYPE_ID)->whereBetween('DATE_SAVE',[$year . '-01-01', $year . '-12-31'])->count();
        }
        return $arr;
    }
    //ใช้ดึงข้อมูลทุกประเภทหนังสือ    ปล.ก่อนใช้เช็ค arr['content'] ก่อน เพื่อป้องกันกรณีข้อมูลผู้ส่งเข้าไม่มี
    public function countTypeebookreceive_byORG_all($year,$limit = 1000)
    {
        $typebook = DB::table('gbook_type')->get();
        $arr['header'] = array(); 
        array_push($arr['header'], 'จากหน่วยงาน'); 
        foreach($typebook as $value){
            array_push($arr['header'],$value->BOOK_TYPE_NAME);
        }
        array_push($arr['header'] ,'รวมทั้งหมด');

        $form = $year . '-01-01';
        $to = $year . '-12-31';

        $org_in = DB::table('gbook_index')->select(DB::raw('gbook_index.BOOK_ORG_ID , grecord_org.RECORD_ORG_NAME , count(gbook_index.BOOK_ORG_ID) as count'))
        ->leftjoin('grecord_org','grecord_org.RECORD_ORG_ID','gbook_index.BOOK_ORG_ID')
        ->whereBetween('gbook_index.DATE_SAVE',[$form,$to])
        ->groupBy('gbook_index.BOOK_ORG_ID','grecord_org.RECORD_ORG_NAME')
        ->limit($limit)
        ->orderBy('count','DESC')
        ->get();
        
        foreach ($org_in as $value) {
            $org_id = $value->BOOK_ORG_ID;
            $arr['content'][$org_id] = array();
            array_push($arr['content'][$org_id] , $value->RECORD_ORG_NAME);
            foreach($typebook as $value2){
            array_push($arr['content'][$org_id], DB::table('gbook_index')->where('BOOK_ORG_ID',$org_id)->where('BOOK_TYPE_ID',$value2->BOOK_TYPE_ID)->whereBetween('DATE_SAVE',[$form,$to])->count());
            }
            array_push($arr['content'][$org_id],$value->count); // คำนวณจากการ GroupBy และ count ออกมา
            // array_push($arr['content'][$org_id],DB::table('gbook_index')->where('BOOK_ORG_ID',$org_id)->whereBetween('DATE_SAVE',[($year - 1) . '-10-01', $year . '-09-30'])->count()); //คำนวณจากตารางใหม่อ้าอิงตาม id
        }
        return $arr;
    }
    //ใช้ดึงข้อมูลบางประเภทหนังสือ     ปล.ก่อนใช้เช็ค arr['content'] ก่อน เพื่อป้องกันกรณีข้อมูลผู้ส่งเข้าไม่มี
    public function countTypeebookreceive_byORG($year,$limit = 50)
    {
        $arr['header'][1] = 'จากหน่วยงาน'; 
        $arr['header'][2] = 'หนังสือภายนอก'; //1
        $arr['header'][3] = 'หนังสือภายใน'; //2
        $arr['header'][4] = 'หนังสือประทับตรา'; //3
        $arr['header'][5] = 'หนังสือประชาสัมพันธ์'; //5
        $arr['header'][6] = 'หนังสือขอประวัติ'; //8
        $arr['header'][7] = 'หนังสือคำสั่ง'; //4
        $arr['header'][8] = 'อื่น ๆ'; 
        $arr['header'][9] = 'รวมทั้งหมด';

        $form = $year . '-01-01';
        $to = $year . '-12-31';

        $org_in = DB::table('gbook_index')->select(DB::raw('gbook_index.BOOK_ORG_ID , grecord_org.RECORD_ORG_NAME , count(gbook_index.BOOK_ORG_ID) as count'))
        ->leftjoin('grecord_org','grecord_org.RECORD_ORG_ID','gbook_index.BOOK_ORG_ID')
        ->whereBetween('gbook_index.DATE_SAVE',[$form,$to])
        ->groupBy('gbook_index.BOOK_ORG_ID','grecord_org.RECORD_ORG_NAME')
        ->limit($limit)
        ->orderBy('count','DESC')
        ->get();
        foreach ($org_in as $value) {
            $arr['content'][$value->BOOK_ORG_ID][1] =$value->RECORD_ORG_NAME;
            $arr['content'][$value->BOOK_ORG_ID][2] = DB::table('gbook_index')->where('BOOK_ORG_ID',$value->BOOK_ORG_ID)->where('BOOK_TYPE_ID',1)
            ->whereBetween('DATE_SAVE',[$form,$to])->count(); //หนังสือภายนอก 1
            $arr['content'][$value->BOOK_ORG_ID][3] = DB::table('gbook_index')->where('BOOK_ORG_ID',$value->BOOK_ORG_ID)->where('BOOK_TYPE_ID',2)
            ->whereBetween('DATE_SAVE',[$form,$to])->count(); //หนังสือภายใน 2
            $arr['content'][$value->BOOK_ORG_ID][4] = DB::table('gbook_index')->where('BOOK_ORG_ID',$value->BOOK_ORG_ID)->where('BOOK_TYPE_ID',3)
            ->whereBetween('DATE_SAVE',[$form,$to])->count(); //หนังสือประทับตรา 3
            $arr['content'][$value->BOOK_ORG_ID][5] = DB::table('gbook_index')->where('BOOK_ORG_ID',$value->BOOK_ORG_ID)->where('BOOK_TYPE_ID',5)
            ->whereBetween('DATE_SAVE',[$form,$to])->count(); //หนังสือประชาสัมพันธ์ 5
            $arr['content'][$value->BOOK_ORG_ID][6] = DB::table('gbook_index')->where('BOOK_ORG_ID',$value->BOOK_ORG_ID)->where('BOOK_TYPE_ID',8)
            ->whereBetween('DATE_SAVE',[$form,$to])->count(); //หนังสือประวัติ 8
            $arr['content'][$value->BOOK_ORG_ID][7] = DB::table('gbook_index')->where('BOOK_ORG_ID',$value->BOOK_ORG_ID)->where('BOOK_TYPE_ID',4)
            ->whereBetween('DATE_SAVE',[$form,$to])->count(); //หนังสือคำสั่ง 4
            $arr['content'][$value->BOOK_ORG_ID][8] = DB::table('gbook_index')->where('BOOK_ORG_ID',$value->BOOK_ORG_ID)
            ->where('BOOK_TYPE_ID','<>',1)
            ->where('BOOK_TYPE_ID','<>',2)
            ->where('BOOK_TYPE_ID','<>',3)
            ->where('BOOK_TYPE_ID','<>',4)
            ->where('BOOK_TYPE_ID','<>',5)
            ->where('BOOK_TYPE_ID','<>',8)
            ->whereBetween('DATE_SAVE',[$form,$to])->count(); //อื่น ๆ
            $arr['content'][$value->BOOK_ORG_ID][9] = $value->count; // คำนวณจากการ GroupBy และ count ออกมา
        }
        // $arr['content'][$value->BOOK_ORG_ID][9] = DB::table('gbook_index')->where('BOOK_ORG_ID',$value->BOOK_ORG_ID)->whereBetween('DATE_SAVE',[($year - 1) . '-10-01', $year . '-09-30'])->count();//คำนวณจากตารางใหม่อ้าอิงตาม id
        return $arr;
    }
}
