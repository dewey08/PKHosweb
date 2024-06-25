<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Picqer;

class BarcodeController extends Controller
{
    public function makeBarcode (Request $request)
    {
        $label = '12345';


            $barcode_generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            $barcode = $barcode_generator->getBarcode($label,$barcode_generator::TYPE_CODE_128);

            return view('barcode',[
                'label'=>$label,
                'barcode'=>$barcode
                ]);
      
    }

}
