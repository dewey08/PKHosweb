@extends('layouts.article')
@section('title', 'PK-OFFICER || ข้อมูลชั้น')

{{-- @section('menu') --}}
    <style>
        .btn {
            font-size: 15px;
        }
        .bgc{
            background-color: #264886;
        }
        .bga{
            background-color: #fbff7d;
        }
    </style>
    <?php
        use App\Http\Controllers\StaticController;
        use Illuminate\Support\Facades\DB;   
        $count_land = StaticController::count_land();
        $count_building = StaticController::count_building();
        $count_article = StaticController::count_article();
    ?>
    {{-- <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
           
            <a href="{{ url('article/article_dashboard') }}" class="btn btn-light btn-sm dark-white me-2">dashboard </a>
            <a href="{{url("land/land_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลที่ดิน<span class="badge bg-danger ms-2">{{$count_land}}</span></a>
            <a href="{{url("building/building_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลอาคาร<span class="badge bg-danger ms-2">{{$count_building}}</span></a>   
            <a href="{{url("article/article_index")}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลครุภัณฑ์<span class="badge bg-danger ms-2">{{$count_article}}</span></a>           
            <a href=" " class="btn btn-light btn-sm text-dark me-2">ข้อมูลค่าเสื่อม</a>
            <a href=" " class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">ขายทอดตลาด</a>  
            <div class="text-end">
                <button class="btn btn-secondary btn-sm text-white me-2">เพิ่มข้อมูลชั้น</button>
                <a href="{{ url('building/building_index') }}" class="btn btn-warning btn-sm text-white me-2">ย้อนกลับ</a>
            </div>
        </div>
    </div>
@endsection --}}

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function building_leveldestroy(building_level_id)
                {
                    Swal.fire({
                    title: 'ต้องการลบใช่ไหม?',
                    text: "ข้อมูลนี้จะถูกลบไปเลย !!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
                    cancelButtonText: 'ไม่, ยกเลิก'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({ 
                        url:"{{url('building/building_leveldestroy')}}" +'/'+ building_level_id, 
                        type:'DELETE',
                        data:{
                            _token : $("input[name=_token]").val()
                        },
                        success:function(response)
                        {          
                            Swal.fire({
                            title: 'ลบข้อมูล!',
                            text: "You Delet data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            // cancelButtonColor: '#d33',
                            confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                            if (result.isConfirmed) {                  
                                $("#sid"+building_level_id).remove();     
                                window.location.reload(); 
                                // window.location = "/building/building_index"; //     
                            }
                            }) 
                        }
                        })        
                    }
                    })
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
   
    $count_level = StaticController::count_level();

    $idbuild = $dataedits->building_id;
    $idlevel = DB::table('building_level')->where('building_id','=', $idbuild)->count();
    ?>
   
    <div class="container-fluid" >

        <div class="row"> 
            
            <div class="col-md-6">
                
                <div class="card ">
                    <div class="card-header ">
                        อาคาร {{ $dataedits->building_name }} 
                    </div>
                    <div class="card-body shadow-lg">

                        @if ($idlevel > 0)

                                <form class="custom-validation" action="{{ route('bu.building_addlevelone_save') }}" method="POST" id="insert_leveloneForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="building_id" id="building_id" value=" {{ $dataedits->building_id }}">
                                        <div class="row"> 
                                            <div class="col-md-2"> </div>               
                                            <div class="col-md-2 text-end">
                                                ชั้น
                                            </div>   
                                            <div class="col-md-2">
                                                <input id="building_level_name" type="text" class="form-control form-control-sm" name="building_level_name" required>
                                            </div>                                            
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                                    บันทึกข้อมูล
                                                </button> 
                                            </div> 
                                        </div>
                                </form>
                            
                        @else

                                <form class="custom-validation" action="{{ route('bu.building_addlevel_save') }}" method="POST" id="insert_levelForm" >
                                    @csrf
                                    <input type="hidden" name="building_id" id="building_id" value=" {{ $dataedits->building_id }}">
                                        <div class="row">    
                                            <div class="col-md-2"> </div>           
                                            <div class="col-md-3 text-end">
                                                อาคารมี (ใส่จำนวนชั้น)
                                            </div>   
                                            <div class="col-md-2">
                                                <input id="building_level_name" type="text" class="form-control form-control-sm" name="building_level_name" required>
                                            </div> 
                                            <div class="col-md-1 ">
                                            ชั้น
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                                    บันทึกข้อมูล
                                                </button> 
                                            </div> 
                                        </div>
                                </form>                            
                        @endif
                       

                        <div class="table-responsive mt-3">
                            <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;"> 
                                <thead>
                                    <tr height="10px">
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">ชั้น</th>                                 
                                        <th width="12%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>    
                                    <?php $i = 1;                                    
                                    $date = date('Y');                                    
                                    ?>
                                    @foreach ($building_level as $item)                         
                                        <tr id="sid{{ $item->building_level_id }}">
                                            <td class="text-center" width="5%">{{ $i++ }}</td>
                                            <td class="p-2">{{$item->building_level_name}}</td>
                                            <td class="text-center" width="20%">
                                                <a href="{{ url('building/building_addlevel_room/'.$dataedits->building_id.'/'.$item->building_level_id) }}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="เพิ่มห้อง">
                                                    <i class="fa-solid fa-file-circle-plus me-2"></i>
                                                </a>
                                                <a class="text-danger" href="javascript:void(0)"
                                                    onclick="building_leveldestroy({{ $item->building_level_id }})"
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                    <i class="fa-solid fa-trash-can me-3"></i>
                                                </a>
                                                 
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>

                        </div>
                      
                       
                    </div>
                   
                  
                </div>

            </div>

            <div class="col-md-6">
                
                <div class="card ">
                    <div class="card-header ">
                        ห้อง
                    </div>
                    <div class="card-body shadow-lg">

                        <div class="table-responsive mt-3">
                            <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;" > 
                                <thead>
                                    <tr height="10px">
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">ห้อง</th>                                 
                                        <th width="12%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>    
                                    
                                </tbody>
                            </table>

                        </div>
                      
                       
                    </div>
                   
                  
                </div>

            </div>




        </div>
    </div>
    </div>
 

@endsection
