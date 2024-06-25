<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Line extends Controller
{
    public static function msg_notify($msg, $token){
        $token = trim($token);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");
        $chOne = curl_init(); 
        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt( $chOne, CURLOPT_POST, 1); 
        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$msg); 
        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($chOne, CURLOPT_HTTPHEADER, array( 
            'Content-type: application/x-www-form-urlencoded', 
            'Authorization: Bearer '.$token.'', )); 
        curl_exec( $chOne ); 
        curl_error($chOne ); 
        curl_close($chOne); 
    }
}
