<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Incidence;
use Illuminate\Support\Facades\Session;
use App\Models\Setupincidence_group;
use App\Models\Setupincidence_category;
use App\Models\Setupincidence_setting;
use Alert;
use App\Models\Setupincidence_groupuser;
use App\Models\Setupincidence_level;
use App\Models\Setupincidence_location;
use App\Models\Setupincidence_origin;
use App\Models\Setupincidence_listdataset;
use App\Models\Setupincidence_sub;
use App\Models\Risk_setupincidence_grouplocation;
use App\Models\Risk_setupincidence_typelocation;
use App\Models\Risk_setupincidence_status;
use App\Models\Risk_category_department;

use App\Models\Risk_setupincidence_reportheader;
use App\Models\Risk_setupincidence_report;
use App\Models\Risk_setupincidence_modify;
use App\Models\Risk_setupincidence_modify_leveldepartsub;
use App\Models\Risk_setupincidence_modify_departsub;

use App\Models\Risk_setupincidence_category_sub;
use App\Models\Risk_setupincidence_level_begin;

date_default_timezone_set("Asia/Bangkok");

class SetupriskController extends Controller
{
       //***อันดับของการเกิด**//
       public function setupincidence_levelbegin()
       {    
           $levelbegin = Risk_setupincidence_level_begin::get();
           return view('admin_risk.setupincidence_levelbegin',[
               'levelbegins'=>$levelbegin
           ]);
       }
       public function setupincidence_levelbegin_add(Request $request)
       {    
           return view('admin_risk.setupincidence_levelbegin_add');
       }
       public function setupincidence_levelbegin_save(Request $request)
       {           
           $add= new Risk_setupincidence_level_begin();
           $add->INCIDENCE_LEVELBEGIN_NAME = $request->INCIDENCE_LEVELBEGIN_NAME;
           $add->save();
           return redirect()->route('srisk.setupincidence_levelbegin');
       }
       public function setupincidence_levelbegin_edit(Request $request,$id)
       {    
           $levelbegin = Risk_setupincidence_level_begin::where('INCIDENCE_LEVELBEGIN_ID','=',$id)->first();
           return view('admin_risk.setupincidence_levelbegin_edit',[
               'levelbegins'=>$levelbegin
           ]);
       }
       public function setupincidence_levelbegin_update(Request $request)
       {           
           $id = $request->INCIDENCE_LEVELBEGIN_ID;
           $update= Risk_setupincidence_level_begin::find($id);
           $update->INCIDENCE_LEVELBEGIN_NAME = $request->INCIDENCE_LEVELBEGIN_NAME;
           $update->save();
           return redirect()->route('srisk.setupincidence_levelbegin');
       }
       public function setupincidence_levelbegin_destroy(Request $request,$id)
       {    
        Risk_setupincidence_level_begin::destroy($id);
           return redirect()->route('srisk.setupincidence_levelbegin');
         
   }
     //***ประเภทอุบัติการณ์ความเสี่ยงย่อย**//
     public function setupincidence_category_sub()
     {    
         $category_subsub = Risk_setupincidence_category_sub::get();
         return view('admin_risk.setupincidence_category_sub',[
             'category_subsubs'=>$category_subsub
         ]);
     }
     public function setupincidence_category_sub_add(Request $request)
     {    
         return view('admin_risk.setupincidence_category_sub_add');
     }
     public function setupincidence_category_sub_save(Request $request)
     {           
         $add= new Risk_setupincidence_category_sub();
         $add->INCIDENCE_CATEGORY_SUBSUB_NAME = $request->INCIDENCE_CATEGORY_SUBSUB_NAME;
         $add->save();
         return redirect()->route('srisk.setupincidence_category_sub');
     }
     public function setupincidence_category_sub_edit(Request $request,$id)
     {    
         $category_subsub = Risk_setupincidence_category_sub::where('INCIDENCE_CATEGORY_SUBSUB_ID','=',$id)->first();
         return view('admin_risk.setupincidence_category_sub_edit',[
             'category_subsubs'=>$category_subsub
         ]);
     }
     public function setupincidence_category_sub_update(Request $request)
     {           
         $id = $request->INCIDENCE_CATEGORY_SUBSUB_ID;
         $update= Risk_setupincidence_category_sub::find($id);
         $update->INCIDENCE_CATEGORY_SUBSUB_NAME = $request->INCIDENCE_CATEGORY_SUBSUB_NAME;
         $update->save();
         return redirect()->route('srisk.setupincidence_category_sub');
     }
     public function setupincidence_category_sub_destroy(Request $request,$id)
     {    
        Risk_setupincidence_category_sub::destroy($id);
         return redirect()->route('srisk.setupincidence_category_sub');
       
 }
    //-----------------***รายงานโดยใช้**---------------------------------//
    public function setupincidence_reportheader()
    {    
        $cidence_reportheader = Risk_setupincidence_reportheader::get();
        return view('admin_risk.setupincidence_reportheader',[
            'cidence_reportheaders'=>$cidence_reportheader
        ]);
    }
    public function setupincidence_reportheader_add(Request $request)
    {    
        return view('admin_risk.setupincidence_reportheader_add');
    }
    public function setupincidence_reportheader_save(Request $request)
    {           
        $add= new Risk_setupincidence_reportheader();
        $add->SETUP_INCEDENCE_REPORTHEADER_NAME = $request->SETUP_INCEDENCE_REPORTHEADER_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_reportheader');
    }
    public function setupincidence_reportheader_edit(Request $request,$id)
    {    
        $cidence_reportheader = Risk_setupincidence_reportheader::where('SETUP_INCEDENCE_REPORTHEADER_ID','=',$id)->first();
        return view('admin_risk.setupincidence_reportheader_edit',[
            'cidence_reportheaders'=>$cidence_reportheader
        ]);
    }
    public function setupincidence_reportheader_update(Request $request)
    {           
        $id = $request->SETUP_INCEDENCE_REPORTHEADER_ID;
        $update= Risk_setupincidence_reportheader::find($id);
        $update->SETUP_INCEDENCE_REPORTHEADER_NAME = $request->SETUP_INCEDENCE_REPORTHEADER_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_reportheader');
    }
    public function setupincidence_reportheader_destroy(Request $request,$id)
    {    
        Risk_setupincidence_reportheader::destroy($id);
        return redirect()->route('srisk.setupincidence_reportheader');
      
}
    //--------------------- //***การรายงานอุบัติการณ์**//-----------------------------------------//
    public function setupincidence_report()
    {    
        $cidence_report = Risk_setupincidence_report::get();
        return view('admin_risk.setupincidence_report',[
            'cidence_reports'=>$cidence_report
        ]);
    }
    public function setupincidence_report_add(Request $request)
    {    
        return view('admin_risk.setupincidence_report_add');
    }
    public function setupincidence_report_save(Request $request)
    {           
        $add= new Risk_setupincidence_report();
        $add->SETUP_INCEDENCE_REPORT_NAME = $request->SETUP_INCEDENCE_REPORT_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_report');
    }
    public function setupincidence_report_edit(Request $request,$id)
    {    
        $cidence_report = Risk_setupincidence_report::where('SETUP_INCEDENCE_REPORT_ID','=',$id)->first();
        return view('admin_risk.setupincidence_report_edit',[
            'cidence_reports'=>$cidence_report
        ]);
    }
    public function setupincidence_report_update(Request $request)
    {           
        $id = $request->SETUP_INCEDENCE_REPORT_ID;
        $update= Risk_setupincidence_report::find($id);
        $update->SETUP_INCEDENCE_REPORT_NAME = $request->SETUP_INCEDENCE_REPORT_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_report');
    }
    public function setupincidence_report_destroy(Request $request,$id)
    {    
        Risk_setupincidence_report::destroy($id);
        return redirect()->route('srisk.setupincidence_report');
      
}
    //---------------------------//***การแก้ไขอุบัติการณ์**//------------------------------------//
    public function setupincidence_modify()
    {    
        $cidence_modify = Risk_setupincidence_modify::get();
        return view('admin_risk.setupincidence_modify',[
            'cidence_modifys'=>$cidence_modify
        ]);
    }
    public function setupincidence_modify_add(Request $request)
    {    
        return view('admin_risk.setupincidence_modify_add');
    }
    public function setupincidence_modify_save(Request $request)
    {           
        $add= new Risk_setupincidence_modify();
        $add->SETUP_INCEDENCE_MODIFY_NAME = $request->SETUP_INCEDENCE_MODIFY_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_modify');
    }
    public function setupincidence_modify_edit(Request $request,$id)
    {    
        $cidence_modify = Risk_setupincidence_modify::where('SETUP_INCEDENCE_MODIFY_ID','=',$id)->first();
        return view('admin_risk.setupincidence_modify_edit',[
            'cidence_modifys'=>$cidence_modify
        ]);
    }
    public function setupincidence_modify_update(Request $request)
    {           
        $id = $request->SETUP_INCEDENCE_MODIFY_ID;
        $update= Risk_setupincidence_modify::find($id);
        $update->SETUP_INCEDENCE_MODIFY_NAME = $request->SETUP_INCEDENCE_MODIFY_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_modify');
    }
    public function setupincidence_modify_destroy(Request $request,$id)
    {    
        Risk_setupincidence_modify::destroy($id);
        return redirect()->route('srisk.setupincidence_modify');
      
}
    //---------------------------//***ระดับกลุ่ม/หน่วยงานหลักที่แก้ไข**//------------------------------------//
    public function setupincidence_modify_leveldepartsub()
    {    
        $cidence_modify_leveldepartsub = Risk_setupincidence_modify_leveldepartsub::get();
        return view('admin_risk.setupincidence_modify_leveldepartsub',[
            'cidence_modify_leveldepartsubs'=>$cidence_modify_leveldepartsub
        ]);
    }
    public function setupincidence_modify_leveldepartsub_add(Request $request)
    {    
        return view('admin_risk.setupincidence_modify_leveldepartsub_add');
    }
    public function setupincidence_modify_leveldepartsub_save(Request $request)
    {           
        $add= new Risk_setupincidence_modify_leveldepartsub();
        $add->SETUP_INCEDENCE_LEVELDEPARTSUB_NAME = $request->SETUP_INCEDENCE_LEVELDEPARTSUB_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_modify_leveldepartsub');
    }
    public function setupincidence_modify_leveldepartsub_edit(Request $request,$id)
    {    
        $cidence_modify_leveldepartsub = Risk_setupincidence_modify_leveldepartsub::where('SETUP_INCEDENCE_LEVELDEPARTSUB_ID','=',$id)->first();
        return view('admin_risk.setupincidence_modify_leveldepartsub_edit',[
            'cidence_modify_leveldepartsubs'=>$cidence_modify_leveldepartsub
        ]);
    }
    public function setupincidence_modify_leveldepartsub_update(Request $request)
    {           
        $id = $request->SETUP_INCEDENCE_LEVELDEPARTSUB_ID;
        $update= Risk_setupincidence_modify_leveldepartsub::find($id);
        $update->SETUP_INCEDENCE_LEVELDEPARTSUB_NAME = $request->SETUP_INCEDENCE_LEVELDEPARTSUB_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_modify_leveldepartsub');
    }
    public function setupincidence_modify_leveldepartsub_destroy(Request $request,$id)
    {    
        Risk_setupincidence_modify_leveldepartsub::destroy($id);
        return redirect()->route('srisk.setupincidence_modify_leveldepartsub');
      
}
    //--------------------------------------------------------------//

//---------------------------//***กลุ่ม/หน่วยงานหลักที่แก้ไข**//------------------------------------//
public function setupincidence_modify_departsub()
{    
    $cidence_modify_departsub = Risk_setupincidence_modify_departsub::get();
    return view('admin_risk.setupincidence_modify_departsub',[
        'cidence_modify_departsubs'=>$cidence_modify_departsub
    ]);
}
public function setupincidence_modify_departsub_add(Request $request)
{    
    return view('admin_risk.setupincidence_modify_departsub_add');
}
public function setupincidence_modify_departsub_save(Request $request)
{           
    $add= new Risk_setupincidence_modify_departsub();
    $add->SETUP_INCEDENCE_MODIFY_DEPARTSUB_NAME = $request->SETUP_INCEDENCE_MODIFY_DEPARTSUB_NAME;
    $add->save();
    return redirect()->route('srisk.setupincidence_modify_departsub');
}
public function setupincidence_modify_departsub_edit(Request $request,$id)
{    
    $cidence_modify_departsub = Risk_setupincidence_modify_departsub::where('SETUP_INCEDENCE_MODIFY_DEPARTSUB_ID','=',$id)->first();
    return view('admin_risk.setupincidence_modify_departsub_edit',[
        'cidence_modify_departsubs'=>$cidence_modify_departsub
    ]);
}
public function setupincidence_modify_departsub_update(Request $request)
{           
    $id = $request->SETUP_INCEDENCE_MODIFY_DEPARTSUB_ID;
    $update= Risk_setupincidence_modify_departsub::find($id);
    $update->SETUP_INCEDENCE_MODIFY_DEPARTSUB_NAME = $request->SETUP_INCEDENCE_MODIFY_DEPARTSUB_NAME;
    $update->save();
    return redirect()->route('srisk.setupincidence_modify_departsub');
}
public function setupincidence_modify_departsub_destroy(Request $request,$id)
{    
    Risk_setupincidence_modify_departsub::destroy($id);
    return redirect()->route('srisk.setupincidence_modify_departsub');
  
}
//--------------------------------------------------------------//





