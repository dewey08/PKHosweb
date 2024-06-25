@extends('layouts.setting')
@section('title', 'ZOFFice || กำหนดสิทธิ์การใช้งาน')
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
                        <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example">
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

                      <div class="row mt-2 me-3 mb-3 ms-3">

                          <div class="col-4 col-md-3 col-xl-3">
                              <div class="card">
                                  <div class="card-body shadow-lg">
                                            
                                      <!-- Default checkbox -->
                                      <div class="form-check mt-2">
                                          <i class="fa-solid fa-user-tie text-primary me-2 ms-2"></i>
                                                                                  
                                          @if ($dataedits->permiss_person == 'ON')
                                          <input class="form-check-input" type="checkbox" value="" id="{{ $dataedits-> id }}" name="{{ $dataedits-> id }}" onchange="switchpermiss_person({{ $dataedits-> id }});" checked/>
                                          @else
                                          <input class="form-check-input" type="checkbox" value="" id="{{ $dataedits-> id }}" name="{{ $dataedits-> id }}" onchange="switchpermiss_person({{ $dataedits-> id }});" />
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
                                        <i class="fa-solid fa-book-open-reader text-secondary me-2 ms-2"></i>
                                         
                                          @if ($dataedits->permiss_book == 'ON')
                                          <input class="form-check-input" type="checkbox" value="" id="{{ $dataedits-> id }}" name="{{ $dataedits-> id }}" onchange="switchpermiss_book({{ $dataedits-> id }});" checked/>
                                          @else
                                          <input class="form-check-input" type="checkbox" value="" id="{{ $dataedits-> id }}" name="{{ $dataedits-> id }}" onchange="switchpermiss_book({{ $dataedits-> id }});" />
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
                                        <i class="fa-solid fa-truck-medical text-info me-2 ms-2"></i>
                                          
                                          @if ($dataedits->permiss_car == 'ON')
                                          <input class="form-check-input" type="checkbox" value="" id="{{ $dataedits-> id }}" name="{{ $dataedits-> id }}" onchange="switchpermiss_car({{ $dataedits-> id }});" checked/>
                                          @else
                                          <input class="form-check-input" type="checkbox" value="" id="{{ $dataedits-> id }}" name="{{ $dataedits-> id }}" onchange="switchpermiss_car({{ $dataedits-> id }});" />
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
                                        <i class="fa-solid fa-house-laptop text-success me-2 ms-2"></i>
                                          
                                          @if ($dataedits->permiss_meetting == 'ON')
                                          <input class="form-check-input" type="checkbox" value="" id="{{ $dataedits-> id }}" name="{{ $dataedits-> id }}" onchange="switchpermiss_meetting({{ $dataedits-> id }});" checked/>
                                          @else
                                          <input class="form-check-input" type="checkbox" value="" id="{{ $dataedits-> id }}" name="{{ $dataedits-> id }}" onchange="switchpermiss_meetting({{ $dataedits-> id }});" />
                                          @endif
                                          <label class="form-check-label" for="permiss_meetting">ห้องประชุม</label>
                                      </div>
                                  </div>
                              </div>
          
                          </div>
                     
                      </div>


                      <div class="row mt-2 me-3 mb-3 ms-3">
                              <div class="col-4 col-md-3 col-xl-3">
                                <div class="card">
                                    <div class="card-body shadow-lg">
                                        
                                        <div class="form-check mt-2">
                                          <i class="fa-solid fa-screwdriver-wrench text-info me-2 ms-2"></i> 
                                            @if ($dataedits->permiss_repair == 'ON')
                                            <input class="form-check-input" type="checkbox" value="" id="{{ $dataedits-> id }}" name="{{ $dataedits-> id }}" onchange="switchpermiss_repair({{ $dataedits-> id }});" checked/>
                                            @else
                                            <input class="form-check-input" type="checkbox" value="" id="{{ $dataedits-> id }}" name="{{ $dataedits-> id }}" onchange="switchpermiss_repair({{ $dataedits-> id }});" />
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
                                          <i class="fa-solid fa-computer text-secondary me-2 ms-2"></i>  
                                            <input class="form-check-input" type="checkbox" value="" id="permiss_com" name="permiss_com"/>
                                            <label class="form-check-label" for="permiss_com">คอมพิวเตอร์</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-3 col-xl-3">
                              <div class="card">
                                  <div class="card-body shadow-lg">
                                    
                                      <div class="form-check mt-2">
                                        <i class="fa-solid fa-pump-medical text-warning me-1 ms-1"></i>
                                          <input class="form-check-input" type="checkbox" value="" id="permiss_medical" name="permiss_medical"/>
                                          <label class="form-check-label" for="permiss_medical">เครื่องมือแพทย์</label>
                                      </div>
                                  </div>
                              </div>
                            </div>
                            <div class="col-4 col-md-3 col-xl-3">
                                <div class="card">
                                    <div class="card-body shadow-lg">
                                        
                                        <div class="form-check mt-2">
                                          <i class="fa-solid fa-house-chimney-user text-info me-2 ms-2"></i>
                                            <input class="form-check-input" type="checkbox" value="" id="permiss_hosing" name="permiss_hosing"/>
                                            <label class="form-check-label" for="permiss_hosing">บ้านพัก</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                      </div>


                      <div class="row mt-3 me-3 mb-3 ms-3">          

                              <div class="col-4 col-md-3 col-xl-3">
                                  <div class="card">
                                      <div class="card-body shadow-lg">
                                          
                                          <div class="form-check mt-2">
                                            <i class="fa-solid fa-clipboard text-danger me-2 ms-2"></i>
                                              <input class="form-check-input" type="checkbox" value="" id="permiss_plan" name="permiss_plan"/>
                                              <label class="form-check-label" for="permiss_plan">แผนงาน</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-4 col-md-3 col-xl-3">
                                  <div class="card">
                                      <div class="card-body shadow-lg">
                                        
                                          <div class="form-check mt-2">
                                            <i class="fa-solid fa-building-shield text-secondary me-2 ms-2"></i>
                                              <input class="form-check-input" type="checkbox" value="" id="permiss_asset" name="permiss_asset"/>
                                              <label class="form-check-label" for="permiss_asset">ทรัพย์สิน</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-4 col-md-3 col-xl-3">
                                <div class="card">
                                    <div class="card-body shadow-lg">
                                      
                                        <div class="form-check mt-2">
                                          <i class="fa-solid fa-paste text-success me-2 ms-2"></i>
                                            <input class="form-check-input" type="checkbox" value="" id="permiss_supplies" name="permiss_supplies"/>
                                            <label class="form-check-label" for="permiss_supplies">พัสดุ</label>
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="col-4 col-md-3 col-xl-3">
                                  <div class="card">
                                      <div class="card-body shadow-lg">
                                          
                                          <div class="form-check mt-2">
                                            <i class="fa-solid fa-shop-lock text-primary me-2 ms-2"></i>
                                              <input class="form-check-input" type="checkbox" value="" id="permiss_store" name="permiss_store"/>
                                              <label class="form-check-label" for="permiss_store">คลังวัสดุ</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         
                      </div>
          
                      <div class="row mt-3 me-3 mb-3 ms-3">                                 

                          <div class="col-4 col-md-3 col-xl-3">
                              <div class="card">
                                  <div class="card-body shadow-lg">
                                      
                                      <div class="form-check mt-2">
                                        <i class="fa-solid fa-prescription text-success me-2 ms-2"></i>
                                          <input class="form-check-input" type="checkbox" value="" id="permiss_store_dug" name="permiss_store_dug"/>
                                          <label class="form-check-label" for="permiss_store_dug">คลังยา</label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-4 col-md-3 col-xl-3">
                              <div class="card">
                                  <div class="card-body shadow-lg">
                                     
                                      <div class="form-check mt-2">
                                        <i class="fa-solid fa-person-booth text-danger me-2 ms-2"></i>
                                          <input class="form-check-input" type="checkbox" value="" id="permiss_pay" name="permiss_pay"/>
                                          <label class="form-check-label" for="permiss_pay">จ่ายกลาง</label>
                                      </div>
                                  </div>
                              </div>
                          </div>                           
          
                      </div>
                        
                </div>
            </div>


        </div>
    </div>
@endsection
