@extends('layouts.anc')
@section('title', 'PK-OFFICER || ANC')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>

    <?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
        $tel_ = Auth::user()->tel;
        $debsubsub = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    $datenow = date('Y-m-d');
    $y = date('Y') + 544;
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\SoteController;
    $refnumber = SoteController::refnumber();
    ?>
    {{-- <style>
        body {
            font-family: sans-serif;
            font: normal;
            font-style: normal;
        }

        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
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
            border: 5px #ddd solid;
            border-top: 10px #12c6fd solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style> --}}
    <style>
        .modal-dialog {
            max-width: 75%;
        }

        .modal-dialog-slideout {
            min-height: 100%;
            margin: 0 0 0 auto;
            background: #fff;
        }

        .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(1);
            transform: translate(100%, 0)scale(1);
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
            display: flex;
            align-items: stretch;
            -webkit-box-align: stretch;
            height: 100%;
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
        }

        .modal-dialog-slideout .modal-content {
            border: 0;
        }

        .modal-dialog-slideout .modal-header,
        .modal-dialog-slideout .modal-footer {
            height: 4rem;
            display: block;
        }
    </style>
    <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>
        <form action="{{ url('prenatal_care') }}" method="GET">
            @csrf
            <div class="row ">
                <div class="col-md-3">
                    <h4 class="card-title">รายละเอียดข้อมูล </h4>
                    {{-- <p class="card-title-desc">รายละเอียดข้อมูล </p> --}}
                </div>
                <div class="col"></div>
                 

            </div>
        </form>


        <div class="row mt-2">
            <div class="col-md-12">
                <div class="main-card card p-2">

                    <table id="example" class="table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">an</th>
                                <th class="text-center">hn</th>
                                <th class="text-center">ptname</th>
                                <th class="text-center">pdx</th>
                                <th class="text-center">regdate</th>
                                <th class="text-center">dchdate</th>
                                <th class="text-center">admdate</th>
                                <th class="text-center">age</th>
                                <th class="text-center">height</th>
                                <th class="text-center">bw</th>
                                <th class="text-center">total_diag</th>
                                <th class="text-center">sum_adjrw</th>
                                <th class="text-center">total_cmi</th>
                                <th class="text-center">total_noadjre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number = 0;
                            $total1 = 0; ?>
                            @foreach ($data_anc as $item)
                                <?php $number++; ?>
                                <tr id="#sid{{ $item->an }}">
                                    <td class="text-center text-muted">{{ $number }}</td>
                                    <td class="text-start" style="font-size: 13px">
                                        {{-- <a href="{{url('prenatal_care_ankph/'.$item->an)}}"> {{ $item->an }}</a> --}}

                                        {{-- <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    <i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i>
                                                    {{ $item->an }}
                                                </button> --}}
                                                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#ModalSlide{{$item->an}}" >{{$item->an}}</button>
                                        {{-- <button type="button" class="btn btn-demo" data-toggle="modal"
                                            data-target="#ModalSlide">
                                            {{ $item->an }}
                                        </button> --}}
                                    <td class="text-start" style="font-size: 13px">{{ $item->hn }}</td>
                                    <td class="text-start" style="font-size: 13px">{{ $item->ptname }}</td>
                                    <td class="text-start" style="font-size: 13px">

                                        @if ($item->pdx == '')
                                            <div class="badge" style="background: rgb(245, 126, 78)"
                                                style="font-size:12px">ว่าง</div>
                                        @else
                                            {{ $item->pdx }}
                                        @endif
                                    </td>
                                    <td class="text-start" style="font-size: 13px">{{ $item->regdate }}</td>
                                    <td class="text-start" style="font-size: 13px">{{ $item->dchdate }}</td>
                                    <td class="text-start" style="font-size: 13px">{{ $item->admdate }}</td>
                                    <td class="text-start" style="font-size: 13px">{{ $item->age }}</td>
                                    <td class="text-start" style="font-size: 13px">{{ $item->height }}</td>
                                    <td class="text-start" style="font-size: 13px">{{ $item->bw }}</td>
                                    <td class="text-start" style="font-size: 13px">
                                        <?php
                                        $data_sub_ = DB::connection('mysql10')->select( '   
                                                SELECT 
                                                    principal_diagnosis ,pre_admission_comorbidity,post_admission_comorbidity,other_diagnosis
                                                    ,tracheostomy  as TRACHEOSTOMY
                                                    ,mechanical_ventilation as MECHANICAL_VENTILATION  
                                                    ,mechanical_ventilation1 as MECHANICAL_VENTILATION1
                                                    ,mechanical_ventilation2 as MECHANICAL_VENTILATION2
                                                    ,packed_redcells as PACKED_RED_CELLS
                                                    ,fresh_frozen_plasma as FRESH_FROZEN_PLASMA
                                                    ,platelets as PLATELETS
                                                    ,cryoprecipitate as CRYOPRECIPITATE
                                                    ,whole_blood  as WHOLE_BLOOD
                                                    ,computer_tomography as COMPUTER_TOMOGRAPHY
                                                    ,computer_tomography_text 
                                                    ,chemotherapy  as CHEMOTHERAPY
                                                    ,mri as MRI
                                                    ,hemodialysis as HEMODIALYSIS
                                                    ,non_or_other as OTHER
                                                    ,non_or_other_text
                                              
                                                FROM kphis.ipd_summary s 
                                                WHERE an = "'.$item->an.'" 
                                        ');
                                        $icd_ = DB::connection('mysql10')->select( '
                                            SELECT a.an,o.icd10 DIAG,i.name as name_eng,i.tname as name_th,o.diagtype DXTYPE  
                                                FROM an_stat a
                                                LEFT OUTER JOIN iptdiag o on o.an = a.an 
                                                INNER JOIN icd101 i on i.code = o.icd10 
                                                WHERE a.an = "'.$item->an.'" 
                                        ');   
                                                 
                                        ?>
                                    </td>
                                    <td class="text-start" style="font-size: 13px">{{ $item->sum_adjrw }}</td>
                                    <td class="text-start" style="font-size: 13px">{{ $item->total_cmi }}</td>
                                    <td class="text-start" style="font-size: 13px">{{ $item->total_noadjre }}</td>
                                </tr>
 
                                <div class="modal fade" id="ModalSlide{{$item->an}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-slideout" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title align-right" id="exampleModalLabel">AN.{{$item->an}} || HN.{{$item->hn}} || ชื่อ-นามสกุล {{$item->ptname}} || PDX.{{$item->pdx}} ||
                                        AGE {{$item->age}} || HEIGHT {{$item->height}} || BW {{$item->bw}} || SUM ADJRW {{$item->sum_adjrw}} || TOTAL CMI {{$item->total_cmi}}
                                        </h5>
                                  
                                        </div>
                                        <div class="modal-body">
                                                        <div class="row ">
                                                            <div class="col"></div> 
                                                            <div class="col-md-3"><h3>โรคที่บันทึกใน HOSXP</h3></div> 
                                                            <div class="col"></div>
                                                        </div>

                                                        <div class="row Head1 mt-3">
                                                            <div class="col"></div>
                                                            <div class="col-md-1">รหัสโรค</div>
                                                            <div class="col-md-4">ชื่อโรค EN</div>
                                                            <div class="col-md-4">ชื่อโรคไทย</div>
                                                            <div class="col-md-1">Type</div>
                                                            <div class="col"></div>
                                                        </div>
                                                        <hr>
                                            <?php $j = 0; $total1 = 0; ?>
                                                @foreach ($icd_ as $item_icd)
                                                    <?php $j++; ?>
                                                        
                                                        <div class="row detail">
                                                            <div class="col"></div>
                                                            <div class="col-md-1">{{ $item_icd->DIAG }}</div>
                                                            <div class="col-md-4">{{ $item_icd->name_eng }}</div>
                                                            <div class="col-md-4">{{ $item_icd->name_th }}</div>
                                                            <div class="col-md-1">{{ $item_icd->DXTYPE }}</div>
                                                            <div class="col"></div>
                                                        </div>
                                                        <hr>
                                                @endforeach
                                                    
                                           <br>  
                                            <div class="row mt-4">
                                                <div class="col-12">

                                                    @foreach ($data_sub_ as $item_s)
                                                
                                                        
                                                            <div class="form-check"> 
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 17px;">principal diagnosis : </label> 
                                                                @if ($item_s->principal_diagnosis =='')
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 16px;color:coral">Null </label> <label class="form-check-label" for="" style="font-size: 18px;color:rgb(255, 80, 124)"><B>||</B> </label>
                                                                @else
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 16px;color:coral">{{ $item_s->principal_diagnosis }} </label> <label class="form-check-label" for="" style="font-size: 18px;color:rgb(255, 80, 124)"><B>||</B> </label>
                                                                @endif
                                                                

                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 17px;">pre admission comorbidity : </label> 
                                                                @if ($item_s->pre_admission_comorbidity == '')
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 16px;color:coral">Null</label> <label class="form-check-label" for="" style="font-size: 18px;color:rgb(255, 80, 124)"><B>||</B> </label>
                                                                @else
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 16px;color:coral">{{ $item_s->pre_admission_comorbidity }} </label> <label class="form-check-label" for="" style="font-size: 18px;color:rgb(255, 80, 124)"><B>||</B> </label>
                                                                @endif
                                                                

                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 17px;">post admission comorbidity : </label> 
                                                                @if ($item_s->post_admission_comorbidity =='')
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 16px;color:coral">Null</label> <label class="form-check-label" for="" style="font-size: 18px;color:rgb(255, 80, 124)"><B>||</B> </label>
                                                                @else
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 16px;color:coral">{{ $item_s->post_admission_comorbidity }} </label> <label class="form-check-label" for="" style="font-size: 18px;color:rgb(255, 80, 124)"><B>||</B> </label>
                                                                @endif
                                                            

                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 17px;">other diagnosis : </label> 
                                                                @if ($item_s->other_diagnosis =='')
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 16px;color:coral">Null </label>
                                                                @else
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 16px;color:coral">{{ $item_s->other_diagnosis }} </label>
                                                                @endif
                                                            
                                                            </div>
                                                            
                                                                
                                                            @if ($item_s->TRACHEOSTOMY == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="TRACHEOSTOMY" checked>
                                                                    <label class="form-check-label" for="TRACHEOSTOMY"> TRACHEOSTOMY </label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="TRACHEOSTOMY">
                                                                    <label class="form-check-label" for="TRACHEOSTOMY"> TRACHEOSTOMY </label>
                                                                </div>
                                                            @endif  

                                                            @if ($item_s->MECHANICAL_VENTILATION == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="MECHANICAL_VENTILATION" checked>
                                                                    <label class="form-check-label" for="MECHANICAL_VENTILATION">MECHANICAL VENTILATION </label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="MECHANICAL_VENTILATION">
                                                                    <label class="form-check-label" for="MECHANICAL_VENTILATION"> MECHANICAL VENTILATION </label>
                                                                </div>
                                                            @endif  

                                                            @if ($item_s->MECHANICAL_VENTILATION1 == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="MECHANICAL_VENTILATION1" checked>
                                                                    <label class="form-check-label" for="MECHANICAL_VENTILATION1">มากกว่า 96 ชม.</label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="MECHANICAL_VENTILATION1">
                                                                    <label class="form-check-label" for="MECHANICAL_VENTILATION1"> มากกว่า 96 ชม. </label>
                                                                </div>
                                                            @endif  

                                                            @if ($item_s->MECHANICAL_VENTILATION2 == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="MECHANICAL_VENTILATION2" checked>
                                                                    <label class="form-check-label" for="MECHANICAL_VENTILATION2">น้อยกว่า 96 ชม.</label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="MECHANICAL_VENTILATION2">
                                                                    <label class="form-check-label" for="MECHANICAL_VENTILATION2"> น้อยกว่า 96 ชม. </label>
                                                                </div>
                                                            @endif  

                                                            @if ($item_s->PACKED_RED_CELLS == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="PACKED_RED_CELLS" checked>
                                                                    <label class="form-check-label" for="PACKED_RED_CELLS">PACKED RED CELLS</label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="PACKED_RED_CELLS">
                                                                    <label class="form-check-label" for="PACKED_RED_CELLS">PACKED RED CELLS</label>
                                                                </div>
                                                            @endif 

                                                            @if ($item_s->FRESH_FROZEN_PLASMA == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="FRESH_FROZEN_PLASMA" checked>
                                                                    <label class="form-check-label" for="FRESH_FROZEN_PLASMA">FRESH FROZEN PLASMA</label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="FRESH_FROZEN_PLASMA">
                                                                    <label class="form-check-label" for="FRESH_FROZEN_PLASMA">FRESH FROZEN PLASMA</label>
                                                                </div>
                                                            @endif 

                                                            @if ($item_s->PLATELETS == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="PLATELETS" checked>
                                                                    <label class="form-check-label" for="PLATELETS">PLATELETS</label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="PLATELETS">
                                                                    <label class="form-check-label" for="PLATELETS">PLATELETS</label>
                                                                </div>
                                                            @endif 

                                                            @if ($item_s->CRYOPRECIPITATE == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="CRYOPRECIPITATE" checked>
                                                                    <label class="form-check-label" for="CRYOPRECIPITATE">CRYOPRECIPITATE</label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="CRYOPRECIPITATE">
                                                                    <label class="form-check-label" for="CRYOPRECIPITATE">CRYOPRECIPITATE</label>
                                                                </div>
                                                            @endif 

                                                            @if ($item_s->WHOLE_BLOOD == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="WHOLE_BLOOD" checked>
                                                                    <label class="form-check-label" for="WHOLE_BLOOD">WHOLE BLOOD</label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="WHOLE_BLOOD">
                                                                    <label class="form-check-label" for="WHOLE_BLOOD">WHOLE BLOOD</label>
                                                                </div>
                                                            @endif 

                                                            @if ($item_s->COMPUTER_TOMOGRAPHY == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="COMPUTER_TOMOGRAPHY" checked>
                                                                    <label class="form-check-label" for="COMPUTER_TOMOGRAPHY">COMPUTER TOMOGRAPHY </label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="COMPUTER_TOMOGRAPHY">
                                                                    <label class="form-check-label" for="COMPUTER_TOMOGRAPHY">COMPUTER TOMOGRAPHY</label>
                                                                </div>
                                                            @endif 

                                                            <div class="form-check"> 
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 17px;">computer_tomography_text : </label> 
                                                                @if ($item_s->computer_tomography_text =='')
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 16px;color:coral">Null </label>
                                                                @else
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 16px;color:coral">{{ $item_s->computer_tomography_text }} </label>
                                                                @endif
                                                            </div>

                                                            @if ($item_s->CHEMOTHERAPY == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="CHEMOTHERAPY" checked>
                                                                    <label class="form-check-label" for="CHEMOTHERAPY">CHEMOTHERAPY </label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="CHEMOTHERAPY">
                                                                    <label class="form-check-label" for="CHEMOTHERAPY">CHEMOTHERAPY</label>
                                                                </div>
                                                            @endif 

                                                            @if ($item_s->MRI == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="MRI" checked>
                                                                    <label class="form-check-label" for="MRI">MRI</label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="MRI">
                                                                    <label class="form-check-label" for="MRI">MRI</label>
                                                                </div>
                                                            @endif 

                                                            @if ($item_s->HEMODIALYSIS == 'Y')
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="HEMODIALYSIS" checked>
                                                                    <label class="form-check-label" for="HEMODIALYSIS">HEMODIALYSIS</label>
                                                                </div>
                                                            @else 
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="HEMODIALYSIS">
                                                                    <label class="form-check-label" for="HEMODIALYSIS">HEMODIALYSIS</label>
                                                                </div>
                                                            @endif 
                                                        
                                                            @if ($item_s->OTHER == 'Y' )
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="other" checked>
                                                                    <label class="form-check-label" for="other"> อื่น ๆ </label>
                                                                </div>
                                                            @else
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="other" >
                                                                    <label class="form-check-label" for="other"> อื่น ๆ </label>
                                                                </div>
                                                            @endif
                                                            <div class="form-check"> 
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 17px;">non_or_other_text : </label> 
                                                                @if ($item_s->non_or_other_text =='')
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 16px;color:coral">Null </label>
                                                                @else
                                                                <label class="form-check-label" for="principal_diagnosis" style="font-size: 16px;color:coral">{{ $item_s->non_or_other_text }} </label>
                                                                @endif
                                                            </div>

                                                            
                                                                
                                                        
                                                    @endforeach
                                                         
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger me-2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark me-2"></i>Close</button>
                                           
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                            @endforeach


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

 

    <!-- Modal -->
    {{-- <div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel2">Right Sidebar</h4>
                </div>

                <div class="modal-body">
                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                        wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                        eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                        assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt
                        sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                        farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                        labore sustainable VHS.
                    </p>
                </div>

            </div> 
        </div> 
    </div>  --}}

@endsection
@section('footer')
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js">
    </script> --}}

    {{-- <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('select').select2();
            // dabyear

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var ctx = document.getElementById("Mychart").getContext("2d");

            fetch("{{ route('anc.prenatal_care_bar') }}")
                .then(response => response.json())
                .then(json => {
                    const Mychart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: json.labels,
                            datasets: json.datasets,

                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        },
                        plugins: [ChartDataLabels],
                    })
                });



        });
    </script> --}}

@endsection
