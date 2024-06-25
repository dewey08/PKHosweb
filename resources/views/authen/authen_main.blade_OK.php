<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PK-AUTHEN</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo150.ico') }}">

    {{-- <link href="{{ asset('bt52/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" /> --}}
    <!-- Plugin css -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <!-- select2 -->
      <link rel="stylesheet" href="{{ asset('asset/js/plugins/select2/css/select2.min.css') }}">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('pkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('disacc/styles/css/base.css') }}" rel="stylesheet">

    
 
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
        }
        /* .label{
                font-size: 12px;
            } */
    </style>
</head>

<body>
    <?php 
      
        $org = DB::connection('mysql')->select('SELECT * FROM orginfo WHERE orginfo_id = 1');
    ?>
 
    <div class="tabs-animation mt-3">
            <div class="row text-center">
                <div id="overlay">
                    <div class="cv-spinner">
                        <span class="spinner"></span>
                    </div>
                </div> 
            </div>
    
            @if ($smartcardcon == 'NO_CID')  
            <div class="row mt-2">
                <div class="col"></div>
                <div class="col-xl-6">
                    <img src="{{ asset('images/spsch.jpg') }}" alt="Image" class="img-thumbnail" width="auto;" height="auto;"> 
                </div>   
                <div class="col"></div>
            </div>                           
            @else  
            <div class="row mt-2">
                <div class="col"></div>
                <div class="col-xl-6">
                    <img src="{{ asset('images/spsch.jpg') }}" alt="Image" class="img-thumbnail" width="auto;" height="auto;"> 
                </div>   
                
                @if ($smartcard == 'NO_CONNECT')                    
                @else
                    <div class="col-xl-1 mt-4">   
                        <img class="img-thumbnail" src="data:image/png;base64,{{ $collection12 }}" alt="" width="auto;" height="auto;">
                    </div>
                @endif     
                <div class="col"></div>
            </div>  
                
            @endif
               
            <div class="row mt-2">
                <div class="col"></div>
                <div class="col-xl-10">
                    <div class="card shadow-lg">
                        <div class="card-header">                           
                             Authen Code                            
                        </div>
                        <div class="card-body"> 
                                    @if ($smartcard == 'NO_CONNECT')
                                        <div class="row">
                                            <div class="col"></div>
                                            <div class="col-md-4 text-center">
                                                <img src="http://localhost:8189/assets/images/smartcard-connected.png" alt=""
                                                    width="320px"><br> <br>
                                                <label for="" class="form-label "
                                                    style="color: rgb(197, 8, 33);font-size:30px" >ไม่พบเครื่องอ่านบัตร</label>
                                                <br>
                                            </div>
                                            <div class="col"></div>
                                        </div>
                          
                                    @else
                                            @if ($smartcardcon == 'NO_CID')
                                                <div class="row mt-4">
                                                    <div class="col"></div>
                                                    <div class="col-md-4 text-center">
                                                        <img src="{{ asset('images/card1.jpg') }}" alt="Image"
                                                            class="img-thumbnail shadow-lg" width="320px">
                                                        <br><br>
                                                        <label for="pid" class="form-label"
                                                            style="color: rgb(197, 8, 33);font-size:24px">กรุณาเสียบบัตรประชาชน</label>
                                                        <br>
                                                    </div>
                                                    <div class="col"></div>
                                                </div>
                                            @else
                                            
                                                <form action="{{ route('authencode') }}" method="POST" id="insert_AuthencodeForm">
                                                    @csrf

                                                    <div class="row mt-3">
                                                        <div class="col-md-3 text-end">
                                                            <div class="mb-2">
                                                                <label for="pid" class="form-label">เลขบัตรประชาชน :</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-2">
                                                                <label for="pid" class="form-label"
                                                                    style="color: rgb(197, 8, 33)">{{ $collection1 }}</label>
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
                                                                    style="color: rgb(197, 8, 33)">{{ $collection2 }}
                                                                    {{ $collection3 }}</label>
                                                                <input type="hidden" class="form-control" id="fname"
                                                                    value="{{ $collection2 }}">
                                                                <input type="hidden" class="form-control" id="lname"
                                                                    value="{{ $collection3 }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 text-end">
                                                            <div class="mb-2">
                                                                <label for="mainInscl" class="form-label">สิทธิหลัก :</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-2">
                                                                <label for="mainInscl" class="form-label"
                                                                    style="color: rgb(197, 8, 33)">{{ $collection6 }}</label>
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
                                                                    style="color: rgb(197, 8, 33)">{{ $collection4 }}</label>
                                                                <input type="hidden" class="form-control" id="birthDate"
                                                                    value="{{ $collection4 }}">
                                                            </div>
                                                        </div> 
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 text-end">
                                                            <div class="mb-2">
                                                                <label for="subInscl" class="form-label">สิทธิ์ย่อย :</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-2">
                                                                <label for="subInscl" class="form-label"
                                                                    style="color: rgb(197, 8, 33)">{{ $collection7 }}</label>
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
                                                                    style="color: rgb(197, 8, 33)">{{ $collection8 }}</label>
                                                                <input type="hidden" class="form-control" id="checkDate"
                                                                    value="{{ $collection8 }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr> 

                                                    <div class="row">
                                                        <div class="col-md-3 text-end">
                                                            <div class="mb-2">
                                                                <label for="claimType" class="form-label">เลือกประเภทเข้ารับบริการ
                                                                    :</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div class="mb-2">
                                                                <input class="form-check-input me-3" type="radio"
                                                                    name="claimType" id="claimType" value="PG0060001" checked>
                                                                <label class="form-check-label" for="claimType">
                                                                    เข้ารับบริการรักษาทั่วไป (OPD/ IPD/ PP)
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 text-end">
                                                            <div class="mb-2">
                                                                <label for="mobile" class="form-label">ยืนยันเบอร์โทรศัพท์
                                                                    :</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="mb-2">
                                                                @if ($hometel == '')
                                                                    <input type="text" class="form-control" id="mobile" name="mobile" required style="background-color: rgb(252, 163, 157)">
                                                                @else
                                                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $hometel }}" style="background-color: aquamarine">
                                                                @endif 
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 text-end">
                                                            <div class="mb-2">
                                                                <label for="claimType2" class="form-label"> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div class="mb-2">
                                                                <input class="form-check-input me-3" type="radio"
                                                                    name="claimType" id="claimType2" value="PG0120001">
                                                                <label class="form-check-label" for="claimType2">
                                                                    UCEP PLUS (ผู้ป่วยกลุ่มอาการสีเหลืองและสีแดง)
                                                                </label>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 text-end">
                                                            <div class="mb-2">
                                                                <label for="mobile" class="form-label">HN
                                                                    :</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="mb-2">
                                                                @if ($hn == '')
                                                                    <input type="text" class="form-control" id="hn" name="hn" style="background-color: rgb(252, 163, 157)">
                                                                @else
                                                                    <input type="text" class="form-control" id="hn" name="hn" value="{{ $hn }}" style="background-color: aquamarine">
                                                                @endif 
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 text-end">
                                                            <div class="mb-2">
                                                                <label for="claimType3" class="form-label"> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9 ">
                                                            <div class="mb-2">
                                                                <input class="form-check-input me-3" type="radio"
                                                                    name="claimType" id="claimType3" value="PG0130001">
                                                                <label class="form-check-label" for="claimType3">
                                                                    บริการฟอกเลือดด้วยเครื่องไตเทียม (HD)
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  

                                                    <div class="row">
                                                   
                                                    </div>

                                                    <hr>

                                                    @if ($hn == '')
 
                                                  
                                                    @else 
                                                        <h3 style="color: rgb(10, 119, 221)" class="ms-4">ลงทะเบียนผู้ป่วย</h3>
                                                        <br>
                                                        <div class="row "> 
                                                            <div class="col-md-12"> 
                                                                {{-- <ul class="nav nav-tabs" role="tablist"> --}}
                                                                    {{-- <li class="nav-item">
                                                                        <a class="nav-link active" data-bs-toggle="tab" href="#Narmala" role="tab">
                                                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                                            <span class="d-none d-sm-block">ทั่วไป </span>    
                                                                        </a>
                                                                    </li>    --}}
                                                                    {{-- <li class="nav-item">
                                                                        <a class="nav-link" data-bs-toggle="tab" href="#Narmalb" role="tab">
                                                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                                            <span class="d-none d-sm-block">ทั่วไป 2</span>    
                                                                        </a>
                                                                    </li> --}}
                                                                    {{-- <li class="nav-item">
                                                                        <a class="nav-link" data-bs-toggle="tab" href="#Narmalc" role="tab">
                                                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                                            <span class="d-none d-sm-block">ทั่วไป 3</span>    
                                                                        </a>
                                                                    </li>  --}}
                                                                {{-- </ul>  --}}
                                                                {{-- <div class="tab-content p-3 text-muted"> --}}
                                                                    {{-- <div class="tab-pane active" id="Narmala" role="tabpanel">
                                                                        <p class="mb-0"> --}}
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
                                                                                <div class="col-md-1 text-end"><label for="mobile" class="form-label">CID </label> </div>
                                                                                <div class="col-md-2 mb-2"> 
                                                                                        <input type="text" class="form-control form-control-sm" id="cid" name="cid" value="{{$collection1}}" placeholder="เลขบัตรประชาชน" style="font-size: 13px">
                                                                                    
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
                                                                                        {{-- <label for="mobile" class="form-label">ชาย</label>  --}}
                                                                                        <input type="hidden" class="form-control" id="sex" name="sex" value="1">
                                                                                        <input type="text" class="form-control form-control-sm" id="" name="" value="ชาย">
                                                                                        @else
                                                                                        {{-- <label for="mobile" class="form-label">หญิง</label>  --}}
                                                                                        <input type="hidden" class="form-control" id="sex" name="sex" value="2">
                                                                                        <input type="text" class="form-control form-control-sm" id="" name="" value="หญิง">
                                                                                        @endif  
                                                                                </div>
                                                                                
                                                                            </div>  
                                                                            <div class="row">
                                                                                <div class="col-md-1 text-end">   <label for="province" class="form-label">จังหวัด </label> </div>
                                                                                <div class="col-md-2 mb-2"> 
                                                                                        <select name="province" id="province" class="form-control province" style="width: 100%">
                                                                                            @foreach ($thaiaddress_provine as $item_prov)
                                                                                            <option value="{{$item_prov->chwpart}}">{{$item_prov->name}}</option>
                                                                                            @endforeach 
                                                                                        </select>  
                                                                                </div>
                                                                                <div class="col-md-1 text-end">   <label for="amphur" class="form-label">อำเภอ </label> </div>
                                                                                <div class="col-md-2 mb-2"> 
                                                                                        <select name="amphur" id="amphur" class="form-control amphur" style="width: 100%">
                                                                                            @foreach ($thaiaddress_amphur as $item_amp)
                                                                                            <option value="{{$item_amp->amppart}}">{{$item_amp->name}}</option>
                                                                                            @endforeach 
                                                                                        </select>  
                                                                                </div>
                                                                                <div class="col-md-1 text-end">   <label for="tumbon" class="form-label">ตำบล </label> </div>
                                                                                <div class="col-md-2 mb-2"> 
                                                                                        <select name="tumbon" id="tumbon" class="form-control tumbon" style="width: 100%">
                                                                                            @foreach ($thaiaddress_tumbon as $item_tum)
                                                                                            <option value="{{$item_tum->tmbpart}}">{{$item_tum->name}}</option>
                                                                                            @endforeach 
                                                                                        </select>  
                                                                                </div>
                                                                                <div class="col-md-1 text-end">   <label for="pocode" class="form-label">รหัสไปรษณีย์ </label> </div>
                                                                                <div class="col-md-2 mb-2">    
                                                                                        <select name="pocode" id="pocode" class="form-control pocode" style="width: 100%">
                                                                                            @foreach ($thaiaddress_po_code as $item_po)
                                                                                            <option value="{{$item_po->po_code}}">{{$item_po->po_code}}</option>
                                                                                            @endforeach 
                                                                                         </select> 
                                                                                </div>
                                                                            </div>  
                                                                        {{-- </p>
                                                                    </div> --}}
                                                                    {{-- <div class="tab-pane" id="Narmalb" role="tabpanel">
                                                                        <p class="mb-0"> 
                                                                        </p>
                                                                    </div> --}}
                                                                    {{-- <div class="tab-pane" id="Narmalc" role="tabpanel">
                                                                        <p class="mb-0"> 
                                                                        </p>
                                                                    </div> --}}
                                                                {{-- </div>  --}}
                                                            </div>
                                                        </div> 

                                                        <hr>

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

                                                    @endif

                                                        <input type="hidden" class="form-control" id="hos_guid" name="hos_guid" value="{{ $hos_guid }}">
                                                        <input type="hidden" class="form-control" id="ovst_key" name="ovst_key" value="{{ $ovst_key }}">
                                                        <input type="hidden" class="form-control" id="vn" name="vn" value="{{ $vn }}">
                                                        <input type="hidden" class="form-control" id="hcode" name="hcode" value="{{ $hcode }}"> 
                                                        <input type="hidden" class="form-control" id="time" name="time" value="{{ $time }}">
                                                        
                                                        <hr>
                                                    <div class="row">
                                                        <div class="col"></div>
                                                        <div class="col-md-8">
                                                            <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary shadow-lg"><i
                                                                    class="fa-brands fa-medrt me-2"></i>Authen Code Only</button>
                                                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success shadow-lg" id="OpenVisit"><i class="fa-brands fa-medrt me-2"></i>Authen Code + Visit</button>
                                                            <a href="{{ url('/login') }}" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger shadow-lg"><i
                                                                    class="fa-solid fa-circle-arrow-left me-2"></i>ย้อนกลับ</a> 
                                                        </div> 
                                                    </div>

                                                </form>

                                            @endif
                                
                                    @endif

                        </div>
                        </form>

                    </div>
                </div>
                <div class="col"></div>
            </div>
          
            <div class="row">
                <div class="col"></div>
                <div class="col-sm-3"> 
                    @foreach ($org as $item)   
                            <h6 style="color:rgb(220, 134, 247)" class="mt-2">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> 
                                © {{$item->orginfo_name}}
                            </h6>  
                    @endforeach
                </div>
                <div class="col-sm-3">
                    <div class="text-sm-end d-none d-sm-block">
                        Created with <i class="mdi mdi-heart text-danger"></i> by ทีมพัฒนา
                        
                         <h6 style="color:rgb(220, 134, 247)" class="mt-2"> PK-OFFICER</h6> 
                    </div>
                </div>
                <div class="col"></div>
            </div>
 

    </div>
    <!-- JAVASCRIPT -->
    <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
            $(document).ready(function() {
                $('select').select2();
                // $('#ovstist').select2({
                //     dropdownParent: $('#insertdata')
                // });
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });
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

            });

             //------------------------ จังหวัด ------------------

            $('.province').change(function(){
                    if($(this).val()!=''){
                    var select = $(this).val();
                    var _token=$('input[name="_token"]').val();
                    alert(select);
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
                    alert(select);
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
                    alert(select);
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
