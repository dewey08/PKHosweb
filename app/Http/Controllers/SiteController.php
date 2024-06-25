<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(){
        $fullname = "JITSANGA";
        $website  = "codingthailand";
        return view('about',[
            'fullname' => $fullname,
             'website' => $website
        ]);
    }
}
