@extends('layouts.car')
@section('title', 'ZOFFice || ยานพาหนะ')
 
    <style>
        .btn {
            font-size: 15px;
        }
    </style>
      <?php
      use App\Http\Controllers\StaticController;
      use Illuminate\Support\Facades\DB;   
      $count_article_car = StaticController::count_article_car();
     $count_car_service = StaticController::count_car_service();
  ?>
 

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function car_destroy(article_id)
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
        url:"{{url('car/car_destroy')}}" +'/'+ article_id, 
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
                $("#sid"+article_id).remove();     
                window.location.reload(); 
                // window.location = "/car/car_data_index"; //     
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
    ?>
    <div class="container-fluid " style="width: 97%">
        <div class="row">
            {{-- <div class="col-md-3">  
        </div> --}}
            <div class="col-md-12">
                <div class="card bg-secondary p-1 mx-0 shadow-lg">
                    <div class="panel-header text-left px-3 py-2 text-white">
                        ปฎิทินข้อมูลการใช้บริการรถยนต์<span
                            class="fw-3 fs-18 text-white bg-sl-r2 px-2 radius-5"> </span>
                    </div>
                    <div class="panel-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> 
                                <thead>
                                    <tr>
                                        <th width="4%" class="text-center">ลำดับ</th>
                                        <th width="13%" class="text-center">รหัสครุภัณฑ์</th>
                                        <th class="text-center">รายการครุภัณฑ์</th>
                                        <th width="15%" class="text-center">ประเภทค่าเสื่อม</th>
                                        <th width="15%" class="text-center">หมวดครุภัณฑ์</th>
                                        <th width="20%" class="text-center">ประจำหน่วยงาน</th> 
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; $date = date('Y'); ?>
                                    @foreach ($article_data as $item)
                                        <tr id="sid{{ $item->article_id }}">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="p-2" width="13%">{{ $item->article_num }} </td>
                                            <td class="p-2">{{ $item->article_name }}</td>
                                            <td class="p-2" width="15%">{{ $item->article_decline_name }}</td>
                                            <td class="p-2" width="15%">{{ $item->article_categoryname }}</td>
                                            <td class="p-2" width="20%">{{ $item->article_deb_subsub_name }}</td> 
                                            <td class="text-center" width="10%">
                                                {{-- <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                      ทำรายการ
                                                    </button>                                      
                                                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                          
                                                              <li>
                                                                <a href="{{ url('car/car_data_index_edit/' .$item->article_id) }}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                                  <i class="fa-solid fa-pen-to-square me-2 mt-3 ms-4"></i>
                                                                  <label for="" style="color: black">แก้ไข</label>
                                                                </a>  
                                                              </li>
                                                              <li>
                                                                <a class="text-danger" href="javascript:void(0)" onclick="car_destroy({{ $item->article_id }})">
                                                                  <i class="fa-solid fa-trash-can me-2 mt-3 ms-4 mb-4"></i>
                                                                  <label for="" style="color: black">ลบ</label>
                                                                </a> 
                                                              </li>

                                                        </ul>
                                                </div> --}}
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-info dropdown-toggle menu" type="button" data-bs-toggle="dropdown" aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                          <li>
                                                             <a href="{{ url('car/car_data_index_edit/' .$item->article_id) }}" class="dropdown-item menu"  data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข" >
                                                              <i class="fa-solid fa-pen-to-square mt-2 ms-2 mb-2 me-2 text-warning"></i>
                                                              <label for="" style="color: rgb(33, 187, 248)">แก้ไข</label> 
                                                            </a>
                                                          </li>                                                         
                                                          <li>
                                                            <a class="dropdown-item menu" href="javascript:void(0)" onclick="car_destroy({{$item->article_id}})" data-bs-toggle="tooltip" data-bs-placement="left" title="แจ้งยกเลิก">
                                                  
                                                              <i class="fa-solid fa-trash-can  me-2 mt-2 ms-2 mb-2 text-danger"></i>
                                                              <label for="" style="color: rgb(255, 22, 22)">ลบ</label> 
                                                            </a>
                                                          </li>                                                               
                                                    </ul>
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
        </div>
    </div>
    </div>
 

@endsection
