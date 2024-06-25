@extends('layouts.user')
@section('title','ZOffice || ช้อมูลการจองห้องประชุม')

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

    $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
?>
<style>
  .btn{
      font-size:15px;
    }
    tr.detailservice{
        cursor:pointer;
    }
    tr.detailservice:hover{
        background:#AED6F1 !important;
    }
    .meetroom:hover{
        background:#AED6F1;
    }
    .tr-header{
        background: #dcdcdc !important;
    }
    .fc-content{
        cursor:pointer;
    }
    #calendar {
        max-width: 95%;
        margin: 0 auto;
        font-size: 15px;
    }

    body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;
    }
</style>
<div class="container-fluid" >
    <div class="px-0 py-0 mb-2">
        <div class="d-flex flex-wrap justify-content-center">  
                <a class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-white me-2"></a>            
                <div class="text-end">
                    <a href="{{url('user_meetting/meetting_dashboard')}}" class="btn btn-light btn-sm text-dark me-2">dashboard</a>
                    <a href="{{url('user_meetting/meetting_calenda')}}" class="btn btn-info btn-sm text-white me-2">ปฎิทิน</a>
                    <a href="{{url('user_meetting/meetting_index')}}" class="btn btn-light btn-sm text-dark me-2">ช้อมูลการจองห้องประชุม</a> 
                </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">   
                <div class="card-body">                      
                    <div class="row">
                        <div class="col-lg-3 mb-2">
                            <div class="card bg-info p-1 mx-0">
                                <div class="card-header px-3 py-2 text-white">
                                    ห้องประชุม
                                </div>
                                <div class="card-body bg-white"> 
                                        @foreach($building_level_room as $row)
                                        <a class="dropdown-item meetroom" href="{{url('').$row->room_id}}">{{$row->room_name}}</a>
                                        @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 mb-2">
                        <div class="card bg-info p-1 mx-0">
                            <div class="panel-header text-left px-3 py-2 text-white">
                                ปฎิทินข้อมูลการใช้บริการห้องประชุม<span class="fw-3 fs-18 text-white bg-sl-r2 px-2 radius-5">ddd</span>
                            </div>
                            <div class="panel-body bg-white">

                                <div id='calendar' ></div>

                            </div>
                            <div class="panel-footer text-end pr-5 py-2 bg-white ">
                                    <p class="m-0 fa fa-circle me-2" style="color:#A3DCA6;"></p> อนุมัติ<label class="me-3"></label>
                                    <p class="m-0 fa fa-circle me-2" style="color:#814ef7;"></p> จัดสรร<label class="me-3"></label>
                                    <p class="m-0 fa fa-circle me-2" style="color:#fa861a;"></p>ร้องขอ <label class="me-5"></label>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

    <!-- Modal -->
    <!--<div class="modal fade" id="meettingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">จองห้องประชุม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body"> 
                                <div class="row">
                                    <div class="col-md-9"> 
                                        <div class="row"> 
                                            <div class="col-md-2 text-end">
                                                <label for="meetting_title">เรื่องการประชุม :</label>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input id="meetting_title" type="text" class="form-control @error('meetting_title') is-invalid @enderror" name="meetting_title" value="{{ old('meetting_title') }}" autocomplete="meetting_title">
                                                    @error('meetting_title')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> 
                                            <div class="col-md-2 text-end">
                                                <label for="meetting_year">ปีงบประมาณ :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <select name="meetting_year" id="meetting_year" class="form-control" style="width: 100%;">
                                                    <option value="" selected>--เลือก--</option> 
                                                    @foreach ($budget_year as $year)
                                                        <option value="{{ $year->leave_year_id }}">{{ $year->leave_year_id}}</option>
                                                    @endforeach                   
                                                </select>
                                                </div>
                                            </div>                         
                                        </div>  

                                        <div class="row mt-3">  
                                            <div class="col-md-2 text-end">
                                                <label for="meetting_target">กลุ่มบุคคลเป้าหมาย :</label>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input id="meetting_target" type="text" class="form-control @error('meetting_target') is-invalid @enderror" name="meetting_target" value="{{ old('meetting_target') }}" autocomplete="meetting_target" >
                                                    @error('meetting_target')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> 
                                            <div class="col-md-2 text-end">
                                                <label for="meetting_person_qty">จำนวน :</label>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input id="meetting_person_qty" type="text" class="form-control @error('meetting_person_qty') is-invalid @enderror" name="meetting_person_qty" value="{{ old('meetting_person_qty') }}" autocomplete="meetting_person_qty" >
                                                    @error('meetting_person_qty')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>  
                                            <div class="col-md-1">
                                            <label for="lname">คน</label>
                                        </div>                       
                                        </div>  

                                        <div class="row mt-3">  
                                            <div class="col-md-2 text-end">
                                                <label for="meeting_objective_id">วัตถุประสงค์การขอใช้ :</label>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                <select name="meeting_objective_id" id="meeting_objective_id" class="form-control" style="width: 100%;">
                                                    <option value="" selected>--เลือก--</option> 
                                                    @foreach ($meeting_objective as $listobj)
                                                        <option value="{{ $listobj->meeting_objective_id }}">{{ $listobj->meeting_objective_name}}</option>
                                                    @endforeach                   
                                                </select>
                                                </div>
                                            </div> 
                                            <div class="col-md-2 text-end">
                                                <label for="meeting_tel">เบอร์โทร :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input id="meeting_tel" type="text" class="form-control @error('meeting_tel') is-invalid @enderror" name="meeting_tel" value="{{Auth::user()->tel }}" autocomplete="meeting_tel" >
                                                    @error('meeting_tel')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>                 
                                        </div>  

                                        <div class="row mt-3">  
                                            <div class="col-md-2 text-end">
                                                <label for="meeting_date_begin">ตั้งแต่วันที่ :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input id="meeting_date_begin" type="date" class="form-control @error('meeting_date_begin') is-invalid @enderror" name="meeting_date_begin" value="{{ old('meeting_date_begin') }}" autocomplete="meeting_date_begin" >
                                                    @error('meeting_date_begin')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> 
                                            <div class="col-md-2 text-end">
                                                <label for="meeting_date_end">ถึงวันที่ :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input id="meeting_date_end" type="date" class="form-control @error('meeting_date_end') is-invalid @enderror" name="meeting_date_end" value="{{ old('meeting_date_end') }}" autocomplete="meeting_date_end" >
                                                    @error('meeting_date_end')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> 
                                        </div> 

                                        <div class="row mt-3">  
                                            <div class="col-md-2 text-end">
                                                <label for="meeting_time_begin">ตั้งแต่เวลา :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input id="meeting_time_begin" type="time" class="form-control @error('meeting_time_begin') is-invalid @enderror" name="meeting_time_begin" value="{{ old('meeting_time_begin') }}" autocomplete="meeting_time_begin" >
                                                    @error('meeting_time_begin')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> 
                                            <div class="col-md-2 text-end">
                                                <label for="meeting_time_end">ถึงเวลา :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input id="meeting_time_end" type="time" class="form-control @error('meeting_time_end') is-invalid @enderror" name="meeting_time_end" value="{{ old('meeting_time_end') }}" autocomplete="meeting_time_end" >
                                                    @error('meeting_time_end')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> 
                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <div class="bg-image hover-overlay ripple">                           
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveBtn" class="btn btn-primary">Save changes</button>
                        </div>
                </div>
            </div>
    </div>-->

    <div class="modal fade" id="meettingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="saveMeetting" action="{{ route('meetting.calendar_save') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">จองห้องประชุม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> 
                        <input type="text" class="form-control" id="meetting_title" name="meetting_title">
                        <span id="meetting_title" class="text-danger"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    <!-- <button type="button" id="saveBtn" class="btn btn-primary">Save changes</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('footer')

<script> 
  $(document).ready(function() {
    $('select').select2();
    $('#meetting_year').select2({
        dropdownParent: $('#meettingModal')
    });
    $('#meeting_objective_id').select2({
        dropdownParent: $('#meettingModal')
    });

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $(function () {

          var meetting = @json($events);

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today', //  prevYear nextYea
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay',
                },               
                events: meetting, 
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDays)   {
                    console.log(start)
                    $('#meettingModal').modal('toggle');
                    // $('#saveBtn').click(function() {

                        // var meettingtitle = $('#meetting_title').val();
                        //     console.log(meettingtitle)
             
                        // var start_date = moment(start).format('YYYY-MM-DD');
                        // var end_date = moment(end).format('YYYY-MM-DD');

                        $("#saveMeetting").on('submit',function(e){ 

                            // alert('ok');
                            e.preventDefault();   
                            
                            // var meetting_title = $('#meetting_title').val();
                            // console.log(meetting_title)

                                var form = this;
                                alert('OJJJJOL');
                                $.ajax({
                                    url:$(form).attr('action'),
                                    method:$(form).attr('method'),
                                    data:new FormData(form),
                                    processData:false,
                                    dataType:'json',
                                    contentType:false,
                                    beforeSend:function(){
                                    $(form).find('span.error-text').text('');
                                    },
                                    success:function(data){
                                    if (data.status == 0 ) {
                                        
                                    } else {          
                                        Swal.fire({
                                        title: 'บันทึกข้อมูลสำเร็จ',
                                        text: "You Insert data success",
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#06D177',
                                        // cancelButtonColor: '#d33',
                                        confirmButtonText: 'เรียบร้อย'
                                        }).then((result) => {
                                        if (result.isConfirmed) {                  
                                            window.location.reload();
                                        }
                                        })      
                                    }
                                    }
                                });
                           

                                // $.ajax({
                                //     // url:"{{ route('meetting.calendar_save') }}",
                                //     url:'/calendar_save',
                                //     data:$("#saveMeetting").serialize(),
                                //     type:"POST"
                                // }).done(function(res){
                                //     alert('ok');
                                //     window.location.reload();
                                   
                                // });
                        });                                   // dataType:'json',
                                    // data:{ meettingtitle  },
                                    // data:{ meettingtitle, start_date, end_date  },
                                    // success:function(response)
                                    // {
                                    //     $('#meettingModal').modal('hide')
                                    //     $('#calendar').fullCalendar('renderEvent', {
                                    //         'meettingtitle': response.meetting_title,
                                    //         // 'start' : response.meetingdate_begin,
                                    //         // 'end'  : response.meetingdate_end,
                                    //         // 'color' : response.color
                                    //     });
                                    // },
                                    // error:function(error)
                                    // {
                                    //     if(error.responseJSON.errors) {
                                    //         $('#titleError').html(error.responseJSON.errors.title);
                                    //     }
                                    // },
                        //         });
                        // });

                       
                    // });  
                }                         
              });
        });
  

  });


</script>

@endsection