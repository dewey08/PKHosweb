<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Healthscreen;
use App\Models\Healthbody;

class HealthpersonReportController extends Controller
{
    public function health_screen_by_budgetyear($budgetyear , $HEALTH_SCREEN_H_ID){
        $query = Healthscreen::where('HEALTH_SCREEN_YEAR',$budgetyear)
                ->leftJoin('hrd_person','hrd_person.ID','health_screen.HEALTH_SCREEN_PERSON_ID')
                ->get();
        $result = array();
        $column = 'HEALTH_SCREEN_H_'.$HEALTH_SCREEN_H_ID;
        foreach($query as $row){
            $result[$row->HEALTH_SCREEN_ID]['name'] = $row->HR_FNAME .' '.$row->HR_LNAME;
            $result[$row->HEALTH_SCREEN_ID]['age'] = $row->HEALTH_SCREEN_AGE;
            $result[$row->HEALTH_SCREEN_ID]['screen_date'] = $row->HEALTH_SCREEN_DATE;
            $result[$row->HEALTH_SCREEN_ID]['health_result'] = $row->$column;
        }
        return $result;
    }
    
    public function physical_examination_results_by_budgetyear($budgetyear , $bodyresult){
        $query = Healthbody::leftJoin('health_screen','health_screen.HEALTH_SCREEN_ID','health_body.HEALTH_SCREEN_ID')
                ->leftJoin('hrd_person','hrd_person.ID','health_screen.HEALTH_SCREEN_PERSON_ID');
        if($budgetyear !== 'ทั้งหมด'){
            $query->where('health_screen.HEALTH_SCREEN_YEAR',$budgetyear);
        }
        if($bodyresult !== 'all'){
            $query->where('HEALTH_BODY_RESULT',$bodyresult);
        }
        return $query->get();
    }
    
    public function count_health_screen_by_budgetyear($budgetyear){
        $query = Healthscreen::where('HEALTH_SCREEN_YEAR',$budgetyear)->get();
        $result = array(); 
        $result[1]['have'] = 0 ;
        $result[1]['nothave'] = 0 ;
        $result[2]['have'] = 0 ;
        $result[2]['nothave'] = 0 ;
        $result[3]['have'] = 0 ;
        $result[3]['nothave'] = 0 ;
        $result[4]['have'] = 0 ;
        $result[4]['nothave'] = 0 ;
        $result[6]['have'] = 0 ;
        $result[6]['nothave'] = 0 ;
        $result[27]['have'] = 0 ;
        $result[27]['nothave'] = 0 ;
        $result[28]['have'] = 0 ;
        $result[28]['nothave'] = 0 ;
        foreach($query as $row){
            if($row->HEALTH_SCREEN_H_1 == 'have'){
                $result[1]['have'] += 1 ;
            }elseif($row->HEALTH_SCREEN_H_1 == 'nothave'){
                $result[1]['nothave'] += 1 ;
            }
            if($row->HEALTH_SCREEN_H_2 == 'have'){
                $result[2]['have'] += 1 ;
            }elseif($row->HEALTH_SCREEN_H_2 == 'nothave'){
                $result[2]['nothave'] += 1 ;
            }
            if($row->HEALTH_SCREEN_H_3 == 'have'){
                $result[3]['have'] += 1 ;
            }elseif($row->HEALTH_SCREEN_H_3 == 'nothave'){
                $result[3]['nothave'] += 1 ;
            }
            if($row->HEALTH_SCREEN_H_4 == 'have'){
                $result[4]['have'] += 1 ;
            }elseif($row->HEALTH_SCREEN_H_4 == 'nothave'){
                $result[4]['nothave'] += 1 ;
            }
            if($row->HEALTH_SCREEN_H_6 == 'have'){
                $result[6]['have'] += 1 ;
            }elseif($row->HEALTH_SCREEN_H_6 == 'nothave'){
                $result[6]['nothave'] += 1 ;
            }
            if($row->HEALTH_SCREEN_H_27 == 'have'){
                $result[27]['have'] += 1 ;
            }elseif($row->HEALTH_SCREEN_H_27 == 'nothave'){
                $result[27]['nothave'] += 1 ;
            }
            if($row->HEALTH_SCREEN_H_28 == 'have'){
                $result[28]['have'] += 1 ;
            }elseif($row->HEALTH_SCREEN_H_28 == 'nothave'){
                $result[28]['nothave'] += 1 ;
            }
        }
        return $result;
    }
}
