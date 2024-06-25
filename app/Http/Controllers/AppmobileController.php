<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class AppmobileController extends Controller
{  
    public function getfire(Request $request,$firenum)
    {
        $user = Biguser::first();
        $uget = Biguser::select('fullname','username','password','email','status')
          ->get();
          return response([$user, $uget]);  
    }
    
}
