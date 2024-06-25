@extends('layouts.medicalslide')
@section('title', 'PK-OFFICER || เครื่องมือแพทย์')
 
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
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;

    date_default_timezone_set('Asia/Bangkok');
    $date = date('Y') + 543;
    $datefull = date('Y-m-d H:i:s');
    $time = date("H:i:s");
    $loter = $date.''.$time

    ?>
        <style>
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
                   .is-hide{
                   display:none;
                   }
        </style>
       <div class="container-fluid">
            <div id="preloader">
                <div id="status">
                    <div class="spinner">
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <h4 class="card-title">Detail Medical</h4>
                    <p class="card-title-desc">รายละเอียดคลังเครื่องมือแพทย์</p>
                </div>
                <div class="col"></div>
                <div class="col-md-2 text-end">
                    {{-- <button class="btn btn-secondary" id="Changbillitems"><i class="fa-solid fa-wand-magic-sparkles me-3"></i>รับเข้าคลัง</button>  --}}
                    <button type="button" style="font-size: 17px" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#insertdata"><i class="fa-solid fa-wand-magic-sparkles me-3"></i>รับเข้าคลัง</button>
                </div>
            </div>
            <div class="row "> 
                {{-- <div class="card">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>รูปภาพ</th>
                                    <th>เลขครุภัณฑ์</th>
                                    <th>ชื่อครุภัณฑ์</th>
                                    <th>หน่วยงาน</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($article_data as $item) 
                                    <tr style="font-size: 12px;" id="sid{{$item->article_id }}">  
                                    <td width="5%">{{ $i++ }}</td>
                                    <td width="10%">
                                        @if ( $item->article_img == Null )
                                        <img src="{{asset('assets/images/default-image.jpg')}}" height="50px" width="50px" alt="Image" class="img-thumbnail">
                                        @else
                                        <img src="{{asset('storage/article/'.$item->article_img)}}" height="50px" width="50px" alt="Image" class="img-thumbnail">                                 
                                        @endif 
                                    </td>
                                    <td class="text-start">{{ $item->article_num }}</td>
                                    <td class="text-start">{{ $item->article_name }}</td>
                                    <td class="text-start">{{ $item->article_deb_subsub_name }}</td>
                                    <td class="text-start">{{ $item->article_deb_subsub_name }}</td>
                                   
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> --}}
                @foreach ($medical_typecat as $item)
                        <div class="col-lg-12 col-xl-4">
                            <div class="main-card mb-3 card">
                                <div class="grid-menu-col">
                                    <div class="g-0 row">
                                        
                                        <div class="col-sm-12">
                                            <div class="widget-chart widget-chart-hover">
                                                <div class="icon-wrapper rounded-circle" >
                                                    <div class="icon-wrapper-bg bg-primary"></div>
                                                    @if ( $item->img == Null )
                                                    <img src="{{asset('assets/images/default-image.jpg')}}" height="50px" width="auto;" alt="Image" class="img-thumbnail">
                                                    @else
                                                    <img src="{{asset('storage/article/'.$item->img)}}" height="50px" alt="Image" class="img-thumbnai">                                 
                                                    @endif 
                                                </div>
                                                <div class="widget-numbers"> <label for="" style="color: red;font-size:17px">{{$item->medical_typecatname}}</label></div>
                                              
                                                    {{-- <div class="row"> 
                                                        <div class="col-md-2">
                                                            <a href="{{url('medical_stock/'.$item->medical_typecat_id)}}" class="btn btn-outline-danger btn-sm me-4" style="font-size: 17px">คลัง</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a href="{{url('medical_store_borrow/'.$item->medical_typecat_id)}}" class="btn btn-outline-info btn-sm ms-4 me-3" style="font-size: 17px">ยืม</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a href="{{url('medical_store_night/'.$item->medical_typecat_id)}}" class="btn btn-outline-success btn-sm ms-5" style="font-size: 17px">คืน</a>
                                                        </div>
                                                       
                                                    </div> --}}
                                                    
                                                <div class="widget-description ">
                                                    <?php 
                                                    
                                                     $dataqty = DB::connection('mysql')->select('   
                                                        SELECT SUM(qty) as Totalqty FROM medical_stock
                                                        WHERE medical_typecat_id="'.$item->medical_typecat_id.'"
                                                    ');
                                                     ?>
                                                    <div class="row">
                                                        <div class="col-lg-4 text-danger"> 
                                                            @foreach ($dataqty as $itemc)
                                                            @if ($itemc->Totalqty > 0)
                                                            <a class="btn btn-outline-danger btn-sm position-relative me-4 mt-3" href="">
                                                               คลัง
                                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" >
                                                                    {{$itemc->Totalqty}}
                                                                    <span class="visually-hidden">unread messages</span>
                                                                </span>
                                                            </a> 
                                                            {{-- <span class="ps-1">
                                                                <a class="btn btn-outline-danger btn-sm me-4" style="font-size: 17px">{{$itemc->Totalqty}}</a>
                                                            </span> --}}
                                                            {{-- <a href="{{url('medical_stock/'.$item->medical_typecat_id)}}" class="btn btn-outline-danger btn-sm me-4" style="font-size: 17px">คลัง</a> --}}
                                                            @else
                                                            {{-- <span class="ps-1">0</span> --}}
                                                            <a class="btn btn-outline-danger btn-sm position-relative me-4 mt-3" href="">
                                                                คลัง
                                                                 <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" >
                                                                     0
                                                                     <span class="visually-hidden">unread messages</span>
                                                                 </span>
                                                             </a> 
                                                            @endif
                                                            
                                                            @endforeach
                                                           
                                                           
                                                        </div>
                                                        <div class="col-lg-4 text-info"> 
                                                            <span class="ps-1">175</span>
                                                        </div>
                                                        <div class="col-lg-4 text-success"> 
                                                            <span class="ps-1">240</span>
                                                        </div>
                                                    </div>   
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                @endforeach 
            </div>
            <div class="row ">
                <div class="card">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">วันที่</th>
                                    <th class="text-center">คลัง</th>
                                    <th class="text-center">ผู้รับ</th> 
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datarep as $item) 
                                    <tr style="font-size: 13px;" id="sid{{$item->medical_store_rep_id }}">  
                                    <td width="5%">{{ $i++ }}</td> 
                                    <td class="text-center" width="10%">{{ $item->date_rep }}</td>
                                    <td class="text-start">{{ $item->medical_typecatname }}</td>
                                    <td class="text-start" width="15%">{{ $item->fname }} {{ $item->lname }}</td> 
                                    <td class="text-start" width="10%">{{ $item->active }}</td>
                                    <td width="10%">
                                        <div class="btn-group">
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                ทำรายการ 
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item text-info"
                                                    href="{{ url('med_store_add/'.$item->medical_store_rep_id)}}"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    data-bs-custom-class="custom-tooltip" title="เพิ่มรายการ">
                                                    <i class="fa-solid fa-plus me-2"></i>
                                                    <label for=""
                                                        style="color: rgb(6, 176, 117);font-size:13px">เพิ่มรายการ</label>
                                                </a>
                                                <a class="dropdown-item text-warning"
                                                href="{{ url('medical/med_con_edit/'.$item->medical_typecat_id)}}"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                <i class="fa-solid fa-pen-to-square me-2"></i>
                                                <label for=""
                                                    style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                            </a>

                                                {{-- <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                    onclick="med_condestroy({{ $item->medical_typecat_id }})"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                    <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                    <label for=""
                                                        style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                </a> --}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

         <!--  Modal content for the insert example -->
         <div class="modal fade" id="insertdata" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">เปิดบิล</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="year">ปีงบ :</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select id="year" name="year"
                                        class="form-control" style="width: 100%">
                                        <option value="">--เลือก--</option>
                                        @foreach ($budget_year as $ye)
                                            @if ($ye->leave_year_id == $date)
                                                <option value="{{ $ye->leave_year_id }}" selected> {{ $ye->leave_year_id }} </option>
                                            @else
                                                <option value="{{ $ye->leave_year_id }}"> {{ $ye->leave_year_id }} </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="date_rep">วันที่ :</label>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="date" id="date_rep" name="date_rep" class="form-control" >
                                </div>   
                            </div>
                            <div class="col-md-1">
                                <label for="time_rep">เวลา :</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="time" id="time_rep" name="time_rep" class="form-control" >
                                </div>   
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <label for="year">คลัง :</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select id="medical_typecat_id" name="medical_typecat_id"
                                        class="form-control" style="width: 100%">
                                        <option value="">--เลือก--</option>
                                        @foreach ($medical_typecat as $te)                                        
                                                <option value="{{ $te->medical_typecat_id }}"> {{ $te->medical_typecatname }} </option>                                        
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <input type="hidden" name="user_rep" id="user_rep" value="{{$iduser}}">
                    <div class="modal-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group">
                                <button type="button" id="Savebtn" class="btn btn-outline-info btn-sm">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    บันทึกข้อมูล
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark me-2"></i>Close</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
@endsection
@section('footer')
<script>
    $(document).ready(function() {
        $('#example').DataTable();
        $('#example2').DataTable();
        $('#p4p_work_month').select2({
            placeholder:"--เลือก--",
            allowClear:true
        }); 
        $('select').select2();                        
        $('#product_id').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });          
        $('#year').select2({ 
            dropdownParent: $('#insertdata') 
        });
        $('#medical_typecat_id').select2({ 
            dropdownParent: $('#insertdata') 
        });
        
        $('#Savebtn').click(function() {
            var year = $('#year').val();  
            var date_rep = $('#date_rep').val(); 
            var time_rep = $('#time_rep').val(); 
            var medical_typecat_id = $('#medical_typecat_id').val(); 
            var user_rep = $('#user_rep').val(); 
            $.ajax({
                url: "{{ route('med.med_store_save') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    year,date_rep,time_rep,medical_typecat_id,user_rep
                },
                success: function(data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: 'บันทึกข้อมูลสำเร็จ',
                            text: "You Insert data success",
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
                                // window.location="{{url('warehouse/warehouse_index')}}";
                            }
                        })
                    } else {
                        Swal.fire({
                            title: 'ข้อมูลมีแล้ว',
                            text: "You Have data ",
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
                                // window.location="{{url('warehouse/warehouse_index')}}";
                            }
                        })

                    }

                },
            });
        });
         
    });
    
</script>

@endsection
