@extends('layouts.user')
@section('title', 'PK-OFFICER || แจ้งซ่อมคอมพิวเตอร์')
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
    use App\Http\Controllers\UsersuppliesController;
          use App\Http\Controllers\StaticController;
          use App\Models\Car_service;
      
          $refnumber = UsersuppliesController::refnumber();    
        //   $checkhn = StaticController::checkhn($iduser);
        //   $checkhnshow = StaticController::checkhnshow($iduser);
        //   $count_suprephn = StaticController::count_suprephn($iduser);
        //   $count_bookrep_po = StaticController::count_bookrep_po();
        //   $idselect = StaticController::idselect();
    ?>
 

    <div class="container-fluid">
   
      <div class="row justify-content-center">
        <div class="row invoice-card-row">  
            <div class="col-md-12 mt-2">
                <div class="card bg-info p-1 mx-0 shadow-lg">
                    <div class="panel-header text-left px-3 py-2 text-white">
                        ปฎิทินข้อมูลการแจ้งซ่อมคอมพิวเตอร์<span
                            class="fw-3 fs-18 text-white bg-sl-r2 px-2 radius-5"> </span>
                    </div>
                    <div class="panel-body bg-white">

                        <div id='calendar'></div>

                    </div>
                    <div class="panel-footer text-end pr-5 py-2 bg-white ">
                        <p class="m-0 fa fa-circle me-2" style="color:#3CDF44;"></p> ซ่อมเสร็จ<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#814ef7;"></p> ดำเนินการ<label
                                class="me-3"></label>
                                <p class="m-0 fa fa-circle me-2" style="color:#07D79E;"></p> รออะไหล่<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#E80DEF;"></p> ส่งซ่อมนอก<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#f50000;"></p> แจ้งยกเลิก<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#ab9e9e;"></p> ยกเลิก<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#fa861a;"></p>แจ้งซ่อม <label
                                class="me-5"></label>
                            
                    </div>
                </div>
            </div>                   
    </div>
</div>



@endsection
@section('footer') 
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="{{ asset('js/gcpdfviewer.js') }}"></script> 



<script>
  $(document).ready(function() {

            $('select').select2();
            $('#car_location_name').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#car_service_location').select2({
                dropdownParent: $('#carservicessModal')
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });           

        $(function() {
            var carservicess = @json($events);
            $('#calendar').fullCalendar({
                header: {
                            left: 'prev,next today', //  prevYear nextYea
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay',
                        },
                        events: carservicess, 
                        selectable: true,
                        selectHelper: true,
                        select: function(start, end, allDays) {
                                // console.log(start)
                                // $('#carservicessModal').modal('toggle');
                                // $('#closebtn').click(function() {
                                //     $('#carservicessModal').modal('hide');
                                //     window.location.reload();   
                                // });
                            },
                           
                            
            });
            
        });

    

  });

</script>


@endsection
