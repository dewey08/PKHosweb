<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Infowork_job_person extends Model
{
    use HasFactory;
    protected $table = 'infowork_job_person';
    protected $primaryKey = 'IWJOB_PERSON_ID';

    public static function getJobPersonByYearPersonJob($budgetyear = 'all', $jobdescript = 'all', $person_id = 'all' ){
        $query = Infowork_job_person::select('infowork_job_person.*','infowork_job_descriptions.*'
        ,'p.HR_FNAME as p_fname' , 'p.HR_LNAME as p_lname'
        , 'p_c.HR_FNAME as p_c_fname' , 'p_c.HR_LNAME as p_c_lname'
        , 'p_a1.HR_FNAME as p_a1_fname' , 'p_a1.HR_LNAME as p_a1_lname'
        , 'p_a2.HR_FNAME as p_a2_fname' , 'p_a2.HR_LNAME as p_a2_lname')
        ->leftJoin('infowork_job_descriptions','infowork_job_descriptions.IWJOB_D_ID','infowork_job_person.IWJOB_D_ID')
        ->leftJoin('hrd_person as p','p.ID','infowork_job_person.PERSON_ID')
        ->leftJoin('hrd_person as p_c','p_c.ID','infowork_job_person.IWJP_CREATED_ID')
        ->leftJoin('hrd_person as p_a1','p_a1.ID','infowork_job_person.IWJP_ASSESSOR_ID_1')
        ->leftJoin('hrd_person as p_a2','p_a2.ID','infowork_job_person.IWJP_ASSESSOR_ID_2');
        if($budgetyear !== 'all'){
            $query = $query->where('infowork_job_person.IWJP_BUDGETYEAR',$budgetyear);
        }
        if($jobdescript !== 'all'){
            $query = $query->where('infowork_job_person.IWJOB_D_ID',$jobdescript);
        }
        if($person_id !== 'all'){
            $query = $query->where('PERSON_ID',$person_id);
        }
        return $query->get();
    } 

    public static function getJobPersonByJobid($IWJOB_PERSON_ID){
        $query = Infowork_job_person::select('infowork_job_person.*','p.HR_FNAME as p_fname' , 'p.HR_LNAME as p_lname'
        ,'infowork_kpi.IWKPI_NAME','infowork_job_descriptions.IWJD_NAME'
        , 'p_c.HR_FNAME as p_c_fname' , 'p_c.HR_LNAME as p_c_lname'
        , 'p_a1.HR_FNAME as p_a1_fname' , 'p_a1.HR_LNAME as p_a1_lname'
        , 'p_a2.HR_FNAME as p_a2_fname' , 'p_a2.HR_LNAME as p_a2_lname'
        , 'iwj_list.IWJOB_PERSON_LIST_ID'
        , 'iwj_list.IWKPI_ID'
        , 'iwj_list.IWJPL_NUMBER_1'
        , 'iwj_list.IWJPL_NUMBER_2'
        , 'iwj_list.IWJPL_NUMBER_3'
        , 'iwj_list.IWJPL_NUMBER_4'
        , 'iwj_list.IWJPL_NUMBER_5'
        , 'iwj_list.IWJPL_SCORE_A'
        , 'iwj_list.IWJPL_WEIGHT_B'
        , 'iwj_list.IWJPL_MULTIPLY_AB'
        , 'iwj_list.IWJPL_TARGET'
        , 'iwj_list.IWJPL_PERFORMANCE_10'
        , 'iwj_list.IWJPL_PERFORMANCE_11'
        , 'iwj_list.IWJPL_PERFORMANCE_12'
        , 'iwj_list.IWJPL_PERFORMANCE_1'
        , 'iwj_list.IWJPL_PERFORMANCE_2'
        , 'iwj_list.IWJPL_PERFORMANCE_3'
        , 'iwj_list.IWJPL_PERFORMANCE_4'
        , 'iwj_list.IWJPL_PERFORMANCE_5'
        , 'iwj_list.IWJPL_PERFORMANCE_6'
        , 'iwj_list.IWJPL_PERFORMANCE_7'
        , 'iwj_list.IWJPL_PERFORMANCE_8'
        , 'iwj_list.IWJPL_PERFORMANCE_9'
        , 'iwj_list.IWJPL_PERFORMANCE_AVG'
        )
        ->leftJoin('infowork_job_person_list as iwj_list','iwj_list.IWJOB_PERSON_ID','infowork_job_person.IWJOB_PERSON_ID')
        ->leftJoin('infowork_kpi','infowork_kpi.IWKPI_ID','iwj_list.IWKPI_ID')
        ->leftJoin('infowork_job_descriptions','infowork_job_descriptions.IWJOB_D_ID','infowork_job_person.IWJOB_D_ID')
        ->leftJoin('hrd_person as p','p.ID','infowork_job_person.PERSON_ID')
        ->leftJoin('hrd_person as p_c','p_c.ID','infowork_job_person.IWJP_CREATED_ID')
        ->leftJoin('hrd_person as p_a1','p_a1.ID','infowork_job_person.IWJP_ASSESSOR_ID_1')
        ->leftJoin('hrd_person as p_a2','p_a2.ID','infowork_job_person.IWJP_ASSESSOR_ID_2')
        ->where('infowork_job_person.IWJOB_PERSON_ID',$IWJOB_PERSON_ID)
        ->get();
        return $query;
    } 
}
