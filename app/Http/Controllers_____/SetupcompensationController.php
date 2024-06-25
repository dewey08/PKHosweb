<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Hrdpersontype;



date_default_timezone_set("Asia/Bangkok");

class SetupcompensationController extends Controller
{

    public function setupcompensationlist()
    {
        $compensationlist = DB::table('hrd_person_type')  
        ->get();
    
        return view('admin_compensation.setupcompensationlist',[
            'compensationlists' => $compensationlist
            ]);
    }


    public function setupcompensationacc()
    {
    
        return view('admin_compensation.setupcompensationacc');
    }


    public function setupcompensationlistreceipt()
    {
    
        return view('admin_compensation.setupcompensationlistreceipt');
    }

    public function setupcompensationlistpay()
    {
        $compensationlistpay = DB::table('salary_pay')
        ->leftjoin('hrd_person_type','salary_pay.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('HR_PERSON_TYPE_ID','=','salary_pay.HR_PERSON_TYPE_ID')  
        ->get();
        return view('admin_compensation.setupcompensationlistpay',[
            'compensationlistpays' => $compensationlistpay
            ]);
    }

    


}

