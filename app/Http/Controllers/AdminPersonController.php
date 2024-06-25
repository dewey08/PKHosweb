<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Person;
use App\Models\Adduser;
use App\Imports\Hrdperson;
use App\Imports\Suppliesimport;
use App\Imports\Gleaveoverimport;
use App\Imports\Assetimport;
use App\Models\User;
use App\Models\Info_module;
use App\Models\PersonImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AdminPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $person = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
                        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
                        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
                        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
                        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                        ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
                        ->orderBy('hrd_person.ID', 'desc')
                        ->get();

        $count = Person::count();

        return view('person.index',[
            'persons' => $person, 
            'count' => $count 
        ]);
    }

    public function changstatususer($id){

        $person = Person::where(['ID' => $id])->first();
        $user = User::where(['PERSON_ID' => $id])->first();
        return  view('person.changstatususer',[
            'person' => $person, 
            'user' => $user
        ]);
    }

    public function changpass($id){

        $person = Person::where(['ID' => $id])->first();
        $user = User::where(['PERSON_ID' => $id])->first();
        return  view('person.changpass',[
            'person' => $person, 
            'user' => $user
        ]);
    }

    

    public function hrdperson_excel(Request $request)
    {      
        $file = $request->HRD_PERSON_EXCEL;
        try {
            Excel::import(new Hrdperson,$file);
  
        } catch (\Throwable $th) {
            //throw $th;
        }

        foreach (PersonImport::all() as $person) {
            $user = new User();
            $user->PERSON_ID = $person->ID;
            $user->username = $person->USERNAME;
            $user->email = $person->HR_EMAIL;
            $user->name = $person->HR_FNAME.' '.$person->HR_LNAME;
            $user->password = Hash::make('123456');
            $user->status = 'USER';
            $user->save();
        }

        return redirect('/person/all');
   
    }
    public function hrdperson_excel_save(Request $request)
      {
        $person_id = $request->id;
        $fname = $request->hr_fname;
        $lname = $request->hr_lname;
        $email = $request->hr_email;
        $username = $request->hr_username;
        $status = 'USER';
        $password = '$2y$10$F6X89Zc07fVsjyY1dZkaB.BzB49YXRCIykw0u8b9Lt/uvQc94OYbm';
       
        $number =count($person_id);
        $count = 0;
        for($count = 0; $count< $number; $count++)
        {        
            $add= new User();
            $add->PERSON_ID = $person_id[$count];
            $add->name = $fname[$count];
            $add->password = $password;
            $add->email = $email[$count];           
            $add->status = $status;   
            $add->username = $username[$count];           
            $add->save();
         }
         return redirect('/person/all');
     }


    public function excelperson()
    {
        $person = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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
            ->orderBy('hrd_person.ID', 'desc')
        ->get();
        //dd($person);

        $count = Person::count();

        return view('person.excelinfoperson',[
            'persons' => $person, 
            'count' => $count 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function module()
    { 
        return view('person.module');
    }
    public function module_save(Request $request)
    {
        $add = new Info_module(); 
        if($request->hasFile('picture')){
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $add->IMGMO = $contents;  
        }
        $add->NAMEMO = $request->name;
        $add->save();        
         return redirect()->route('mo.module'); 
     }

    public function create()
    {  
        $infoprefix =  DB::table('hrd_prefix')->get();
        $infomarry =  DB::table('hrd_marry_status')->get();
        $inforeligion =  DB::table('hrd_religion')->get();
        $infonation =  DB::table('hrd_nationality')->get();
        $infocitizen =  DB::table('hrd_citizenship')->get();
        $infosex =  DB::table('hrd_sex')->get();
        $infoblood =  DB::table('hrd_bloodgroup')->get();
        $infoprovince =  DB::table('hrd_province')->get();
        $infodepartment =  DB::table('hrd_department')->get();
        $infodepartment_sub =  DB::table('hrd_department_sub')->get();
        $infodepartment_sub_sub =  DB::table('hrd_department_sub_sub')->get();
        $infolevel =  DB::table('hrd_level')->get();
        $infostatus =  DB::table('hrd_status')->get();
        $infokind =  DB::table('hrd_kind')->get();
        $infokind_type =  DB::table('hrd_kind_type')->get();    
        $infoperson_type =  DB::table('hrd_person_type')->get();
        $infoposition =  DB::table('hrd_position')->get();
        $hrd_amphurs =  DB::table('hrd_amphur')->get();
        $hrd_tumbons =  DB::table('hrd_tumbon')->get();
        

        return view('person.admin_adduser',[
            'infoprefixs' => $infoprefix,
            'infomarrys' => $infomarry,
            'inforeligions' => $inforeligion,
            'infonations' => $infonation,
            'infocitizens' => $infocitizen,
            'infosexs' => $infosex,
            'infobloods' => $infoblood,
            'infoprovinces' => $infoprovince,
            'hrd_amphurs' => $hrd_amphurs,
            'hrd_tumbons' => $hrd_tumbons,
            'infodepartments' => $infodepartment,
            'infodepartment_subs' => $infodepartment_sub,
            'infodepartment_sub_subs' => $infodepartment_sub_sub,  
            'infolevels' => $infolevel,
            'infostatuss' => $infostatus,
            'infokinds' => $infokind,
            'infokind_types' => $infokind_type,
            'infoperson_types' => $infoperson_type,
            'infopositions' => $infoposition
           
        ]);
       
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $person = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
        ->where('HR_CID','like','%'.$search.'%')
        ->orwhere('HR_PREFIX_NAME','like','%'.$search.'%')
        ->orwhere('HR_FNAME','like','%'.$search.'%')
        ->orwhere('HR_LNAME','like','%'.$search.'%')
        ->orwhere('NICKNAME','like','%'.$search.'%')
        ->orwhere('SEX_NAME','like','%'.$search.'%')
        ->orwhere('HR_STATUS_NAME','like','%'.$search.'%')
        ->orwhere('POSITION_IN_WORK','like','%'.$search.'%')
        ->orwhere('HR_LEVEL_NAME','like','%'.$search.'%')
        ->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%')
        ->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%')
        ->orwhere('HR_DEPARTMENT_NAME','like','%'.$search.'%')
        ->orderBy('hrd_person.ID', 'desc')    
        ->get();
        //dd($person);

        $count = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
        ->where('HR_CID','like','%'.$search.'%')
        ->orwhere('HR_PREFIX_NAME','like','%'.$search.'%')
        ->orwhere('HR_FNAME','like','%'.$search.'%')
        ->orwhere('HR_LNAME','like','%'.$search.'%')
        ->orwhere('NICKNAME','like','%'.$search.'%')
        ->orwhere('SEX_NAME','like','%'.$search.'%')
        ->orwhere('HR_STATUS_NAME','like','%'.$search.'%')
        ->orwhere('POSITION_IN_WORK','like','%'.$search.'%')
        ->orwhere('HR_LEVEL_NAME','like','%'.$search.'%')
        ->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%')
        ->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%')
        ->orwhere('HR_DEPARTMENT_NAME','like','%'.$search.'%')    
        ->count();

        return view('person.index',[
        'persons' => $person, 
        'count' => $count,
        'search' => $search
        ]);
            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'HR_USERNAME' => 'required',
            'HR_PREFIX' => 'required',
            'HR_FNAME' => 'required',
            'HR_LNAME' => 'required',
            'HR_BIRTHDAY' => 'required',
            'HR_CID' => 'required',
            'HR_EMAIL' => 'required',
            'HR_DEPARTMENT' => 'required',
            'DEPARTMENT_SUB' => 'required',
            'POSITION_IN_WORK' => 'required',
            'HR_DEPARTMENT_SUB_SUB' => 'required',
            'STARTWORK' => 'required',
            'HR_SALARY' => 'required',
            'HR_STATUS' => 'required',
            'HR_HOME_NUMBER' => 'required',
            'HR_VILLAGE_NO' => 'required',
            'PROVINCE_NAME' => 'required',
            'AMPHUR_NAME' => 'required',
            'TUMBON_NAME' => 'required',
            'HR_ZIPCODE' => 'required',
            'HR_PERSON_TYPE' => 'required',
            'HR_RELIGION' => 'required',
            'HR_NATIONALITY' => 'required',
            'HR_CITIZENSHIP' => 'required',
            'HR_HOME_NUMBER_1' => 'required',
            'PROVINCE_NAME_1' => 'required',
            'HR_VILLAGE_NO_1' => 'required',
            'AMPHUR_NAME_1' => 'required', 
            'TUMBON_NAME_1' => 'required',
            'HR_ZIPCODE_1' => 'required',
        
        ]);

       
        $checkbirt  = $request->HR_BIRTHDAY;
        $checkstart = $request->STARTWORK;
        $checkvcode =$request->VCODE_DATE;
        $displaybirthdate = CheckDatethaiParse($checkbirt)?CheckDatethaiParse($checkbirt):'1997-01-01';
        $displaystartdate = CheckDatethaiParse($checkstart)?CheckDatethaiParse($checkstart):'1997-01-01';
        $displayvcodedate = CheckDatethaiParse($checkvcode)?CheckDatethaiParse($checkvcode):'1997-01-01';
      

        $username = $request->HR_USERNAME;

        $addperson = new Person(); 
        $addperson->HR_PREFIX_ID = $request->HR_PREFIX;
        $addperson->HR_FNAME = $request->HR_FNAME;
        $addperson->HR_LNAME = $request->HR_LNAME; 
        $addperson->HR_EN_NAME = $request->HR_EN_NAME;
        $addperson->NICKNAME = $request->NICKNAME;
        $addperson->HR_BIRTHDAY = $displaybirthdate;  
        $addperson->HR_CID = $request->HR_CID;
        $addperson->HR_MARRY_STATUS_ID = $request->HR_MARRY_STATUS;
        $addperson->HR_RELIGION_ID = $request->HR_RELIGION;   
        $addperson->HR_NATIONALITY_ID = $request->HR_NATIONALITY;    
        $addperson->HR_CITIZENSHIP_ID = $request->HR_CITIZENSHIP; 
        $addperson->SEX = $request->SEX; 
        $addperson->HR_BLOODGROUP_ID = $request->HR_BLOODGROUP; 
        $addperson->HR_HIGH = $request->HR_HIGH;
        $addperson->HR_WEIGHT = $request->HR_WEIGHT;
        $addperson->HR_PHONE = $request->HR_PHONE;
        $addperson->HR_EMAIL = $request->HR_EMAIL;
        $addperson->HR_FACEBOOK = $request->HR_FACEBOOK;
        $addperson->HR_LINE = $request->HR_LINE;

        $addperson->HR_DEPARTMENT_ID = $request->HR_DEPARTMENT;
        $addperson->HR_DEPARTMENT_SUB_ID = $request->DEPARTMENT_SUB;
        $addperson->HR_DEPARTMENT_SUB_SUB_ID = $request->HR_DEPARTMENT_SUB_SUB;

        $addperson->HR_STARTWORK_DATE = $displaystartdate;

        $addperson->HR_POSITION_NUM = $request->HR_POSITION_NUM;
        $addperson->VCODE = $request->VCODE;

        $addperson->VCODE_DATE =  $displayvcodedate;

        $position =  DB::table('hrd_position')
                    ->where('HR_POSITION_ID','=',$request->POSITION_IN_WORK)
                    ->first();
        $addperson->POSITION_IN_WORK = $position->HR_POSITION_NAME;

        $addperson->HR_POSITION_ID = $request->POSITION_IN_WORK;
        $addperson->HR_LEVEL_ID = $request->HR_LEVEL;
        $addperson->HR_STATUS_ID = $request->HR_STATUS;
        $addperson->HR_KIND_ID = $request->HR_KIND;
        $addperson->HR_KIND_TYPE_ID = $request->HR_KIND_TYPE;
        $addperson->HR_PERSON_TYPE_ID = $request->HR_PERSON_TYPE;
        $addperson->HR_AGENCY_ID = $request->HR_AGENCY_ID;
        $addperson->HR_SALARY = $request->HR_SALARY;
        $addperson->MONEY_POSITION = $request->MONEY_POSITION;

        $addperson->HR_HOME_NUMBER = $request->HR_HOME_NUMBER;
        $addperson->HR_VILLAGE_NO = $request->HR_VILLAGE_NO;
        $addperson->HR_ROAD_NAME = $request->HR_ROAD_NAME;
        $addperson->HR_SOI_NAME = $request->HR_SOI_NAME;
        $addperson->HR_HOME_NUMBER = $request->HR_HOME_NUMBER;
        $addperson->PROVINCE_ID = $request->PROVINCE_NAME;
        $addperson->AMPHUR_ID = $request->AMPHUR_NAME;
        $addperson->TUMBON_ID = $request->TUMBON_NAME; 
        $addperson->HR_ZIPCODE = $request->HR_ZIPCODE;

        $addperson->HR_HOME_NUMBER_1 = $request->HR_HOME_NUMBER_1;
        $addperson->HR_VILLAGE_NO_1 = $request->HR_VILLAGE_NO_1;
        $addperson->HR_ROAD_NAME_1 = $request->HR_ROAD_NAME_1;
        $addperson->HR_SOI_NAME_1 = $request->HR_SOI_NAME_1;
        $addperson->PROVINCE_ID_1 = $request->PROVINCE_NAME_1;
        $addperson->AMPHUR_ID_1 = $request->AMPHUR_NAME_1;
        $addperson->TUMBON_ID_1 = $request->TUMBON_NAME_1; 
        $addperson->HR_ZIPCODE_1 = $request->HR_ZIPCODE_1;

        $addperson->BOOK_BANK_NUMBER = $request->BOOK_BANK_NUMBER;
        $addperson->BOOK_BANK_NAME = $request->BOOK_BANK_NAME;
        $addperson->BOOK_BANK = $request->BOOK_BANK;
        $addperson->BOOK_BANK_BRANCH = $request->BOOK_BANK_BRANCH;

        $addperson->BOOK_BANK_OT_NUMBER = $request->BOOK_BANK_OT_NUMBER;
        $addperson->BOOK_BANK_OT_NAME = $request->BOOK_BANK_OT_NAME;
        $addperson->BOOK_BANK_OT = $request->BOOK_BANK_OT;
        $addperson->BOOK_BANK_OT_BRANCH = $request->BOOK_BANK_OT_BRANCH;
          

        if($request->hasFile('picture')){
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addperson->HR_IMAGE = $contents;   
        }
       
       $addperson->save();

       $idperson = Person::max('ID'); 

       $password="123456";
       $adduser= new Adduser(); 
       $adduser->name = $request->HR_FNAME.' '.$request->HR_LNAME; 
       $adduser->email = $request->HR_EMAIL;
       $adduser->password = Hash::make($password);
       $adduser->remember_token = $request->_token;
       $adduser->status = 'USER';
       $adduser->PERSON_ID = $idperson;
       $adduser->username =$username;
       $adduser->save();


        return redirect()->route('person.all'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatepass(Request $request)
    {
        $id = $request->ID;
        $password = $request->NEWPASSWORD;
        
            try {
                $updatepass= Adduser::where('PERSON_ID', '=',  $id)->first();
                $updatepass->password = Hash::make($password);
                $updatepass->save();
            } catch (\Throwable $th) {
                //throw $th;
            }
                    

        return redirect()->route('person.all'); 
    }

    public function updatestatususer(Request $request)
    {
        $id = $request->ID;
        

        $updatepass= Adduser::where('PERSON_ID', '=',  $id)->first();
        $updatepass->status = $request->status;
        $updatepass->save();
       
 
        return redirect()->route('person.all'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Person::destroy($id);   
        User::where('PERSON_ID', '=', $id)->delete();

        return redirect()->route('person.all'); 
    }
    


    public function changpassword()
    {
        return view('admin.setuppassword_admin');
    }

    public function updatechangpassword(Request $request)
    {
        $id = $request->ID;
        $changpassword = $request->NEWPASSWORD;
        //dd(Hash::make($password));

        $updatechangpass= Adduser::where('id', '=',  $id)->first();
        $updatechangpass->password = Hash::make($changpassword);
        $updatechangpass->save();

       
 
        return view('dashboard_admin');
    }

    public function adduserintensive(Request $request)
    {

        $addperson = new Person(); 
        $addperson->HR_FNAME = $request->HR_FNAME;
        $addperson->HR_LNAME = $request->HR_LNAME; 
        $addperson->HR_EMAIL = $request->HR_EMAIL;
        $addperson->save();

       $idperson = Person::max('ID'); 

       $password="123456";
       $adduser= new Adduser(); 
       $adduser->name = $request->HR_FNAME.' '.$request->HR_LNAME; 
       $adduser->email = $request->HR_EMAIL;
       $adduser->password = Hash::make($password);
       $adduser->remember_token = $request->_token;
       $adduser->status = 'USER';
       $adduser->PERSON_ID = $idperson;
       $adduser->save();
      

        return redirect()->action('AdminPersonController@index'); 
    }


    public static function checkinfoperson($id_user)
    {
        $personinfomation = Person::where('ID','=',$id_user)->first();

     if( $personinfomation->HR_DEPARTMENT_ID == '' ||  $personinfomation->HR_DEPARTMENT_SUB_ID == '' ||  $personinfomation->HR_DEPARTMENT_SUB_SUB_ID == ''){
        $checkinfoperson =  0;
     }else{
        $checkinfoperson =  1;
     }
        
    
     return $checkinfoperson;
    }

}
