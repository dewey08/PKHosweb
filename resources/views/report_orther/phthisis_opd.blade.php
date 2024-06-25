@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || วัณโรค')
 
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
               border-top: 10px #1fdab1 solid;
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
    
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
        <form action="{{ url('phthisis_opd') }}" method="GET">
            @csrf
        <div class="row"> 
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end"> 
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' autocomplete="off"
                     data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $startdate }}"/>
                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' autocomplete="off"
                    data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $enddate }}"/>
                   
                </div>
            </div>
            <div class="col-md-1"> 
                <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                    <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                    ค้นหา
                </button>   
            </div> 
        
        </div>
    </form> 
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body shadow-lg">
                        <div class="row mt-3 text-center">  
                            <div id="overlay">
                                <div class="cv-spinner">
                                <span class="spinner"></span>
                                </div>
                            </div>
                        </div> 
                      
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="card-title">Detail </h4>
                                <p class="card-title-desc">รายละเอียดวัณโรค OPD แยกตามสิทธิ์</p>
                            </div>
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                
                            </div>
                        </div>

                        <p class="mb-0">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr> 
                                            <th width="5%" class="text-center">ลำดับ</th>  
                                            <th class="text-center" width="5%">pttype</th> 
                                            <th class="text-center">name</th>
                                            <th class="text-center" >countvn</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($phthisis_opd as $item) 
                                            <tr>                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td>   
                                                <td class="text-center" width="5%">{{ $item->pttype }}</td> 
                                                <td class="p-2" >{{ $item->name }}</td> 
                                                <td class="text-center" width="5%">{{ $item->countvn }}</td>  
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </p>
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
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#stamp').on('click', function(e) {
            if($(this).is(':checked',true))  
            {
                $(".sub_chk").prop('checked', true);  
            } else {  
                $(".sub_chk").prop('checked',false);  
            }  
            }); 
             
            $("#spinner-div").hide(); //Request is complete so hide spinner

          
          
        });
    </script>
    @endsection
