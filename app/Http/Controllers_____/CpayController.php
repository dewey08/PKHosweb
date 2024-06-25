<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cpay_department_sub_sub_quota_user;
use App\Models\Person;

use Auth;

class CpayController extends Controller
{
    public function dashboard(Request $request){
        $data['yearlist'] = getBudgetYearAmount(); 
        return view('general_cpay.dashboard',$data);
    }

    public function quota_equpment(Request $request){
        $person_id = Auth()->user()->PERSON_ID;
        $person = Person::find($person_id);

        $data['quota_equpment'] = Cpay_department_sub_sub_quota_user::select('*')
        ->leftJoin('cpay_setequpment','cpay_setequpment.CPAY_SET_ID','cpay_department_sub_sub_quota.CPAY_SET_ID')
        ->leftJoin('cpay_department_sub_sub','cpay_department_sub_sub.CPAY_DEP_ID','cpay_department_sub_sub_quota.CPAY_DEP_ID')
        ->leftJoin('cpay_unit','cpay_unit.CPAY_UNIT_ID','cpay_setequpment.CPAY_UNIT_ID')
        ->leftJoin('cpay_typemachine','cpay_typemachine.CPAY_TYPEMACH_ID','cpay_setequpment.CPAY_TYPEMACH_ID')
        ->where('cpay_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID',$person->HR_DEPARTMENT_SUB_SUB_ID)->get();
        return view('general_cpay.quota_equpment',$data);
    }
}
