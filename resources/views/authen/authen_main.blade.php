<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PK-AUTHEN</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Srisakdi:wght@400;700&display=swap" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo150.ico') }}">

    {{-- <link href="{{ asset('bt52/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" /> --}}
    <!-- Plugin css -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      
    <!-- Bootstrap Css -->
    <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('pkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('disacc/styles/css/base.css') }}" rel="stylesheet">
     <!-- select2 -->
     <link rel="stylesheet" href="{{ asset('asset/js/plugins/select2/css/select2.min.css') }}">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
 
    <style>
        body {
            background-color: rgb(252, 229, 241);
            background-repeat: no-repeat;
            background-attachment: fixed;
            /* background-size: cover; */
            background-size: 100% 100%;
            /* font-family: 'Nunito', sans-serif; */
            font-family: 'Noto Sans Thai', sans-serif;
            font-size: 14px; 
        }
        .Head1{
			font-family: 'Srisakdi', sans-serif;
            /* font-size: 17px; */
            /* font-style: normal; */
          font-weight: 500;
		}
        .Head2{
			font-family: 'Srisakdi', sans-serif;
            /* font-size: 17px; */
            /* font-style: bold; */
          font-weight: 500;
		}
        .detail{
            font-size: 13px;
        }
        .bgbody{
            background-color: rgb(252, 225, 240);
            background-repeat: no-repeat;
            background-attachment: fixed; 
            background-size: 100% 100%; 
            font-family: 'Noto Sans Thai', sans-serif;
            font-size: 14px; 
        }

        #button{
               display:block;
               margin:20px auto;
               padding:30px 30px;
               background-color:#eee;
               border:solid #ccc 1px;
               cursor: pointer;
               }
               #overlay{	
               position: fixed;
               top: 0;
               z-index: 100;
               width: 100%;
               height:100%;
               display: none;
               background: rgba(0,0,0,0.6);
               }
               .cv-spinner {
               height: 100%;
               display: flex;
               justify-content: center;
               align-items: center;  
               }
               .spinner {
               width: 250px;
               height: 250px;
               border: 10px #ddd solid;
               border-top: 10px #1fdab1 solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% { 
                   transform: rotate(390deg); 
               }
               }
               .is-hide{
               display:none;
               }
    </style>
</head>

