@extends('layouts.backend')

<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
<link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet" />
<style>
        .center {
                margin: auto;
                width: 100%;
                padding: 10px;
        }
</style>


@section('content')
<script>
        function checklogin() {
                window.location.href = '{{route("index")}}';
        }
</script>
<?php

if(Auth::check()){
    $status = Auth::user()->status;
    $id_user = Auth::user()->PERSON_ID;   
}else{
    
    echo "<body onload=\"checklogin()\"></body>";
    exit();
} 

$url = Request::url();
$pos = strrpos($url, '/') + 1;
$user_id = substr($url, $pos); 

?>
<style>
        body {
                font-family: 'Kanit', sans-serif;
                font-size: 14px;

        }

        .form-control {
                font-family: 'Kanit', sans-serif;
                font-size: 14px;
        }
</style>

<div class="bg-body-light">
        <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                        <h1
                                style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.3rem;font-weight:normal;">
                                {{ $inforpersons -> HR_PREFIX_NAME }} {{ $inforpersons -> HR_FNAME }}
                                {{ $inforpersons -> HR_LNAME }}</h1>
                        <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                                <ol class="breadcrumb">

                                </ol>
                        </nav>
                </div>
        </div>
</div>




<form method="post" action="{{ url('editpersoninfouser/'.$infoid->ID)}}" enctype="multipart/form-data"
        class="needs-validation" novalidate>

        @csrf
        <div class="content">
                <div class="block block-rounded block-bordered">

                        <div class="block-header block-header-default ">
                                <h3 class="block-title" style="font-family: 'Kanit', sans-serif;">
                                        <B>แก้ไขรายละเอียดข้อมูลบุคคล</B></h3>
                        </div>

                        <div class="block-content">
                                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"><span
                                                style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลส่วนตัว&nbsp;&nbsp;</span>
                                </h2>

                                <div class="row push">
                                        <div class="col-lg-4">
                                                <div class="form-group">
                                                        <label>รูปประจำตัว</label>



                                                        @if ( $inforpersons->HR_IMAGE == Null )
                                                        <img id="image_upload_preview" src="{{asset('image/pers.png')}}"
                                                                height="60%" width="60%">
                                                        @else
                                                        <img id="image_upload_preview"
                                                                src="data:image/png;base64,{{ chunk_split(base64_encode($inforpersons->HR_IMAGE)) }}"
                                                                height="230px" width="200px">
                                                        @endif

                                                </div>
                                                <div class="form-group">
                                                        <input style="font-family: 'Kanit', sans-serif;" type="file"
                                                                name="picture" id="picture" class="form-control">
                                                </div>



                                        </div>

                                        <div class="col-lg-4">

                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>Username</label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <input class="form-control input-lg"
                                                                                value="{{ Auth::user()->username}}"
                                                                                readonly>

                                                                </div>
                                                        </div>
                                                </div>


                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>คำนำหน้า</label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <select name="HR_PREFIX"
                                                                                class="form-control input-lg">
                                                                                @foreach ($infoprefixs as $infoprefix)
                                                                                {{ $infoprefix -> HR_PREFIX_ID }}
                                                                                {{ $infoprefix -> HR_PREFIX_NAME }}

                                                                                @if($inforpersons -> HR_PREFIX_ID ==
                                                                                $infoprefix -> HR_PREFIX_ID )
                                                                                <option value=" {{ $infoprefix -> HR_PREFIX_ID }}"
                                                                                        selected>
                                                                                        {{ $infoprefix -> HR_PREFIX_NAME }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value=" {{ $infoprefix -> HR_PREFIX_ID }}">
                                                                                        {{ $infoprefix -> HR_PREFIX_NAME }}
                                                                                </option>
                                                                                @endif

                                                                                @endforeach
                                                                        </select>
                                                                </div>
                                                        </div>

                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>ชื่อ</label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <input name="HR_FNAME" id="HR_FNAME"
                                                                                class="form-control input-lg"
                                                                                value="{{ $inforpersons -> HR_FNAME }}"
                                                                                onkeyup="checkname()">
                                                                        <div style="color: red;" id="fname"></div>
                                                                        <div id="name"></div>
                                                                </div>
                                                        </div>
                                                </div>

                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>นามสกุล</label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <input name="HR_LNAME" id="HR_LNAME"
                                                                                class="form-control input-lg"
                                                                                value="{{ $inforpersons -> HR_LNAME }}"
                                                                                onkeyup="checklastname()">
                                                                        <div style="color: red;" id="lname"></div>
                                                                        <div id="lastname"></div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>ชื่ออังกฤษ</label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <input name="HR_EN_NAME" id="HR_EN_NAME"
                                                                                class="form-control input-lg"
                                                                                value="{{ $inforpersons -> HR_EN_NAME }}">
                                                                        
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>ชื่อเล่น </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <input name="NICKNAME" id="NICKNAME"
                                                                                class="form-control input-lg"
                                                                                value="{{ $inforpersons -> NICKNAME }}" onkeyup="checknickname()">
                                                                        <div style="color: red;" id="nick_name"></div>
                                                                        <div id="nickname"></div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>วันเกิด </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <input name="HR_BIRTHDAY" id="HR_BIRTHDAY"
                                                                                class="form-control input-lg datepicker"
                                                                                data-date-format="mm/dd/yyyy"
                                                                                value="{{ formate($inforpersons -> HR_BIRTHDAY) }}"
                                                                                onchange="checkbirthdate()" readonly>
                                                                        <div style="color: red;" id="birth_date"></div>
                                                                        <div id="birthdate"></div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-5">
                                                                        <label>เลขประจำตัวประชาชน </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                        <input name="HR_CID" id="HR_CID" onkeyup="checkhrid()"
                                                                                class="form-control input-lg"
                                                                                value="{{ $inforpersons->HR_CID }}"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                OnKeyPress="return chkNumber(this)"
                                                                                maxlength="13" oncontextmenu="checkhrid()">
                                                                        <div style="color: red;" id="cid"></div>
                                                                        <div id="hrcid"></div>
                                                                </div>
                                                        </div>
                                                </div>

                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-5">
                                                                        <label>สถานะสมรส </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                        <select name="HR_MARRY_STATUS"
                                                                                class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                onchange="checkmarry()">
                                                                                @foreach ($infomarrys as $infomarry)
                                                                                {{ $infomarry -> HR_MARRY_STATUS_ID }}
                                                                                {{ $infomarry -> HR_MARRY_STATUS_NAME }}

                                                                                @if($inforpersons -> HR_MARRY_STATUS_ID
                                                                                == $infomarry -> HR_MARRY_STATUS_ID )
                                                                                <option value=" {{ $infomarry -> HR_MARRY_STATUS_ID }}"
                                                                                        selected>
                                                                                        {{ $infomarry -> HR_MARRY_STATUS_NAME }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value=" {{ $infomarry -> HR_MARRY_STATUS_ID }}">
                                                                                        {{ $infomarry -> HR_MARRY_STATUS_NAME }}
                                                                                </option>
                                                                                @endif

                                                                                @endforeach
                                                                        </select>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-5">
                                                                        <label>ศาสนา </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                        <select name="HR_RELIGION"
                                                                                class="form-control input-lg">
                                                                                @foreach ($inforeligions as
                                                                                $inforeligion)
                                                                                {{ $inforeligion -> HR_RELIGION_ID }}
                                                                                {{ $inforeligion -> HR_RELIGION_NAME }}

                                                                                @if($inforpersons -> HR_RELIGION_ID ==
                                                                                $inforeligion -> HR_RELIGION_ID )
                                                                                <option value=" {{ $inforeligion -> HR_RELIGION_ID }}"
                                                                                        selected>
                                                                                        {{ $inforeligion -> HR_RELIGION_NAME }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value=" {{ $inforeligion -> HR_RELIGION_ID }}">
                                                                                        {{ $inforeligion -> HR_RELIGION_NAME }}
                                                                                </option>
                                                                                @endif

                                                                                @endforeach
                                                                        </select>
                                                                </div>
                                                        </div>
                                                </div>



                                        </div>


                                        <div class="col-lg-4">
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>เชื้อชาติ </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <select name="HR_NATIONALITY"
                                                                                class="form-control input-lg">
                                                                                @foreach ($infonations as $infonation)
                                                                                {{ $infonation -> HR_NATIONALITY_ID }}
                                                                                {{ $infonation -> HR_NATIONALITY_NAME }}

                                                                                @if($inforpersons -> HR_NATIONALITY_ID
                                                                                == $infonation -> HR_NATIONALITY_ID )
                                                                                <option value=" {{ $infonation -> HR_NATIONALITY_ID }}"
                                                                                        selected>
                                                                                        {{ $infonation -> HR_NATIONALITY_NAME }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value=" {{ $infonation -> HR_NATIONALITY_ID }}">
                                                                                        {{ $infonation -> HR_NATIONALITY_NAME }}
                                                                                </option>
                                                                                @endif

                                                                                @endforeach
                                                                        </select>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>สัญชาติ </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <select name="HR_CITIZENSHIP"
                                                                                class="form-control input-lg">
                                                                                @foreach ($infocitizens as $infocitizen)
                                                                                {{ $infocitizen -> HR_CITIZENSHIP_ID }}
                                                                                {{ $infocitizen -> HR_CITIZENSHIP_NAME }}

                                                                                @if($inforpersons -> HR_CITIZENSHIP_ID
                                                                                == $infocitizen -> HR_CITIZENSHIP_ID )
                                                                                <option value=" {{ $infocitizen -> HR_CITIZENSHIP_ID }}"
                                                                                        selected>
                                                                                        {{ $infocitizen -> HR_CITIZENSHIP_NAME }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value=" {{ $infocitizen -> HR_CITIZENSHIP_ID }}">
                                                                                        {{ $infocitizen -> HR_CITIZENSHIP_NAME }}
                                                                                </option>
                                                                                @endif

                                                                                @endforeach
                                                                        </select>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>เพศ </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">

                                                                        <select name="SEX" class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                onchange="checksex()">
                                                                                @foreach ($infosexs as $infosex)
                                                                                {{ $infosex -> SEX_ID }}
                                                                                {{ $infosex -> SEX_NAME }}

                                                                                @if($inforpersons -> SEX == $infosex ->
                                                                                SEX_ID )
                                                                                <option value=" {{ $infosex -> SEX_ID }}"
                                                                                        selected>
                                                                                        {{ $infosex -> SEX_NAME }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value=" {{ $infosex -> SEX_ID }}">
                                                                                        {{ $infosex -> SEX_NAME }}
                                                                                </option>
                                                                                @endif

                                                                                @endforeach
                                                                        </select>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>กรุ๊ปเลือด </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">

                                                                        <select name="HR_BLOODGROUP"
                                                                                class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                onchange="checkbloodgroup()">
                                                                                @foreach ($infobloods as $infoblood)
                                                                                {{ $infoblood -> HR_BLOODGROUP_ID }}
                                                                                {{ $infoblood -> HR_BLOODGROUP_NAME }}

                                                                                @if($inforpersons -> HR_BLOODGROUP_ID ==
                                                                                $infoblood -> HR_BLOODGROUP_ID )
                                                                                <option value=" {{ $infoblood -> HR_BLOODGROUP_ID }}"
                                                                                        selected>
                                                                                        {{ $infoblood -> HR_BLOODGROUP_NAME }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value=" {{ $infoblood -> HR_BLOODGROUP_ID }}">
                                                                                        {{ $infoblood -> HR_BLOODGROUP_NAME }}
                                                                                </option>
                                                                                @endif

                                                                                @endforeach
                                                                        </select>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>ส่วนสูง</label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                        <input name="HR_HIGH" id="HR_HIGH" onkeyup="checkhrhight()"
                                                                                class="form-control input-lg"
                                                                                value="{{ $inforpersons -> HR_HIGH }}"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                OnKeyPress="return chkNumber(this)">
                                                                        <div style="color: red;" id="hrhigh"></div>
                                                                        <div id="hrhight"></div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label>เซนติเมตร</label>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>น้ำหนัก </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                        <input name="HR_WEIGHT" id="HR_WEIGHT" onkeyup="checkhrweight()" 
                                                                                class="form-control input-lg"
                                                                                value="{{ $inforpersons -> HR_WEIGHT }}"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                OnKeyPress="return chkNumber(this)">
                                                                        <div style="color: red;" id="hrweight"></div>
                                                                        <div id="hrweight"></div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label>กิโลกรัม</label>
                                                                </div>
                                                        </div>
                                                </div>

                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>เบอร์โทร </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <input name="HR_PHONE" id="HR_PHONE" onkeyup="checkhrphone()" 
                                                                                class="form-control input-lg"
                                                                                value="{{ $inforpersons -> HR_PHONE }}"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                OnKeyPress="return chkNumber(this)"
                                                                                maxlength="10">
                                                                        <div style="color: red;" id="hrphone"></div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">

                                                                        <label>อีเมล </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <input name="HR_EMAIL" id="HR_EMAIL"
                                                                                class="form-control input-lg"
                                                                                value="{{ $inforpersons -> HR_EMAIL  }}"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                onkeyup="checkemail()">
                                                                        <div style="color: red;" id="hremail"></div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>Facebook </label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <input name="HR_FACEBOOK"
                                                                                class="form-control input-lg"
                                                                                value="{{ $inforpersons -> HR_FACEBOOK }}">
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>Line Token</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <input name="HR_LINE"
                                                                                class="form-control input-lg"
                                                                                value="{{ $inforpersons -> HR_LINE }}">
                                                                </div>
                                                        </div>
                                                </div>

                                        </div>
                                </div>
                        </div>

                        @if($status=='ADMIN')

                        <div class="block-content">
                                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"><span
                                                style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลอาชีพ&nbsp;&nbsp;</span>
                                </h2>
                                <div class="row push">
                                        <div class="col-lg-4">
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>กลุ่มงาน </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <select name="HR_DEPARTMENT" id="HR_DEPARTMENT"
                                                                                class="form-control input-lg department"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                onchange="checkhrdepartment()">
                                                                                <option value="">--กรุณาเลือกกลุ่มงาน--
                                                                                </option>
                                                                                @foreach ($infodepartments as
                                                                                $infodepartment)
                                                                                @if($infodepartment ->HR_DEPARTMENT_ID
                                                                                == $inforpersons ->HR_DEPARTMENT_ID)
                                                                                <option value="{{ $infodepartment ->HR_DEPARTMENT_ID  }}"
                                                                                        selected>
                                                                                        {{ $infodepartment->HR_DEPARTMENT_NAME  }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value="{{ $infodepartment ->HR_DEPARTMENT_ID  }}">
                                                                                        {{ $infodepartment->HR_DEPARTMENT_NAME  }}
                                                                                </option>
                                                                                @endif

                                                                                @endforeach
                                                                        </select>
                                                                        <div style="color: red;" id="hrdepartment">
                                                                        </div>
                                                                </div>

                                                        </div>

                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>ฝ่าย/แผนก</label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <select name="DEPARTMENT_SUB"
                                                                                id="DEPARTMENT_SUB"
                                                                                class="form-control input-lg department_sub"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                onchange="checkhrdepartmentsub()">
                                                                                <option
                                                                                        value="{{ $inforpersons ->HR_DEPARTMENT_SUB_ID  }}">
                                                                                        {{ $inforpersons->HR_DEPARTMENT_SUB_NAME  }}
                                                                                </option>
                                                                        </select>
                                                                        <div style="color: red;" id="hrdepartmentsub">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>หน่วยงาน </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <select name="HR_DEPARTMENT_SUB_SUB"
                                                                                id="HR_DEPARTMENT_SUB_SUB"
                                                                                class="form-control input-lg department_sub_sub"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                onchange="checkhrdepartmentsubsub()">
                                                                                <option
                                                                                        value="{{ $inforpersons ->HR_DEPARTMENT_SUB_SUB_ID  }}">
                                                                                        {{ $inforpersons->HR_DEPARTMENT_SUB_SUB_NAME  }}
                                                                                </option>

                                                                        </select>
                                                                        <div style="color: red;"
                                                                                id="hrdepartmentsubsub"></div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>วันที่บรรจุ <div style="color: red;"
                                                                                        id="startworkdate"></div> <label style="color:red;"> *</label>
                                                                        </label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <input name="STARTWORK" id="STARTWORK"
                                                                                class="form-control input-lg datepicker"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                data-date-format="mm/dd/yyyy"
                                                                                value="{{ formate($inforpersons -> HR_STARTWORK_DATE) }}"
                                                                                onchange="checkstartworkdate()"
                                                                                readonly>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>เลขตำแหน่ง </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <input name="HR_POSITION_NUM" id="HR_POSITION_NUM" onkeyup="checkHR_POSITION_NUM()" 
                                                                                class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                value="{{ $inforpersons -> HR_POSITION_NUM }}">
                                                                        <div style="color: red;display:none" id="text_HR_POSITION_NUM"></div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-5">

                                                                        <label>เลขใบประกอบวิชาชีพ </label>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                        <input name="VCODE"
                                                                                class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                value="{{ $inforpersons -> VCODE }}">
                                                                </div>
                                                        </div>
                                                </div>

                                        </div>
                                        <div class="col-lg-4">


                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-5">
                                                                        <label>วดป.รับใบประกอบ </label>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                        <input name="VCODE_DATE" id="VCODE_DATE"
                                                                                class="form-control input-lg datepicker"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                data-date-format="mm/dd/yyyy"
                                                                                value="{{ formate($inforpersons -> VCODE_DATE) }}"
                                                                                readonly>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">

                                                                        <label>ตำแหน่ง </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <select name="POSITION_IN_WORK"
                                                                                id="POSITION_IN_WORK"
                                                                                class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                onchange="checkhrpositioninwork()">
                                                                                <option value="">--กรุณาเลือกตำแหน่ง--
                                                                                </option>
                                                                                @foreach ($infopositions as
                                                                                $infoposition) inforpersons
                                                                                @if($infoposition ->HR_POSITION_ID ==
                                                                                $inforpersons ->HR_POSITION_ID)
                                                                                <option value="{{ $infoposition ->HR_POSITION_ID  }}"
                                                                                        selected>
                                                                                        {{ $infoposition->HR_POSITION_NAME  }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value="{{ $infoposition ->HR_POSITION_ID  }}">
                                                                                        {{ $infoposition->HR_POSITION_NAME  }}
                                                                                </option>
                                                                                @endif

                                                                                @endforeach
                                                                        </select>
                                                                        <div style="color: red;" id="hrpositioninwork">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-3">

                                                                        <label>ระดับ </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        <select name="HR_LEVEL" id="HR_LEVEL"
                                                                                class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                onchange="checkhrlevel()">
                                                                                <option value="">--กรุณาเลือกระดับ--
                                                                                </option>
                                                                                @foreach ($infolevels as $infolevel)
                                                                                @if($infolevel ->HR_LEVEL_ID ==
                                                                                $inforpersons ->HR_LEVEL_ID)
                                                                                <option value="{{ $infolevel ->HR_LEVEL_ID  }}"
                                                                                        selected>
                                                                                        {{ $infolevel->HR_LEVEL_NAME  }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value="{{ $infolevel ->HR_LEVEL_ID  }}">
                                                                                        {{ $infolevel->HR_LEVEL_NAME  }}
                                                                                </option>
                                                                                @endif

                                                                                @endforeach
                                                                        </select>
                                                                        <div style="color: red;" id="hrlevel"></div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-5">

                                                                        <label>สถานะปัจจุบัน </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                        <select name="HR_STATUS" id="HR_STATUS"
                                                                                class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                onchange="checkhrstatus()">
                                                                                <option value="">--กรุณาเลือกสถานะ--
                                                                                </option>
                                                                                @foreach ($infostatuss as $infostatus)
                                                                                @if($infostatus ->HR_STATUS_ID ==
                                                                                $inforpersons ->HR_STATUS_ID)
                                                                                <option value="{{ $infostatus ->HR_STATUS_ID }}"
                                                                                        selected>
                                                                                        {{ $infostatus->HR_STATUS_NAME }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value="{{ $infostatus ->HR_STATUS_ID }}">
                                                                                        {{ $infostatus->HR_STATUS_NAME }}
                                                                                </option>
                                                                                @endif
                                                                                @endforeach
                                                                        </select>
                                                                        <div style="color: red;" id="hrstatus"></div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-5">
                                                                        <label>กลุ่มข้าราชการ </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                        <select name="HR_KIND" id="HR_KIND" onchange="checkhrkind()" 
                                                                                class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;">
                                                                                <option value="">
                                                                                        --กรุณาเลือกกลุ่มข้าราชการ--
                                                                                </option>
                                                                                @foreach ($infokinds as $infokind)
                                                                                @if($infokind->HR_KIND_ID ==
                                                                                $inforpersons->HR_KIND_ID)
                                                                                <option value="{{ $infokind ->HR_KIND_ID  }}"
                                                                                        selected>
                                                                                        {{ $infokind->HR_KIND_NAME }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value="{{ $infokind ->HR_KIND_ID  }}">
                                                                                        {{ $infokind->HR_KIND_NAME }}
                                                                                </option>
                                                                                @endif
                                                                                @endforeach
                                                                        </select>
                                                                        <div style="color: red;" id="hrkind"></div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-5">
                                                                        <label>ประเภทข้าราชการ </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                        <select name="HR_KIND_TYPE" id="HR_KIND_TYPE"
                                                                                class="form-control input-lg" onchange="checkhrkindtype()" 
                                                                                style=" font-family: 'Kanit', sans-serif;">
                                                                                <option value="">
                                                                                        --กรุณาเลือกประเภทข้าราชการ--
                                                                                </option>
                                                                                @foreach ($infokind_types as
                                                                                $infokind_type)
                                                                                @if($infokind_type ->HR_KIND_TYPE_ID ==
                                                                                $inforpersons ->HR_KIND_TYPE_ID)
                                                                                <option value="{{ $infokind_type ->HR_KIND_TYPE_ID  }}"
                                                                                        selected>
                                                                                        {{ $infokind_type->HR_KIND_TYPE_NAME  }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value="{{ $infokind_type ->HR_KIND_TYPE_ID  }}">
                                                                                        {{ $infokind_type->HR_KIND_TYPE_NAME  }}
                                                                                </option>
                                                                                @endif

                                                                                @endforeach
                                                                        </select>
                                                                        <div style="color: red;" id="hrkindtype"></div>
                                                                </div>
                                                        </div>
                                                </div>

                                        </div>
                                        <div class="col-lg-4">


                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-5">
                                                                        <label>กลุ่มบุคลากร </label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                        <select name="HR_PERSON_TYPE"
                                                                                id="HR_PERSON_TYPE"
                                                                                class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                onchange="checkhrpersontype()">
                                                                                <option value="">
                                                                                        --กรุณาเลือกกลุมบุคคลากร--
                                                                                </option>
                                                                                @foreach ($infoperson_types as
                                                                                $infoperson_type)
                                                                                @if($infoperson_type ->HR_PERSON_TYPE_ID
                                                                                == $inforpersons ->HR_PERSON_TYPE_ID)
                                                                                <option value="{{ $infoperson_type ->HR_PERSON_TYPE_ID  }}"
                                                                                        selected>
                                                                                        {{ $infoperson_type->HR_PERSON_TYPE_NAME  }}
                                                                                </option>
                                                                                @else
                                                                                <option
                                                                                        value="{{ $infoperson_type ->HR_PERSON_TYPE_ID  }}">
                                                                                        {{ $infoperson_type->HR_PERSON_TYPE_NAME  }}
                                                                                </option>
                                                                                @endif

                                                                                @endforeach
                                                                        </select>
                                                                        <div style="color: red;" id="hrpersontype">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-5">
                                                                        <label>ต้นสังกัด</label>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                        <input name="HR_AGENCY_ID"
                                                                                class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                value="{{$inforpersons ->HR_AGENCY_ID}}">
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-5">
                                                                        <label>เงินเดือน</label> <label style="color:red;"> *</label>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                        <input name="HR_SALARY" id="HR_SALARY"
                                                                                onkeyup="checkhrsalary()"
                                                                                class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                OnKeyPress="return chkmunny(this)"
                                                                                value="{{ $inforpersons -> HR_SALARY }}">
                                                                        <div style="color: red;" id="hrsalary"></div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <div class="row">
                                                                <div class="col-lg-5">
                                                                        <label>เงินประจำตำแหน่ง <div style="color: red;"
                                                                                        id="moneyposition"></div>
                                                                        </label>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                        <input name="MONEY_POSITION" id="MONEY_POSITION"
                                                                                class="form-control input-lg"
                                                                                style=" font-family: 'Kanit', sans-serif;"
                                                                                OnKeyPress="return chkmunny(this)"
                                                                                value="{{ $inforpersons -> MONEY_POSITION }}">
                                                                </div>
                                                        </div>
                                                </div>

                                        </div>
                                </div>

                                @else
                                <div class="block-content">
                                        <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"><span
                                                        style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลอาชีพ&nbsp;&nbsp;</span>
                                        </h2>
                                        <div class="row push">
                                                <div class="col-lg-4">

                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-3">
                                                                                <label>กลุ่มงาน </label>
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                                <input class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_DEPARTMENT_NAME }}"
                                                                                        readonly>

                                                                                <input type="hidden"
                                                                                        name="HR_DEPARTMENT"
                                                                                        id="HR_DEPARTMENT"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons ->HR_DEPARTMENT_ID }}">

                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-3">
                                                                                <label>ฝ่าย/แผนก </label>
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                                <input class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_DEPARTMENT_SUB_NAME }}"
                                                                                        readonly>
                                                                                <input type="hidden"
                                                                                        name="DEPARTMENT_SUB"
                                                                                        id="DEPARTMENT_SUB"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons ->HR_DEPARTMENT_SUB_ID }}">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-3">
                                                                                <label>หน่วยงาน </label>
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                                <input class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_DEPARTMENT_SUB_SUB_NAME }}"
                                                                                        readonly>
                                                                                <input type="hidden"
                                                                                        name="HR_DEPARTMENT_SUB_SUB"
                                                                                        id="HR_DEPARTMENT_SUB_SUB"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons ->HR_DEPARTMENT_SUB_SUB_ID }}">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-3">
                                                                                <label>วันที่เริ่มงาน </label>
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                                <input name="STARTWORK" id="STARTWORK"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ formate($inforpersons -> HR_STARTWORK_DATE)}}"
                                                                                        readonly>

                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-3">
                                                                                <label>เลขตำแหน่ง </label>
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                                <input name="HR_POSITION_NUM"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_POSITION_NUM }}"
                                                                                        readonly onkeyup="checkenname()" >
                                                                        </div>
                                                                </div>
                                                        </div>

                                                </div>
                                                <div class="col-lg-4">

                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-5">
                                                                                <label>เลขใบประกอบวิชาชีพ </label>
                                                                        </div>
                                                                        <div class="col-lg-7">
                                                                                <input name="VCODE"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> VCODE }}"
                                                                                        readonly>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-5">
                                                                                <label>วดป.รับใบประกอบ </label>
                                                                        </div>
                                                                        <div class="col-lg-7">

                                                                                <input name="VCODE_DATE" id="VCODE_DATE"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ formate($inforpersons -> VCODE_DATE) }}"
                                                                                        readonly>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-3">
                                                                                <label>ตำแหน่ง </label>
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                                <input class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> POSITION_IN_WORK }}"
                                                                                        readonly>
                                                                                <input type="hidden"
                                                                                        name="POSITION_IN_WORK"
                                                                                        id="POSITION_IN_WORK"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons ->HR_POSITION_ID }}">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-3">
                                                                                <label>ระดับ </label>
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                                <input class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_LEVEL_NAME}}"
                                                                                        readonly>
                                                                                <input type="hidden" name="HR_LEVEL"
                                                                                        id="HR_LEVEL"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons ->HR_LEVEL_ID }}">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-5">
                                                                                <label>สถานะปัจจุบัน </label>
                                                                        </div>
                                                                        <div class="col-lg-7">
                                                                                <input class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_STATUS_NAME }}"
                                                                                        readonly>
                                                                                <input type="hidden" name="HR_STATUS"
                                                                                        id="HR_STATUS"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons ->HR_STATUS_ID }}">
                                                                        </div>
                                                                </div>
                                                        </div>

                                                </div>
                                                <div class="col-lg-4">

                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-5">
                                                                                <label>กลุ่มข้าราชการ </label>
                                                                        </div>
                                                                        <div class="col-lg-7">
                                                                                <input class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_KIND_NAME }}"
                                                                                        readonly>
                                                                                <input type="hidden" name="HR_KIND"
                                                                                        id="HR_KIND"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons ->HR_KIND_ID }}">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-5">
                                                                                <label>ประเภทข้าราชการ </label>
                                                                        </div>
                                                                        <div class="col-lg-7">
                                                                                <input class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_KIND_TYPE_NAME }}"
                                                                                        readonly>
                                                                                <input type="hidden" name="HR_KIND_TYPE"
                                                                                        id="HR_KIND_TYPE"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons ->HR_KIND_TYPE_ID }}">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-5">
                                                                                <label>กลุ่มบุคลากร </label>
                                                                        </div>
                                                                        <div class="col-lg-7">
                                                                                <input class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_PERSON_TYPE_NAME }}"
                                                                                        readonly>
                                                                                <input type="hidden"
                                                                                        name="HR_PERSON_TYPE"
                                                                                        id="HR_PERSON_TYPE"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons ->HR_PERSON_TYPE_ID }}">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-5">
                                                                                <label>ต้นสังกัด </label>
                                                                        </div>
                                                                        <div class="col-lg-7">
                                                                                <input name=""
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HOS_USE_CODE }}"
                                                                                        readonly>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-5">
                                                                                <label>เงินเดือน </label>
                                                                        </div>
                                                                        <div class="col-lg-7">
                                                                                <input name="HR_SALARY" id="HR_SALARY"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_SALARY }}"
                                                                                        readonly>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-5">
                                                                                <label>เงินประจำตำแหน่ง </label>
                                                                        </div>
                                                                        <div class="col-lg-7">
                                                                                <input name="MONEY_POSITION"
                                                                                        id="MONEY_POSITION"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> MONEY_POSITION }}"
                                                                                        readonly>
                                                                        </div>
                                                                </div>
                                                        </div>

                                                </div>
                                        </div>
                                        @endif
                                </div>

                                <div class="block-content">
                                        <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"><span
                                                        style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลที่อยู่อาศัยปัจจุบัน&nbsp;&nbsp;</span>
                                        </h2>
                                        <div class="row">
                                                <div class="col-lg-3">
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>บ้านเลขที่ </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="HR_HOME_NUMBER"
                                                                                        id="HR_HOME_NUMBER"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_HOME_NUMBER }}"
                                                                                        style=" font-family: 'Kanit', sans-serif;"
                                                                                        onkeyup="checkhomenumber()">
                                                                                <div style="color: red;"
                                                                                        id="homenumber"></div>
                                                                        </div>
                                                                </div>
                                                        </div>

                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>จังหวัด </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <select name="PROVINCE_NAME"
                                                                                        id="PROVINCE_NAME"
                                                                                        class="form-control input-lg provice"
                                                                                        style=" font-family: 'Kanit', sans-serif;"
                                                                                        onchange="checkprovincename()">

                                                                                        <option
                                                                                                value=" {{ $inforpersons -> PROVINCE_ID }}">
                                                                                                {{ $inforpersons -> PROVINCE_NAME }}
                                                                                        </option>
                                                                                        @foreach ($infoprovinces as
                                                                                        $infoprovince)

                                                                                        <option
                                                                                                value=" {{ $infoprovince -> ID }}">
                                                                                                {{ $infoprovince -> PROVINCE_NAME }}
                                                                                        </option>

                                                                                        @endforeach
                                                                                </select>
                                                                        </div>
                                                                </div>
                                                        </div>

                                                </div>

                                                <div class="col-lg-3">
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>หมู่ที่ </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="HR_VILLAGE_NO"
                                                                                        id="HR_VILLAGE_NO"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_VILLAGE_NO }}"
                                                                                        style=" font-family: 'Kanit', sans-serif;"
                                                                                        onkeyup="checkvillageno()">
                                                                                <div style="color: red;" id="villageno">
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>อำเภอ </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <select name="AMPHUR_NAME"
                                                                                        id="AMPHUR_NAME"
                                                                                        class="form-control input-lg amphures"
                                                                                        style=" font-family: 'Kanit', sans-serif;"
                                                                                        onchange="checkamphurname()">
                                                                                        <option
                                                                                                value=" {{ $inforpersons -> AMPHUR_ID }}">
                                                                                                {{ $inforpersons -> AMPHUR_NAME }}
                                                                                        </option>
                                                                                        <?php $infoamphures = DB::table('hrd_amphur')->where('PROVINCE_ID','=',$inforpersons -> PROVINCE_ID)->get(); ?>

                                                                                        @foreach ($infoamphures as
                                                                                        $infoamphure)

                                                                                        <option
                                                                                                value=" {{ $infoamphure -> ID }}">
                                                                                                {{ $infoamphure -> AMPHUR_NAME }}
                                                                                        </option>

                                                                                        @endforeach
                                                                                </select>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-lg-3">
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>ถนน </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="HR_ROAD_NAME" id="HR_ROAD_NAME" onkeyup="checkHR_ROAD_NAME()" 
                                                                                        class="form-control input-lg"
                                                                                        value="{{  $inforpersons -> HR_ROAD_NAME }}">
                                                                                <div style="color:red;display:none" id="text_HR_ROAD_NAME"></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>ตำบล </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <select name="TUMBON_NAME"
                                                                                        id="TUMBON_NAME"
                                                                                        class="form-control input-lg tumbon"
                                                                                        style=" font-family: 'Kanit', sans-serif;"
                                                                                        onchange="checktumbonname()">
                                                                                        <option
                                                                                                value=" {{ $inforpersons -> TUMBON_ID }}">
                                                                                                {{ $inforpersons -> TUMBON_NAME }}
                                                                                        </option>
                                                                                        <?php $infohrdtumbons = DB::table('hrd_tumbon')->where('AMPHUR_ID','=',$inforpersons -> AMPHUR_ID)->get(); ?>

                                                                                        @foreach ($infohrdtumbons as
                                                                                        $infohrdtumbon)

                                                                                        <option
                                                                                                value=" {{ $infohrdtumbon -> ID }}">
                                                                                                {{ $infohrdtumbon -> TUMBON_NAME }}
                                                                                        </option>

                                                                                        @endforeach
                                                                                </select>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-lg-3">
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>ซอย </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="HR_SOI_NAME" id="HR_SOI_NAME"  onkeyup="checkHR_SOI_NAME()" 
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_SOI_NAME }}">
                                                                                <div style="color:red;display:none" id="text_HR_SOI_NAME"></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-5">
                                                                                <label>รหัสไปรษณีย์ </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-7">
                                                                                <input name="HR_ZIPCODE" id="HR_ZIPCODE"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_ZIPCODE }}"
                                                                                        maxlength="5"
                                                                                        onkeyup="checkzipcodename()">
                                                                                <div style="color: red;"
                                                                                        id="zipcodename"></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>




                                <div class="block-content">
                                        <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"><span
                                                        style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลที่อยู่อาศัยตามทะเบียนบ้าน&nbsp;&nbsp;</span>
                                        </h2>
                                        <div class="row push">

                                                <div class="col-lg-3">
                                                        <div class="form-group">
                                                                <input type="checkbox" name="billingtoo"
                                                                        onclick="FillBilling(this.form)">ข้อมูลที่อยู่อาศัยปัจจุบัน
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">

                                                                                <label>บ้านเลขที่ </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="HR_HOME_NUMBER_1"
                                                                                        id="HR_HOME_NUMBER_1"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_HOME_NUMBER_1 }}"
                                                                                        style=" font-family: 'Kanit', sans-serif;"
                                                                                        onchange="checkhomenumber1()">
                                                                                <div style="color: red;"
                                                                                        id="homenumber1"></div>
                                                                                <div id="homenumber1"></div>
                                                                        </div>
                                                                </div>
                                                        </div>

                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>จังหวัด </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <select name="PROVINCE_NAME_1"
                                                                                        id="PROVINCE_NAME_1"
                                                                                        class="form-control input-lg provice_sub"
                                                                                        style=" font-family: 'Kanit', sans-serif;"
                                                                                        onchange="checkprovincename1()">
                                                                                        <option
                                                                                                value=" {{ $inforperson_add1 -> PROVINCE_ID_1 }}">
                                                                                                {{ $inforperson_add1 -> PROVINCE_NAME }}
                                                                                        </option>
                                                                                        @foreach ($infoprovinces as
                                                                                        $infoprovince)

                                                                                        <option
                                                                                                value=" {{ $infoprovince -> ID }}">
                                                                                                {{ $infoprovince -> PROVINCE_NAME }}
                                                                                        </option>

                                                                                        @endforeach
                                                                                </select>
                                                                                <div style="color: red;"
                                                                                        id="provincename1"></div>
                                                                                <div id="provincename1"></div>
                                                                        </div>
                                                                </div>
                                                        </div>

                                                </div>

                                                <div class="col-lg-3">
                                                        <div class="form-group">
                                                                <label>&nbsp; </label>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>หมู่ที่ </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="HR_VILLAGE_NO_1"
                                                                                        id="HR_VILLAGE_NO_1"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_VILLAGE_NO_1   }}"
                                                                                        style=" font-family: 'Kanit', sans-serif;"
                                                                                        onkeyup="checkvillageno1()">
                                                                                <div style="color: red;"
                                                                                        id="villageno1"></div>
                                                                                <div id="villageno1"></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>อำเภอ </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <select name="AMPHUR_NAME_1"
                                                                                        id="AMPHUR_NAME_1"
                                                                                        class="form-control input-lg amphures_sub"
                                                                                        style=" font-family: 'Kanit', sans-serif;"
                                                                                        onchange="checkamphurname1()">
                                                                                        <option
                                                                                                value=" {{ $inforperson_add1 -> AMPHUR_ID_1 }}">
                                                                                                {{ $inforperson_add1 -> AMPHUR_NAME }}
                                                                                        </option>
                                                                                        <?php $infoamphures_add1 = DB::table('hrd_amphur')->where('PROVINCE_ID','=',$inforperson_add1 -> PROVINCE_ID)->get(); ?>

                                                                                        @foreach ($infoamphures_add1 as
                                                                                        $infoamphure_add1)

                                                                                        <option
                                                                                                value=" {{ $infoamphure_add1 -> ID }}">
                                                                                                {{ $infoamphure_add1 -> AMPHUR_NAME }}
                                                                                        </option>

                                                                                        @endforeach

                                                                                </select>
                                                                                <div style="color: red;"
                                                                                        id="amphurname1"></div>
                                                                                <div id="amphurname1"></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-lg-3">
                                                        <div class="form-group">
                                                                <label>&nbsp; </label>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>ถนน </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="HR_ROAD_NAME_1" id="HR_ROAD_NAME_1"  onkeyup="checkHR_ROAD_NAME_1()" 
                                                                                        class="form-control input-lg"
                                                                                        value="{{  $inforpersons -> HR_ROAD_NAME_1 }}">
                                                                                <div style="color:red;display:none" id="text_HR_ROAD_NAME_1"></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>ตำบล </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <select name="TUMBON_NAME_1"
                                                                                        id="TUMBON_NAME_1"
                                                                                        class="form-control input-lg tumbon_sub"
                                                                                        style=" font-family: 'Kanit', sans-serif;"
                                                                                        onchange="checktumbonname1()">
                                                                                        <option
                                                                                                value=" {{ $inforperson_add1 -> TUMBON_ID_1 }}">
                                                                                                {{ $inforperson_add1 -> TUMBON_NAME }}
                                                                                        </option>

                                                                                        <?php $infohrdtumbons_add1 = DB::table('hrd_tumbon')->where('AMPHUR_ID','=',$inforperson_add1 -> AMPHUR_ID)->get(); ?>

                                                                                        @foreach ($infohrdtumbons_add1
                                                                                        as $infohrdtumbon_add1)

                                                                                        <option
                                                                                                value=" {{ $infohrdtumbon_add1 -> ID }}">
                                                                                                {{ $infohrdtumbon_add1 -> TUMBON_NAME }}
                                                                                        </option>

                                                                                        @endforeach
                                                                                </select>
                                                                                <div style="color: red;"
                                                                                        id="tumbonname1"></div>
                                                                                <div id="tumbonname1"></div>
                                                                        </div>
                                                                        {{csrf_field()}}
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-lg-3">
                                                        <div class="form-group">
                                                                <label>&nbsp; </label>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>ซอย </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="HR_SOI_NAME_1" id="HR_SOI_NAME_1"  onkeyup="checkHR_SOI_NAME_1()" 
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_SOI_NAME_1 }}">
                                                                                <div style="color:red;display:none" id="text_HR_SOI_NAME_1"></div>
                                                                        </div>
                                                                </div>
                                                        </div>

                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-5">
                                                                                <label>รหัสไปรษณีย์ </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-7">
                                                                                <input name="HR_ZIPCODE_1"
                                                                                        id="HR_ZIPCODE_1"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> HR_ZIPCODE_1 }}"
                                                                                        style=" font-family: 'Kanit', sans-serif;"
                                                                                        maxlength="5"
                                                                                        onkeyup="checkzipcodename1()"
                                                                                        value="">
                                                                                <div style="color: red;"
                                                                                        id="zipcodename1"></div>
                                                                                <div id="zipcodename1"></div>
                                                                        </div>
                                                                </div>
                                                        </div>


                                                </div>
                                        </div>
                                </div>






                                <div class="block-content">
                                        <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"><span
                                                        style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลบัญชีธนาคาร&nbsp;&nbsp;</span>
                                        </h2>
                                        <div class="row">
                                                <div class="col-lg-4">

                                                        <div class="form-group">
                                                                <label>เงินค่าตอบแทน </label>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>เลขบัญชีธนาคาร </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="BOOK_BANK_NUMBER" id="BOOK_BANK_NUMBER"  onkeyup="checkBOOK_BANK_NUMBER()" 
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> BOOK_BANK_NUMBER }}">
                                                                                <div style="color:red;display:none" id="text_BOOK_BANK_NUMBER"></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>ชื่อบัญชีธนาคาร </label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="BOOK_BANK_NAME"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> BOOK_BANK_NAME }}">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>ธนาคาร </label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="BOOK_BANK"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> BOOK_BANK }}">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>สาขา </label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="BOOK_BANK_BRANCH"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> BOOK_BANK_BRANCH }}">
                                                                        </div>
                                                                </div>
                                                        </div>

                                                </div>
                                                <div class="col-lg-4">

                                                        <div class="form-group">
                                                                <label>เงินค่าตอบแทน OT</label>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>เลขบัญชีธนาคาร </label> <label style="color:red;"> *</label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="BOOK_BANK_OT_NUMBER" id="BOOK_BANK_OT_NUMBER"  onkeyup="checkBOOK_BANK_OT_NUMBER()" 
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> BOOK_BANK_OT_NUMBER }}">
                                                                                <div style="color:red;display:none" id="text_BOOK_BANK_OT_NUMBER"></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>ชื่อบัญชีธนาคาร </label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="BOOK_BANK_OT_NAME"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> BOOK_BANK_OT_NAME }}">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>ธนาคาร </label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="BOOK_BANK_OT"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> BOOK_BANK_OT }}">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <div class="row">
                                                                        <div class="col-lg-4">
                                                                                <label>สาขา </label>
                                                                        </div>
                                                                        <div class="col-lg-8">
                                                                                <input name="BOOK_BANK_OT_BRANCH"
                                                                                        class="form-control input-lg"
                                                                                        value="{{ $inforpersons -> BOOK_BANK_OT_BRANCH }}">
                                                                        </div>
                                                                </div>
                                                        </div>


                                                </div>





                                        </div><br>

                                        <div align="right"><button type="submit"
                                                        class="btn btn-hero-sm btn-hero-info"><i
                                                                class="fas fa-save"></i>
                                                        &nbsp;บันทึกแก้ไขข้อมูล</button>&nbsp;&nbsp;<a
                                                        href="{{ url('person/personinfouser/'.$infoid -> ID)  }}"
                                                        class="btn btn-hero-sm btn-hero-danger"
                                                        onclick="return confirm('ต้องการที่จะยกเลิกการแก้ไข ?')"><i
                                                                class="fas fa-window-close"></i> &nbsp;ยกเลิก</a> </div>
                                        <br>


