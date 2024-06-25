<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Infopublicityimage;

class SetuppublicityimageController extends Controller
{
    public function infopublicityimage()
    {
       

        $infopublicityimage = DB::table('info_publicity_image')->get();

       //dd($infoorg);
        return view('admin.setuppublicityimage',[
            'infopublicityimages' =>$infopublicityimage 
        ]);
    }


    public function createpublicityimage()
    {
       

        return view('admin.setuppublicityimage_add');
    }

    
    function savepublicityimage(Request $request)
    {  
      
        
        $addpublicityimage = new Infopublicityimage(); 
        $addpublicityimage->NAME_IMG = $request->NAME_IMG;
  
        
        if($request->hasFile('picture')){
            //$newFileName = $picid.'.'.$request->picture->extension();
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addpublicityimage->IMG = $contents;   
            //$request->picture->storeAs('images',$newFileName,'public');
            //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
        }
     
        
        $addpublicityimage->save();
    

    
        return redirect()->route('setup.infopublicityimage');
    }

        
    public function destroypublicityimage($id) { 
                
        Infopublicityimage::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infopublicityimage');   
    }

    function switchactive(Request $request)
    {  
        //return $request->all(); 
        $id = $request->idimg;
        $budgetactive = Infopublicityimage::find($id);
        $budgetactive->ACTIVE = $request->onoff;
        $budgetactive->save();
    }

}
