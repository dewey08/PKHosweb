<?php

namespace App\Http\Controllers;

use App\Models\Information_facebook_page;
use Illuminate\Http\Request;
use Session;
class Setupinfo_pagefacebookController extends Controller
{
    public function pagefacebook()
    {
        $facebookpage = Information_facebook_page::getAllFacebookpage();
        return view('admin.other.setup_pagefacebook_view')->with([
            'facebookpage' => $facebookpage
        ]);
    }

    public function pagefacebook_add()
    {
        return view('admin.other.setup_pagefacebook_add');
    }

    public function pagefacebook_save(Request $request)
    {   
        $pagefacebook = new Information_facebook_page();
        $pagefacebook->IFP_PLUGIN = $request->IFP_PLUGIN;
        $pagefacebook->IFP_DATASHOW = $request->IFP_DATASHOW;
        $pagefacebook->IFP_ACTIVE = !empty($request->IFP_ACTIVE)?$request->IFP_ACTIVE:0;
        $pagefacebook->save();
        Session::flash('scc','บันทึกข้อมูลสำเร็จ');
        return redirect(route('admin.setupinfo.pagefacebook'));
    }

    public function pagefacebook_edit($id)
    {
        $pagefacebook = Information_facebook_page::find($id);
        return view('admin.other.setup_pagefacebook_edit')->with([
            'pagefacebook' => $pagefacebook,
        ]);
    }

    public function pagefacebook_update(Request $request)
    {
        $pagefacebook = Information_facebook_page::find($request->id);
        $pagefacebook->IFP_PLUGIN = $request->IFP_PLUGIN;
        $pagefacebook->IFP_DATASHOW = $request->IFP_DATASHOW;
        $pagefacebook->IFP_ACTIVE = !empty($request->IFP_ACTIVE)?$request->IFP_ACTIVE:0;
        $pagefacebook->save();
        Session::flash('scc','แก้ไขข้อมูลสำเร็จ');
        return redirect(route('admin.setupinfo.pagefacebook'));
    }

    public function pagefacebook_delete($id)
    {
        Information_facebook_page::destroy($id);
        Session::flash('scc','ลบข้อมูลสำเร็จ');
        return redirect(route('admin.setupinfo.pagefacebook'));
    }
}