</form>



</div>

</div>

@endsection


@section('footer')

<script src="{{ asset('select2/select2.min.js') }}"></script>
<script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>

<script>
        $(document).ready(function () {

                $('select').select2();


        });

        $('body').on('keydown', 'input, select, textarea', function (e) {
                var self = $(this),
                        form = self.parents('form:eq(0)'),
                        focusable, next;
                if (e.keyCode == 13) {
                        focusable = form.find('input,a,select,button,textarea').filter(':visible');
                        next = focusable.eq(focusable.index(this) + 1);
                        if (next.length) {
                                next.focus();
                        } else {
                                form.submit();
                        }
                        return false;
                }
        });


        $(document).ready(function () {

                $('.datepicker').datepicker({
                        format: 'dd/mm/yyyy',
                        todayBtn: true,
                        language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                        thaiyear: true,
                        autoclose: true //Set เป็นปี พ.ศ.
                }); //กำหนดเป็นวันปัจุบัน
        });

        //-----------------------------------------------------------------------------------------
        function checkname() {
                name = document.getElementById("HR_FNAME").value;
                if (name == null || name == '') {
                        document.getElementById("fname").style.display = "";
                        text_name = "*กรุณาระบุข้อมูลชื่อ";
                        document.getElementById("fname").innerHTML = text_name;
                } else {
                        document.getElementById("fname").style.display = "none";
                }
        }

        function checklastname() {
                lastname = document.getElementById("HR_LNAME").value;
                if (lastname == null || lastname == '') {
                        document.getElementById("lname").style.display = "";
                        text_lastname = "*กรุณาระบุข้อมูลนามสกุล";
                        document.getElementById("lname").innerHTML = text_lastname;
                } else {
                        document.getElementById("lname").style.display = "none";
                }
        }

        function checkenname() {
                enname = document.getElementById("HR_EN_NAME").value;
                if (enname == null || enname == '') {
                        document.getElementById("en_name").style.display = "";
                        text_enname = "*กรุณาระบุข้อมูลชื่อภาษาอังกฤษ";
                        document.getElementById("en_name").innerHTML = text_enname;
                } else {
                        document.getElementById("en_name").style.display = "none";
                }
        }

        function checknickname() {
                nickname = document.getElementById("NICKNAME").value;
                if (nickname == null || nickname == '') {
                        document.getElementById("nick_name").style.display = "";
                        text_nickname = "*กรุณาระบุข้อมูลชื่อเล่น";
                        document.getElementById("nick_name").innerHTML = text_nickname;
                } else {
                        document.getElementById("nick_name").style.display = "none";
                }
        }

        function checkbirthdate() {
                birthdate = document.getElementById("HR_BIRTHDAY").value;


                if (birthdate == null || birthdate == '') {
                        document.getElementById("birth_date").style.display = "";
                        text_birthdate = "*กรุณาระบุข้อมูลวันเกิด";
                        document.getElementById("birth_date").innerHTML = text_birthdate;
                } else {
                        document.getElementById("birth_date").style.display = "none";
                }
        }



        function checkmarry() {
                marry = document.getElementById("HR_MARRY_STATUS").value;
                if (marry == null || marry == '') {
                        document.getElementById("marrystatus").style.display = "";
                        text_marry = "*กรุณาระบุข้อมูลสถานะสมรส";
                        document.getElementById("marrystatus").innerHTML = text_marry;
                } else {
                        document.getElementById("marrystatus").style.display = "none";
                }
        }

        function checksex() {
                sex = document.getElementById("SEX").value;
                if (sex == null || sex == '') {
                        document.getElementById("hrsex").style.display = "";
                        text_sex = "*กรุณาระบุข้อมูลเพศ";
                        document.getElementById("hrsex").innerHTML = text_sex;
                } else {
                        document.getElementById("hrsex").style.display = "none";
                }
        }

        function checkbloodgroup() {
                bloodgroup = document.getElementById("HR_BLOODGROUP").value;
                if (bloodgroup == null || bloodgroup == '') {
                        document.getElementById("hrblood").style.display = "";
                        text_bloodgroup = "*กรุณาระบุข้อมูลกรุ๊ปเลือด";
                        document.getElementById("hrblood").innerHTML = text_bloodgroup;
                } else {
                        document.getElementById("hrblood").style.display = "none";
                }
        }

        function checkhrhight() {
                hrhight = document.getElementById("HR_HIGH").value;
                if (hrhight == null || hrhight == '') {
                        document.getElementById("hrhigh").style.display = "";
                        text_hrhight = "*กรุณาระบุส่วนสูง";
                        document.getElementById("hrhigh").innerHTML = text_hrhight;
                } else {
                        document.getElementById("hrhigh").style.display = "none";
                }
        }

        function checkhrweight() {
                hrweight = document.getElementById("HR_WEIGHT").value;
                if(hrweight == null || hrweight == '') {
                        document.getElementById("hrweight").style.display = "";
                        text_hrweight = "*กรุณาระบุน้ำหนัก";
                        document.getElementById("hrweight").innerHTML = text_hrweight;
                } else {
                        document.getElementById("hrweight").style.display = "none";
                }
        }
        function checkhrphone()
        { 
                hrphone = document.getElementById("HR_PHONE").value;
                if (hrphone==null || hrphone==''){
                document.getElementById("hrphone").style.display = "";     
                text_hrphone= "*กรุณาระบุหมายเลขโทรศัพท์";
                document.getElementById("hrphone").innerHTML = text_hrphone;
                }else{
                document.getElementById("hrphone").style.display = "none";
                }
        }

        //--------------------------------------------------------------

        function checkhrdepartment() {
                hrdepartment = document.getElementById("HR_DEPARTMENT").value;
                if (hrdepartment == null || hrdepartment == '') {
                        document.getElementById("hrdepartment").style.display = "";
                        text_department = "*กรุณาระบุกลุ่มงาน";
                        document.getElementById("hrdepartment").innerHTML = text_department;
                } else {
                        document.getElementById("hrdepartment").style.display = "none";
                }
        }

        function checkhrdepartmentsub() {
                hrdepartmentsub = document.getElementById("DEPARTMENT_SUB").value;
                if (hrdepartmentsub == null || hrdepartmentsub == '') {
                        document.getElementById("hrdepartmentsub").style.display = "";
                        text_departmentsub = "*กรุณาระบุฝ่าย/แผนก";
                        document.getElementById("hrdepartmentsub").innerHTML = text_departmentsub;
                } else {
                        document.getElementById("hrdepartmentsub").style.display = "none";
                }
        }

        function checkhrdepartmentsubsub() {
                hrdepartmentsubsub = document.getElementById("HR_DEPARTMENT_SUB_SUB").value;
                if (hrdepartmentsubsub == null || hrdepartmentsubsub == '') {
                        document.getElementById("hrdepartmentsubsub").style.display = "";
                        text_departmentsubsub = "*กรุณาระบุหน่วยงาน";
                        document.getElementById("hrdepartmentsubsub").innerHTML = text_departmentsubsub;
                } else {
                        document.getElementById("hrdepartmentsubsub").style.display = "none";
                }
        }

        function checkstartworkdate() {
                startworkdate = document.getElementById("STARTWORK").value;
                if (startworkdate == null || startworkdate == '') {
                        document.getElementById("startworkdate").style.display = "";
                        text_startworkdate = "*กรุณาระบุวันเริ่มงาน";
                        document.getElementById("startworkdate").innerHTML = text_startworkdate;
                } else {
                        document.getElementById("startworkdate").style.display = "none";
                }


        }

        function checkhrpositioninwork() {
                hrpositioninwork = document.getElementById("POSITION_IN_WORK").value;
                if (hrpositioninwork == null || hrpositioninwork == '') {
                        document.getElementById("hrpositioninwork").style.display = "";
                        text_positioninwork = "*กรุณาระบุตำแหน่ง";
                        document.getElementById("hrpositioninwork").innerHTML = text_positioninwork;
                } else {
                        document.getElementById("hrpositioninwork").style.display = "none";
                }
        }

        function checkhrlevel() {
                hrlevel = document.getElementById("HR_LEVEL").value;
                if (hrlevel == null || hrlevel == '') {
                        document.getElementById("hrlevel").style.display = "";
                        text_level = "*กรุณาระบุระดับ";
                        document.getElementById("hrlevel").innerHTML = text_level;
                } else {
                        document.getElementById("hrlevel").style.display = "none";
                }
        }

        function checkhrstatus() {
                hrstatus = document.getElementById("HR_STATUS").value;
                if (hrstatus == null || hrstatus == '') {
                        document.getElementById("hrstatus").style.display = "";
                        text_status = "*กรุณาระบุสถานะ";
                        document.getElementById("hrstatus").innerHTML = text_status;
                } else {
                        document.getElementById("hrstatus").style.display = "none";
                }
        }

        function checkhrkind() {
                hrkind = document.getElementById("HR_KIND").value;
                console.log(hrkind);
                if (hrkind == null || hrkind == '') {
                        document.getElementById("hrkind").style.display = "";
                        text_kind = "*กรุณาระบุกลุ่มข้าราชการ";
                        document.getElementById("hrkind").innerHTML = text_kind;
                } else {
                        document.getElementById("hrkind").style.display = "none";
                }
        }

        function checkhrkindtype() {
                hrkindtype = document.getElementById("HR_KIND_TYPE").value;
                if (hrkindtype == null || hrkindtype == '') {
                        document.getElementById("hrkindtype").style.display = "";
                        text_kindtype = "*กรุณาระบุประเภทข้าราชการ";
                        document.getElementById("hrkindtype").innerHTML = text_kindtype;
                } else {
                        document.getElementById("hrkindtype").style.display = "none";
                }
        }

        function checkhrpersontype() {
                hrpersontype = document.getElementById("HR_PERSON_TYPE").value;
                if (hrpersontype == null || hrpersontype == '') {
                        document.getElementById("hrpersontype").style.display = "";
                        text_persontype = "*กรุณาระบุกลุ่มบุคลากร";
                        document.getElementById("hrpersontype").innerHTML = text_persontype;
                } else {
                        document.getElementById("hrpersontype").style.display = "none";
                }
        }

        function checkhrsalary() {
                hrsalary = document.getElementById("HR_SALARY").value;
                if (hrsalary == null || hrsalary == '') {
                        document.getElementById("hrsalary").style.display = "";
                        text_salary = "*กรุณาระบุเงินเดือน";
                        document.getElementById("hrsalary").innerHTML = text_salary;
                } else {
                        document.getElementById("hrsalary").style.display = "none";
                }
        }

        function checkhomenumber() {
                homenumber = document.getElementById("HR_HOME_NUMBER").value;
                if (homenumber == null || homenumber == '') {
                        document.getElementById("homenumber").style.display = "";
                        text_homenumber = "*กรุณาระบุบ้านเลขที่";
                        document.getElementById("homenumber").innerHTML = text_homenumber;
                } else {
                        document.getElementById("homenumber").style.display = "none";
                }
        }

        function checkvillageno() {
                villageno = document.getElementById("HR_VILLAGE_NO").value;
                if (villageno == null || villageno == '') {
                        document.getElementById("villageno").style.display = "";
                        text_villageno = "*กรุณาระบุหมู่ที่";
                        document.getElementById("villageno").innerHTML = text_villageno;
                } else {
                        document.getElementById("villageno").style.display = "none";
                }
        }

        function checkprovincename() {
                provincename = document.getElementById("PROVINCE_NAME").value;
                if (provincename == null || provincename == '') {
                        document.getElementById("provincename").style.display = "";
                        text_provincename = "*กรุณาระบุจังหวัด";
                        document.getElementById("provincename").innerHTML = text_provincename;
                } else {
                        document.getElementById("provincename").style.display = "none";
                }
        }

        function checkamphurname() {
                amphurname = document.getElementById("AMPHUR_NAME").value;
                if (amphurname == null || amphurname == '') {
                        document.getElementById("amphurname").style.display = "";
                        text_amphurname = "*กรุณาระบุอำเภอ";
                        document.getElementById("amphurname").innerHTML = text_amphurname;
                } else {
                        document.getElementById("amphurname").style.display = "none";
                }
        }

        function checktumbonname() {
                tumbonname = document.getElementById("TUMBON_NAME").value;
                if (tumbonname == null || tumbonname == '') {
                        document.getElementById("tumbonname").style.display = "";
                        text_tumbonname = "*กรุณาระบุตำบล";
                        document.getElementById("tumbonname").innerHTML = text_tumbonname;
                } else {
                        document.getElementById("tumbonname").style.display = "none";
                }
        }

        function checkzipcodename() {
                zipcodename = document.getElementById("HR_ZIPCODE").value;
                if (zipcodename == null || zipcodename == '') {
                        document.getElementById("zipcodename").style.display = "";
                        text_zipcodename = "*กรุณาระบุรหัสไปรษณีย์";
                        document.getElementById("zipcodename").innerHTML = text_zipcodename;
                } else {
                        document.getElementById("zipcodename").style.display = "none";
                }
        }

        function checkvillageno1() {
                villageno1 = document.getElementById("HR_VILLAGE_NO_1").value;
                if (villageno1 == null || villageno1 == '') {
                        document.getElementById("villageno1").style.display = "";
                        text_villageno1 = "*กรุณาระบุหมู่ที่";
                        document.getElementById("villageno1").innerHTML = text_villageno1;
                } else {
                        document.getElementById("villageno1").style.display = "none";
                }
        }

        function checkprovincename1() {
                provincename1 = document.getElementById("PROVINCE_NAME_1").value;
                if (provincename1 == null || provincename1 == '') {
                        document.getElementById("provincename1").style.display = "";
                        text_provincename1 = "*กรุณาระบุจังหวัด";
                        document.getElementById("provincename1").innerHTML = text_provincename1;
                } else {
                        document.getElementById("provincename1").style.display = "none";
                }
        }

        function checkamphurname1() {
                amphurname1 = document.getElementById("AMPHUR_NAME_1").value;
                if (amphurname1 == null || amphurname1 == '') {
                        document.getElementById("amphurname1").style.display = "";
                        text_amphurname1 = "*กรุณาระบุอำเภอ";
                        document.getElementById("amphurname1").innerHTML = text_amphurname1;
                } else {
                        document.getElementById("amphurname1").style.display = "none";
                }
        }

        function checktumbonname1() {
                tumbonname1 = document.getElementById("TUMBON_NAME_1").value;
                if (tumbonname1 == null || tumbonname1 == '') {
                        document.getElementById("tumbonname1").style.display = "";
                        text_tumbonname1 = "*กรุณาระบุตำบล";
                        document.getElementById("tumbonname1").innerHTML = text_tumbonname1;
                } else {
                        document.getElementById("tumbonname1").style.display = "none";
                }
        }

        function checkhomenumber1() {
                homenumber1 = document.getElementById("HR_HOME_NUMBER_1").value;
                if (homenumber1 == null || homenumber1 == '') {
                        document.getElementById("homenumber1").style.display = "";
                        text_homenumber1 = "*กรุณาระบุบ้านเลขที่";
                        document.getElementById("homenumber1").innerHTML = text_homenumber1;
                } else {
                        document.getElementById("homenumber1").style.display = "none";
                }
        }

        function checkHR_POSITION_NUM() {
                HR_POSITION_NUM = document.getElementById("HR_POSITION_NUM").value;
                if (HR_POSITION_NUM == null || HR_POSITION_NUM == '') {
                        document.getElementById("text_HR_POSITION_NUM").style.display = "";
                        let text = "*กรุณาระบุเลขตำแหน่ง";
                        document.getElementById("text_HR_POSITION_NUM").innerHTML = text;
                } else {
                        document.getElementById("text_HR_POSITION_NUM").style.display = "none";
                }
        }

        function checkHR_ROAD_NAME() {
                HR_ROAD_NAME = document.getElementById("HR_ROAD_NAME").value;
                if (HR_ROAD_NAME == null || HR_ROAD_NAME == '') {
                        document.getElementById("text_HR_ROAD_NAME").style.display = "";
                        let text = "*กรุณาระบุถนน";
                        document.getElementById("text_HR_ROAD_NAME").innerHTML = text;
                } else {
                        document.getElementById("text_HR_ROAD_NAME").style.display = "none";
                }
        }

        function checkHR_ROAD_NAME_1() {
                HR_ROAD_NAME_1 = document.getElementById("HR_ROAD_NAME_1").value;
                if (HR_ROAD_NAME_1 == null || HR_ROAD_NAME_1 == '') {
                        document.getElementById("text_HR_ROAD_NAME_1").style.display = "";
                        let text = "*กรุณาระบุถนน";
                        document.getElementById("text_HR_ROAD_NAME_1").innerHTML = text;
                } else {
                        document.getElementById("text_HR_ROAD_NAME_1").style.display = "none";
                }
        }

        function checkHR_SOI_NAME() {
                HR_SOI_NAME = document.getElementById("HR_SOI_NAME").value;
                if (HR_SOI_NAME == null || HR_SOI_NAME == '') {
                        document.getElementById("text_HR_SOI_NAME").style.display = "";
                        let text = "*กรุณาระบุซอย";
                        document.getElementById("text_HR_SOI_NAME").innerHTML = text;
                } else {
                        document.getElementById("text_HR_SOI_NAME").style.display = "none";
                }
        }

        function checkHR_SOI_NAME_1() {
                HR_SOI_NAME_1 = document.getElementById("HR_SOI_NAME_1").value;
                if (HR_SOI_NAME_1 == null || HR_SOI_NAME_1 == '') {
                        document.getElementById("text_HR_SOI_NAME_1").style.display = "";
                        let text = "*กรุณาระบุซอย";
                        document.getElementById("text_HR_SOI_NAME_1").innerHTML = text;
                } else {
                        document.getElementById("text_HR_SOI_NAME_1").style.display = "none";
                }
        }

        function checkBOOK_BANK_NUMBER() {
                BOOK_BANK_NUMBER = document.getElementById("BOOK_BANK_NUMBER").value;
                if (BOOK_BANK_NUMBER == null || BOOK_BANK_NUMBER == '') {
                        document.getElementById("text_BOOK_BANK_NUMBER").style.display = "";
                        let text = "*กรุณาระบุเลขบัญชีธนาคาร";
                        document.getElementById("text_BOOK_BANK_NUMBER").innerHTML = text;
                } else {
                        document.getElementById("text_BOOK_BANK_NUMBER").style.display = "none";
                }
        }

        function checkBOOK_BANK_OT_NUMBER() {
                BOOK_BANK_OT_NUMBER = document.getElementById("BOOK_BANK_OT_NUMBER").value;
                if (BOOK_BANK_OT_NUMBER == null || BOOK_BANK_OT_NUMBER == '') {
                        document.getElementById("text_BOOK_BANK_OT_NUMBER").style.display = "";
                        let text = "*กรุณาระบุเลขบัญชีธนาคาร";
                        document.getElementById("text_BOOK_BANK_OT_NUMBER").innerHTML = text;
                } else {
                        document.getElementById("text_BOOK_BANK_OT_NUMBER").style.display = "none";
                }
        }
        
        function checkzipcodename1() {
                zipcodename1 = document.getElementById("HR_ZIPCODE_1").value;
                if (zipcodename1 == null || zipcodename1 == '') {
                        document.getElementById("zipcodename1").style.display = "";
                        text_zipcodename1 = "*กรุณาระบุรหัสไปรษณีย์";
                        document.getElementById("zipcodename1").innerHTML = text_zipcodename1;
                } else {
                        document.getElementById("zipcodename1").style.display = "none";
                }
        }

        function checkhrid() {
                var select = document.getElementById("HR_CID").value;
                var _token = $('input[name="_token"]').val();
                $.ajax({
                        url: "{{route('check.checkhrid')}}",
                        method: "GET",
                        data: {
                                select: select,
                                _token: _token
                        },
                        success: function (result) {
                                $('#cid').html(result);
                        }
                })

        }

        function checkemail() {
                var select = document.getElementById("HR_EMAIL").value;
                var _token = $('input[name="_token"]').val();
                $.ajax({
                        url: "{{route('check.checkemail')}}",
                        method: "GET",
                        data: {
                                select: select,
                                _token: _token
                        },
                        success: function (result) {
                                $('#hremail').html(result);
                        }
                })
        }
        
