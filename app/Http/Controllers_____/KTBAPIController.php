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
use Stevebauman\Location\Facades\Location;
use Http;
use SoapClient; 
use SplFileObject;
use Arr;
use Storage;
use GuzzleHttp\Client;
use App\Models\Tempexport;
use App\Models\D_aer;
use App\Models\D_adp;
use App\Models\D_cha;  
use App\Models\D_cht;
use App\Models\D_oop;
use App\Models\D_odx;
use App\Models\D_orf;
use App\Models\D_pat;
use App\Models\D_ins;
use App\Models\D_dru;
use App\Models\D_opd;
use App\Models\D_ktb_b17;
use App\Models\Stm;
use App\Models\D_export;

class KTBAPIController extends Controller
{
    public function ktb_test(Request $request)
    { 
        $data['users'] = User::get();
        $budget = DB::table('budget_year')->where('active','=','True')->first();
        $datestart = $budget->date_begin;
        $dateend = $budget->date_end;
        
        $url = "https://www.healthplatform.krungthai.com/healthPlatform/assets/config/config.json";
        $url2 = "https://www.healthplatform.krungthai.com/api/v1/nhso-auth/login";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$url",
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
         
            $response = curl_exec($curl);
            curl_close($curl);
            $content = $response;
            $result = json_decode($content, true); 
            // dd($result); 
            // @$responseCode = $result['responseCode'];
            // // dd($responseCode);
            // if (@$responseCode < 0) {
            //     $smartcard = 'NO_CONNECT';
            // } else { 
            //     $smartcard = 'CONNECT';
            // }
            // dd($smartcard);
                @$endpoint = $result['endpoint'];
                
                $endpoint         = @$endpoint; 
                   dd($endpoint);
                // dd( @$fullNameTH); 
        return view('ktb.ktb_getcard', $data,[  
            'smartcard'     =>  $smartcard, 
           
        ]);
    }
    
    
    
    
    
}
