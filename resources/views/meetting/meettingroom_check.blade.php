@extends('layouts.meettingnew')
@section('title', 'PK-OFFICER || ห้องประชุม')
 
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
               border-top: 10px #24e373 solid;
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


                    <div class="card-header ">
                        {{-- <form>
                            @csrf --}}
                            {{-- <div class="row"> 
                              
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
                                 
                                        <select name="meeting_status_code" id="meeting_status_code" class="form-control" style="width: 100%;">
                                 
                                            @foreach ($meeting_status as $st)  
                                            @if ($datastatus == $st->meeting_status_code)
                                            <option value="{{ $st->meeting_status_code }}" selected>{{ $st->meeting_status_name}}</option>   
                                            @else
                                            <option value="{{ $st->meeting_status_code }}">{{ $st->meeting_status_name}}</option>   
                                            @endif  
                                            @endforeach                   
                                        </select>
                                                                              
                                </div>
                                <div class="col-md-2">
                                    <input id="q" name="q" type="text" class="form-control" value="{{$q}}" placeholder="ค้นหา">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-sm"> 
                                        <i class="fa-solid fa-magnifying-glass me-2"></i>
                                        ค้นหา
                                    </button> 
                                </div>
                            </div> --}}
                        
                                <div class="btn-actions-pane-right">
                                    <form>
                                        @csrf
                                        <div class="row"> 
                                            <div class="col-md-1 text-end">วันที่</div>
                                            <div class="col-md-6 text-center">
                                                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                                    data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                        data-date-language="th-th" value="{{ $startdate }}" required/>
                                                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                        data-date-language="th-th" value="{{ $enddate }}" required/> 
                                                </div>
                                            </div> 
                                            <div class="col-md-1 text-center">สถานะ</div>
                                            <div class="col-md-2 text-center">
                                                <div class="input-group">
                                                    <select name="meeting_status_code" id="meeting_status_code" class="form-control" style="width: 100%;"> 
                                                        @foreach ($meeting_status as $st)  
                                                        @if ($datastatus == $st->meeting_status_code)
                                                        <option value="{{ $st->meeting_status_code }}" selected>{{ $st->meeting_status_name}}</option>   
                                                        @else
                                                        <option value="{{ $st->meeting_status_code }}">{{ $st->meeting_status_name}}</option>   
                                                        @endif  
                                                        @endforeach                   
                                                    </select>
                                            </div>
                                            </div>
                                            <div class="col-md-2">  
                                                <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                    <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                                </button>  
                                            </div> 
                                        </div>
                                    </div>
                                </form>
                    </div>
                    <div class="card-body shadow-lg"> 
                     
                        <div class="table-responsive">
                            {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example">  --}}
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <tr height="10px">
                                            <th width="7%" class="text-center">ลำดับ</th>
                                            <th width="10%" class="text-center">สถานะ</th>
                                            <th class="text-center">ปี</th>
                                            <th class="text-center">ห้องประชุม</th>
                                            <th class="text-center">วันที่จอง</th>
                                            <th class="text-center">เวลา</th>
                                            <th class="text-center">ถึงวันที่</th>
                                            <th class="text-center">เวลา</th>
                                            <th width="10%" class="text-center">ผู้ร้องขอ</th>
                                            <th width="10%" class="text-center">Manage</th>
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
                                        
                                                <td class="text-center" width="7%">
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">ทำรายการ</button>
                                                        <ul class="dropdown-menu"> 
                                                            <li>
                                                            <a class="text-info me-3" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->meeting_id }}"> 
                                                                <i class="fa-solid fa-circle-info me-2 mt-2 ms-4"></i>
                                                                <label for="" style="color: black">รายละเอียด</label>
                                                              </a>  
                                                            </li>
                                                              <li>
                                                            <a href="{{ url('meetting/meettingroom_check_allow/'. $item->meeting_id) }}" class="text-primary me-3"  > 
                                                                <i class="fa-solid fa-car-rear me-2 mt-2 ms-4 mb-2"></i>
                                                                <label for="" style="color: black">จัดสรร</label>
                                                              </a>  
                                                            </li>
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
                                                            <label for="meeting_date_end">ถึงวันที่ :</label>
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
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">ปิด</button>             
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
    <script>
         $(document).ready(function() {
        // $("#overlay").fadeIn(300);　

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $('#datepicker3').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker4').datepicker({
            format: 'yyyy-mm-dd'
        });
    });
    </script>

@endsection
     

   