</script>

<script>
        function FillBilling(f) {
                if (f.billingtoo.checked == true) {


                        f.HR_HOME_NUMBER_1.value = f.HR_HOME_NUMBER.value;

                        f.HR_VILLAGE_NO_1.value = f.HR_VILLAGE_NO.value;
                        f.HR_ROAD_NAME_1.value = f.HR_ROAD_NAME.value;
                        f.HR_SOI_NAME_1.value = f.HR_SOI_NAME.value;

                        var found_p = false;
                        for (var i = 0; i < f.PROVINCE_NAME_1.options.length; i++) {
                                if (f.PROVINCE_NAME_1.options[i].value.toLowerCase() === f.PROVINCE_NAME.value
                                        .toLowerCase()) {
                                        f.PROVINCE_NAME_1.selectedIndex = i;
                                        found_p = true;
                                        break;
                                }
                        }
                        if (!found_p) {
                                var extraOption = f.PROVINCE_NAME_1.getAttribute("data-extra-option");
                                if (extraOption) {
                                        f.PROVINCE_NAME_1.options[f.PROVINCE_NAME_1.options.length - 1].text = f
                                                .PROVINCE_NAME.value;
                                        f.PROVINCE_NAME_1.options[f.PROVINCE_NAME_1.options.length - 1].value = f
                                                .PROVINCE_NAME.value;
                                } else {
                                        var newOption = new Option(f.PROVINCE_NAME.value, f.PROVINCE_NAME.value);
                                        f.PROVINCE_NAME_1.setAttribute("data-extra-option", "true");
                                        f.PROVINCE_NAME_1.appendChild(newOption);
                                        f.PROVINCE_NAME_1.selectedIndex = f.PROVINCE_NAME_1.options.length - 1;
                                }
                        } else {
                                if (f.PROVINCE_NAME_1.getAttribute("data-extra-option")) {
                                        f.PROVINCE_NAME_1.removeChild(f.PROVINCE_NAME_1.options[f.PROVINCE_NAME_1
                                                .options.length - 1]);
                                        f.PROVINCE_NAME_1.selectedIndex = 0;
                                }
                        }

                        var newOption_a = new Option(f.AMPHUR_NAME.options[f.AMPHUR_NAME.selectedIndex].text, f
                                .AMPHUR_NAME.value);
                        f.AMPHUR_NAME_1.setAttribute("data-extra-option", "true");
                        f.AMPHUR_NAME_1.appendChild(newOption_a);
                        f.AMPHUR_NAME_1.selectedIndex = f.AMPHUR_NAME_1.options.length - 1;

                        var newOption_t = new Option(f.TUMBON_NAME.options[f.TUMBON_NAME.selectedIndex].text, f
                                .TUMBON_NAME.value);
                        f.TUMBON_NAME_1.setAttribute("data-extra-option", "true");
                        f.TUMBON_NAME_1.appendChild(newOption_t);
                        f.TUMBON_NAME_1.selectedIndex = f.TUMBON_NAME_1.options.length - 1;

                        f.HR_ZIPCODE_1.value = f.HR_ZIPCODE.value;
                }
                if (f.billingtoo.checked == false) {
                        f.HR_HOME_NUMBER_1.value = '';
                        f.HR_VILLAGE_NO_1.value = '';
                        f.HR_ROAD_NAME_1.value = '';
                        f.HR_SOI_NAME_1.value = '';


                        f.PROVINCE_NAME_1.removeChild(f.PROVINCE_NAME_1.options[f.PROVINCE_NAME_1.options.length - 1]);
                        f.PROVINCE_NAME_1.selectedIndex = 0;

                        f.AMPHUR_NAME_1.removeChild(f.AMPHUR_NAME_1.options[f.AMPHUR_NAME_1.options.length - 1]);
                        f.AMPHUR_NAME_1.selectedIndex = 0;

                        f.TUMBON_NAME_1.removeChild(f.TUMBON_NAME_1.options[f.TUMBON_NAME_1.options.length - 1]);
                        f.TUMBON_NAME_1.selectedIndex = 0;


                        f.HR_ZIPCODE_1.value = '';
                }
        }


        function readURL(input) {
                var fileInput = document.getElementById('picture');
                var url = input.value;
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();

                if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                                $('#image_upload_preview').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                } else {

                        alert('กรุณาอัปโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                        fileInput.value = '';
                        return false;

                }
        }

        $("#picture").change(function () {
                readURL(this);
        });
