<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HelloController extends Controller
{
        function showHello(){
            return '<h1>Hello Controller</h1>';
        }

      
        function prefix(){
            $prefix = DB::table('hrd_prefix')->get();

            var_dump($prefix);
          
        }

      

}

