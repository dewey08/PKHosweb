<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Persontype;

class SetupconditionController extends Controller
{
    public function infocondition()
    {
       
        $infocondition = Persontype::orderBy('HR_PERSON_TYPE_ID', 'asc')  
                                     ->get();

       //dd($infoeducation);
        return view('admin.setupcondition',[
            'infoconditions' => $infocondition 
        ]);
    }
}