</script>
<script>
        $('.provice').change(function () {
                if ($(this).val() != '') {
                        var select = $(this).val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                                url: "{{route('dropdown.fetch')}}",
                                method: "GET",
                                data: {
                                        select: select,
                                        _token: _token
                                },
                                success: function (result) {
                                        $('.amphures').html(result);
                                }
                        })
                        // console.log(select);
                }
        });

        $('.amphures').change(function () {
                if ($(this).val() != '') {
                        var select = $(this).val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                                url: "{{route('dropdown.fetchsub')}}",
                                method: "GET",
                                data: {
                                        select: select,
                                        _token: _token
                                },
                                success: function (result) {
                                        $('.tumbon').html(result);
                                }
                        })
                        // console.log(select);
                }
        });

        $('.provice_sub').change(function () {
                if ($(this).val() != '') {
                        var select = $(this).val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                                url: "{{route('dropdown.fetch')}}",
                                method: "GET",
                                data: {
                                        select: select,
                                        _token: _token
                                },
                                success: function (result) {
                                        $('.amphures_sub').html(result);
                                }
                        })
                        // console.log(select);
                }
        });

        $('.amphures_sub').change(function () {
                if ($(this).val() != '') {
                        var select = $(this).val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                                url: "{{route('dropdown.fetchsub')}}",
                                method: "GET",
                                data: {
                                        select: select,
                                        _token: _token
                                },
                                success: function (result) {
                                        $('.tumbon_sub').html(result);
                                }
                        })
                        // console.log(select);
                }
        });
