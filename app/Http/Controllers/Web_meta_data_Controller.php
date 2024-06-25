<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Web_meta_data_Controller extends Controller
{
    public static function getValueByName($meta_name)
    {
        return DB::table('web_meta_data')->where('meta_name',$meta_name)->first()->meta_value;
    }
    public static function updateValueByName(Request $req)
    {
        DB::table('web_meta_data')->where('meta_name',$req->name)->update(['meta_value'=>$req->value,'updated_at'=>date('Y-m-d H:i:s')]);
    }

}
