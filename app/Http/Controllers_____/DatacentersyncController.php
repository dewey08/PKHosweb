<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assetarticle;
use App\Models\Org;
use App\Models\Person;

use Auth;
use Illuminate\Support\Facades\DB;
class DatacentersyncController extends Controller
{

    private function org(){
        $org = Org::first();
        return [
            'hospcode' => $org->ORG_PCODE,
            'hos_name' => $org->ORG_NAME,
            'user_id' => Auth::id(),
            'username' => Auth::user()->name,
            'ip_gateway' => request()->ip(), 
            'ip_client' => request()->ip(),
        ];
    }
    public function index(){
        
        return view('datacentersync.index',[
            $hospcode = $this->org(),
            'hospcode' =>  $hospcode['hospcode'],
        ]);
    }


    public function summary(){
        $asset =  $this->assets();
        $person =  $this->person();

        return response()->json([
            'assets' => $asset->count(),
            'person' => $person->count(),
        ]);
    }

    private function assets(){
        return Assetarticle::select([
            DB::raw('distinct(ARTICLE_NUM)'),
            DB::raw('(select ORG_PCODE FROM info_org limit 1) as hospcode'),
            DB::raw('(select ORG_NAME FROM info_org limit 1) as HOS_NAME'),
            'ARTICLE_NUM',
            'ARTICLE_NAME',
            'RECEIVE_DATE',
            'PRICE_PER_UNIT',
            'REMARK','STATUS_ID','EXPIRE_DATE',
            'OLD_USE',
            'VENDOR_ID',
            'asset_article.BUY_ID',
            'supplies_buy.BUY_NAME',
            'asset_article.YEAR_ID',
            'DECLINE_ID',
            'CODE_REF',
            'asset_article.BUDGET_ID',
            'BUDGET_NAME',
            'ARTICLE_PROP',
            'SUP_FSN'
        ])
        ->join('supplies_prop','asset_article.SUP_FSN','=','supplies_prop.NUM')
        ->leftJoin('supplies_buy','asset_article.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','asset_article.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->whereNotNull('asset_article.SUP_FSN')
        ->get();
    }


    private function person(){
        return Person::select([
            DB::raw('(select ORG_PCODE FROM info_org limit 1) as hospcode'),
            DB::raw('(select ORG_NAME FROM info_org limit 1) as HOS_NAME'),
            'HR_FNAME',
            'HR_FNAME',
            'HR_LNAME',
            'HR_CID',
            'HR_BIRTHDAY',
            'HR_MARRY_STATUS_NAME',
            'HR_RELIGION_NAME',
            'HR_NATIONALITY_NAME',
            'HR_CITIZENSHIP_NAME',
            'SEX',
            'SEX_NAME',
            'HR_BLOODGROUP_NAME',
            'HR_DEPARTMENT_NAME',
            'HR_DEPARTMENT_SUB_NAME',
            'HR_DEPARTMENT_SUB_SUB_NAME',
            'HR_STARTWORK_DATE',
            'HR_POSITION_NUM',
            'HR_POSITION_ID',
            'POSITION_IN_WORK',
            'VCODE',
            'VCODE_DATE',
            'HR_LEVEL_NAME',
            'HR_STATUS_NAME',
            'HR_KIND_NAME',
            'HR_KIND_TYPE_NAME',
            'hrd_person.HR_PERSON_TYPE_ID',
            'HR_PERSON_TYPE_NAME',
            'HR_AGENCY_ID',
            'HR_SALARY',
            'MONEY_POSITION',
        ])
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
        ->whereNotIn('hrd_person.HR_STATUS_ID', [5,6,7,8])
        // ->limit(10)
        ->get();
    }
    public function getasset(){

        $data = $this->assets();
        $hospcode = Org::first();
        unset($data->IMG);
        return response()->json([
            'total' => $data->count(),
            'infomation' => $this->org(),
            'items' => $data
        ]);
    }


    public function getPerson(){
       
        $item = $this->person();

        return response()->json([
            'infomation' => $this->org(),
            'total' => $item->count(),
            'items' => $item
        ]);
    }
}