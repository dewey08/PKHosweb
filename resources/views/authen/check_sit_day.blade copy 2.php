@extends('layouts.checksit')
@section('title', 'PK-OFFICER || checksit')
@section('content')
<style>
         #button{
                display:block;
                margin:20px auto;
                padding:10px 30px;
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
                width: 40px;
                height: 40px;
                border: 4px #ddd solid;
                border-top: 4px #2e93e6 solid;
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
    {{-- <form action="{{ route('claim.check_sit_day') }}" method="GET">
        @csrf
        <div class="row"> 
            <div class="col"></div>
            <div class="col-md-1 text-end">วันที่</div>
            <div class="col-md-2 text-center">
                <div class="input-group" id="datepicker1">
                    <input type="text" class="form-control" name="startdate" id="datepicker"  data-date-container='#datepicker1'
                        data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                        value="{{ $start }}">

                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                </div>
            </div>
            <div class="col-md-1 text-center">ถึงวันที่</div>
            <div class="col-md-2 text-center">
                <div class="input-group" id="datepicker1">
                    <input type="text" class="form-control" name="enddate" id="datepicker2" data-date-container='#datepicker1'
                        data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                        value="{{ $end }}">

                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                </div>
            </div>    
            <div class="col-md-3">
                <button type="submit" class="btn btn-info" > 
                    ค้นหา
                </button> 
                <button type="button" class="btn btn-success" id="PullChecksitbtn"> 
                    ดึงข้อมูล
                </button> 
                <button type="button" class="btn btn-warning" id="Checksitbtn">  
                    ตรวจสอบสิทธิ์
                </button>
            </div>  
             <div class="col"></div>   
        </div> 
    </form> --}}
        <div class="row mt-3 text-center">  
            <div id="overlay">
                <div class="cv-spinner">
                  <span class="spinner"></span>
                </div>
              </div>
        </div> 
        <div class="row mt-3"> 
            <div class="col-md-12"> 
                {{-- <div class="main-card mb-3 card"> --}}
                    <div class="card-header">
                        Report check sit
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group"> 
                                <button class="active btn btn-focus">auto</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('claim.check_sit_day') }}" method="GET">
                            @csrf
                            <div class="row mt-3"> 
                                <div class="col"></div>
                                <div class="col-md-1 text-end">วันที่</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" name="startdate" id="datepicker"  data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                            value="{{ $start }}">
                    
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-1 text-center">ถึงวันที่</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" name="enddate" id="datepicker2" data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                            value="{{ $end }}">
                    
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>    
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-info" > 
                                        ค้นหา
                                    </button> 
                                    <button type="button" class="btn btn-success" id="PullChecksitbtn"> 
                                        ดึงข้อมูล
                                    </button> 
                                    <button type="button" class="btn btn-warning" id="Checksitbtn">  
                                        ตรวจสอบสิทธิ์
                                    </button>
                                </div>  
                                 <div class="col"></div>   
                            </div> 
                        </form>
                        
                        <div class="table-responsive mt-5">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>vn</th>
                                        <th>hn</th>
                                        <th>cid</th>
                                        <th>pttype Hos</th>
                                        <th>pttype สปสช</th>
                                        <th>vstdate</th>
                                        <th>vsttime</th>
                                        <th>fullname</th>
                                        <th>staff</th>                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($data_sit as $item) 
                                    <?php 
                                            $data_ = DB::connection('mysql7')->select(' 
                                                SELECT * FROM check_sit_auto  
                                               where subinscl = "'.$item->pttype.'"
                                            ');  
                                            $data_c = DB::connection('mysql7')->table('check_sit_auto')->where('subinscl','=',$item->pttype)->count(); 
                                    ?> 

                                    @if ( $item->pttype != $item->subinscl)
                                        <tr style="background-color: rgb(255, 255, 25)">
                                            <td>{{ $ia++ }}</td>
                                            <td>{{ $item->vn }}</td>
                                            <td>{{ $item->hn }}</td>
                                            <td>{{ $item->cid }}</td>  

                                            <td>
                                                {{-- <a href="" data-toggle="tooltip" data-placement="top" title="222">
                                                    {{ $item->pttype }}
                                                </a> --}}
                                                <button type="button" class="btn btn-secondary">
                                                    {{ $item->pttype }}                                               
                                                <i class="fa-solid fa-stamp font-size-22 mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ "> </i>  
                                            </button>
                                            </td>                                       
                                            <td >{{ $item->subinscl }}</td>
                                            
                                            <td>{{ $item->vstdate }}</td>
                                            <td>{{ $item->vsttime }}</td>
                                            <td>{{ $item->fullname }}</td>
                                            <td>{{ $item->staff }}</td> 
                                        </tr>
                                    @else
                                        <tr style="background-color: rgb(255, 255, 255)">
                                            <td>{{ $ia++ }}</td>
                                            <td>{{ $item->vn }}</td>
                                            <td>{{ $item->hn }}</td>
                                            <td>{{ $item->cid }}</td>  
                                            {{--  <td style="background-color: rgb(249, 217, 210)">{{ $item->pttype }}</td>                                       
                                            <td style="background-color: rgb(219, 247, 255)">{{ $item->subinscl }}</td> --}}
                                            
                                            <td style="background-color: rgb(255, 255, 255)">{{ $item->pttype }}</td>                                       
                                            <td style="background-color: rgb(255, 255, 255)">{{ $item->subinscl }}</td>

                                            <td>{{ $item->vstdate }}</td>
                                            <td>{{ $item->vsttime }}</td>
                                            <td>{{ $item->fullname }}</td>
                                            <td>{{ $item->staff }}</td> 
                                        </tr>
                                    @endif
                                   
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                
                    </div>
                </div>
            </div>            
        </div>
</div> 
      
@endsection
@section('footer')

<script>
     window.setTimeout(function() {             
            window.location.reload();
        },500000);
    $(document).ready(function() {
        // $("#overlay").fadeIn(300);　

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

        $("#spinner-div").hide(); //Request is complete so hide spinner

        $('#PullChecksitbtn').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val();  
                // alert(datepicker);
               
                    Swal.fire({
                        title: 'ต้องการดึงข้อมูลใช่ไหม ?',
                        text: "You won't pull Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner-div").show(); //Load button clicked show spinner
                                
                                $.ajax({
                                        url: "{{ route('claim.check_sit_daysearch') }}",
                                        type: "POST",
                                        dataType: 'json',
                                        data: {
                                            datepicker,
                                            datepicker2                      
                                        },
                                        success: function(data) {
                                            if (data.status == 200) {
                                                Swal.fire({
                                                    title: 'ดึงข้อมูลสำเร็จ',
                                                    text: "You Pull data success",
                                                    icon: 'success',
                                                    showCancelButton: false,
                                                    confirmButtonColor: '#06D177',
                                                    confirmButtonText: 'เรียบร้อย'
                                                }).then((result) => {
                                                    if (result
                                                        .isConfirmed) {
                                                        console.log(
                                                            data);
                                                        window.location.reload();
                                                        $('#spinner-div').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                    }
                                                })
                                            } else {                                                
                                            }
                                        },
                                        complete: function () {
                                            // $('#spinner-div').hide();//Request is complete so hide spinner
                                        }
                                    // }).done(function() {
                                    // setTimeout(function(){
                                    //     $("#overlay").fadeOut(300);
                                    // },500);
                                });
 
                            }
                        })
                
        });
        $('#Checksitbtn').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val();  
                // alert(datepicker);
                Swal.fire({
                        title: 'ต้องการปรับข้อมูลใช่ไหม ?',
                        text: "You won't Update Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Update it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner-div").show(); //Load button clicked show spinner

                                $.ajax({
                                    url: "{{ route('claim.check_sit_auto') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                      
                                    },
                                    success: function(data) {
                                        if (data.status == 200) {
                                            Swal.fire({
                                                title: 'ปรับข้อมูลสำเร็จ',
                                                text: "You Insert data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner-div').hide();//Request is complete so hide spinner
                                                    setTimeout(function(){
                                                        $("#overlay").fadeOut(300);
                                                    },500);
                                                }
                                            })    
                                                                     
                                        } else {   
                                        }
                                         
                                    },
                                    // complete: function (data) {
                                    //     $('#spinner-div').hide();//Request is complete so hide spinner
                                    //     setTimeout(function(){
                                    //         $("#overlay").fadeOut(300);
                                    //     },500);
                                    // }
                                    })
                                    // .done(function() {
                                        // setTimeout(function(){
                                        //     $("#overlay").fadeOut(300);
                                        // },500);
                                    // });
                            }
                        })
                
                




        });
    });
</script>
@endsection
 
 