<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information_publicize;
use Session;
date_default_timezone_set('Asia/Bangkok');
class Setupinfo_publicizeController extends Controller
{
    public function publicize(){
        $publicize = Information_publicize::getAllPublicize();
        return view('admin.other.setup_publicize_view')->with([
            'publicize' => $publicize,
        ]);
    }

    public function publicize_add(){
        return view('admin.other.setup_publicize_add');
    }

    public function publicize_save(Request $request){
        $infopublic = new Information_publicize();
        $infopublic->IPUB_NAME = $request->IPUB_NAME;
        $infopublic->IPUB_DETAIL = $request->IPUB_DETAIL;
        if($request->hasFile('IPUB_IMG')){
            $file = $request->file('IPUB_IMG');  
            $contents = $file->openFile()->fread($file->getSize());
            $infopublic->IPUB_IMG = $contents;
        }
        $infopublic->IPUB_LINK = $request->IPUB_LINK;
        $infopublic->IPUB_DATE = CheckDatethaiParse($request->IPUB_DATE)?CheckDatethaiParse($request->IPUB_DATE):date('Y-m-d');
        $infopublic->IPUB_TIME = $request->IPUB_TIME;
        $infopublic->IPUB_ACTIVE = !empty($request->IPUB_ACTIVE)?$request->IPUB_ACTIVE:0;
        $infopublic->save();
        Session::flash('scc','บันทึกข้อมูลสำเร็จ');
        return redirect(route('admin.setupinfo.publicize'));
    }

    public function publicize_edit($id){
        $infopublic = Information_publicize::find($id);
        return view('admin.other.setup_publicize_edit')->with([
            'infopublic' => $infopublic,
        ]);
    }

    public function publicize_update(Request $request){ 
        $infopublic = Information_publicize::find($request->id);
        $infopublic->IPUB_NAME = $request->IPUB_NAME;
        $infopublic->IPUB_DETAIL = $request->IPUB_DETAIL;
        if($request->hasFile('IPUB_IMG')){
            $file = $request->file('IPUB_IMG');  
            $contents = $file->openFile()->fread($file->getSize());
            $infopublic->IPUB_IMG = $contents;
        }
        $infopublic->IPUB_LINK = $request->IPUB_LINK;
        $infopublic->IPUB_DATE = CheckDatethaiParse($request->IPUB_DATE)?CheckDatethaiParse($request->IPUB_DATE):date('Y-m-d');
        $infopublic->IPUB_TIME = $request->IPUB_TIME;
        $infopublic->IPUB_ACTIVE = !empty($request->IPUB_ACTIVE)?$request->IPUB_ACTIVE:0;
        $infopublic->save();
        Session::flash('scc','แก้ไขข้อมูลสำเร็จ');
        return redirect(route('admin.setupinfo.publicize'));
    }

    public function publicize_delete($id){
        Information_publicize::destroy($id);
        Session::flash('scc','ลบข้อมูลสำเร็จ');
        return redirect(route('admin.setupinfo.publicize'));
    }
}
