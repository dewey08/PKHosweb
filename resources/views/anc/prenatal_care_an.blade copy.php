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
    <style>
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
                                               
                                                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal {{ $item->an }}">
                                                    <i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i>
                                                    {{ $item->an }}
                                                </button>
                                            <td class="text-start" style="font-size: 13px">{{ $item->hn }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->ptname }}</td>
                                            <td class="text-start" style="font-size: 13px">
                                             
                                                @if ($item->pdx == '')
                                                <div class="badge" style="background: rgb(245, 126, 78)" style="font-size:12px">ว่าง</div>
                                               
                                                @else
                                                {{$item->pdx}}
                                                @endif
                                            </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->regdate }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->dchdate }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->admdate }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->age }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->height }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->bw }}</td>
                                            <td class="text-start" style="font-size: 13px">
                                                {{-- <a href="{{url('prenatal_care_andiag/'.$item->an)}}"> {{ $item->total_diag }}</a>  --}}
                                                <?php 
                                                    $data_sub_ = DB::connection('mysql10')->select('   
                                                            SELECT principal_diagnosis
                                                            ,pre_admission_comorbidity 
                                                            ,if(s.tracheostomy="Y","TRACHEOSTOMY","") as TRACHEOSTOMY
                                                            ,if(s.mechanical_ventilation="Y","MECHANICAL VENTILATION","") as MECHANICAL_VENTILATION  
                                                            ,if(s.mechanical_ventilation1="Y","มากกว่า 96 ชม.","") as ">96hr" 
                                                            ,if(s.mechanical_ventilation2="Y","น้อยกว่า 96 ชม.","") as "<96hr" 
                                                            ,if(s.packed_redcells="Y","PACKED RED CELLS","") as PACKED_RED_CELLS
                                                            ,if(s.fresh_frozen_plasma="Y","PACKED RED CELLS","") as FRESH_FROZEN_PLASMA
                                                            ,if(s.platelets="Y","PLATELETS","") as PLATELETS
                                                            ,if(s.cryoprecipitate="Y","CRYOPRECIPITATE","") as CRYOPRECIPITATE
                                                            ,if(s.whole_blood="Y","Whole Blood","") as whole_blood
                                                            ,if(s.computer_tomography="Y","Computer Tomography","") as Computer_Tomography
                                                            ,s.computer_tomography_text 
                                                            ,if(s.chemotherapy="Y","CHEMOTHERAPY","") as CHEMOTHERAPY
                                                            ,if(s.mri="Y","MRI","") as MRI
                                                            ,if(s.hemodialysis="Y","Hemodialysis","") as Hemodialysis
                                                            ,if(s.non_or_other="Y","อื่น ๆ","") as outers
                                                            ,s.non_or_other_text
                                                            ,s.*
                                                            FROM  kphis.ipd_summary s 
                                                            WHERE an = "'.$item->an.'" 
                                                    ');  
                                                    // SELECT i.icd10,ic.name as iname,ic.tname,i.diagtype FROM iptdiag i
                                                    //         LEFT JOIN  icd101 ic  on  i.icd10=ic.`code`
                                                    //         WHERE i.an="'.$item->an.'"
                                                    //         GROUP BY  i.icd10
                                                    //         ORDER BY i.diagtype  ASC
                                                    //         limit 1000
                                                        // $data_sub_ = DB::connection('mysql')->select('
                                                        //     SELECT * from acc_setpang_type a
                                                        //     LEFT JOIN pttype p ON p.pttype = a.pttype 
                                                        //     WHERE acc_setpang_id = "'.$item->acc_setpang_id.'"');
                
                                                        // $data_subcount_ = DB::connection('mysql')->select('SELECT COUNT(acc_setpang_id) as acc_setpang_id from acc_setpang_type WHERE acc_setpang_id = "'.$item->acc_setpang_id.'"');
                                                        // foreach ($data_subcount_ as $key => $value) {
                                                        //     $data_subcount = $value->acc_setpang_id;
                                                        // }
                                                ?>
                                                {{-- <div id="headingTwo" class="b-radius-0 card-header">
                                                    <button type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne2{{ $item->an }}" aria-expanded="false"
                                                        aria-controls="collapseTwo" class="text-start m-0 p-0 btn btn-link btn-block">
                                                        <h5 style="color: rgb(119, 118, 118)">{{ $item->total_diag }} <label for="" style="color: red"> !! คลิก !!</label></h5> 
                                                    </button>
                                                </div> --}}
                                                {{-- <div data-parent="#accordion" id="collapseOne2{{ $item->an }}" class="collapse">
                                                    <div class="card-body">
                                                        <div class="row ms-3 me-3">
                                                            @foreach ($data_sub_ as $itemsub) 
                                                                    @if ($itemsub->iname != '')
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                                {{ $itemsub->tname }}
                                                                            </label>
                                                                        </div>
                                                                    @else                                                                    
                                                                    @endif  
                                                            @endforeach                                                        
                                                        </div>
                                                    </div>
                                                </div>  --}}
                                            </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->sum_adjrw }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->total_cmi }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->total_noadjre }}</td> 
                                    </tr>

                                     <!-- addicodeModal Modal -->
                                    <div class="modal fade" id="exampleModal{{$item->an}}"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content ">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">รายการขอปรับเปลี่ยนผังบัญชี</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    </button>
                                                </div>
                                                <div class="modal-body"> 
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="pang" class="form-label">รหัสผังบัญชี</label>
                                                                <div class="input-group input-group-sm"> 
                                                                    <input type="text" class="form-control" id="account_code" name="account_code" readonly>  
                                                                </div>
                                                            </div>  
                                                            <div class="col-md-3">
                                                                <label for="pangname" class="form-label">vn</label>
                                                                <div class="input-group input-group-sm"> 
                                                                    <input type="text" class="form-control" id="vn" name="vn" readonly>  
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-2">
                                                                <label for="pangname" class="form-label">an</label>
                                                                <div class="input-group input-group-sm"> 
                                                                    <input type="text" class="form-control" id="an" name="an" readonly>  
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-2">
                                                                <label for="pangname" class="form-label">hn</label>
                                                                <div class="input-group input-group-sm"> 
                                                                    <input type="text" class="form-control" id="hn" name="hn" readonly>  
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-2">
                                                                <label for="pangname" class="form-label">vstdate</label>
                                                                <div class="input-group input-group-sm"> 
                                                                    <input type="date" class="form-control" id="vstdate" name="vstdate" readonly>  
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <label for="pang" class="form-label">ชื่อ-นาสกุล</label>
                                                                <div class="input-group input-group-sm"> 
                                                                    <input type="text" class="form-control" id="ptname" name="ptname" readonly>  
                                                                </div>
                                                            </div>  
                                                            <div class="col-md-3">
                                                                <label for="pang" class="form-label">cid</label>
                                                                <div class="input-group input-group-sm"> 
                                                                    <input type="text" class="form-control" id="cid" name="cid" readonly>  
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-2">
                                                                <label for="pangname" class="form-label">pttype</label>
                                                                <div class="input-group input-group-sm"> 
                                                                    <input type="text" class="form-control" id="pttype" name="pttype" readonly>  
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-2">
                                                                <label for="pangname" class="form-label">ลูกหนี้</label>
                                                                <div class="input-group input-group-sm"> 
                                                                    <input type="text" class="form-control" id="debit_total" name="debit_total" readonly>  
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-2">
                                                                <label for="pangname" class="form-label">dchdate</label>
                                                                <div class="input-group input-group-sm"> 
                                                                    <input type="date" class="form-control" id="dchdate" name="dchdate" readonly>  
                                                                </div>
                                                            </div>
                                                        </div> 
                                        
                                                        <hr style="color: red">

                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <label for="pang" class="form-label" style="color: red">ผังบัญชีใหม่</label>
                                                                <div class="input-group input-group-sm"> 
                                                                    <input type="text" class="form-control" id="account_code_new" name="account_code_new" >  
                                                                </div>
                                                            </div>  
                                                            <div class="col-md-3">
                                                                <label for="pangname" class="form-label" style="color: red">สิทธิ์ใหม่</label>
                                                                <div class="input-group input-group-sm"> 
                                                                    <input type="text" class="form-control" id="pttype_new" name="pttype_new" >  
                                                                </div>
                                                            </div> 
                                                            
                                                            
                                                        </div> 
                                                        
                                                    <input type="hidden" name="user_id" id="adduser_id"> 
                                                    <input type="hidden" name="acc_debtor_id" id="acc_debtor_id"> 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Updatedata">
                                                        <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                                                    </button>
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

@endsection
@section('footer')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

    <script>
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
    </script>

@endsection
