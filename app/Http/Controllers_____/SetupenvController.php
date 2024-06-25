<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;



date_default_timezone_set("Asia/Bangkok");

class SetupenvController extends Controller
{
    public function dashboard_env()
    {
    
        return view('admin_env.dashboard_env');
    }
    public function list_check()
    {
    
        return view('admin_env.list_check');
    }

    public function list_check_add()
    {
    
        return view('admin_env.list_check_add');
    }
    public function list_check_save(Request $request)
    {
    
        return redirect()->route('setenv.list_check');
    }
    public function list_check_edit(Request $request,$id)
    {
    
        return view('admin_env.list_check_edit');
    }
    public function list_check_update(Request $request)
    {
    
        return redirect()->route('setenv.list_check');
    }
   
  

}

