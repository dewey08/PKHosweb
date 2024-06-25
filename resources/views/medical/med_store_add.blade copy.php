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
            <div class="row ">   
                @foreach ($medical_typecat as $item)
                    
                        <div class="col-6 col-md-4 col-xl-2 mt-3">  
                            <a href="{{url('med_store_add/'.$item->medical_typecat_id)}}">
                                @if ($id == $item->medical_typecat_id)
                                    <div class="card">
                                        <div class="card-body text-center shadow-lg"> 
                                            <i class="fa-solid fa-3x fa-warehouse text-danger"></i> 
                                            <br>
                                            <label for="" class="mt-2" style="color: red">{{$item->medical_typecatname}}</label>
                                            <br>
                                            <a href="" class="btn btn-outline-danger btn-sm">ยืม</a>
                                            <a href="" class="btn btn-outline-danger btn-sm">คืน</a>
                                            <a href="" class="btn btn-outline-danger btn-sm">คลัง</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="card">
                                        <div class="card-body text-center shadow-lg"> 
                                            <i class="fa-solid fa-3x fa-warehouse text-primary"></i> 
                                            <br>
                                            <label for="" class="mt-2">{{$item->medical_typecatname}}</label>
                                        </div>
                                    </div>                                    
                                @endif
                                
                            </a>
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
                                    {{-- <td width="10%">
                                        <div class="btn-group">
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                ทำรายการ 
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item text-warning"
                                                    href="{{ url('medical/med_con_edit/'.$item->article_id)}}"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                                    <label for=""
                                                        style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                </a>

                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                    onclick="med_condestroy({{ $item->article_id }})"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                    <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                    <label for=""
                                                        style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
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
        $('#p4p_work_month').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });
         
    });
    
</script>

@endsection
