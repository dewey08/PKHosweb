<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Linetoken;


use Illuminate\Support\Facades\Auth;

class SetuplineController extends Controller
{
    public function infolinetoken(Request $request)
    {
        $infolinetoken= Linetoken::get();

       //dd($infoeducation);
      

        return view('admin.setupinfolinetoken',[
            'infolinetokens' => $infolinetoken 
        ]);
    }
   

    public function updateinfolinetoken(Request $request)
    {
        $id = $request->ID_LINE_TOKEN; 
        $linetoken = Linetoken::find($id);
        $linetoken->LINE_TOKEN = $request->LINE_TOKEN;
        $linetoken->save();
        
            
            return redirect()->route('setup.infolinetoken');  

    }






}