<body>
    <?php 
      
        $org = DB::connection('mysql')->select('SELECT * FROM orginfo WHERE orginfo_id = 1');
    ?>
 
 
            <div class="tabs-animation">
                <div class="row text-center">
                    <div id="overlay">
                        <div class="cv-spinner">
                            <span class="spinner"></span>
                        </div>
                    </div> 
                </div> 
                {{-- <div id="preloader">
                    <div id="status">
                        <div class="spinner"> 
                        </div>
                    </div>
                </div> --}}
               
            <div class="row mt-2">
                <div class="col"></div>
                <div class="col-xl-10">
                  
                                    @if ($smartcard == 'NO_CONNECT')
                                                <div class="row mt-4">
                                                    <div class="col"></div> 
                                                    <div class="col-md-1 text-end">
                                                        <img src="{{ asset('medical/assets/img/logo150.png') }}" alt="" height="70px" width="70px">   
                                                    </div>
                                                    <div class="col-md-4 text-start mt-3">  
                                                        @foreach ($org as $item)  
                                                                <h1 style="color:rgb(136, 43, 241)" class="Head2"> 
                                                                    {{$item->orginfo_name}}
                                                                </h1>  
                                                        @endforeach
                                                    </div> 
                                                    <div class="col"></div> 
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col"></div>
                                                    <div class="col-md-4 text-center ">
                                                        <img src="http://localhost:8189/assets/images/smartcard-connected.png" alt=""
                                                            width="320px"><br> <br>
                                                        <label for="" class="form-label Head1"
                                                            style="color: rgb(255, 255, 255);font-size:35px" >ไม่พบเครื่องอ่านบัตร</label>
                                                        <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
                                                    </div>
                                                    <div class="col"></div>
                                                </div>
                          
                                    @else

                                            @if ($smartcardcon == 'NO_CID')

                                                    <div class="row mt-4">
                                                        <div class="col"></div> 
                                                        <div class="col-md-1 text-end">
                                                            <img src="{{ asset('medical/assets/img/logo150.png') }}" alt="" height="70px" width="70px">   
                                                        </div>
                                                        <div class="col-md-4 text-start mt-3">  
                                                            @foreach ($org as $item)  
                                                                    <h1 style="color:rgb(136, 43, 241)" class="Head2"> 
                                                                        {{$item->orginfo_name}}
                                                                    </h1>  
                                                            @endforeach
                                                        </div> 
                                                        <div class="col"></div> 
                                                    </div>

                                                    <div class="row mt-4">
                                                        <div class="col"></div>
                                                        <div class="col-md-4 text-center">
                                                            <img src="{{ asset('images/card1.jpg') }}" alt="Image"
                                                                class="img-thumbnail shadow-lg" width="320px">
                                                            <br><br> 
                                                                <label for="" class="form-label Head1"
                                                                style="color: rgb(255, 255, 255);font-size:35px" >กรุณาเสียบบัตรประชาชน</label>
                                                            <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
                                                        </div>
                                                        <div class="col"></div>
                                                    </div>
                                            @else

                                                    <div class="row mt-4">
                                                        <div class="col"></div> 
                                                        <div class="col-md-1 text-end">
                                                            <img src="{{ asset('medical/assets/img/logo150.png') }}" alt="" height="70px" width="70px">   
                                                        </div>
                                                        <div class="col-md-4 text-start mt-3">  
                                                            @foreach ($org as $item)  
                                                                    <h1 style="color:rgb(136, 43, 241)" class="Head2"> 
                                                                        {{$item->orginfo_name}}
                                                                    </h1>  
                                                            @endforeach
                                                        </div> 
                                                        <div class="col"></div> 
                                                    </div>

                                                    <hr style="height: 2px;color:white;">
                                             
                                                    <div class="row mt-4">
                                                        <div class="col-md-11">

                                                            <div class="row">
                                                                <div class="col-md-2 text-end">
                                                                    <div class="mb-2">
                                                                        <label for="pid" class="form-label">เลขบัตรประชาชน :</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="mb-2">
                                                                        <label for="pid" class="form-label"
                                                                        style="color: rgb(247, 84, 43)">{{ $collection1 }}</label>
                                                                        <input type="hidden" class="form-control" id="pid"
                                                                            name="pid" value="{{ $collection1 }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 text-end">
                                                                    <div class="mb-2">
                                                                        <label for="fname" class="form-label">ชื่อ-นามสกุล :</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="mb-2">
                                                                        <label for="fname" class="form-label"
                                                                        style="color: rgb(247, 84, 43)">{{ $collection2 }}
                                                                            {{ $collection3 }}</label>
                                                                        <input type="hidden" class="form-control" id="fname" value="{{ $collection2 }}">
                                                                        <input type="hidden" class="form-control" id="lname" value="{{ $collection3 }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-2 text-end">
                                                                    <div class="mb-2">
                                                                        <label for="mainInscl" class="form-label">สิทธิหลัก :</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="mb-2">
                                                                        <label for="mainInscl" class="form-label"
                                                                        style="color: rgb(247, 84, 43)">{{ $collection6 }}</label>
                                                                        <input type="hidden" class="form-control" id="mainInscl"
                                                                            value="{{ $collection6 }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 text-end">
                                                                    <div class="mb-2">
                                                                        <label for="birthDate" class="form-label">วันเกิด :</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="mb-2">
                                                                        <label for="birthDate" class="form-label"
                                                                        style="color: rgb(247, 84, 43)">{{ $collection4 }}</label>
                                                                        <input type="hidden" class="form-control" id="birthDate" value="{{ $collection4 }}">
                                                                    </div>
                                                                </div> 
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-2 text-end">
                                                                    <div class="mb-2">
                                                                        <label for="subInscl" class="form-label">สิทธิ์ย่อย :</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="mb-2">
                                                                        <label for="subInscl" class="form-label"
                                                                        style="color: rgb(247, 84, 43)">{{ $collection7 }}</label>
                                                                        <input type="hidden" class="form-control" id="subInscl"
                                                                            value="{{ $collection7 }}">
                                                                    </div>
                                                                </div> 
                                                                <div class="col-md-2 text-end">
                                                                    <div class="mb-2">
                                                                        <label for="checkDate" class="form-label">อายุ :</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="mb-2">
                                                                        <label for="checkDate" class="form-label"
                                                                            style="color: rgb(247, 84, 43)">{{ $collection8 }}</label>
                                                                        <input type="hidden" class="form-control" id="checkDate"
                                                                            value="{{ $collection8 }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-1">
                                                            <img class="img-thumbnail" src="data:image/png;base64,{{ $collection12 }}" alt="" width="auto;" height="auto;">
                                                        </div>
                                                    </div>
 

                                                    <div class="row">
                                                        <div class="col-md-11">
                                                            <div class="row">

                                                                <div class="col-md-2 mb-2 text-end"> <label for="claimType" class="form-label">ประเภทเข้ารับบริการ :</label>  </div>
                                                                <div class="col-md-5 mb-2"> 
                                                                        <input class="form-check-input me-3" type="radio"
                                                                            name="claimType" id="claimType" value="PG0060001" checked>
                                                                        <label class="form-check-label" for="claimType">
                                                                            เข้ารับบริการรักษาทั่วไป (OPD/ IPD/ PP)
                                                                        </label> 
                                                                </div>
                                                                <div class="col-md-2 mb-2 text-end"> 
                                                                        <label for="mobile" class="form-label">ยืนยันเบอร์โทรศัพท์ :</label> 
                                                                </div>
                                                                <div class="col-md-3 mb-2"> 
                                                                        @if ($hometel == '')
                                                                            <input type="text" class="form-control shadow-lg" id="mobile" name="mobile" required style="background-color: rgb(252, 163, 157);color:white">
                                                                        @else
                                                                            <input type="text" class="form-control shadow-lg" id="mobile" name="mobile" value="{{ $hometel }}" style="background-color: rgb(151, 248, 216);color:rgb(236, 72, 7)">
                                                                        @endif  
                                                                </div>  
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-11">
                                                            <div class="row">
                                                                <div class="col-md-2 mb-2 text-end"> <label for="claimType2" class="form-label"> </label> </div>
                                                                <div class="col-md-5 mb-2"> 
                                                                        <input class="form-check-input me-3" type="radio"
                                                                            name="claimType" id="claimType2" value="PG0120001">
                                                                        <label class="form-check-label" for="claimType2">
                                                                            UCEP PLUS (ผู้ป่วยกลุ่มอาการสีเหลืองและสีแดง)
                                                                        </label> 
                                                                </div>
                                                                <div class="col-md-2 mb-2 text-end"> <label for="mobile" class="form-label">HN :</label> </div>
                                                                <div class="col-md-3 mb-2"> 
                                                                        @if ($hn == '')
                                                                            <input type="text" class="form-control shadow-lg" id="hn" name="hn" style="background-color: rgb(252, 163, 157);color:white" readonly>
                                                                        @else
                                                                            <input type="text" class="form-control shadow-lg" id="hn" name="hn" value="{{ $hn }}" style="background-color: rgb(151, 248, 216);color:rgb(236, 72, 7)" readonly>
                                                                        @endif  
                                                                </div>
                                                                <div class="col"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-11">
                                                            <div class="row">
                                                                <div class="col-md-2 text-end"> <label for="claimType3" class="form-label"> </label> </div>
                                                                <div class="col-md-7"> 
                                                                        <input class="form-check-input me-3" type="radio"
                                                                            name="claimType" id="claimType3" value="PG0130001">
                                                                        <label class="form-check-label" for="claimType3">
                                                                            บริการฟอกเลือดด้วยเครื่องไตเทียม (HD)
                                                                        </label> 
                                                                </div>
                                                                <div class="col-md-3 text-center">  
                                                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Authen_Only"> 
                                                                        <i class="fa-solid fa-heart-circle-bolt ms-4 me-4 mt-2" style="font-size: 18px;color:rgb(136, 43, 241)"></i>
                                                                        <label for="" style="font-size: 18px;color:rgb(136, 43, 241)" class="me-3 mt-2">Authen Code Only</label>
                                                                    </button>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div> 

                                                    <hr style="height: 2px;color:white;">

                                                    @if ($hn == '')

                                                            <div id="accordion" class="custom-accordion">
                                                                <div class="card mb-1 shadow-none">
                                                                    <a href="#collapseOne" class="text-dark collapsed" data-bs-toggle="collapse"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapseOne">
                                                                        <div class="card-header" id="headingOne" style="background-color: rgba(250, 227, 240, 0.699)">
                                                                            <h5 class="m-0" style="color: rgb(10, 119, 221)">
                                                                                @if ($hn == '')
                                                                                    ลงทะเบียนผู้ป่วย
                                                                                @else
                                                                                    ทะเบียนผู้ป่วย
                                                                                @endif                                                                            
                                                                                <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                                            </h5>
                                                                        </div>
                                                                    </a>
                            
                                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                                                        <div class="card-body bgbody">
                                                                            <div class="row "> 
                                                                                <div class="col-md-12"> 
                                                                                    
                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="mobile" class="form-label">คำนำหน้า </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="pname_p" id="pname_p" class="form-control" style="width: 100%">
                                                                                                        @foreach ($pname as $item_p)
                                                                                                        @if ($collection15 == $item_p->provis_code)
                                                                                                        <option value="{{$item_p->name}}" selected>{{$item_p->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_p->name}}">{{$item_p->name}}</option>
                                                                                                        @endif                                                                                            
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end"><label for="fname" class="form-label">ชื่อ </label> </div>
                                                                                            <div class="col-md-2 mb-2">  
                                                                                                    <input type="text" class="form-control form-control-sm" id="fname_p" name="fname_p" value="{{$collection2}}" style="font-size: 13px"> 
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end"><label for="lname" class="form-label">นามสกุล </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <input type="text" class="form-control form-control-sm" id="lname_p" name="lname_p" value="{{$collection3}}" style="font-size: 13px"> 
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end"><label for="pttype_p" class="form-label">สิทธิ์การรักษา </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    {{-- <input type="text" class="form-control form-control-sm" id="pttype_p" name="pttype_p"  placeholder="สิทธิ์การรักษา" style="font-size: 13px">  --}}
                                                                                                    <select name="pttype_p" id="pttype_p" class="form-control" style="width: 100%">
                                                                                                        @foreach ($pttype as $item_pt)
                                                                                                        {{-- @if ($subinscl == $item_pt->hipdata_pttype && $pttype == $item_pt->pttype) --}}
                                                                                                        @if ($ori_pttype == $item_pt->pttype)
                                                                                                        <option value="{{$item_pt->pttype}}" selected>{{$item_pt->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_pt->pttype}}">{{$item_pt->name}}</option>
                                                                                                        @endif                                                                                            
                                                                                                        @endforeach 
                                                                                                    </select> 
                                                                                            </div>                                                                                    
                                                                                        </div>

                                                                                        <input type="hidden" class="form-control form-control-sm" id="cid_p" name="cid_p" value="{{$collection1}}" placeholder="เลขบัตรประชาชน" style="font-size: 13px">  

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="marrystatus_p" class="form-label">สถานภาพ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="marrystatus_p" id="marrystatus_p" class="form-control" style="width: 100%">
                                                                                                        @foreach ($marrystatus as $item_ma)
                                                                                                        <option value="{{$item_ma->code}}">{{$item_ma->name}}</option>
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end"> <label for="mobile" class="form-label">เชื้อชาติ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="citizenship_p" id="citizenship_p" class="form-control " style="width: 100%">
                                                                                                        @foreach ($nationality as $item_na)
                                                                                                        @if ($collection14 == $item_na->code)
                                                                                                        <option value="{{$item_na->code}}" selected>{{$item_na->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_na->code}}">{{$item_na->name}}</option>
                                                                                                        @endif                                                                                            
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div> 
                                                                                            <div class="col-md-1 text-end">   <label for="mobile" class="form-label">สัญชาติ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="nationality_p" id="nationality_p" class="form-control" style="width: 100%">
                                                                                                        @foreach ($nationality as $item_na)
                                                                                                        @if ($collection14 == $item_na->code)
                                                                                                        <option value="{{$item_na->code}}" selected>{{$item_na->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_na->code}}">{{$item_na->name}}</option>
                                                                                                        @endif                                                                                            
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div> 
                                                                                            <div class="col-md-1 text-end">   <label for="mobile" class="form-label">เพศ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    @if ($collection13 =='ชาย') 
                                                                                                    <input type="hidden" class="form-control" id="sex_p" name="sex_p" value="1">
                                                                                                    <input type="text" class="form-control form-control-sm" id="" name="" value="ชาย">
                                                                                                    @else 
                                                                                                    <input type="hidden" class="form-control" id="sex_p" name="sex_p" value="2">
                                                                                                    <input type="text" class="form-control form-control-sm" id="" name="" value="หญิง">
                                                                                                    @endif  
                                                                                            </div> 
                                                                                        </div>  
                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="addrpart_p" class="form-label">บ้านเลขที่ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="addrpart_p" name="addrpart_p" style="font-size: 13px" value="{{$addrpart}}">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="moopart_p" class="form-label">หมู่ที่ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="moopart_p" name="moopart_p" value="{{$primary_moo}}" style="font-size: 13px">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="hometel_p" class="form-label">เบอร์โทร </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                @if ($hometel == '')
                                                                                                    <input type="text" class="form-control form-control-sm shadow-lg" id="hometel_p" name="hometel_p" style="font-size: 13px;background-color: rgb(252, 163, 157);color: rgb(247, 84, 43)">
                                                                                                @else
                                                                                                    <input type="text" class="form-control form-control-sm shadow-lg" id="hometel_p" name="hometel_p" value="{{ $hometel }}" style="font-size: 13px;background-color: aquamarine;color: rgb(247, 84, 43)">
                                                                                                @endif 
                                                                                                {{-- <input type="text" class="form-control form-control-sm" id="hometel" name="hometel" style="font-size: 13px"> --}}
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="bloodgrp_p" class="form-label">หมู่เลือด </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="bloodgrp_p" id="bloodgrp_p" class="form-control" style="width: 100%"> 
                                                                                                        <option value="">-เลือก-</option>
                                                                                                        @foreach ($blood_group as $item_bloo)
                                                                                                        @if ($bloodgrp == $item_bloo->name)
                                                                                                        <option value="{{$item_bloo->name}}" selected>{{$item_bloo->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_bloo->name}}">{{$item_bloo->name}}</option>
                                                                                                        @endif
                                                                                                        
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="chwpart_p" class="form-label">จังหวัด </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="chwpart_p" id="chwpart_p" class="form-control province" style="width: 100%">
                                                                                                        @foreach ($thaiaddress_provine as $item_prov)
                                                                                                        @if ($chwpart == $item_prov->name)
                                                                                                        <option value="{{$item_prov->chwpart}}" selected>{{$item_prov->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_prov->chwpart}}">{{$item_prov->name}}</option>
                                                                                                        @endif                                                                                                
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="amppart_p" class="form-label">อำเภอ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="amppart_p" id="amppart_p" class="form-control amphur" style="width: 100%">
                                                                                                        @foreach ($thaiaddress_amphur as $item_amp)
                                                                                                        @if ($amppart == $item_amp->name)
                                                                                                        <option value="{{$item_amp->amppart}}" selected>{{$item_amp->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_amp->amppart}}">{{$item_amp->name}}</option>
                                                                                                        @endif
                                                                                                        
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="tmbpart_p" class="form-label">ตำบล </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="tmbpart_p" id="tmbpart_p" class="form-control tumbon" style="width: 100%">
                                                                                                        @foreach ($thaiaddress_tumbon as $item_tum)                                                                                            
                                                                                                        @if ($tmbpart == $item_tum->name)
                                                                                                        <option value="{{$item_tum->tmbpart}}" selected>{{$item_tum->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_tum->tmbpart}}">{{$item_tum->name}}</option>
                                                                                                        @endif
                                                                                                        
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="po_code_p" class="form-label">รหัสไปรษณีย์ </label> </div>
                                                                                            <div class="col-md-2 mb-2">    
                                                                                                    {{-- <select name="pocode" id="pocode" class="form-control pocode" style="width: 100%">
                                                                                                        @foreach ($thaiaddress_po_code as $item_po)
                                                                                                        <option value="{{$item_po->po_code}}">{{$item_po->po_code}}</option>                                                                                            
                                                                                                        @endforeach 
                                                                                                        </select>  --}}
                                                                                                        <input class="form-control form-control-sm pocode" type="text" name="po_code_p" id="po_code_p" value="{{$po_code}}" style="font-size: 13px">
                                                                                            </div>
                                                                                        </div>  

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="occupation_p" class="form-label">อาชีพ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <select name="occupation_p" id="occupation_p" class="form-control" style="width: 100%">  
                                                                                                    @foreach ($occupation as $item_oc) 
                                                                                                    <option value="{{$item_oc->occupation}}">{{$item_oc->name}}</option>                                    
                                                                                                    @endforeach 
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="religion_p" class="form-label">ศาสนา </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="religion_p" id="religion_p" class="form-control" style="width: 100%">  
                                                                                                        @foreach ($religion as $item_rel) 
                                                                                                        <option value="{{$item_rel->religion}}">{{$item_rel->name}}</option>                                    
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="lang_p" class="form-label">ภาษา </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="lang_p" id="lang_p" class="form-control" style="width: 100%"> 
                                                                                                        <option value="TH">TH</option>              
                                                                                                        <option value="EN">EN</option> 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="country_p" class="form-label">ประเทศ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="country_p" id="country_p" class="form-control" style="width: 100%">  
                                                                                                        @foreach ($nationality as $item_con) 
                                                                                                        <option value="{{$item_con->code}}">{{$item_con->name}}</option>                                    
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                        </div>

                                                                                        <hr style="height: 2px;color:white;">

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="informname_p" class="form-label">ชื่อผู้ติดต่อ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="informname_p" name="informname_p" style="font-size: 13px">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="informrelation_p" class="form-label">ความสำคัญกับผู้ป่วย </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="informrelation_p" id="informrelation_p" class="form-control" style="width: 100%">  
                                                                                                        @foreach ($informrelation_list as $item_la) 
                                                                                                        <option value="{{$item_la->name}}">{{$item_la->name}}</option>                                    
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div> 
                                                                                            <div class="col-md-1 text-end">   <label for="informtel_p" class="form-label">เบอร์โทร </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="informtel_p" name="informtel_p" style="font-size: 13px" style="font-size: 13px;background-color: aquamarine;color: rgb(247, 84, 43)">
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="fathername_p" class="form-label">ชื่อบิดา </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="fathername_p" name="fathername_p" style="font-size: 13px">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="fatherlname_p" class="form-label">นามสกุล </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="fatherlname_p" name="fatherlname_p" style="font-size: 13px">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="father_cid_p" class="form-label">cid </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="father_cid_p" name="father_cid_p" style="font-size: 13px">
                                                                                            </div>
                                                                                            
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="mothername_p" class="form-label">ชื่อมารดา </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="mothername_p" name="mothername_p" style="font-size: 13px">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="motherlname_p" class="form-label">นามสกุล </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="motherlname_p" name="motherlname_p" style="font-size: 13px">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="mother_cid_p" class="form-label">cid </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="mother_cid_p" name="mother_cid_p" style="font-size: 13px">
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="spsname_p" class="form-label">ชื่อคู่สมรส </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="spsname_p" name="spsname_p" style="font-size: 13px">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="spslname_p" class="form-label">นามสกุล </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="spslname_p" name="spslname_p" style="font-size: 13px">
                                                                                            </div>
                                                                                            {{-- <div class="col-md-1 text-end">   <label for="mothername_p" class="form-label">ชื่อมารดา </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control" id="mothername_p" name="mothername_p">
                                                                                            </div> --}}
                                                                                            {{-- <div class="col-md-1 text-end">   <label for="motherlname_p" class="form-label">นามสกุล </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control" id="motherlname_p" name="motherlname_p">
                                                                                            </div> --}}
                                                                                        </div>
                                                                                            
                                                                                </div>
                                                                            </div> 

                                                                            <input type="hidden" class="form-control" id="birthDate_p" value="{{ $collection4 }}">
                                                                            <input type="hidden" class="form-control" id="hos_guid_p" name="hos_guid_p" value="{{ $hos_guid }}">  
                                                                            <input type="hidden" class="form-control" id="hcode_p" name="hcode_p" value="{{ $hcode }}">  

                                                                            <hr style="height: 2px;color:white;">
                                                                            
                                                                            <div class="row mt-3">
                                                                                <div class="col"></div>
                                                                                <div class="col-md-8 text-center">  
                                                                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Registerpatient"> 
                                                                                        <i class="fa-solid fa-heart-circle-bolt ms-4 me-4 mt-2" style="font-size: 18px;color:rgb(136, 43, 241)"></i>
                                                                                        <label for="" style="font-size: 18px;color:rgb(136, 43, 241)" class="me-3 mt-2">ลงทะเบียนผู้ป่วย</label>
                                                                                    </button>
                                                                                </div> 
                                                                                <div class="col"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                            </div>
                                                  
                                                    @else 
                                                            <div id="accordion" class="custom-accordion">
                                                                <div class="card mb-1 shadow-none">
                                                                    <a href="#collapseOne" class="text-dark collapsed" data-bs-toggle="collapse"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapseOne">
                                                                        <div class="card-header" id="headingOne" style="background-color: rgba(250, 227, 240, 0.699)">
                                                                            <h5 class="m-0" style="color: rgb(10, 119, 221)">
                                                                                @if ($hn == '')
                                                                                    ลงทะเบียนผู้ป่วย
                                                                                @else
                                                                                    ทะเบียนผู้ป่วย
                                                                                @endif                                                                            
                                                                                <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                                            </h5>
                                                                        </div>
                                                                    </a>
                            
                                                                    <div id="collapseOne" class="collapse"
                                                                            aria-labelledby="headingOne" data-bs-parent="#accordion">
                                                                        <div class="card-body bgbody">
                                                                            <div class="row "> 
                                                                                <div class="col-md-12"> 
                                                                                    
                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="mobile" class="form-label">คำนำหน้า </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="" id="" class="form-control" style="width: 100%">
                                                                                                        @foreach ($pname as $item_p)
                                                                                                        @if ($collection15 == $item_p->provis_code)
                                                                                                        <option value="{{$item_p->name}}" selected>{{$item_p->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_p->name}}">{{$item_p->name}}</option>
                                                                                                        @endif                                                                                            
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end"><label for="mobile" class="form-label">ชื่อ </label> </div>
                                                                                            <div class="col-md-2 mb-2">  
                                                                                                    <input type="text" class="form-control form-control-sm" id="fname" name="fname" value="{{$collection2}}" style="font-size: 13px"> 
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end"><label for="mobile" class="form-label">นามสกุล </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <input type="text" class="form-control form-control-sm" id="lname" name="lname" value="{{$collection3}}" style="font-size: 13px"> 
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end"><label for="mobile" class="form-label">สิทธิ์การรักษา </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    {{-- <input type="text" class="form-control form-control-sm" id="cid" name="cid" value="{{$collection1}}" placeholder="เลขบัตรประชาชน" style="font-size: 13px"> --}}
                                                                                                    
                                                                                                        <select name="pttype" id="pttype" class="form-control" style="width: 100%">
                                                                                                            @foreach ($pttype as $item_pt) 
                                                                                                            @if ($ori_pttype == $item_pt->pttype)
                                                                                                            <option value="{{$item_pt->pttype}}" selected>{{$item_pt->name}}</option>
                                                                                                            @else
                                                                                                            <option value="{{$item_pt->pttype}}">{{$item_pt->name}}</option>
                                                                                                            @endif                                                                                            
                                                                                                            @endforeach 
                                                                                                        </select> 
                                                                                               
                                                                                            </div> 
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="mobile" class="form-label">สถานภาพ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="marrystatus" id="marrystatus" class="form-control" style="width: 100%">
                                                                                                        @foreach ($marrystatus as $item_ma)
                                                                                                        <option value="{{$item_ma->code}}">{{$item_ma->name}}</option>
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end"> <label for="mobile" class="form-label">เชื้อชาติ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="citizenship" id="citizenship" class="form-control " style="width: 100%">
                                                                                                        @foreach ($nationality as $item_na)
                                                                                                        @if ($collection14 == $item_na->code)
                                                                                                        <option value="{{$item_na->code}}" selected>{{$item_na->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_na->code}}">{{$item_na->name}}</option>
                                                                                                        @endif                                                                                            
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div> 
                                                                                            <div class="col-md-1 text-end">   <label for="mobile" class="form-label">สัญชาติ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="nationality" id="nationality" class="form-control" style="width: 100%">
                                                                                                        @foreach ($nationality as $item_na)
                                                                                                        @if ($collection14 == $item_na->code)
                                                                                                        <option value="{{$item_na->code}}" selected>{{$item_na->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_na->code}}">{{$item_na->name}}</option>
                                                                                                        @endif                                                                                            
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div> 
                                                                                            <div class="col-md-1 text-end">   <label for="mobile" class="form-label">เพศ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    @if ($collection13 =='ชาย') 
                                                                                                    <input type="hidden" class="form-control" id="sex" name="sex" value="1">
                                                                                                    <input type="text" class="form-control form-control-sm" id="" name="" value="ชาย" style="font-size: 13px">
                                                                                                    @else 
                                                                                                    <input type="hidden" class="form-control" id="sex" name="sex" value="2">
                                                                                                    <input type="text" class="form-control form-control-sm" id="" name="" value="หญิง" style="font-size: 13px">
                                                                                                    @endif  
                                                                                            </div> 
                                                                                        </div>  

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="mobile" class="form-label">บ้านเลขที่ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="addrpart" name="addrpart" style="font-size: 13px" value="{{$addrpart}}">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="mobile" class="form-label">หมู่ที่ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="moopart" name="moopart" value="{{$primary_moo}}" style="font-size: 13px">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="hometel" class="form-label">เบอร์โทร </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                @if ($hometel == '')
                                                                                                    <input type="text" class="form-control shadow-lg" id="hometel" name="hometel" style="font-size: 13px;background-color: rgb(252, 163, 157);color: rgb(247, 84, 43)"">
                                                                                                @else
                                                                                                    <input type="text" class="form-control shadow-lg" id="hometel" name="hometel" value="{{ $hometel }}" style="font-size: 13px;background-color: aquamarine;color: rgb(247, 84, 43)">
                                                                                                @endif 
                                                                                                {{-- <input type="text" class="form-control form-control-sm" id="hometel" name="hometel" style="font-size: 13px"> --}}
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="province" class="form-label">หมู่เลือด </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="bloodgrp" id="bloodgrp" class="form-control" style="width: 100%">
                                                                                                        <option value="">--Choose--</option>
                                                                                                        @foreach ($blood_group as $item_bloo)
                                                                                                        @if ($bloodgrp == $item_bloo->name)
                                                                                                        <option value="{{$item_bloo->name}}" selected>{{$item_bloo->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_bloo->name}}">{{$item_bloo->name}}</option>
                                                                                                        @endif
                                                                                                        
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="province" class="form-label">จังหวัด </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="province" id="province" class="form-control province" style="width: 100%">
                                                                                                        @foreach ($thaiaddress_provine as $item_prov)
                                                                                                        @if ($primary_province_name == $item_prov->name)
                                                                                                        <option value="{{$item_prov->chwpart}}" selected>{{$item_prov->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_prov->chwpart}}">{{$item_prov->name}}</option>
                                                                                                        @endif
                                                                                                        
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="amphur" class="form-label">อำเภอ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="amphur" id="amphur" class="form-control amphur" style="width: 100%">
                                                                                                        @foreach ($thaiaddress_amphur as $item_amp)
                                                                                                        @if ($primary_amphur_name == $item_amp->name)
                                                                                                        <option value="{{$item_amp->amppart}}" selected>{{$item_amp->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_amp->amppart}}">{{$item_amp->name}}</option>
                                                                                                        @endif
                                                                                                        
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="tumbon" class="form-label">ตำบล </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="tumbon" id="tumbon" class="form-control tumbon" style="width: 100%">
                                                                                                        @foreach ($thaiaddress_tumbon as $item_tum)
                                                                                                        @if ($primary_tumbon_name == $item_tum->name)
                                                                                                        <option value="{{$item_tum->tmbpart}}" selected>{{$item_tum->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_tum->tmbpart}}">{{$item_tum->name}}</option>
                                                                                                        @endif
                                                                                                        {{-- @if ($tmbpart == $item_tum->tmbpart)
                                                                                                        <option value="{{$item_tum->tmbpart}}" selected>{{$item_tum->name}}</option>
                                                                                                        @else
                                                                                                        <option value="{{$item_tum->tmbpart}}">{{$item_tum->name}}</option>
                                                                                                        @endif --}}
                                                                                                        
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="pocode" class="form-label">รหัสไปรษณีย์ </label> </div>
                                                                                            <div class="col-md-2 mb-2">    
                                                                                                    {{-- <select name="pocode" id="pocode" class="form-control pocode" style="width: 100%">
                                                                                                        @foreach ($thaiaddress_po_code as $item_po)
                                                                                                        <option value="{{$item_po->po_code}}">{{$item_po->po_code}}</option>                                                                                            
                                                                                                        @endforeach 
                                                                                                        </select>  --}}
                                                                                                        <input class="form-control pocode" type="text" name="pocode" id="pocode" value="{{$po_code}}" style="font-size: 13px">
                                                                                            </div>
                                                                                        </div>  

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="occupation_p" class="form-label">อาชีพ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <select name="occupation_p" id="occupation_p" class="form-control" style="width: 100%">  
                                                                                                    @foreach ($occupation as $item_oc) 
                                                                                                    <option value="{{$item_oc->occupation}}">{{$item_oc->name}}</option>                                    
                                                                                                    @endforeach 
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="religion_p" class="form-label">ศาสนา </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="religion_p" id="religion_p" class="form-control" style="width: 100%">  
                                                                                                        @foreach ($religion as $item_rel) 
                                                                                                        <option value="{{$item_rel->religion}}">{{$item_rel->name}}</option>                                    
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="lang_p" class="form-label">ภาษา </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="lang_p" id="lang_p" class="form-control" style="width: 100%"> 
                                                                                                        <option value="TH">TH</option>              
                                                                                                        <option value="EN">EN</option> 
                                                                                                    </select>  
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="country_p" class="form-label">ประเทศ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="country_p" id="country_p" class="form-control" style="width: 100%">  
                                                                                                        @foreach ($nationality as $item_con) 
                                                                                                        <option value="{{$item_con->code}}">{{$item_con->name}}</option>                                    
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div>
                                                                                        </div>
        
                                                                                        <hr style="height: 2px;color:white;">

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="informname_p" class="form-label">ชื่อผู้ติดต่อ </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="informname_p" name="informname_p" style="font-size: 13px" value="{{$informname}}">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="informrelation_p" class="form-label">ความสำคัญกับผู้ป่วย </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                    <select name="informrelation_p" id="informrelation_p" class="form-control" style="width: 100%">  
                                                                                                        @foreach ($informrelation_list as $item_la) 
                                                                                                        @if ($informrelation == $item_la->name)
                                                                                                        <option value="{{$item_la->name}}" selected>{{$item_la->name}}</option> 
                                                                                                        @else
                                                                                                        <option value="{{$item_la->name}}">{{$item_la->name}}</option> 
                                                                                                        @endif                           
                                                                                                        @endforeach 
                                                                                                    </select>  
                                                                                            </div> 
                                                                                            <div class="col-md-1 text-end">   <label for="informtel_p" class="form-label">เบอร์โทร </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="informtel_p" name="informtel_p" value="{{$informtel}}" style="font-size: 13px" style="font-size: 13px;background-color: aquamarine;color: rgb(247, 84, 43)">
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="fathername_p" class="form-label">ชื่อบิดา </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="fathername_p" name="fathername_p" style="font-size: 13px" value="{{$fathername}}">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="fatherlname_p" class="form-label">นามสกุล </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="fatherlname_p" name="fatherlname_p" style="font-size: 13px" value="{{$fatherlname}}">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="father_cid_p" class="form-label">cid </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="father_cid_p" name="father_cid_p" style="font-size: 13px" value="{{$father_cid}}">
                                                                                            </div>
                                                                                            
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="mothername_p" class="form-label">ชื่อมารดา </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="mothername_p" name="mothername_p" style="font-size: 13px" value="{{$mathername}}">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="motherlname_p" class="form-label">นามสกุล </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="motherlname_p" name="motherlname_p" style="font-size: 13px" value="{{$motherlname}}">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="mother_cid_p" class="form-label">cid </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="mother_cid_p" name="mother_cid_p" style="font-size: 13px" value="{{$mother_cid}}">
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-1 text-end">   <label for="spsname_p" class="form-label">ชื่อคู่สมรส </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="spsname_p" name="spsname_p" style="font-size: 13px" value="{{$spsname}}">
                                                                                            </div>
                                                                                            <div class="col-md-1 text-end">   <label for="spslname_p" class="form-label">นามสกุล </label> </div>
                                                                                            <div class="col-md-2 mb-2"> 
                                                                                                <input type="text" class="form-control form-control-sm" id="spslname_p" name="spslname_p" style="font-size: 13px" value="{{$spslname}}">
                                                                                            </div> 
                                                                                        </div>
                                                                                            
                                                                                </div>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card mb-1 shadow-none">
                                                                    <a href="#collapseTwo" class="text-dark collapsed" data-bs-toggle="collapse"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapseTwo">
                                                                        <div class="card-header" id="headingTwo" style="background-color: rgba(250, 227, 240, 0.699)">
                                                                            <h5 class="m-0" style="color: rgb(10, 119, 221)">
                                                                                เปิด Visit
                                                                                <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                                            </h5>
                                                                        </div>
                                                                    </a>
                                                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                                            data-bs-parent="#accordion">
                                                                        <div class="card-body bgbody">

                                                                                <div class="row">
                                                                                    <div class="col-md-2 text-end">วันที่</div>
                                                                                    <div class="col-md-1"> <label class="form-check-label" for="claimType3">{{Date($date)}} </label>  </div>
                                                                                    <div class="col-md-1 text-end">เวลา</div>
                                                                                    <div class="col-md-1"> <label class="form-check-label" for="claimType3">{{$time_s}} </label> </div>
                                                                                    <div class="col-md-2 text-end">มาครั้งสุดท้าย</div>
                                                                                    <div class="col-md-1"> <label class="form-check-label" for="claimType3">{{Date($last_visit)}} </label>  </div>
                                                                                    <div class="col-md-2 text-end"> 
                                                                                        <div class="mb-2">
                                                                                            <input class="form-check-input me-3" type="radio" name="time_" id="intime" checked>
                                                                                            <label class="form-check-label" for="intime"> ในเวลา </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 text-start"> 
                                                                                        <div class="mb-2">
                                                                                            <input class="form-check-input me-3" type="radio" name="time_" id="outtime" >
                                                                                            <label class="form-check-label" for="outtime">นอกเวลา</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> 
                        
                                                                                <br>
                        
                                                                                <div class="row">
                                                                                    <div class="col-md-2 text-end mt-2">ส่งต่อไปยัง</div>
                                                                                    <div class="col-md-2"> 
                                                                                        <select name="main_dep_queue" id="main_dep_queue" class="form-control" style="width: 100%">
                                                                                            @foreach ($kskdepartment as $item_m)
                                                                                            <option value="{{$item_m->depcode}}">{{$item_m->department}}</option>
                                                                                            @endforeach                                                                
                                                                                        </select>
                                                                                    </div> 
                                                                                    <div class="col-md-2 text-end mt-2"> แผนก </div>
                                                                                    <div class="col-md-2">
                                                                                        <select name="spclty" id="spclty" class="form-control" style="width: 100%">
                                                                                            @foreach ($spclty as $item2)
                                                                                            <option value="{{$item2->spclty}}">{{$item2->name}}</option>
                                                                                            @endforeach                                                                
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-2 text-end mt-2">ประเภท</div>
                                                                                    <div class="col-md-2"> 
                                                                                        <select name="pt_subtype" id="pt_subtype" class="form-control" style="width: 100%">
                                                                                            @foreach ($pt_subtype as $item_su)
                                                                                            <option value="{{$item_su->pt_subtype}}">{{$item_su->name}}</option>
                                                                                            @endforeach                                                                
                                                                                        </select>
                                                                                    </div>
                                                                                </div> 
                        
                                                                                <br>
                        
                                                                                <div class="row">
                                                                                    <div class="col-md-2 text-end mt-2">ประเภทการมา</div>
                                                                                    <div class="col-md-2"> 
                                                                                        <select name="ovstist" id="ovstist" class="form-control" style="width: 100%">
                                                                                            @foreach ($ovstist as $item)
                                                                                            <option value="{{$item->ovstist}}">{{$item->name}}</option>
                                                                                            @endforeach                                                                
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-2 text-end mt-2">ความเร่งด่วน</div>
                                                                                    <div class="col-md-2"> 
                                                                                        <select name="pt_priority" id="pt_priority" class="form-control" style="width: 100%">
                                                                                            @foreach ($pt_priority as $item_p)
                                                                                            <option value="{{$item_p->id}}">{{$item_p->name}}</option>
                                                                                            @endforeach                                                                
                                                                                        </select>
                                                                                    </div> 
                                                                                    <div class="col-md-2 text-end mt-2"> สภาพผู้ป่วย </div>
                                                                                    <div class="col-md-2">
                                                                                        <select name="pt_walk" id="pt_walk" class="form-control" style="width: 100%">
                                                                                            @foreach ($pt_walk as $item_w)
                                                                                            <option value="{{$item_w->walk_id}}">{{$item_w->name}}</option>
                                                                                            @endforeach                                                                
                                                                                        </select>
                                                                                    </div>                                                        
                                                                                </div> 
                        
                                                                                <br>  
                                                                                
                                                                                <div class="row">
                                                                                    <div class="col-md-2 text-end mt-2">อาการที่มา</div>
                                                                                    <div class="col-md-10"> 
                                                                                        <textarea name="cc" id="cc" rows="2" type="text" class="form-control"></textarea> 
                                                                                    </div>                                     
                                                                                </div> 

                                                                                <div class="row mt-2">
                                                                                    <div class="col"></div>
                                                                                    <div class="col-md-8 text-center">  
                                                                                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info"> 
                                                                                            <i class="fa-solid fa-heart-circle-bolt ms-4 me-4 mt-2" style="font-size: 18px;color:rgb(136, 43, 241)"></i>
                                                                                            <label for="" style="font-size: 18px;color:rgb(136, 43, 241)" class="me-3 mt-2">Authen Code + Visit</label>
                                                                                        </button>
                                                                                        {{-- <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info" id="OpenVisit"> 
                                                                                            <i class="fa-solid fa-heart-circle-bolt ms-4 me-4 mt-2" style="font-size: 18px;color:rgb(136, 43, 241)"></i>
                                                                                            <label for="" style="font-size: 18px;color:rgb(136, 43, 241)" class="me-3 mt-2">Authen Code + Visit</label>
                                                                                        </button> --}}
                                                                                    </div> 
                                                                                    <div class="col"></div>
                                                                                </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div> 

                                                    @endif

                                                        <input type="hidden" class="form-control" id="correlationId" name="correlationId" value="{{ $collection10 }}">
                                                        <input type="hidden" class="form-control" id="hos_guid" name="hos_guid" value="{{ $hos_guid }}">
                                                        <input type="hidden" class="form-control" id="ovst_key" name="ovst_key" value="{{ $ovst_key }}">
                                                        <input type="hidden" class="form-control" id="vn" name="vn" value="{{ $vn }}">
                                                        <input type="hidden" class="form-control" id="hcode" name="hcode" value="{{ $hcode }}"> 
                                                        <input type="hidden" class="form-control" id="time" name="time" value="{{ $time }}">
                                                        
                                                        <hr style="height: 2px;color:white;">
 
                                                        <h3 style="color:rgb(136, 43, 241)" class="Head2 text-center"> 
                                                             BY ทีมพัฒนา PK-OFFICER
                                                        </h3>  
                                                        
                                            @endif
                                
                                    @endif

                      
                        </form> 
                </div>
                <div class="col"></div>
            </div> 
           
    </div>
    <!-- JAVASCRIPT -->
    {{-- <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>  --}}
    <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

    <script>
            $(document).ready(function() {
                $('select').select2();
                // $('#ovstist').select2({
                //     dropdownParent: $('#insertdata')
                // });
                $('#spinner').hide();//Request is complete so hide spinner
                // $("#spinner-div").hide(); //Request is complete so hide spinner
                
                $('#Authen_Only').click(function() {
                        var pid             = $('#pid').val(); 
                        var claimType       = $('#claimType').val(); 
                        var mobile          = $('#mobile').val(); 
                        var correlationId   = $('#correlationId').val(); 
                        var hn              = $('#hn').val(); 
                        var hcode           = $('#hcode').val(); 

                        
                        Swal.fire({
                                title: 'ต้องการ Authen Code ใช่ไหม ?',
                                text: "You Warn Authen Code Data!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, Authen Code it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });                                        
                                        $.ajax({
                                            url: "{{ route('authencode') }}",
                                            type: "POST",
                                            dataType: 'json',
                                            data: {
                                                pid,claimType,mobile,correlationId,hcode,hn                       
                                            },
                                            success: function(data) {
                                                if (data.status == 200) { 
                                                    Swal.fire({
                                                        title: 'เปิด Authen Code สำเร็จ',
                                                        text: "You Authen Code success",
                                                        icon: 'success',
                                                        showCancelButton: false,
                                                        confirmButtonColor: '#06D177',
                                                        confirmButtonText: 'เรียบร้อย'
                                                    }).then((result) => {
                                                        if (result
                                                            .isConfirmed) {
                                                            console.log(
                                                                data);
                                                            window.location.reload();
                                                            // $('#spinner').hide();//Request is complete so hide spinner
                                                            //     setTimeout(function(){
                                                            //         $("#overlay").fadeOut(300);
                                                            //     },500);
                                                        }
                                                    })
                                                } else {
                                                    // consollog(data);
                                                    Swal.fire({
                                                        icon: "error",
                                                        title: "Oops...Authen Code ไม่สำเร็จ",
                                                        text: "Authen Code Unsuccess!",
                                                        footer: '<a href="#">กรุณาลองใหม่อีกครั้ง?</a>'
                                                    }).then((result) => {
                                                        if (result
                                                            .isConfirmed) {
                                                            console.log(
                                                                data);
                                                            window.location.reload(); 
                                                        }
                                                    })
                                                }
                                            },
                                        });
                                        
                                    }
                        })
                    });
                $('#insert_AuthencodeForm').on('submit', function(e) {
                    e.preventDefault();
                    var form = this;
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {
                            if (data.status == 0) {

                            } else {
                                Swal.fire({
                                    title: 'ออก Authen Code สำเร็จ',
                                    text: "You Get Authen Code success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    // cancelButtonColor: '#d33',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // window.location.reload();  
                                        window.location = "{{ url('authen_main') }}";
                                    }
                                })
                            }
                        }
                    });
                });

                $('#OpenVisit').click(function() {
                    var hos_guid  = $('#hos_guid').val();
                    var ovst_key  = $('#ovst_key').val();
                    var vn        = $('#vn').val();
                    var hcode     = $('#hcode').val(); 
                    var pid       = $('#pid').val(); 
                    var mainInscl = $('#mainInscl').val(); 
                    var subInscl  = $('#subInscl').val(); 
                    var claimType = $('#claimType').val(); 
                    var claimType2 = $('#claimType2').val(); 
                    var claimType3 = $('#claimType3').val(); 
                    var mobile     = $('#mobile').val(); 
                    var hn         = $('#hn').val(); 

                    var main_dep_queue = $('#main_dep_queue').val(); 
                    var spclty         = $('#spclty').val(); 
                    var pt_subtype     = $('#pt_subtype').val(); 
                    var ovstist        = $('#ovstist').val(); 
                    var pt_priority    = $('#pt_priority').val(); 
                    var pt_walk        = $('#pt_walk').val(); 
                    var cc             = $('#cc').val(); 
                    var time           = $('#time').val(); 
                   // alert(hos_guid);
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('a.authencode_visit_save') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            _token:"{{ csrf_token() }}",
                            hos_guid,ovst_key,vn,hcode,pid ,mainInscl,subInscl,claimType,claimType2,claimType3,mobile
                            ,hn,main_dep_queue,spclty,pt_subtype,ovstist,pt_priority,pt_walk,cc,time
                        },
                        
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'Authen+Visit สำเร็จ',
                                    text: "You Authen + Visit success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result
                                        .isConfirmed) {
                                        console.log(
                                            data);
                                        window.location.reload();
                                        // window.location="{{ url('warehouse/warehouse_index') }}";
                                    }
                                })
                            } else {

                            }

                        },
                    });
                }); 

                $('#Registerpatient').click(function() { 
                    var pname_p           = $('#pname_p').val();
                    var fname_p           = $('#fname_p').val();
                    var lname_p           = $('#lname_p').val();
                    var cid_p             = $('#cid_p').val(); 
                    var marrystatus_p     = $('#marrystatus_p').val(); 
                    var citizenship_p     = $('#citizenship_p').val(); 
                    var nationality_p     = $('#nationality_p').val(); 
                    var sex_p             = $('#sex_p').val(); 
                    var addrpart_p        = $('#addrpart_p').val(); 
                    var moopart_p         = $('#moopart_p').val(); 
                    var hometel_p         = $('#hometel_p').val(); 
                    var bloodgrp_p        = $('#bloodgrp_p').val(); 
                    var chwpart_p         = $('#chwpart_p').val(); 
                    var amppart_p         = $('#amppart_p').val(); 
                    var tmbpart_p         = $('#tmbpart_p').val(); 
                    var po_code_p         = $('#po_code_p').val(); 
                    var hos_guid_p        = $('#hos_guid_p').val(); 
                    var hcode_p           = $('#hcode_p').val(); 
                    var birthDate_p       = $('#birthDate_p').val(); 
                    var lang_p            = $('#lang_p').val(); 
                    var country_p         = $('#country_p').val(); 
                    var informname_p      = $('#informname_p').val(); 
                    var informrelation_p  = $('#informrelation_p').val(); 
                    var fathername_p      = $('#fathername_p').val(); 
                    var fatherlname_p     = $('#fatherlname_p').val(); 
                    var mothername_p      = $('#mothername_p').val(); 
                    var motherlname_p     = $('#motherlname_p').val(); 
                    var spsname_p         = $('#spsname_p').val(); 
                    var spslname_p        = $('#spslname_p').val(); 

                    var father_cid_p      = $('#father_cid_p').val(); 
                    var mother_cid_p      = $('#mother_cid_p').val(); 
                    var religion_p        = $('#religion_p').val(); 
                    var occupation_p      = $('#occupation_p').val(); 
                    var informtel_p      = $('#informtel_p').val(); 
                    var pttype_p         = $('#pttype_p').val(); 
                    // alert(hos_guid_p);
                      
                    $.ajax({     
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},        
                        url: "{{ route('a.authencode_patient_save') }}",
                        type: "POST",
                        dataType: 'json', 
                        data: { 
                            _token:"{{ csrf_token() }}",
                            hos_guid_p,pname_p,fname_p,lname_p,cid_p,marrystatus_p ,citizenship_p,nationality_p
                            ,sex_p,addrpart_p,moopart_p,hometel_p,bloodgrp_p,chwpart_p,amppart_p,tmbpart_p
                            ,po_code_p,hos_guid_p,hcode_p,birthDate_p,lang_p,country_p,informname_p,informrelation_p
                            ,fathername_p,fatherlname_p,mothername_p,motherlname_p,spsname_p,spslname_p,father_cid_p
                            ,mother_cid_p,religion_p,occupation_p,informtel_p,pttype_p
                        },                        
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'ลงทะเบียนผู้ป่วยสำเร็จ',
                                    text: "Successfully registered patient",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result
                                        .isConfirmed) {
                                        console.log(
                                            data);
                                        window.location.reload();
                                        // window.location="{{ url('warehouse/warehouse_index') }}";
                                    }
                                })
                            } else {

                            }
                        },
                    });
                });
 

            });

             //------------------------ จังหวัด ------------------

            $('.province').change(function(){
                    if($(this).val()!=''){
                    var select = $(this).val();
                    var _token=$('input[name="_token"]').val();
                    // alert(select);
                        $.ajax({
                                url:"{{route('fecth.fetch_province')}}",
                                method:"GET",
                                data:{select:select,_token:_token},
                                success:function(result){
                                    $('.amphur').html(result);
                                }
                        }) 
                    }        
            });

            $('.amphur').change(function(){
                    if($(this).val()!=''){
                    var select   = $(this).val();
                    var province = $('#province').val();
                    var _token=$('input[name="_token"]').val();
                    // alert(select);
                        $.ajax({
                                url:"{{route('fecth.fetch_amphur')}}",
                                method:"GET",
                                data:{select:select,province:province,_token:_token},
                                success:function(result){
                                $('.tumbon').html(result);
                                }
                        }) 
                    }        
            });
            $('.tumbon').change(function(){
                    if($(this).val()!=''){
                    var select   = $(this).val();
                    var amphur   = $('#amphur').val();
                    var province = $('#province').val();
                    var _token=$('input[name="_token"]').val();
                    // alert(select);
                        $.ajax({
                                url:"{{route('fecth.fetch_tumbon')}}",
                                method:"GET",
                                data:{select:select,province:province,amphur:amphur,_token:_token},
                                success:function(result){
                                $('.pocode').html(result);
                                }
                        }) 
                    }        
            });


            
    </script>
    

</body>

</html>
