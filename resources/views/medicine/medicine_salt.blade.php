@extends('layouts.medicine')
@section('title', 'PK-OFFICER || แพทย์แผนไทย')

     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
 ?>


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
               border: 10px #ddd solid;
               border-top: 10px #20a886 solid;
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
               .inputmedsalt{
                    border-radius: 4em 4em 4em 4em;
                    box-shadow: 0 0 10px rgb(189, 187, 187);
                }
                .cardmedsalt{
                    border-radius: 4em 4em 4em 4em;
                    box-shadow: 0 0 10px rgb(122, 121, 121);
                    /* box-shadow: 0 0 10px rgb(232, 187, 243); */
                }
    </style>
     <div class="tabs-animation">
        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div> 
        </div> 
        <div id="preloader">
            <div id="status">
                <div class="spinner"> 
                </div>
            </div>
        </div>
    {{-- <div class="container-fluid"> --}}
        <div class="row"> 
            <div class="col-xl-12">
                <form action="{{ route('me.medicine_salt') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-2"> 
                            <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail Over the salt pot</h4>
                            <p class="card-title-desc"> การลงข้อมูล ทับหม้อเกลือ บัตรทองในเขต  </p>
                        </div>
                        <div class="col"></div>
                        <div class="col-md-1 text-end">วันที่</div>
                        <div class="col-md-4 text-center">
                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                <input type="text" class="form-control d-shadow" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                    data-date-language="th-th" value="{{ $start }}" required/>
                                <input type="text" class="form-control d-shadow" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                    data-date-language="th-th" value="{{ $end }}"/>  
                                    {{-- </div>  --}}

                                    {{-- <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" name="startdate" id="datepicker"  data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                            value="{{ $start }}">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span> 
                                    </div> --}}
                                {{-- </div> --}}
                                {{-- <div class="col-md-1 text-center">ถึงวันที่</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group" id="datepicker1"> 
                                        <input type="text" class="form-control" name="enddate" id="datepicker2" data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                            value="{{ $end }}">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div> --}}
                                <button type="submit" class="ladda-button btn-pill btn btn-primary d-shadow" data-style="expand-left">
                                    <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                                    <span class="ladda-spinner"></span>
                                </button> 
                                {{-- <div class="col-md-2">
                                    <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                        <i class="fa-solid fa-magnifying-glass me-2"></i>
                                        ค้นหา
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                        {{-- <div class="col"></div> --}}
                </form>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col"></div>
            <div class="col-md-8">
                <div class="card cardshadow">
                    {{-- <div class="card-header ">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>การลงข้อมูล ทับหม้อเกลือ บัตรทองในเขต </h5>
                            </div> 
                        </div>
                    </div> --}}
                    {{-- <div class="card-header">
                        การลงข้อมูล ทับหม้อเกลือ บัตรทองในเขต  
                        <div class="btn-actions-pane-right">
                             
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">ปี</th>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">จำนวนผู้ป่วย(ครั้ง)</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                    @foreach ($datashow as $item)
                                        <tr>
                                            <td class="text-center">{{$i++}}</td> 
                                            <td class="text-center">{{$item->years}}</td>

                                            @if ($item->months == '1')
                                            <td width="15%" class="text-center">มกราคม</td>
                                            @elseif ($item->months == '2')
                                                <td width="15%" class="text-center">กุมภาพันธ์</td>
                                            @elseif ($item->months == '3')
                                                <td width="15%" class="text-center">มีนาคม</td>
                                            @elseif ($item->months == '4')
                                                <td width="15%" class="text-center">เมษายน</td>
                                            @elseif ($item->months == '5')
                                                <td width="15%" class="text-center">พฤษภาคม</td>
                                            @elseif ($item->months == '6')
                                                <td width="15%" class="text-center">มิถุนายน</td>
                                            @elseif ($item->months == '7')
                                                <td width="15%" class="text-center">กรกฎาคม</td>
                                            @elseif ($item->months == '8')
                                                <td width="15%" class="text-center">สิงหาคม</td>
                                            @elseif ($item->months == '9')
                                                <td width="15%" class="text-center">กันยายน</td>
                                            @elseif ($item->months == '10')
                                                <td width="15%" class="text-center">ตุลาคม</td>
                                            @elseif ($item->months == '11')
                                                <td width="15%" class="text-center">พฤษจิกายน</td>
                                            @else
                                            <td width="15%" class="text-center">ธันวาคม</td>
                                            @endif

                                            <td class="text-center">
                                                <a href="{{ url('medicine_salt_sub/'.$item->months.'/'.$start.'/'.$end) }}" target="_blank">{{ $item->countan }}</a> 
                                            </td>  
                                        </tr>
                                    @endforeach
    
                            </tbody>
                        </table>
                            
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
    </div>
    

    @endsection
    @section('footer')
    
    
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();
    
                $('select').select2();
                $('#ECLAIM_STATUS').select2({
                    dropdownParent: $('#detailclaim')
                });
    
                $('#users_group_id').select2({
                    placeholder: "--เลือก-- ",
                    allowClear: true
                });
    
                $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                });
                $('#datepicker2').datepicker({
                    format: 'yyyy-mm-dd'
                });
    
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $(document).on('click', '#printBtn', function() {
                    var month_id = $(this).val();
                    alert(month_id);
                    
                });
     
               
            });
        </script>
    
    @endsection
