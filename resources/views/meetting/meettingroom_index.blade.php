@extends('layouts.meettingnew')
@section('title', 'PK-OFFICER || ห้องประชุม')
@section('content')
     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
 ?>
  
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
           border: 10px #ddd solid;
           border-top: 10px #24e373 solid;
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
<div class="tabs-animation">
    
    <div class="row text-center">   
              
        <div id="preloader">
          <div id="status">
              <div class="spinner">
                  
              </div>
          </div>
      </div>
  </div> 
    <div class="row"> 
        <div class="col-md-12"> 
             <div class="main-card mb-3 card">
                <div class="card-header">
                    ข้อมูลห้องประชุม
                    <div class="btn-actions-pane-right"> 
                            {{-- <a href="{{ url('meetting/meettingroom_add')}}"  class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary"> 
                                <i class="fa-regular fa-square-plus me-2"></i>เพิ่มข้อมูล
                            </a>   --}}
                        </div> 
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive">
                            {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example">  --}}
                                {{-- <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;" id="example">  --}}
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                {{-- <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example"> --}}
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">ชื่อห้องประชุม</th>
                                        <th class="text-center">สถานที่ตั้ง</th>
                                        <th class="text-center">ความจุ</th>
                                        <th class="text-center">ผู้รับผิดชอบ</th>  
                                        <th width="10%" class="text-center">Manage</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; $date = date('Y'); ?>
                                    @foreach ($building_data as $item)
                                        <tr id="sid{{ $item->building_id }}" style="font-size: 13px;">
                                            <td class="text-center" width="3%">{{ $i++ }}</td>                                           
                                            <td class="p-2">{{ $item->room_name }}</td>
                                            <td class="p-2">{{ $item->building_name }}</td>                                         
                                            <td class="p-2" width="7%">{{ $item->room_amount }}</td>
                                            <td class="p-2" width="12%">{{ $item->room_user_name }}</td>
                                            <td class="text-center" width="7%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle menu"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="{{ url('meetting/meettingroom_index_edit/' . $item->room_id) }}"
                                                                class="dropdown-item menu" data-bs-toggle="tooltip"
                                                                data-bs-placement="left" title="แก้ไข">
                                                                <i
                                                                    class="fa-solid fa-pen-to-square mt-2 ms-2 mb-2 me-2 text-warning" style="font-size: 13px;"></i>
                                                                <label for=""
                                                                    style="font-size: 13px;color: rgb(233, 175, 17)">แก้ไข</label>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('meetting/meettingroom_index_tool/' . $item->room_id) }}"
                                                                class="text-primary me-3" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                                title="เพิ่มอุปกรณ์">   
                                                                <i class="fa-solid fa-list-check me-2 mt-3 ms-4 mb-4"></i>
                                                                <label for="" style="font-size: 13px;color: rgb(53, 81, 241)">เพิ่มอุปกรณ์</label>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                {{-- <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                      ทำรายการ
                                                    </button>                                      
                                                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                          
                                                              <li>
                                                                <a href="{{ url('meetting/meettingroom_index_edit/' . $item->room_id) }}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                                  <i class="fa-solid fa-pen-to-square me-2 mt-3 ms-4"></i>
                                                                  <label for="" style="color: black">แก้ไข</label>
                                                                </a>  
                                                              </li>
                                                              <li>
                                                                
                                                                <a href="{{ url('meetting/meettingroom_index_tool/' . $item->room_id) }}"
                                                                    class="text-primary me-3" data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                                    title="เพิ่มอุปกรณ์">   
                                                                    <i class="fa-solid fa-list-check me-2 mt-3 ms-4 mb-4"></i>
                                                                    <label for="" style="color: black">เพิ่มอุปกรณ์</label>
                                                                </a>
                                                              </li>

                                                        </ul>
                                                </div> --}}
                                                 
                                                
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
    @section('footer')
    
    @endsection
 
