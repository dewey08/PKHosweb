<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;



date_default_timezone_set("Asia/Bangkok");

class ManagerreportController extends Controller
{
    public function dashboard()
    {
    
        return view('manager_report.dashboard_report');
    }

    public function detail()
    {
    
        return view('manager_report.reportdetail');
    }

    
    


}

