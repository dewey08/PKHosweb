@extends('layouts.admin_setting')
@section('title', 'PK-OFFICER || กำหนดสิทธิ์การใช้งาน')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
</script>
<script>
    function settingdep_destroy(DEPARTMENT_ID) {
        // alert(bookrep_id);
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "delete",
                    url: "{{ url('setting_index_destroy') }}" + '/' + DEPARTMENT_ID,
                    success: function(response) {
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
                                $("#sid" + DEPARTMENT_ID).remove();
                                window.location.reload();
                                // window.location = "/book/bookmake_index"; //   

                            }
                        })
                    }
                })
            }
        })
    }

    function switchpermiss_person(person){    
        var checkBox=document.getElementById(person);
        var onoff;
                if (checkBox.checked == true){
                    onoff = "ON";
                } else {
                        onoff = "OFF";
                }                
                var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('setting.switchpermiss_person')}}",
                            method:"GET",
                            data:{onoff:onoff,person:person,_token:_token}
                    })
    }
    function switchpermiss_book(book){    
        var checkBox=document.getElementById(book);
        var onoff;
                if (checkBox.checked == true){
                    onoff = "ON";
                } else {
                        onoff = "OFF";
                }                
                var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('setting.switchpermiss_book')}}",
                            method:"GET",
                            data:{onoff:onoff,book:book,_token:_token}
                    })
    }
    function switchpermiss_car(car){    
        var checkBox=document.getElementById(car);
        var onoff;
                if (checkBox.checked == true){
                    onoff = "ON";
                } else {
                        onoff = "OFF";
                }                
                var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('setting.switchpermiss_car')}}",
                            method:"GET",
                            data:{onoff:onoff,car:car,_token:_token}
                    })
    }
    function switchpermiss_meetting(meetting){    
        var checkBox=document.getElementById(meetting);
        var onoff;
                if (checkBox.checked == true){
                    onoff = "ON";
                } else {
                        onoff = "OFF";
                }                
                var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('setting.switchpermiss_meetting')}}",
                            method:"GET",
                            data:{onoff:onoff,meetting:meetting,_token:_token}
                    })
    }
    function switchpermiss_repair(repaire){    
        var checkBox=document.getElementById(repaire);
        var onoff;
                if (checkBox.checked == true){
                    onoff = "ON";
                } else {
                        onoff = "OFF";
                }                
                var _token=$('input[name="_token"]').val();
                    $.ajax({
                            url:"{{route('setting.switchpermiss_repair')}}",
                            method:"GET",
                            data:{onoff:onoff,repaire:repaire,_token:_token}
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

use App\Http\Controllers\StaticController;
use App\Models\Products_request_sub;
// $permiss_upstm = StaticController::permiss_upstm($iduser); 
$permiss_account = StaticController::permiss_account($iduser); 

?>
@section('menu')
    <style>
        .btn {
            font-size: 15px;
        }
    </style>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
            <!-- Danger -->
            <div class="btn-group">
                <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-mdb-toggle="dropdown"
                    aria-expanded="false">
                    ตั้งค่าทั่วไป
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ url('setting/setting_index') }}">กลุ่มงาน</a></li>
                    <li><a class="dropdown-item" href="{{ url('setting/depsub_index') }}">ฝ่าย/แผนก</a></li>
                    <li><a class="dropdown-item" href="{{ url('setting/depsubsub_index') }}">หน่วยงาน</a></li>
                    <li><a class="dropdown-item" href="{{url('setting/orginfo')}}">องค์กร</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ url('setting/leader') }}">กำหนดสิทธิ์การเห็นชอบ</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ url('setting/permiss') }}">กำหนดสิทธิ์การใช้งาน</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ url('setting/line_token') }}">ตั้งค่า Line Token</a></li>
                </ul>
            </div>
            <div class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto"></div>

            <div class="text-end">
                <button type="button" class="btn btn-danger btn-sm">กำหนดสิทธิ์การใช้งาน</button>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid" style="width: 97%">
        <div class="card ">


                <div class="row justify-content-center mt-2">
                    <div class="col-md-5">

                    </div>
                    <div class="col-md-4">
                       <label for="">{{$dataedits->prefix_name}}{{$dataedits->fname}}  {{$dataedits->lname}}</label>
                    </div>

                    <div class="col-md-3">
                       
                    </div>
                </div>
                
            

            <hr>
            <div class="row p-3">
                <div class="col-md-4">
                    <div class="table-responsive"> 
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> --}}
                              <thead>
                                  <tr height="10px">
                                      <th width="5%" class="text-center">ลำดับ</th> 
                                      <th class="text-center">ชื่อ-นามสกุล</th>
                                      <th width="10%" class="text-center">Manage</th>
                                  </tr>
                              </thead>
                              <tbody>
                                        <?php $num = 0;                                    
                                        $date = date('Y');                                    
                                        ?>
                                        @foreach ($users as $item)
                                        <?php $num++; ?>
                                            <tr id="sid{{ $item->id }}">
                                                <td class="text-center">{{ $num }}</td>
                                                <td class="p-2">{{ $item->fname }}  {{ $item->lname }}</td>                         
                                                <td class="text-center" width="10%">
                                                    <a href="{{ url('setting/permiss_liss/' . $item->id) }}"
                                                        class="text-success me-3" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                        title="กำหนดสิทธิ์การใช้งาน" > 
                                                        <i class="fa-solid fa-user-shield"></i>
                                                    </a>                                         
                                                </td>
                                            </tr>                                  
                                        @endforeach                                
                              </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-md-8">
                    <form action="{{ route('setting.permiss_save') }}" id="insert_permissForm" method="POST">
                        @csrf

                    {{-- <form action="{{ route('setting.permiss_save') }}" method="POST">
                        @csrf --}}
                        <input type="hidden" id="id" name="id" value="{{$dataedits->id}}"> 
                        {{-- <input type="hidden" id="ids" name="ids" value="{{$dataedits->ids}}">  --}}
                        <input type="hidden" id="iduser" name="iduser" value="{{$iduser}}"> 
                      <div class="row me-1 mb-1 ms-1">

                          <div class="col-4 col-md-3 col-xl-3">
                              <div class="card">
                                  <div class="card-body shadow-lg">
                                            
                                      <!-- Default checkbox -->
                                      <div class="form-check mt-2">
                                          <i class="fa-solid fa-user-tie text-primary"></i>
                                                                                  
                                          @if ($dataedits->permiss_person == 'on')
                                          <input class="form-check-input" type="checkbox" id="permiss_person" name="permiss_person" checked/>
                                          @else
                                          <input class="form-check-input" type="checkbox" id="permiss_person" name="permiss_person" />
                                          @endif
                                          
                                          <label class="form-check-label" for="permiss_person">บุคคลากร</label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-4 col-md-3 col-xl-3">
                              <div class="card">
                                  <div class="card-body shadow-lg">
                                     
                                      <!-- Default checkbox -->
                                      <div class="form-check mt-2">
                                        <i class="fa-solid fa-book-open-reader text-secondary"></i>
                                         
                                          @if ($dataedits->permiss_book == 'on')
                                          <input class="form-check-input" type="checkbox" id="permiss_book" name="permiss_book"  checked/>
                                          @else
                                          <input class="form-check-input" type="checkbox" id="permiss_book" name="permiss_book"/>
                                          @endif
                                          <label class="form-check-label" for="permiss_book">สารบรรณ</label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-4 col-md-3 col-xl-3">
                              <div class="card">
                                  <div class="card-body shadow-lg">
                                     
                                      <div class="form-check mt-2">
                                        <i class="fa-solid fa-truck-medical text-info"></i>
                                          
                                          @if ($dataedits->permiss_car == 'on')
                                          <input class="form-check-input" type="checkbox" id="permiss_car" name="permiss_car" checked/>
                                          @else
                                          <input class="form-check-input" type="checkbox" id="permiss_car" name="permiss_car"/>
                                          @endif
                                          <label class="form-check-label" for="permiss_car">ยานพาหนะ</label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-4 col-md-3 col-xl-3">
                              <div class="card">
                                  <div class="card-body shadow-lg">
                                  
                                      <div class="form-check mt-2">
                                        <i class="fa-solid fa-house-laptop text-success"></i>
                                          
                                          @if ($dataedits->permiss_meetting == 'on')
                                          <input class="form-check-input" type="checkbox" id="permiss_meetting" name="permiss_meetting" checked/>
                                          @else
                                          <input class="form-check-input" type="checkbox" id="permiss_meetting" name="permiss_meetting"/>
                                          @endif
                                          <label class="form-check-label" for="permiss_meetting">ห้องประชุม</label>
                                      </div>
                                  </div>
                              </div>
          
                          </div>
                     
                      {{-- </div> --}}

                      {{-- <div class="row mt-2 me-3 mb-3 ms-3"> --}}
                              <div class="col-4 col-md-3 col-xl-3">
                                <div class="card">
                                    <div class="card-body shadow-lg">
                                        
                                        <div class="form-check mt-2">
                                          <i class="fa-solid fa-screwdriver-wrench text-info"></i> 
                                            @if ($dataedits->permiss_repair == 'on')
                                            <input class="form-check-input" type="checkbox" id="permiss_repair" name="permiss_repair" checked/>
                                            @else
                                            <input class="form-check-input" type="checkbox" id="permiss_repair" name="permiss_repair" />
                                            @endif
                                            <label class="form-check-label" for="permiss_repair">ซ่อมบำรุง</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-3 col-xl-3">
                                <div class="card">
                                    <div class="card-body shadow-lg">
                                       
                                        <div class="form-check mt-2">
                                          <i class="fa-solid fa-computer text-secondary"></i>   
                                            @if ($dataedits->permiss_com == 'on')
                                            <input class="form-check-input" type="checkbox" id="permiss_com" name="permiss_com" checked/>
                                            @else
                                            <input class="form-check-input" type="checkbox" id="permiss_com" name="permiss_com" />
                                            @endif
                                            <label class="form-check-label" for="permiss_com">คอมพิวเตอร์</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-3 col-xl-3">
                              <div class="card">
                                  <div class="card-body shadow-lg">
                                    
                                      <div class="form-check mt-2">
                                        <i class="fa-solid fa-pump-medical text-warning"></i> 
                                          @if ($dataedits->permiss_medical == 'on')
                                            <input class="form-check-input" type="checkbox" id="permiss_medical" name="permiss_medical" checked/>
                                            @else
                                            <input class="form-check-input" type="checkbox" id="permiss_medical" name="permiss_medical" />
                                            @endif
                                          <label class="form-check-label" for="permiss_medical">เครื่องมือแพทย์</label>
                                      </div>
                                  </div>
                              </div>
                            </div>
                            <div class="col-4 col-md-3 col-xl-3">
                                <div class="card">
                                    <div class="card-body shadow-lg">
                                        
                                        <div class="form-check mt-2">
                                          <i class="fa-solid fa-house-chimney-user text-info"></i> 
                                            @if ($dataedits->permiss_hosing == 'on')
                                            <input class="form-check-input" type="checkbox" id="permiss_hosing" name="permiss_hosing" checked/>
                                            @else
                                            <input class="form-check-input" type="checkbox" id="permiss_hosing" name="permiss_hosing" />
                                            @endif
                                            <label class="form-check-label" for="permiss_hosing">บ้านพัก</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                      {{-- </div> --}}

                      {{-- <div class="row mt-3 me-3 mb-3 ms-3">           --}}

                              <div class="col-4 col-md-3 col-xl-3">
                                  <div class="card">
                                      <div class="card-body shadow-lg">
                                          
                                          <div class="form-check mt-2">
                                            <i class="fa-solid fa-clipboard text-danger"></i> 
                                              @if ($dataedits->permiss_plan == 'on')
                                              <input class="form-check-input" type="checkbox" id="permiss_plan" name="permiss_plan" checked/>
                                              @else
                                              <input class="form-check-input" type="checkbox" id="permiss_plan" name="permiss_plan" />
                                              @endif
                                              <label class="form-check-label" for="permiss_plan">แผนงาน</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-4 col-md-3 col-xl-3">
                                  <div class="card">
                                      <div class="card-body shadow-lg">
                                        
                                          <div class="form-check mt-2">
                                            <i class="fa-solid fa-building-shield text-secondary"></i> 
                                              @if ($dataedits->permiss_asset == 'on')
                                              <input class="form-check-input" type="checkbox" id="permiss_asset" name="permiss_asset" checked/>
                                              @else
                                              <input class="form-check-input" type="checkbox" id="permiss_asset" name="permiss_asset" />
                                              @endif
                                              <label class="form-check-label" for="permiss_asset">ทรัพย์สิน</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-4 col-md-3 col-xl-3">
                                <div class="card">
                                    <div class="card-body shadow-lg">
                                      
                                        <div class="form-check mt-2">
                                          <i class="fa-solid fa-paste text-success"></i> 
                                            @if ($dataedits->permiss_supplies == 'on')
                                            <input class="form-check-input" type="checkbox" id="permiss_supplies" name="permiss_supplies" checked/>
                                            @else
                                            <input class="form-check-input" type="checkbox" id="permiss_supplies" name="permiss_supplies" />
                                            @endif
                                            <label class="form-check-label" for="permiss_supplies">พัสดุ</label>
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="col-4 col-md-3 col-xl-3">
                                  <div class="card">
                                      <div class="card-body shadow-lg">
                                          
                                          <div class="form-check mt-2">
                                            <i class="fa-solid fa-shop-lock text-primary"></i> 
                                              @if ($dataedits->permiss_store == 'on')
                                              <input class="form-check-input" type="checkbox" id="permiss_store" name="permiss_store" checked/>
                                              @else
                                              <input class="form-check-input" type="checkbox" id="permiss_store" name="permiss_store" />
                                              @endif
                                              <label class="form-check-label" for="permiss_store">คลังวัสดุ</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         
                      {{-- </div> --}}
          
                      {{-- <div class="row mt-3 me-3 mb-3 ms-3"> --}}

                          <div class="col-4 col-md-3 col-xl-3">
                              <div class="card">
                                  <div class="card-body shadow-lg">
                                      
                                      <div class="form-check mt-2">
                                        <i class="fa-solid fa-prescription text-success"></i> 
                                          @if ($dataedits->permiss_store_dug == 'on')
                                              <input class="form-check-input" type="checkbox" id="permiss_store_dug" name="permiss_store_dug" checked/>
                                              @else
                                              <input class="form-check-input" type="checkbox" id="permiss_store_dug" name="permiss_store_dug" />
                                              @endif
                                          <label class="form-check-label" for="permiss_store_dug">คลังยา</label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-4 col-md-3 col-xl-3">
                              <div class="card">
                                  <div class="card-body shadow-lg">
                                     
                                      <div class="form-check mt-2">
                                        <i class="fa-solid fa-person-booth text-danger"></i> 
                                          @if ($dataedits->permiss_pay == 'on')
                                              <input class="form-check-input" type="checkbox" id="permiss_pay" name="permiss_pay" checked/>
                                              @else
                                              <input class="form-check-input" type="checkbox" id="permiss_pay" name="permiss_pay" />
                                              @endif
                                          <label class="form-check-label" for="permiss_pay">จ่ายกลาง</label>
                                      </div>
                                  </div>
                              </div>
                          </div>  
                          <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">
                                   
                                    <div class="form-check mt-2">
                                      <i class="fa-solid fa-file-invoice-dollar text-warning"></i> 
                                        @if ($dataedits->permiss_money == 'on')
                                            <input class="form-check-input" type="checkbox" id="permiss_money" name="permiss_money" checked/>
                                            @else
                                            <input class="form-check-input" type="checkbox" id="permiss_money" name="permiss_money" />
                                            @endif
                                        <label class="form-check-label" for="permiss_money">การเงิน</label>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">
                                   
                                    <div class="form-check mt-2">
                                      <i class="fa-solid fa-sack-dollar text-danger"></i> 
                                        @if ($dataedits->permiss_claim == 'on')
                                            <input class="form-check-input" type="checkbox" id="permiss_claim" name="permiss_claim" checked/>
                                            @else
                                            <input class="form-check-input" type="checkbox" id="permiss_claim" name="permiss_claim" />
                                            @endif
                                        <label class="form-check-label" for="permiss_claim">งานประกัน</label>
                                    </div>
                                </div>
                            </div>
                        </div>                            
          
                      {{-- </div> --}}

                      {{-- <div class="row mt-3 me-3 mb-3 ms-3"> --}}
                        {{-- <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-square-person-confined" style="color: rgb(159, 9, 197)"></i>
                                        @if ($dataedits->permiss_medicine == 'on')
                                        <input class="form-check-input" type="checkbox" id="permiss_medicine" name="permiss_medicine" checked/>
                                        @else
                                        <input class="form-check-input" type="checkbox" id="permiss_medicine" name="permiss_medicine" />
                                        @endif
                                        <label class="form-check-label" for="permiss_medicine">แพทย์แผนไทย</label>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-solid fa-people-line" style="color: rgb(9, 106, 197)"></i>
                                        @if ($dataedits->permiss_ot == 'on')
                                        <input class="form-check-input" type="checkbox" id="permiss_ot" name="permiss_ot" checked/>
                                        @else
                                        <input class="form-check-input" type="checkbox" id="permiss_ot" name="permiss_ot" />
                                        @endif
                                        <label class="form-check-label" for="permiss_ot">โอที</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-solid fa-hospital-user" style="color: rgb(170, 7, 97)"></i>
                                        @if ($dataedits->permiss_gleave == 'on')
                                        <input class="form-check-input" type="checkbox" id="permiss_gleave" name="permiss_gleave" checked/>
                                        @else
                                        <input class="form-check-input" type="checkbox" id="permiss_gleave" name="permiss_gleave" />
                                        @endif
                                        <label class="form-check-label" for="permiss_gleave">ระบบการลา</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-p text-primary"></i><i class="fa-solid fa-4 text-primary"></i><i class="fa-solid fa-p text-primary"></i>
                                        @if ($dataedits->permiss_p4p == 'on')
                                        <input class="form-check-input" type="checkbox" id="permiss_p4p" name="permiss_p4p" checked/>
                                        @else
                                        <input class="form-check-input" type="checkbox" id="permiss_p4p" name="permiss_p4p" />
                                        @endif
                                        <label class="form-check-label" for="permiss_p4p">งาน P4P</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-regular fa-clock text-primary"></i>  
                                        
                                            @if ($dataedits->permiss_time == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_time" name="permiss_time" checked/>
                                        @else
                                        <input class="form-check-input" type="checkbox" id="permiss_time" name="permiss_time"/>
                                        @endif
                                        <label class="form-check-label" for="permiss_time">ระบบลงเวลา</label> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-hand-holding-droplet" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->permiss_env == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_env" name="permiss_env" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_env" name="permiss_env"/>
                                        @endif
                                            <label class="form-check-label" for="permiss_env">ระบบ ENV</label> 
                                    </div> 

                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>  
                                        @if ($dataedits->permiss_setting_env == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_setting_env" name="permiss_setting_env" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_setting_env" name="permiss_setting_env" />
                                        @endif
                                            <label class="form-check-label" for="permiss_setting_env">ตั้งค่า ENV</label> 
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-house-medical-circle-check" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->permiss_clinic_tb == 'on') 
                                                                          
                                        <input class="form-check-input" type="checkbox" id="permiss_clinic_tb" name="permiss_clinic_tb" checked/>
                                        @else
                                        <input class="form-check-input" type="checkbox" id="permiss_clinic_tb" name="permiss_clinic_tb"/>
                                        @endif
                                        <label class="form-check-label" for="permiss_clinic_tb">Clinic TB</label> 
                                    </div> 
                                </div>
                            </div> 
                        </div>

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-camera-retro" style="color: rgb(9, 169, 197)"></i> 
                                        @if ($dataedits->permiss_sot == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_sot" name="permiss_sot" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_sot" name="permiss_sot"/>
                                        @endif
                                            <label class="form-check-label" for="permiss_sot">งานโสต</label>                                     
                                        
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-square-person-confined" style="color: rgb(9, 169, 197)"></i> 
                                        @if ($dataedits->permiss_medicine_salt == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_medicine_salt" name="permiss_medicine_salt" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_medicine_salt" name="permiss_medicine_salt"/>
                                        @endif
                                            <label class="form-check-label" for="permiss_medicine_salt">แพทย์แผนไทย</label>                                     
                                        
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-regular fa-heart" style="color: rgb(9, 169, 197)"></i> 
                                        @if ($dataedits->pesmiss_ct == 'on') 
                                            <input class="form-check-input" type="checkbox" id="pesmiss_ct" name="pesmiss_ct" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="pesmiss_ct" name="pesmiss_ct"/>
                                        @endif
                                            <label class="form-check-label" for="pesmiss_ct">CT</label>                                     
                                        
                                    </div> 
                                </div>
                            </div>
                        </div>

                      
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-regular fa-heart" style="color: rgb(110, 4, 54)"></i> 
                                        @if ($dataedits->per_prs == 'on') 
                                            <input class="form-check-input" type="checkbox" id="per_prs" name="per_prs" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="per_prs" name="per_prs"/>
                                        @endif
                                            <label class="form-check-label" for="per_prs">สนับสนุนบริการสุขภาพ</label>                                     
                                        
                                    </div> 


                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(197, 9, 103)"></i>   
                                        @if ($dataedits->per_cctv == 'on') 
                                            <input class="form-check-input" type="checkbox" id="per_cctv" name="per_cctv" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="per_cctv" name="per_cctv"/>
                                        @endif
                                            <label class="form-check-label" for="per_cctv">CCTV</label> 
                                    </div> 

                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->per_fire == 'on') 
                                            <input class="form-check-input" type="checkbox" id="per_fire" name="per_fire" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="per_fire" name="per_fire"/>
                                        @endif
                                            <label class="form-check-label" for="per_fire">ถังดับเพลิง</label> 
                                    </div> 

                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->per_air == 'on') 
                                            <input class="form-check-input" type="checkbox" id="per_air" name="per_air" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="per_air" name="per_air"/>
                                        @endif
                                            <label class="form-check-label" for="per_air">เครื่องปรับอากาศ</label> 
                                    </div> 
                                    
                                </div>
                            </div> 
                        </div> 
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(109, 105, 107)"></i>  
                                            @if ($dataedits->permiss_account == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_account" name="permiss_account" checked/>
                                        @else
                                        <input class="form-check-input" type="checkbox" id="permiss_account" name="permiss_account"/>
                                        @endif
                                        <label class="form-check-label" for="permiss_account">การบัญชี</label> 
                                    </div>


                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->permiss_ucs == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_ucs" name="permiss_ucs" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_ucs" name="permiss_ucs"/>
                                        @endif
                                            <label class="form-check-label" for="permiss_ucs">UCS</label> 
                                    </div> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->permiss_sss == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_sss" name="permiss_sss" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_sss" name="permiss_sss"/>
                                        @endif
                                            <label class="form-check-label" for="permiss_sss">SSS</label> 
                                    </div> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->permiss_ofc == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_ofc" name="permiss_ofc" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_ofc" name="permiss_ofc"/>
                                        @endif
                                            <label class="form-check-label" for="permiss_ofc">OFC</label> 
                                    </div> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->permiss_lgo == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_lgo" name="permiss_lgo" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_lgo" name="permiss_lgo"/>
                                        @endif
                                            <label class="form-check-label" for="permiss_lgo">LGO</label> 
                                    </div> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->permiss_prb == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_prb" name="permiss_prb" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_prb" name="permiss_prb"/>
                                        @endif
                                            <label class="form-check-label" for="permiss_prb">พรบ</label> 
                                    </div> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->permiss_ti == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_ti" name="permiss_ti" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_ti" name="permiss_ti"/>
                                        @endif
                                            <label class="form-check-label" for="permiss_ti">ไต</label> 
                                    </div> 




                                    
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->permiss_setting_account == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_setting_account" name="permiss_setting_account" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_setting_account" name="permiss_setting_account"/>
                                        @endif
                                            <label class="form-check-label" for="permiss_setting_name">ตั้งค่า Account</label> 
                                    </div> 

                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->permiss_setting_upstm == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_setting_upstm" name="permiss_setting_upstm" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_setting_upstm" name="permiss_setting_upstm" />
                                        @endif
                                            <label class="form-check-label" for="permiss_setting_upstm">UP STM</label> 
                                    </div> 

                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-file-invoice-dollar text-danger" style="color: rgb(9, 169, 197)"></i>   
                                        @if ($dataedits->permiss_rep_money == 'on') 
                                            <input class="form-check-input" type="checkbox" id="permiss_rep_money" name="permiss_rep_money" checked/>
                                        @else
                                            <input class="form-check-input" type="checkbox" id="permiss_rep_money" name="permiss_rep_money" />
                                        @endif
                                            <label class="form-check-label" for="permiss_rep_money">ใบเสร็จรับเงิน</label> 
                                    </div>

                                </div>
                            </div>
                        </div>

                        

                        



                    </div>

                      <div class="modal-footer"> 
                        <button type="submit" class="btn btn-primary btn-sm">บันทึกข้อมูล</button> 
                    </div>

                    </form>     
                </div>
            </div>


        </div>
    </div>
@endsection
@section('footer')

@endsection
