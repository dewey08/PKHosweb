@extends('layouts.meetting')
@section('title', 'ZOFFice || ห้องประชุม')

@section('menu')
    <style>
        .btn {
            font-size: 15px;
        }
    </style>
     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
     $count_meettinservice = StaticController::count_meettinservice();
 ?>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
           
            <a href="{{ url('meetting/meettingroom_dashboard') }}" class="btn btn-light btn-sm text-dark me-2">dashboard </a>
            <a href="{{ url('meetting/meettingroom_index') }}" class="btn btn-light btn-sm text-dark me-2">รายการห้องประชุม <span class="badge bg-danger ms-2">{{$count_meettingroom}}</span></a>
            <a href="{{ url('meetting/meettingroom_check') }}" class="btn btn-success btn-sm text-white me-2">ตรวจสอบการจองห้องประชุม <span class="badge bg-danger ms-2">{{$count_meettinservice}}</span></a>
            <a href="{{ url('meetting/meettingroom_report') }}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">รายงาน</a>

            <div class="text-end">
                {{-- <a href="{{url("car/car_report")}}" class="btn btn-success btn-rounded">ออกเลขหนังสือรับ</a> --}}
               
            </div>
        </div>
    </div>
@endsection

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
    <div class="container-fluid " style="width: 97%">
        <div class="row"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body shadow-lg"> 
                            <form>
                                <div class="row"> 
                                   <!-- <div class="col-md-1 text-end">ปี </div>
                                    <div class="col-md-1">
                                        <select name="year" id="year" class="form-control" style="width: 100%;">
                                            <option value="" selected>--เลือก--</option> 
                                            @foreach ($budget_year as $year)                                    
                                            <option value="{{ $year->leave_year_id }}">{{ $year->leave_year_id}}</option>   
                                            @endforeach                   
                                        </select>
                                    </div>-->
                                    <div class="col text-end">วันที่</div>
                                    <div class="col">
                                        <input id="start" name="start" type="date" class="form-control" value="{{$start}}">
                                    </div>
                                    <div class="col-md-1 text-end">ถึงวันที่</div>
                                    <div class="col">
                                        <input id="end" name="end" type="date" class="form-control" value="{{$end}}">
                                    </div>
                                    <div class="col text-end">สถานะ </div>
                                    <div class="col">
                                        @if ($meeting_status_code == '')
                                            <select name="meeting_status_code" id="meeting_status_code" class="form-control" style="width: 100%;">
                                                {{-- <option value="" selected>--ทั้งหมด--</option>  --}}
                                                @foreach ($meeting_status as $st)  
                                                @if ($st->meeting_status_code == 'REQUEST')
                                                <option value="{{ $st->meeting_status_code }}" selected>{{ $st->meeting_status_name}}</option>   
                                                @else
                                                <option value="{{ $st->meeting_status_code }}">{{ $st->meeting_status_name}}</option>   
                                                @endif                                  
                                                
                                                @endforeach                   
                                            </select>
                                            
                                        @elseif ($meeting_status_code == 'ALL')
                                            <select name="meeting_status_code" id="meeting_status_code" class="form-control" style="width: 100%;">
                                                {{-- <option value="" selected>--ทั้งหมด--</option>  --}}
                                                @foreach ($meeting_status as $st)  
                                                @if ($st->meeting_status_code == 'ALL')
                                                <option value="{{ $st->meeting_status_code }}" selected>{{ $st->meeting_status_name}}</option>   
                                                @else
                                                <option value="{{ $st->meeting_status_code }}">{{ $st->meeting_status_name}}</option>   
                                                @endif                                  
                                                
                                                @endforeach                   
                                            </select>
                                            @elseif ($meeting_status_code == 'ALLOCATE')
                                            <select name="meeting_status_code" id="meeting_status_code" class="form-control" style="width: 100%;">
                                                {{-- <option value="" selected>--ทั้งหมด--</option>  --}}
                                                @foreach ($meeting_status as $st)  
                                                @if ($st->meeting_status_code == 'ALLOCATE')
                                                <option value="{{ $st->meeting_status_code }}" selected>{{ $st->meeting_status_name}}</option>   
                                                @else
                                                <option value="{{ $st->meeting_status_code }}">{{ $st->meeting_status_name}}</option>   
                                                @endif                                  
                                                
                                                @endforeach                   
                                            </select>
                                        @elseif ($meeting_status_code == 'ALLOWPO')
                                            <select name="meeting_status_code" id="meeting_status_code" class="form-control" style="width: 100%;">
                                                {{-- <option value="" selected>--ทั้งหมด--</option>  --}}
                                                @foreach ($meeting_status as $st)  
                                                @if ($st->meeting_status_code == 'ALLOWPO')
                                                <option value="{{ $st->meeting_status_code }}" selected>{{ $st->meeting_status_name}}</option>   
                                                @else
                                                <option value="{{ $st->meeting_status_code }}">{{ $st->meeting_status_name}}</option>   
                                                @endif                                  
                                                
                                                @endforeach                   
                                            </select>
                                        @elseif ($meeting_status_code == 'CANCEL')
                                            <select name="meeting_status_code" id="meeting_status_code" class="form-control" style="width: 100%;">
                                                {{-- <option value="" selected>--ทั้งหมด--</option>  --}}
                                                @foreach ($meeting_status as $st)  
                                                @if ($st->meeting_status_code == 'CANCEL')
                                                <option value="{{ $st->meeting_status_code }}" selected>{{ $st->meeting_status_name}}</option>   
                                                @else
                                                <option value="{{ $st->meeting_status_code }}">{{ $st->meeting_status_name}}</option>   
                                                @endif                                  
                                                
                                                @endforeach                   
                                            </select>
                                        @else
                                            <select name="meeting_status_code" id="meeting_status_code" class="form-control" style="width: 100%;">
                                                {{-- <option value="" selected>--ทั้งหมด--</option>  --}}
                                                @foreach ($meeting_status as $st)  
                                                @if ($meeting_status_code == $st->meeting_status_code)
                                                <option value="" selected>{{ $st->meeting_status_name}}</option>   
                                                @else
                                                <option value="">{{ $st->meeting_status_name}}</option>   
                                                @endif                                  
                                                
                                                @endforeach                   
                                            </select>

                                            
                                        @endif
                                       
                                    </div>
                                    <div class="col-md-2">
                                        <input id="q" name="q" type="text" class="form-control" value="{{$q}}" placeholder="ค้นหา">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn-sm"> 
                                            ค้นหา
                                        </button> 
                                    </div>
                                </div>
                        </form>

                    <hr>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> 
                                <thead>
                                    <tr>
                                        <tr height="10px">
                                            <th width="7%">ลำดับ</th>
                                            <th width="10%">สถานะ</th>
                                            <th>ปี</th>
                                            <th>ห้องประชุม</th>
                                            <th>วันที่จอง</th>
                                            <th>เวลา</th>
                                            <th>ถึงวันที่</th>
                                            <th>เวลา</th>
                                            <th width="10%">ผู้ร้องขอ</th>
                                            <th width="10%">ทำรายการ</th>
                                        </tr>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; $date = date('Y'); ?>
                                        @foreach ($meeting_service as $item)
                                            <tr id="sid{{ $item->meeting_id }}" height="30">
                                                <td class="text-center" width="3%">{{ $i++ }}</td>    
      
                                                @if ($item->meetting_status == 'REQUEST')
                                                <td class="text-center" width="5%"><div class="badge bg-warning">ร้องขอ</div></td>
                                              @elseif ($item->meetting_status == 'ALLOCATE')
                                                <td class="text-center" width="5%"><div class="badge bg-info">จัดสรร</div></td>                                         
                                              @else
                                                <td class="text-center" width="5%"><div class="badge bg-success">อนุมัติ</div></td>
                                              @endif
      
      
                                                <td class="text-center" width="7%">{{ $item->meetting_year }}</td>                                         
                                                <td class="p-2">{{ $item->room_name }}</td>
                                                <td class="p-2" width="10%">{{ DateThai($item->meeting_date_begin) }}</td>
                                                <td class="p-2" width="7%">{{ $item->meeting_time_begin }}</td>
                                                <td class="p-2" width="10%">{{ DateThai($item->meeting_date_end )}}</td>
                                                <td class="p-2" width="7%">{{ $item->meeting_time_end }}</td>
                                                <td class="p-2" width="12%">{{ $item->meeting_user_name }}</td>
                                                <td class="text-center" width="10%">
                                                  <!-- Info -->                                               
                                                      <div class="dropdown">
                                                        <a class="dropdown-toggle text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                          เลือก
                                                        </a>
                                                      
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                          <li>
                                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->meeting_id }}">รายละเอียด</button>
                                                            
                                                            {{-- <a class="dropdown-item edit_detail" href="#" value="{{ $item->meeting_id }}">รายละเอียด</a> --}}
                                                          </li>
                                                          <li><a class="dropdown-item" href="{{ url('meetting/meettingroom_check_allow/'. $item->meeting_id) }}">จัดสรร</a></li>
                                                   
                                                        </ul>
                                                      </div>
                                                                                  
                                                </td>
                                          </tr> 


                                          <div class="modal fade" id="detailModal{{ $item->meeting_id }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detailModalLabel">รายละเอียดจองห้องประชุม</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" id="closebtnx" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row ">
                                                            <div class="col-md-2 text-end">
                                                                <label for="room_name">ห้องประชุม :</label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="">{{ $item->room_name }}</label> 
                                                                </div>
                                                            </div>   
                                                            <div class="col-md-2 text-end">
                                                              <label for="meetting_year">ปีงบประมาณ :</label>
                                                          </div>
                                                          <div class="col-md-3">
                                                              <div class="form-group">
                                                                <label for="">{{ $item->meetting_year }}</label>  
                                                              </div>
                                                          </div>   
                                                                 
                                                        </div>
                                          
                                                        <div class="row mt-3">
                                                            <div class="col-md-2 text-end">
                                                                <label for="meetting_title">เรื่องการประชุม :</label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group"> 
                                                                    <label for="">{{ $item->meetting_title }}</label>  
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 text-end">
                                                              <label for="meeting_user_name">ผู้ร้องขอ :</label>
                                                          </div>
                                                          <div class="col-md-3">
                                                              <div class="form-group">
                                                                <label for="">{{ $item->meeting_user_name }}</label>                         
                                                              </div>
                                                          </div>    
                                          
                                          
                                          
                                                        </div>
                                          
                                                        <div class="row mt-3">
                                                            <div class="col-md-2 text-end">
                                                                <label for="meetting_target">กลุ่มบุคคลเป้าหมาย :</label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="">{{ $item->meetting_target }}</label>  
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 text-end">
                                                              <label for="meeting_tel">เบอร์โทร :</label>
                                                          </div>
                                                          <div class="col-md-3">
                                                              <div class="form-group">
                                                                <label for="">{{ $item->meeting_tel }}</label>                     
                                                              </div>
                                                          </div>
                                          
                                          
                                          
                                                        </div>
                                          
                                                        <div class="row mt-3">
                                                            <div class="col-md-2 text-end">
                                                                <label for="meeting_objective_name">วัตถุประสงค์การขอใช้ :</label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="">{{ $item->meeting_objective_name }}</label> 
                                                                 
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 text-end">
                                                              <label for="meetting_person_qty">จำนวน :</label>
                                                          </div>
                                                          <div class="col-md-1">
                                                              <div class="form-group">
                                                                <label for="">{{ $item->meetting_person_qty }}</label> 
                                                                 
                                                              </div>
                                                          </div>
                                                          <div class="col-md-1">
                                                              <label for="lname">คน</label>
                                                          </div>
                                                            
                                                        </div>
                                          
                                                        <div class="row mt-3">  
                                                          <div class="col-md-2 text-end">
                                                              <label for="meeting_date_begin">ตั้งแต่วันที่ </label>
                                                          </div>
                                                          <div class="col-md-2">
                                                              <div class="form-group">
                                                                <label for="">{{ DateThai($item->meeting_date_begin) }}</label>  
                                                              </div>
                                                          </div>  
                                                          <div class="col-md-1 text-end">
                                                            <label for="meeting_date_end">ถึงวันที่ </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="">{{ DateThai($item->meeting_date_end )}}</label>  
                                                            </div>
                                                        </div>                                                                                                   
                                                        </div> 
                                          
                                          
                                                        <div class="row mt-3">
                                                            <div class="col-md-2 text-end">
                                                                <label for="meeting_time_begin">ตั้งแต่เวลา :</label>
                                                            </div> 
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="">{{ $item->meeting_time_begin }}</label>  
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 text-end">
                                                                <label for="meeting_time_end">ถึงเวลา :</label>
                                                            </div>
                                                            
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="">{{ $item->meeting_time_end }}</label>  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger btn-sm" id="closebtn" data-bs-dismiss="modal">ปิด</button>             
                                                    </div>
                                                    <!-- </form> -->
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
        </div>
    </div>
    </div>
    @endsection

    @section('footer') 
    <script src="{{ asset('js/meetting.js') }}"></script>

    <script>
        $(document).ready(function() {      
              $('select').select2( );
          });
  </script>
@endsection
