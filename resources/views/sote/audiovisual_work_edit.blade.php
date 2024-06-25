@extends('layouts.userdashboard')
@section('title', 'PK-OFFICER || Sot')
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
    use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SoteController; 
$refnumber = SoteController::refnumber();
    ?>
    <style>
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
    
        .is-hide {
            display: none;
        }
        .modal-dis {
            width: 1350px;
            margin: auto;
        }
        @media (min-width: 1200px) {
            .modal-xlg {
                width: 90%; 
            }
        }
    </style>
    <div class="tabs-animation">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>

        </div>

        <form action="{{ route('user.audiovisual_work_update') }}" method="POST">
            @csrf          
                <div class="row mt-2">
                    <div class="col"></div>
                    <div class="col-md-8">
                        <div class="card card_user_4 p-2">
                            <div class="card-header">  
                                <h5 class="modal-title me-3" id="editModalLabel">แก้ไขรายละเอียดการขอใช้บริการ</h5>  
                                <div class="btn-actions-pane-right">   
                                <h6 class="mt-2 me-3"> เลขที่ {{$dataedit->billno}}</h6> 
                            </div>  
                            </div>                 
                            <div class="card-body"> 
                                <div class="row"> 
                                    <div class="col-md-6">
                                        <label for="ptname" class="form-label">ชื่อ-นามสกุล</label><label for="tel" class="form-label" style="color: red">*</label>
                                        <div class="input-group input-group-sm">  
                                            <select class="form-control" id="ptname" name="ptname" style="width: 100%">
                                                @foreach ($users as $item)
                                                @if ($dataedit->ptname == $item->id)
                                                <option value="{{$item->id}}" selected>{{$item->fname}} {{$item->lname}}</option>
                                                @else
                                                <option value="{{$item->id}}">{{$item->fname}} {{$item->lname}}</option>
                                                @endif                                            
                                                @endforeach
                                            </select>
                                        
                                        </div>
                                    </div>  
                                    <div class="col-md-2">
                                        <label for="tel" class="form-label"> เบอร์โทร</label><label for="tel" class="form-label" style="color: red">*</label>
                                        <div class="input-group input-group-sm">  
                                        
                                                <input type="text" class="form-control" id="tel" name="tel" value="{{ $dataedit->tel}}">   
                                            
                                        </div>
                                    </div> 
                                    <div class="col-md-2">
                                        <label for="work_order_date" class="form-label" >วันที่สั่งงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                        <div class="input-group input-group-sm"> 
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                            <input type="text" class="form-control" name="work_order_date" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' autocomplete="off"
                                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $dataedit->work_order_date}}"/>
                                        </div> 
                                        </div>
                                    </div> 
                                    <div class="col-md-2">
                                        <label for="job_request_date" class="form-label" >วันที่ขอรับงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                        <div class="input-group input-group-sm"> 
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                            <input type="text" class="form-control" name="job_request_date" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' autocomplete="off"
                                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $dataedit->job_request_date}}"/> 
                                        </div>
                                        </div>
                                    </div>  
                                </div>
                                <div class="row mt-2"> 
                                    <div class="col-md-6">
                                        <label for="department" class="form-label">หน่วยงาน</label><label for="tel" class="form-label" style="color: red">*</label>
                                        <div class="input-group input-group-sm">  
                                            <select class="form-control" id="department" name="department" style="width: 100%">
                                                @foreach ($department_sub_sub as $item2)
                                                @if ($dataedit->department == $item2->DEPARTMENT_SUB_SUB_ID)
                                                <option value="{{$item2->DEPARTMENT_SUB_SUB_ID}}" selected>{{$item2->DEPARTMENT_SUB_SUB_NAME}} </option>
                                                @else
                                                <option value="{{$item2->DEPARTMENT_SUB_SUB_ID}}"> {{$item2->DEPARTMENT_SUB_SUB_NAME}}</option>
                                                @endif                                            
                                                @endforeach
                                            </select>
                                        
                                        </div>
                                    </div>  
                                    <div class="col-md-4">
                                        <label for="audiovisual_type" class="form-label" >ชนิดของงาน</label><label for="tel" class="form-label" style="color: red">*</label>
                                        <div class="input-group input-group-sm">  
                                            <select class="form-control" id="audiovisual_type" name="audiovisual_type" style="width: 100%">
                                                @foreach ($audiovisual_type as $item3)  
                                                @if ($dataedit->audiovisual_type == $item3->audiovisual_type_id)
                                                <option value="{{$item3->audiovisual_type_id}}" selected> {{$item3->audiovisual_typename}}</option> 
                                                @else
                                                <option value="{{$item3->audiovisual_type_id}}"> {{$item3->audiovisual_typename}}</option> 
                                                @endif
                                                
                                                @endforeach
                                            </select>
                                        
                                        </div>
                                    </div>   
                                    <div class="col-md-2">
                                        <label for="lineid" class="form-label" >ไอดีไลน์</label><label for="tel" class="form-label" style="color: red">*</label>
                                        <div class="input-group input-group-sm"> 
                                            <input type="text" class="form-control" id="lineid" name="lineid" value="{{$dataedit->lineid}}">  
                                        </div>
                                    </div> 
                                </div>  

                                <div class="row mt-2"> 
                                    <div class="col-md-10">
                                        <label for="audiovisual_name" class="form-label" >ชื่อชิ้นงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                        <div class="input-group input-group-sm"> 
                                            <input type="text" class="form-control" id="audiovisual_name" name="audiovisual_name" value="{{$dataedit->audiovisual_name}}">  
                                        </div>
                                    </div>  
                                    
                                    <div class="col-md-2">
                                        <label for="audiovisual_qty" class="form-label" >จำนวนชิ้นงาน</label>
                                        <div class="input-group input-group-sm"> 
                                            <input type="text" class="form-control" id="audiovisual_qty" name="audiovisual_qty" value="{{$dataedit->audiovisual_qty}}">  
                                        </div>
                                    </div>  
                                </div> 
                                <div class="row mt-2"> 
                                    <div class="col-md-12">
                                        <label for="audiovisual_detail" class="form-label" >รายละเอียดงาน (เช่นขนาดงาน สถานที่ )</label><label for="tel" class="form-label" style="color: red">*</label>
                                        <div class="input-group input-group-sm"> 
                                            <textarea id="audiovisual_detail" name="audiovisual_detail" cols="30" rows="3" class="form-control form-control-sm" >{{$dataedit->audiovisual_detail}}</textarea> 
                                        </div>
                                    </div>  
                             
                                </div> 
                            </div>
                            <input type="hidden" id="audiovisual_id" name="audiovisual_id" value="{{$dataedit->audiovisual_id}}">
                            <div class="card-footer">
                                <div class="btn-actions-pane-right">
                                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Updatedata">
                                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Update changes
                                </button>
                                <a href="{{ url('audiovisual_work') }}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger me-2">
                                    <i class="fa-solid fa-xmark me-2"></i>
                                Back
                            </a>
                            </div>
                            </div>
                        </div>   
                    </div> 
                    <div class="col"></div>
                </div>

        </form>
    </div>
    
@endsection
@section('footer')


    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            // collapseTwo
            $('select').select2();
              
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
            $("#spinner-div").hide(); //Request is complete so hide spinner
  

            $('#Updatedata').click(function() {
                var ptname             = $('#ptname').val();
                var tel                = $('#tel').val();
                var work_order_date    = $('#datepicker').val();
                var job_request_date   = $('#datepicker2').val();
                var department         = $('#department').val();
                var audiovisual_type   = $('#audiovisual_type').val();
                var audiovisual_name   = $('#audiovisual_name').val();
                var audiovisual_qty    = $('#audiovisual_qty').val();
                var audiovisual_detail = $('#audiovisual_detail').val();
                var audiovisual_id     = $('#audiovisual_id').val();
                var lineid             = $('#lineid').val();
                $.ajax({
                    url: "{{ route('user.audiovisual_work_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        ptname, tel,work_order_date, job_request_date,department,audiovisual_type,audiovisual_name,audiovisual_qty,audiovisual_detail,audiovisual_id,lineid
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                position: "top-end",
                                title: 'แก้ไขข้อมูลสำเร็จ',
                                text: "You Update data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                        window.location="{{url('audiovisual_work')}}";
                                    // window.location
                                    //     .reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });

        });
    </script>

@endsection
