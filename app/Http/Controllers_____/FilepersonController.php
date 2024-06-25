<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Hrdfileperson;
use Illuminate\Support\Facades\Auth;

class FilepersonController extends Controller
{
    public function infouserfile($iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        $infouserfile = Hrdfileperson::where('PERSON_ID','=',$iduser)
        ->orderBy('hrd_tr_file.ID', 'desc')  
        ->get();

        $inforpersonusereducat =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        return view('person.personinfouserfile',[
            'inforpersonusereducat' => $inforpersonusereducat,
            'inforpersonuserid' => $inforpersonuserid,
            'infouserfile' => $infouserfile,
        ]);
    }

    public function infouserfile_save(Request $request)
    {
            $iduser = $request->PERSON_ID;

            $addfile = new Hrdfileperson(); 
            $addfile->PERSON_ID = $request->PERSON_ID;
            $addfile->FILE_NAME = $request->FILE_NAME;
            $addfile->DATE_SAVE = date('Y-m-d');

            if($request->hasFile('FILE_PERSON')){
                $maxid = Hrdfileperson::max('ID');
                $idfile = $maxid+1;
                $newFileName = 'fileperson_'.$idfile.'.'.$request->FILE_PERSON->extension();
                $request->FILE_PERSON->storeAs('filepreson',$newFileName,'public');
                $addfile->FILE_PERSON = $newFileName;
            }

            $addfile->save();

            return redirect()->route('person.inforfile',[
                'iduser' => $iduser,
            ])->with('success', "บันทึกข้อมูลเรียบร้อย");
    }

    public function infouserfile_update(Request $request)
    {
            $iduser = $request->PERSON_ID_EDIT;
            $id = $request->ID; 

            $updatefile = Hrdfileperson::find($id);
            $updatefile->PERSON_ID = $request->PERSON_ID_EDIT;
            $updatefile->FILE_NAME = $request->FILE_NAME_EDIT;

            if($request->hasFile('FILE_PERSON_EDIT')){
                $newFileName = 'fileperson_'.$id.'.'.$request->FILE_PERSON_EDIT->extension();
                $request->FILE_PERSON_EDIT->storeAs('filepreson',$newFileName,'public');
                $updatefile->FILE_PERSON = $newFileName;
            }

            $updatefile->save();

            return redirect()->route('person.inforfile',[
                'iduser' => $iduser,
            ])->with('success', "แก้ไขข้อมูลเรียบร้อย");

    }

    public function infouserfile_destroy($id,$iduser) { 

        Hrdfileperson::destroy($id);    

        return redirect()->route('person.inforfile',['iduser'=>  $iduser])->with('success', "ลบข้อมูลเรียบร้อย"); 
    }
}