</script>
<script>
        function checkcancel() {

                var r = confirm("ต้องการยกเลิกการแก้ไข");
                if (r == true) {
                        window.location.href = "{{ url('person/personinfouser')}}"
                } else {
                        return false;
                }
        }



        function readURL(input) {
                var fileInput = document.getElementById('picture');
                var url = input.value;
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                var numb = input.files[0].size / 1024;

                if (numb > 16000) {
                        alert('กรุณาอัปโหลดไฟล์ขนาดไม่เกิน 64KB');
                        fileInput.value = '';
                        return false;
                }

                if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                                $('#image_upload_preview').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                } else {

                        alert('กรุณาอัปโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                        fileInput.value = '';
                        return false;

                }




        }


        $("#picture").change(function () {
                readURL(this);
        });
</script>

<script>
        $('.department').change(function () {
                if ($(this).val() != '') {
                        var select = $(this).val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                                url: "{{route('dropdown.department')}}",
                                method: "GET",
                                data: {
                                        select: select,
                                        _token: _token
                                },
                                success: function (result) {
                                        $('.department_sub').html(result);
                                }
                        })
                        // console.log(select);
                }
        });

        $('.department_sub').change(function () {
                if ($(this).val() != '') {
                        var select = $(this).val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                                url: "{{route('dropdown.departmenthsub')}}",
                                method: "GET",
                                data: {
                                        select: select,
                                        _token: _token
                                },
                                success: function (result) {
                                        $('.department_sub_sub').html(result);
                                }
                        })
                        // console.log(select);
                }
        });
