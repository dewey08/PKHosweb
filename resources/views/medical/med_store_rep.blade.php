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
                    <p class="card-title-desc">รายละเอียดคลัง {{$medical_typecat->medical_typecatname}}</p>
                </div>
              
                <div class="col-md-1">รายการ
                </div>
                <div class="col-md-4 text-center">
                    <select id="article_id" name="article_id"
                        class="form-select form-select-lg" style="width: 100%">
                        <option value=""></option>
                        @foreach ($article_data as $it)
                        <?php  $idarticle = DB::table('medical_stock')->where('article_id','=',$it->article_id)->count();?>
                        @if ($idarticle > 0)                        
                        @else
                        <option value="{{$it->article_id}}">{{ $it->article_num}} {{ $it->article_name}}</option>
                        @endif                       
                        @endforeach                        
                    </select>
                </div>
                <div class="col-md-2 text-start">
                    <button class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="rep"> 
                        <i class="fa-solid fa-circle-plus me-2"></i>
                        รับเข้าคลัง
                    </button>   
                </div>
                {{-- <div class="col"></div>
                <div class="col-md-1 text-start">
                    <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="pe-7s-shuffle btn-icon-wrapper"></i>รับเข้าคลัง
                    </button>
                </div>
                --}}
            </div>
            
                <div class="col-md-12">
                    <label for="">รับเข้าคลัง</label>
                    <div class="card mt-2">                        
                        <div class="table-responsive me-2 ms-2 mb-2">
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">รายการ</th>
                                        <th class="text-center">จำนวน</th> 
                                        {{-- <th class="text-center">จัดการ</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($data_stock as $item) 
                                        <tr style="font-size: 13px;" id="sid{{$item->medical_stock_id }}">  
                                        <td width="3%">{{ $i++ }}</td> 
                                        <td class="text-start" width="10%">{{ $item->article_num }}</td> 
                                        <td class="p-2" width="50%">{{ $item->article_name }}</td>
                                        <td class="text-center" width="10%">{{ $item->qty }}</td> 
                                        {{-- <td class="text-center" width="10%">
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
                                                    
                                                </div>
                                            </div>
                                        </td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
        // $('#article_id').select2({
        //     placeholder:"--เลือก--",
        //     allowClear:true
        // }); 
        $('select').select2();                        
        $('#article_id').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });          
        $('#year').select2({ 
            dropdownParent: $('#insertdata') 
        });
        $('#medical_typecat_id').select2({ 
            dropdownParent: $('#insertdata') 
        });
        
        $('#rep').click(function() {
            var article_id = $('#article_id').val();  
            // var date_rep = $('#date_rep').val(); 
            // var time_rep = $('#time_rep').val(); 
            // var medical_typecat_id = $('#medical_typecat_id').val(); 
            // var user_rep = $('#user_rep').val(); 
            // alert(article_id);
            $.ajax({
                url: "{{ route('med.med_store_repsave') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    article_id
                    // year,date_rep,time_rep,medical_typecat_id,user_rep
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
                            title: 'มีรายการนี้แล้ว',
                            text: "You Have data success",
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#0679D1',
                            confirmButtonText: 'ย้อนกลับ'
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
        });
         
    });
    
</script>

@endsection
