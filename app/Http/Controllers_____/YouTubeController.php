<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Youtube_upload;
use Spatie\PdfToImage\Pdf;
use Org_Heigl\Ghostscript\Ghostscript;

date_default_timezone_set("Asia/Bangkok");

class YouTubeController extends Controller
{
    public function youtubeindex(Request $request)
    {
        $videoLists = $this->_videoLists('คู่มือสอนการใช้งาน');
       
        return view('youtube.youtubeindex',compact('videoLists'));
        
    }
    public function youtuberesults(Request $request)
    {
        return view('youtube.youtuberesults');
    }
    public function youtubewatch(Request $request)
    {
        return view('youtube.youtubewatch');
    }
    public function youtubegleave(Request $request)
    {
        return view('youtube.youtubegleave');
    }



    protected function _videoLists($keywords)
    {
        $part = 'snippet';
        $country = 'TH';
        $apiKey = config('services.youtube.api_key');
        $maxResults = 12;
        $youTubeEndPoint = config('services.youtube.search_endpoint');
        $type = 'video';

        $url = "$youTubeEndPoint?part=$part&maxResults=$maxResults&regionCode=$country&type=$type&key=$apiKey&q=$keywords";
        $response =Http::get($url);
        $results = json_decode($response);
        File::put(storage_path() . '/app/public/results.json', $response->body());
        return $results;
    }

    public function uploadpdf(Request $request)
    {   
        $datashow = Youtube_upload::get();
        return view('youtube.uploadpdf',['datashow' => $datashow]);
    }

    public function uploadpdf_file(Request $request)
    {           
        $data = new Youtube_upload();

        $maxid = Youtube_upload::max('PDF_FILEID');
        $idfile = $maxid+1;

        if ($request->hasFile('file')) {

            $fileimg = $request->file('file');

            $contents = $fileimg->openFile()->fread($fileimg->getSize());  

            $data->file_img = $contents;

        $filename = 'You_'.$idfile.'.'.$fileimg->getClientOriginalExtension();
        $namepng = 'You_'.$idfile;

        $request->file->move(storage_path() . '/app/public/youtube',$filename);

        $data->file_pdf = $filename;        

        //บันทึกไฟล์ pdf
        $pdffile = storage_path() .'\app\public\youtube\\'.$filename;

        //บันทึกไฟล์ ภาพ
        if ($filename = 1) {
            $output_path = storage_path() .'\app\public\youtube\\'.$namepng;
        } else if($filename > 1) {
            $output_path = storage_path() .'\app\public\youtube\\'.$namepng.'%d';
        }else{

        
        }
        
        // $output_path = storage_path() .'\app\public\youtube\\'.$namepng;
        // $output_path = storage_path() ."\app\public\youtube\\%d";

        //บน windows
        Ghostscript::setGsPath("C:\Program Files\gs\gs9.54.0\bin\gswin64c.exe");

        // $gs_path = ('\app\public\ghostscript');
        // Ghostscript::setGsPath($gs_path);

        // dd($gs_path);
        // $pdf = new Pdf($pdffile);
        // $saveImageUrl = storage_path('\app\public\youtube\\'.$filename);
        // $pdf->saveImage($saveImageUrl);
        $pdf = new Pdf($pdffile);
        // $pdf = new Spatie\PdfToImage\Pdf($pdffile);
        $pdf->setOutputFormat('png');

        $pdf->saveImage($output_path);

        // dd($pdf);
        
        $output_path2 = storage_path() ."\app\public\youtube\\You%d";
        $data->NAME_IMG =  'You_'.$idfile.'.png';
        $data->file_imgs =  $output_path2;
           
        }    

        $data->PDF_FILENAME = $request->PDF_FILENAME;

        $data->save();

        return redirect()->route('you.uploadpdf');
        // return $request;
    }



//********************************** User  **********************//

public function youtubeuser_personcheckinindex(Request $request,$iduser)
{
    $videoLists = $this->_videoLists('คู่มือสอนการใช้งาน');
   
    // return view('youtube.youtubeuser_gleaveindex',compact('videoLists'));
    return view('youtube.youtubeuser_personcheckinindex',[
        'videoLists'=>$videoLists,
        'iduser'=>$iduser,
    ]);
    
}
public function youtubeuser_gleaveindex(Request $request,$iduser)
{
    $videoLists = $this->_videoLists('คู่มือสอนการใช้งาน');
   
    return view('youtube.youtubeuser_gleaveindex',[
        'videoLists'=>$videoLists,
        'iduser'=>$iduser,
    ]);    
}

public function youtubeuser_persondevindex(Request $request,$iduser)
{
    $videoLists = $this->_videoLists('คู่มือสอนการใช้งาน');
   
    return view('youtube.youtubeuser_persondevindex',[
        'videoLists'=>$videoLists,
        'iduser'=>$iduser,
    ]);    
}

public function youtubeuser_compensationindex(Request $request,$iduser)
{
    $videoLists = $this->_videoLists('คู่มือสอนการใช้งาน');
   
    return view('youtube.youtubeuser_compensationindex',[
        'videoLists'=>$videoLists,
        'iduser'=>$iduser,
    ]);    
}

public function youtubeuser_guesthouseindex(Request $request,$iduser)
{
    $videoLists = $this->_videoLists('คู่มือสอนการใช้งาน');
   
    return view('youtube.youtubeuser_guesthouseindex',[
        'videoLists'=>$videoLists,
        'iduser'=>$iduser,
    ]);    
}

public function youtubeuser_warehouse(Request $request,$iduser)
{
    $videoLists = $this->_videoLists('คู่มือสอนการใช้งาน');
   
    return view('youtube.youtubeuser_warehouse',[
        'videoLists'=>$videoLists,
        'iduser'=>$iduser,
    ]);    
}
}