        public function setupincidence_category_depart()
    {    
        $catdepartment = Risk_category_department::leftjoin('hrd_department','risk_category_department.CATEGORY_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->get();

        return view('admin_risk.setupincidence_category_depart',[
            'catdepartments'=>$catdepartment
        ]);
    }
    public function setupincidence_category_depart_add(Request $request)
    {    
        $depart = DB::table('hrd_department')->get();
        return view('admin_risk.setupincidence_category_depart_add',[
            'departs'=>$depart
        ]);
    }
    public function setupincidence_category_depart_save(Request $request)
    {           
        $add= new Risk_category_department();
        $add->CATEGORY_DEPARTMENT_NAME = $request->CATEGORY_DEPARTMENT_NAME;
        $add->CATEGORY_DEPARTMENT_SUBNAME = $request->CATEGORY_DEPARTMENT_SUBNAME;
       
        $add->save();
        return redirect()->route('srisk.setupincidence_category_depart');
    }
    public function setupincidence_category_depart_edit(Request $request,$id)
    {    
        $catdepartment = Risk_category_department::where('CATEGORY_DEPARTMENT_ID','=',$id)->first();
        $depart = DB::table('hrd_department')->get();
        return view('admin_risk.setupincidence_category_depart_edit',[
            'catdepartments'=>$catdepartment,
            'departs'=>$depart
        ]);
    }
    public function setupincidence_category_depart_update(Request $request)
    {           
        $id = $request->CATEGORY_DEPARTMENT_ID;
        $update= Risk_category_department::find($id);
        $update->CATEGORY_DEPARTMENT_NAME = $request->CATEGORY_DEPARTMENT_NAME;
        $update->CATEGORY_DEPARTMENT_SUBNAME = $request->CATEGORY_DEPARTMENT_SUBNAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_category_depart');
    }
    public function setupincidence_category_depart_destroy(Request $request,$id)
    {    
        Risk_category_department::destroy($id);
        return redirect()->route('srisk.setupincidence_category_depart');
      
}
    //--------------------------------------------------------------//
            //     public function setupincidence_status()
            //     {    
            //         $incidence_typelocation = Risk_setupincidence_status::get();
            //         return view('admin_risk.setupincidence_status',[
            //             'incidence_typelocations'=>$incidence_typelocation
            //         ]);
            //     }
            //     public function setupincidence_status_add(Request $request)
            //     {    
            //         return view('admin_risk.setupincidence_typelocation_add');
            //     }
            //     public function setupincidence_status_save(Request $request)
            //     {           
            //         $add= new Risk_setupincidence_status();
            //         $add->SETUP_TYPELOCATION_NAME = $request->SETUP_TYPELOCATION_NAME;
            //         $add->save();
            //         return redirect()->route('srisk.setupincidence_status');
            //     }
            //     public function setupincidence_status_edit(Request $request,$id)
            //     {    
            //         $incidence_typelocation = Risk_setupincidence_status::where('SETUP_TYPELOCATION_ID','=',$id)->first();
            //         return view('admin_risk.setupincidence_typelocation_edit',[
            //             'incidence_typelocations'=>$incidence_typelocation
            //         ]);
            //     }
            //     public function setupincidence_status_update(Request $request)
            //     {           
            //         $id = $request->SETUP_TYPELOCATION_ID;
            //         $update= Risk_setupincidence_status::find($id);
            //         $update->SETUP_TYPELOCATION_NAME = $request->SETUP_TYPELOCATION_NAME;
            //         $update->save();
            //         return redirect()->route('srisk.setupincidence_status');
            //     }
            //     public function setupincidence_status_destroy(Request $request,$id)
            //     {    
            //         Risk_setupincidence_status::destroy($id);
            //         return redirect()->route('srisk.setupincidence_status');
      
// }
    //--------------------------------------------------------------//
    public function setupincidence_typelocation()
    {    
        $incidence_typelocation = Risk_setupincidence_typelocation::get();
        return view('admin_risk.setupincidence_typelocation',[
            'incidence_typelocations'=>$incidence_typelocation
        ]);
    }
    public function setupincidence_typelocation_add(Request $request)
    {    
        return view('admin_risk.setupincidence_typelocation_add');
    }
    public function setupincidence_typelocation_save(Request $request)
    {           
        $add= new Risk_setupincidence_typelocation();
        $add->SETUP_TYPELOCATION_NAME = $request->SETUP_TYPELOCATION_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_typelocation');
    }
    public function setupincidence_typelocation_edit(Request $request,$id)
    {    
        $incidence_typelocation = Risk_setupincidence_typelocation::where('SETUP_TYPELOCATION_ID','=',$id)->first();
        return view('admin_risk.setupincidence_typelocation_edit',[
            'incidence_typelocations'=>$incidence_typelocation
        ]);
    }
    public function setupincidence_typelocation_update(Request $request)
    {           
        $id = $request->SETUP_TYPELOCATION_ID;
        $update= Risk_setupincidence_typelocation::find($id);
        $update->SETUP_TYPELOCATION_NAME = $request->SETUP_TYPELOCATION_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_typelocation');
    }
    public function setupincidence_typelocation_destroy(Request $request,$id)
    {    
        Risk_setupincidence_typelocation::destroy($id);
        return redirect()->route('srisk.setupincidence_typelocation');
      
}
    //--------------------------------------------------------------//
    public function setupincidence_grouplocation()
    {    
        $incidence_grouplocation = Risk_setupincidence_grouplocation::get();
        return view('admin_risk.setupincidence_grouplocation',[
            'incidence_grouplocations'=>$incidence_grouplocation
        ]);
    }
    public function setupincidence_grouplocation_add(Request $request)
    {    
        return view('admin_risk.setupincidence_grouplocation_add');
    }
    public function setupincidence_grouplocation_save(Request $request)
    {           
        $add= new Risk_setupincidence_grouplocation();
        $add->SETUP_GROUPLOCATION_NAME = $request->SETUP_GROUPLOCATION_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_grouplocation');
    }
    public function setupincidence_grouplocation_edit(Request $request,$id)
    {    
        $incidence_grouplocation = Risk_setupincidence_grouplocation::where('SETUP_GROUPLOCATION_ID','=',$id)->first();
        return view('admin_risk.setupincidence_grouplocation_edit',[
            'incidence_grouplocations'=>$incidence_grouplocation
        ]);
    }
    public function setupincidence_grouplocation_update(Request $request)
    {           
        $id = $request->SETUP_GROUPLOCATION_ID;
        $update= Risk_setupincidence_grouplocation::find($id);
        $update->SETUP_GROUPLOCATION_NAME = $request->SETUP_GROUPLOCATION_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_grouplocation');
    }
    public function setupincidence_grouplocation_destroy(Request $request,$id)
    {    
        Risk_setupincidence_grouplocation::destroy($id);
        return redirect()->route('srisk.setupincidence_grouplocation');
      
}
    //--------------------------------------------------------------//
    
public function setupincidence_group()
    {    
        $incidencegroup = Setupincidence_group::get();
        return view('admin_risk.setupincidence_group',[
            'incidencegroups'=>$incidencegroup
        ]);
    }
    public function setupincidence_group_add(Request $request)
    {    
        return view('admin_risk.setupincidence_group_add');
    }
    public function setupincidence_group_save(Request $request)
    {           
        $add= new Setupincidence_group();
        $add->INCIDENCE_GROUP_NAME = $request->INCIDENCE_GROUP_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_group');
    }
    public function setupincidence_group_edit(Request $request,$id)
    {    
        $incidencegroup = Setupincidence_group::where('INCIDENCE_GROUP_ID','=',$id)->first();
        return view('admin_risk.setupincidence_group_edit',[
            'incidencegroups'=>$incidencegroup
        ]);
    }
    public function setupincidence_group_update(Request $request)
    {           
        $id = $request->INCIDENCE_GROUP_ID;
        $update= Setupincidence_group::find($id);
        $update->INCIDENCE_GROUP_NAME = $request->INCIDENCE_GROUP_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_group');
    }
    public function setupincidence_group_destroy(Request $request,$id)
    {    
        Setupincidence_group::destroy($id);
        return redirect()->route('srisk.setupincidence_group');
      
}
    //--------------------------------------------------------------//
public function setupincidence_category()
    {    
        $incidencecategory = Setupincidence_category::get();
        return view('admin_risk.setupincidence_category',[
            'incidencecategorys'=>$incidencecategory
        ]);
    }
    public function setupincidence_category_add(Request $request)
    {    
        return view('admin_risk.setupincidence_category_add');
    }
    public function setupincidence_category_save(Request $request)
    {           
        $add= new Setupincidence_category();
        $add->INCIDENCE_CATEGORY_NAME = $request->INCIDENCE_CATEGORY_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_category');
    }
    public function setupincidence_category_edit(Request $request,$id)
    {    
        $incidencecategory = Setupincidence_category::where('INCIDENCE_CATEGORY_ID','=',$id)->first();
        return view('admin_risk.setupincidence_category_edit',[
            'incidencecategorys'=>$incidencecategory
        ]);
    }
    public function setupincidence_category_update(Request $request)
    {           
        $id = $request->INCIDENCE_CATEGORY_ID;
        $update= Setupincidence_category::find($id);
        $update->INCIDENCE_CATEGORY_NAME = $request->INCIDENCE_CATEGORY_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_category');
    }
    public function setupincidence_category_destroy(Request $request,$id)
    {    
        Setupincidence_category::destroy($id);
        return redirect()->route('srisk.setupincidence_category');
      
}
    //--------------------------------------------------------------//
public function setupincidence_setting()
    {    
        $incidencesetting = Setupincidence_setting::get();
        return view('admin_risk.setupincidence_setting',[
            'incidencesettings'=>$incidencesetting
        ]);
    }
    public function setupincidence_setting_add(Request $request)
    {    
        return view('admin_risk.setupincidence_setting_add');
    }
    public function setupincidence_setting_save(Request $request)
    {           
        $add= new Setupincidence_setting();
        $add->INCIDENCE_SETTING_NAME = $request->INCIDENCE_SETTING_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_setting');
    }
    public function setupincidence_setting_edit(Request $request,$id)
    {    
        $incidencesetting = Setupincidence_setting::where('INCIDENCE_SETTING_ID','=',$id)->first();
        return view('admin_risk.setupincidence_setting_edit',[
            'incidencesettings'=>$incidencesetting
        ]);
    }
    public function setupincidence_setting_update(Request $request)
    {           
        $id = $request->INCIDENCE_SETTING_ID;
        $update= Setupincidence_setting::find($id);
        $update->INCIDENCE_SETTING_NAME = $request->INCIDENCE_SETTING_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_setting');
    }
    public function setupincidence_setting_destroy(Request $request,$id)
    {    
        Setupincidence_setting::destroy($id);
        return redirect()->route('srisk.setupincidence_setting');
      
}
    //--------------------------------------------------------------//
public function setupincidence_groupuser()
    {    
        $incidencegroupuser = Setupincidence_groupuser::get();
        return view('admin_risk.setupincidence_groupuser',[
            'incidencegroupusers'=>$incidencegroupuser
        ]);
    }
    public function setupincidence_groupuser_add(Request $request)
    {    
        return view('admin_risk.setupincidence_groupuser_add');
    }
    public function setupincidence_groupuser_save(Request $request)
    {           
        $add= new Setupincidence_groupuser();
        $add->INCIDENCE_GROUPUSER_NAME = $request->INCIDENCE_GROUPUSER_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_groupuser');
    }
    public function setupincidence_groupuser_edit(Request $request,$id)
    {    
        $incidencegroupuser = Setupincidence_groupuser::where('INCIDENCE_GROUPUSER_ID','=',$id)->first();
        return view('admin_risk.setupincidence_groupuser_edit',[
            'incidencegroupusers'=>$incidencegroupuser
        ]);
    }
    public function setupincidence_groupuser_update(Request $request)
    {           
        $id = $request->INCIDENCE_GROUPUSER_ID;
        $update= Setupincidence_groupuser::find($id);
        $update->INCIDENCE_GROUPUSER_NAME = $request->INCIDENCE_GROUPUSER_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_groupuser');
    }
    public function setupincidence_groupuser_destroy(Request $request,$id)
    {    
        Setupincidence_groupuser::destroy($id);
        return redirect()->route('srisk.setupincidence_groupuser');
      
}
    //--------------------------------------------------------------//
public function setupincidence_level()
    {    
        $incidencelevel = Setupincidence_level::get();

        return view('admin_risk.setupincidence_level',[
            'incidencelevels'=>$incidencelevel
        ]);
    }
    public function setupincidence_level_add(Request $request)
    {    
        return view('admin_risk.setupincidence_level_add');
    }
    public function setupincidence_level_save(Request $request)
    {           
        $add= new Setupincidence_level();
        $add->INCIDENCE_LEVEL_CODE = $request->INCIDENCE_LEVEL_CODE;
        $add->INCIDENCE_LEVEL_NAME = $request->INCIDENCE_LEVEL_NAME;
        $add->INCIDENCE_LEVEL_NAME_DETAIL = $request->INCIDENCE_LEVEL_NAME_DETAIL;
        $add->save();
        return redirect()->route('srisk.setupincidence_level');
    }
    public function setupincidence_level_edit(Request $request,$id)
    {    
        $incidencelevel = Setupincidence_level::where('INCIDENCE_LEVEL_ID','=',$id)->first();
        return view('admin_risk.setupincidence_level_edit',[
            'incidencelevels'=>$incidencelevel
        ]);
    }
    public function setupincidence_level_update(Request $request)
    {           
        $id = $request->INCIDENCE_LEVEL_ID;
        $update= Setupincidence_level::find($id);
        $update->INCIDENCE_LEVEL_CODE = $request->INCIDENCE_LEVEL_CODE;
        $update->INCIDENCE_LEVEL_NAME = $request->INCIDENCE_LEVEL_NAME;
        $update->INCIDENCE_LEVEL_NAME_DETAIL = $request->INCIDENCE_LEVEL_NAME_DETAIL;
        $update->save();
        return redirect()->route('srisk.setupincidence_level');
    }
    public function setupincidence_level_destroy(Request $request,$id)
    {    
        Setupincidence_level::destroy($id);
        return redirect()->route('srisk.setupincidence_level');      
}
    //--------------------------------------------------------------//
public function setupincidence_location()
    {    
        $incidencelocation = Setupincidence_location::get();
        return view('admin_risk.setupincidence_location',[
            'incidencelocations'=>$incidencelocation
        ]);
    }
    public function setupincidence_location_add(Request $request)
    {    
        return view('admin_risk.setupincidence_location_add');
    }
    public function setupincidence_location_save(Request $request)
    {           
        $add= new Setupincidence_location();
        $add->INCIDENCE_LOCATION_NAME = $request->INCIDENCE_LOCATION_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_location');
    }
    public function setupincidence_location_edit(Request $request,$id)
    {    
        $incidencelocation = Setupincidence_location::where('INCIDENCE_LOCATION_ID','=',$id)->first();
        return view('admin_risk.setupincidence_location_edit',[
            'incidencelocations'=>$incidencelocation
        ]);
    }
    public function setupincidence_location_update(Request $request)
    {           
        $id = $request->INCIDENCE_LOCATION_ID;
        $update= Setupincidence_location::find($id);
        $update->INCIDENCE_LOCATION_NAME = $request->INCIDENCE_LOCATION_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_location');
    }
    public function setupincidence_location_destroy(Request $request,$id)
    {    
        Setupincidence_location::destroy($id);
        return redirect()->route('srisk.setupincidence_location');      
}
    //--------------------------------------------------------------//
public function setupincidence_origin()
    {    
        $incidenceorigin = Setupincidence_origin::get();
        return view('admin_risk.setupincidence_origin',[
            'incidenceorigins'=>$incidenceorigin
        ]);
    }
    public function setupincidence_origin_add(Request $request)
    {    
        return view('admin_risk.setupincidence_origin_add');
    }
    public function setupincidence_origin_save(Request $request)
    {           
        $add= new Setupincidence_origin();
        $add->INCIDENCE_ORIGIN_NAME = $request->INCIDENCE_ORIGIN_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_origin');
    }
    public function setupincidence_origin_edit(Request $request,$id)
    {    
        $incidenceorigin = Setupincidence_origin::where('INCIDENCE_ORIGIN_ID','=',$id)->first();
        return view('admin_risk.setupincidence_origin_edit',[
            'incidenceorigins'=>$incidenceorigin
        ]);
    }
    public function setupincidence_origin_update(Request $request)
    {           
        $id = $request->INCIDENCE_ORIGIN_ID;
        $update= Setupincidence_origin::find($id);
        $update->INCIDENCE_ORIGIN_NAME = $request->INCIDENCE_ORIGIN_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_origin');
    }
    public function setupincidence_origin_destroy(Request $request,$id)
    {    
        Setupincidence_origin::destroy($id);
        return redirect()->route('srisk.setupincidence_origin');      
}
    //--------------------------------------------------------------//
public function setupincidence_listdataset()
    {    
        $incidencelistdataset = Setupincidence_listdataset::get();
        return view('admin_risk.setupincidence_listdataset',[
            'incidencelistdatasets'=>$incidencelistdataset
        ]);
    }
    public function setupincidence_listdataset_add(Request $request)
    {    
        return view('admin_risk.setupincidence_listdataset_add');
    }
    public function setupincidence_listdataset_save(Request $request)
    {           
        $add= new Setupincidence_listdataset();
        $add->INCIDENCE_LISTDATASET_NAME = $request->INCIDENCE_LISTDATASET_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_listdataset');
    }
    public function setupincidence_listdataset_edit(Request $request,$id)
    {    
        $incidencelistdataset = Setupincidence_listdataset::where('INCIDENCE_LISTDATASET_ID','=',$id)->first();
        return view('admin_risk.setupincidence_listdataset_edit',[
            'incidencelistdatasets'=>$incidencelistdataset
        ]);
    }
    public function setupincidence_listdataset_update(Request $request)
    {           
        $id = $request->INCIDENCE_LISTDATASET_ID;
        $update= Setupincidence_listdataset::find($id);
        $update->INCIDENCE_LISTDATASET_NAME = $request->INCIDENCE_LISTDATASET_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_listdataset');
    }
    public function setupincidence_listdataset_destroy(Request $request,$id)
    {    
        Setupincidence_listdataset::destroy($id);
        return redirect()->route('srisk.setupincidence_listdataset');      
}
    //--------------------------------------------------------------//
public function setupincidence_sub()
    {    
        $incidencesub = Setupincidence_sub::get();
        return view('admin_risk.setupincidence_sub',[
            'incidencesubs'=>$incidencesub
        ]);
    }
    public function setupincidence_sub_add(Request $request)
    {    
        return view('admin_risk.setupincidence_sub_add');
    }
    public function setupincidence_sub_save(Request $request)
    {           
        $add= new Setupincidence_sub();
        $add->INCIDENCE_SUB_NAME = $request->INCIDENCE_SUB_NAME;
        $add->save();
        return redirect()->route('srisk.setupincidence_sub');
    }
    public function setupincidence_sub_edit(Request $request,$id)
    {    
        $incidencesub = Setupincidence_sub::where('INCIDENCE_SUB_ID','=',$id)->first();
        return view('admin_risk.setupincidence_sub_edit',[
            'incidencesubs'=>$incidencesub
        ]);
    }
    public function setupincidence_sub_update(Request $request)
    {           
        $id = $request->INCIDENCE_SUB_ID;
        $update= Setupincidence_sub::find($id);
        $update->INCIDENCE_SUB_NAME = $request->INCIDENCE_SUB_NAME;
        $update->save();
        return redirect()->route('srisk.setupincidence_sub');
    }
    public function setupincidence_sub_destroy(Request $request,$id)
    {    
        Setupincidence_sub::destroy($id);
        return redirect()->route('srisk.setupincidence_sub');      
}   
   //--------------------------------------------------------------//
   
   

}