</script>

<script>
        function chkNumber(ele) {
                var vchar = String.fromCharCode(event.keyCode);
                if ((vchar < '0' || vchar > '9')) return false;
                ele.onKeyPress = vchar;
        }

        function chkmunny(ele) {
                var vchar = String.fromCharCode(event.keyCode);
                if ((vchar < '0' || vchar > '9') && (vchar != '.')) return false;
                ele.onKeyPress = vchar;
        }

        $('form').submit(function () {
                
                var name, text_name;
                var lastname, text_lastname;
                var enname, text_enname;
                var nickname, text_nickname;
                var birthdate, text_birthdate;
                var hrcid, text_hrcid;
                var hrhight, text_hrhight;
                var hrweight, text_hrweight;

                var homenumber, text_homenumber;
                var villageno, text_villageno;

                var zipcodename, text_zipcodename;

                var homenumber1, text_homenumber1;
                var villageno1, text_villageno1;
                var provincename1, text_provincename1;
                var amphurname1, text_amphurname1;
                var tumbonname1, text_tumbonname1;
                var zipcodename1, text_zipcodename1;

                var hrphone, text_hrphone;
                var hremail, text_email;

                var hrdepartment, text_department;
                var hrdepartmentsub, text_departmentsub;
                var hrdepartmentsubsub, text_departmentsubsub;

                var hrpositioninwork, text_positioninwork;
                var hrlevel, text_level;
                var hrstatus, text_status;
                var hrkind, text_kind;
                var hrkindtype, text_kindtype;
                var hrpersontype, text_persontype;


                name = document.getElementById("HR_FNAME").value;
                lastname = document.getElementById("HR_LNAME").value;
                enname = document.getElementById("HR_EN_NAME").value;
                nickname = document.getElementById("NICKNAME").value;
                birthdate = document.getElementById("HR_BIRTHDAY").value;
                hrcid = document.getElementById("HR_CID").value;
                hrhight = document.getElementById("HR_HIGH").value;
                hrweight = document.getElementById("HR_WEIGHT").value;
                hrphone = document.getElementById("HR_PHONE").value;
                hremail = document.getElementById("HR_EMAIL").value;

                hrdepartment = document.getElementById("HR_DEPARTMENT").value;
                hrdepartmentsub = document.getElementById("DEPARTMENT_SUB").value;
                hrdepartmentsubsub = document.getElementById("HR_DEPARTMENT_SUB_SUB").value;

                hrpositioninwork = document.getElementById("POSITION_IN_WORK").value;
                hrlevel = document.getElementById("HR_LEVEL").value;
                hrstatus = document.getElementById("HR_STATUS").value;
                hrkind = document.getElementById("HR_KIND").value;
                hrkindtype = document.getElementById("HR_KIND_TYPE").value;
                hrpersontype = document.getElementById("HR_PERSON_TYPE").value;


                homenumber = document.getElementById("HR_HOME_NUMBER").value;
                villageno = document.getElementById("HR_VILLAGE_NO").value;

                zipcodename = document.getElementById("HR_ZIPCODE").value;

                homenumber1 = document.getElementById("HR_HOME_NUMBER_1").value;
                villageno1 = document.getElementById("HR_VILLAGE_NO_1").value;
                provincename1 = document.getElementById("PROVINCE_NAME_1").value;
                amphurname1 = document.getElementById("AMPHUR_NAME_1").value;
                tumbonname1 = document.getElementById("TUMBON_NAME_1").value;
                zipcodename1 = document.getElementById("HR_ZIPCODE_1").value;
                let HR_POSITION_NUM = document.getElementById("HR_POSITION_NUM").value;
                let HR_SALARY = document.getElementById("HR_SALARY").value;
                let HR_ROAD_NAME = document.getElementById("HR_ROAD_NAME").value;
                let HR_SOI_NAME = document.getElementById("HR_SOI_NAME").value;
                let HR_ROAD_NAME_1 = document.getElementById("HR_ROAD_NAME_1").value;
                let HR_SOI_NAME_1 = document.getElementById("HR_SOI_NAME_1").value;
                let BOOK_BANK_NUMBER = document.getElementById("BOOK_BANK_NUMBER").value;
                let BOOK_BANK_OT_NUMBER = document.getElementById("BOOK_BANK_OT_NUMBER").value;
                
                if (name == null || name == '') {
                        document.getElementById("fname").style.display = "";
                        text_name = "*กรุณาระบุข้อมูลชื่อ";
                        document.getElementById("fname").innerHTML = text_name;
                } else {
                        document.getElementById("fname").style.display = "none";
                }


                if (lastname == null || lastname == '') {
                        document.getElementById("lname").style.display = "";
                        text_lastname = "*กรุณาระบุข้อมูลนามสกุล";
                        document.getElementById("lname").innerHTML = text_lastname;
                } else {
                        document.getElementById("lname").style.display = "none";
                }



                if (birthdate == null || birthdate == '') {
                        document.getElementById("birth_date").style.display = "";
                        text_birthdate = "*กรุณาระบุข้อมูลวันเกิด";
                        document.getElementById("birth_date").innerHTML = text_birthdate;
                } else {
                        document.getElementById("birth_date").style.display = "none";
                }
                if (hrcid == null || hrcid == '') {
                        document.getElementById("cid").style.display = "";
                        text_hrcid = "*กรุณาระบุข้อมูลเลขประจำตัวประชาชน";
                        document.getElementById("cid").innerHTML = text_hrcid;
                } else {
                        document.getElementById("cid").style.display = "none";
                }

                if (hrdepartment == null || hrdepartment == '') {
                        document.getElementById("hrdepartment").style.display = "";
                        text_department = "*กรุณาระบุกลุ่มงาน";
                        document.getElementById("hrdepartment").innerHTML = text_department;
                } else {
                        document.getElementById("hrdepartment").style.display = "none";
                }
                if (hrdepartmentsub == null || hrdepartmentsub == '') {
                        document.getElementById("hrdepartmentsub").style.display = "";
                        text_departmentsub = "*กรุณาระบุฝ่าย/แผนก";
                        document.getElementById("hrdepartmentsub").innerHTML = text_departmentsub;
                } else {
                        document.getElementById("hrdepartmentsub").style.display = "none";
                }

                if (hrdepartmentsubsub == null || hrdepartmentsubsub == '') {
                        document.getElementById("hrdepartmentsubsub").style.display = "";
                        text_departmentsubsub = "*กรุณาระบุหน่วยงาน";
                        document.getElementById("hrdepartmentsubsub").innerHTML = text_departmentsubsub;
                } else {
                        document.getElementById("hrdepartmentsubsub").style.display = "none";
                }


                if (hrpositioninwork == null || hrpositioninwork == '') {
                        document.getElementById("hrpositioninwork").style.display = "";
                        text_positioninwork = "*กรุณาระบุตำแหน่ง";
                        document.getElementById("hrpositioninwork").innerHTML = text_positioninwork;
                } else {
                        document.getElementById("hrpositioninwork").style.display = "none";
                }



                if (hrstatus == null || hrstatus == '') {
                        document.getElementById("hrstatus").style.display = "";
                        text_status = "*กรุณาระบุสถานะ";
                        document.getElementById("hrstatus").innerHTML = text_status;
                } else {
                        document.getElementById("hrstatus").style.display = "none";
                }


                if (hrpersontype == null || hrpersontype == '') {
                        document.getElementById("hrpersontype").style.display = "";
                        text_persontype = "*กรุณาระบุกลุ่มบุคลากร";
                        document.getElementById("hrpersontype").innerHTML = text_persontype;
                } else {
                        document.getElementById("hrpersontype").style.display = "none";
                }

                if (homenumber == null || homenumber == '') {
                        document.getElementById("homenumber").style.display = "";
                        text_homenumber = "*กรุณาระบุบ้านเลขที่";
                        document.getElementById("homenumber").innerHTML = text_homenumber;
                } else {
                        document.getElementById("homenumber").style.display = "none";
                }

                if (villageno == null || villageno == '') {
                        document.getElementById("villageno").style.display = "";
                        text_villageno = "*กรุณาระบุหมู่ที่";
                        document.getElementById("villageno").innerHTML = text_villageno;
                } else {
                        document.getElementById("villageno").style.display = "none";
                }
                if (zipcodename == null || zipcodename == '') {
                        document.getElementById("zipcodename").style.display = "";
                        text_zipcodename = "*กรุณาระบุรหัสไปรษณีย์";
                        document.getElementById("zipcodename").innerHTML = text_zipcodename;
                } else {
                        document.getElementById("zipcodename").style.display = "none";
                }



                if (homenumber1 == null || homenumber1 == '') {
                        document.getElementById("homenumber1").style.display = "";
                        text_homenumber1 = "*กรุณาระบุบ้านเลขที่";
                        document.getElementById("homenumber1").innerHTML = text_homenumber1;
                } else {
                        document.getElementById("homenumber1").style.display = "none";
                }

                if (villageno1 == null || villageno1 == '') {
                        document.getElementById("villageno1").style.display = "";
                        text_villageno1 = "*กรุณาระบุหมู่ที่";
                        document.getElementById("villageno1").innerHTML = text_villageno1;
                } else {
                        document.getElementById("villageno1").style.display = "none";
                }

                if (provincename1 == null || provincename1 == '') {
                        document.getElementById("provincename1").style.display = "";
                        text_provincename1 = "*กรุณาระบุจังหวัด";
                        document.getElementById("provincename1").innerHTML = text_provincename1;
                } else {
                        document.getElementById("provincename1").style.display = "none";
                }

                if (amphurname1 == null || amphurname1 == '') {
                        document.getElementById("amphurname1").style.display = "";
                        text_amphurname1 = "*กรุณาระบุอำเภอ";
                        document.getElementById("amphurname1").innerHTML = text_amphurname1;
                } else {
                        document.getElementById("amphurname1").style.display = "none";
                }


                if (tumbonname1 == null || tumbonname1 == '') {
                        document.getElementById("tumbonname1").style.display = "";
                        text_tumbonname1 = "*กรุณาระบุตำบล";
                        document.getElementById("tumbonname1").innerHTML = text_tumbonname1;
                } else {
                        document.getElementById("tumbonname1").style.display = "none";
                }



                if (hremail == null || hremail == '') {
                        document.getElementById("hremail").style.display = "";
                        text_email = "*กรุณาระบุอีเมลล์";
                        document.getElementById("hremail").innerHTML = text_email;
                } else {
                        document.getElementById("hremail").style.display = "none";
                }
                if (zipcodename1 == null || zipcodename1 == '') {
                        document.getElementById("zipcodename1").style.display = "";
                        text_zipcodename1 = "*กรุณาระบุรหัสไปรษณีย์";
                        document.getElementById("zipcodename1").innerHTML = text_zipcodename1;
                } else {
                        document.getElementById("zipcodename1").style.display = "none";
                }

                checkenname();
                checknickname();
                checkhrhight();
                checkhrweight();
                checkhrphone();
                checkHR_POSITION_NUM();
                checkhrlevel();
                checkhrkind();
                checkhrkindtype();
                checkhrsalary();
                checkHR_ROAD_NAME();
                checkHR_SOI_NAME();
                checkHR_ROAD_NAME_1();
                checkHR_SOI_NAME_1();
                checkBOOK_BANK_NUMBER();
                checkBOOK_BANK_OT_NUMBER();
                //กำหนดการแจ้งเตือนใน submin
                if (    name == null || name == '' ||
                        lastname == null || lastname == '' ||
                        birthdate == null || birthdate == '' ||
                        hrcid == null || hrcid == '' ||
                        hremail == null || hremail == '' ||
                        hrdepartment == null || hrdepartment == '' ||
                        hrdepartmentsub == null || hrdepartmentsub == '' ||
                        hrdepartmentsubsub == null || hrdepartmentsubsub == '' ||
                        hrpositioninwork == null || hrpositioninwork == '' ||
                        hrstatus == null || hrstatus == '' ||
                        hrpersontype == null || hrpersontype == '' ||
                        homenumber == null || homenumber == '' ||
                        villageno == null || villageno == '' ||
                        zipcodename == null || zipcodename == '' ||
                        villageno1 == null || villageno1 == '' ||
                        provincename1 == null || provincename1 == '' ||
                        amphurname1 == null || amphurname1 == '' ||
                        tumbonname1 == null || tumbonname1 == '' ||
                        zipcodename1 == null || zipcodename1 == '' ||
                        homenumber1 == null || homenumber1 == '' ||
                        nickname == null || nickname == '' ||
                        hrhight == null || hrhight == '' ||
                        hrweight == null || hrweight == '' ||
                        hrphone == null || hrphone == '' ||
                        HR_POSITION_NUM == null || HR_POSITION_NUM == '' ||
                        hrlevel == null || hrlevel == '' ||
                        hrkind == null || hrkind == '' ||
                        hrkindtype == null || hrkindtype == '' ||
                        HR_SALARY == null || HR_SALARY == '' ||
                        HR_ROAD_NAME == null || HR_ROAD_NAME == '' ||
                        HR_SOI_NAME == null || HR_SOI_NAME == '' ||
                        HR_ROAD_NAME_1 == null || HR_ROAD_NAME_1 == '' ||
                        HR_SOI_NAME_1 == null || HR_SOI_NAME_1 == '' ||
                        BOOK_BANK_NUMBER == null || BOOK_BANK_NUMBER == '' ||
                        BOOK_BANK_OT_NUMBER == null || BOOK_BANK_OT_NUMBER == '' ||
                        enname == null || enname == '' 
                )
                {
                        Swal.fire({
                                icon: 'error',
                                title: 'กรอกข้อมูลให้ครบถ้วน',
                                text: 'Something went wrong!',
                        })
                        return false;
                }


        });
</script>

@endsection