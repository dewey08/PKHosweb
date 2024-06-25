@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || SSOP')
   

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
               border-top: 10px #fd6812 solid;
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
     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
 ?>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
        <form action="{{ route('claim.Tranfer_stmsearch') }}" method="POST">
            @csrf
                <div class="row"> 
                    <div class="row"> 
                        <div class="col-md-2 text-end"></div>
                        <div class="col-md-1 text-end">วันที่</div>
                        <div class="col-md-6 text-center">
                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                            <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1'
                             data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $start }}"/>
                            <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1'
                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $end }}"/>
                            <button type="submit" class="btn btn-info">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                ดึงข้อมูล 
                            </button>
                            <a href="{{url('Tranfer_stm_save')}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</a>     
                        </div>
                    </div>
                </div>

            </form>
         
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body shadow-lg">
                       
                        <h4 class="card-title">UP STATMENT</h4>
                        <p class="card-title-desc">นำเข้า STM.
                        </p>

                        <div>
                            <div class="table-responsive">
                                <table id="key-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">ลำดับ</th>  
                                            <th class="text-center">VN</th>
                                            <th class="text-center">AN</th>
                                            <th class="text-center">HN</th>
                                            <th class="text-center">PID</th>
                                            <th class="text-center">FULLNAME</th>   
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        {{-- @foreach ($ssop_dispensing as $item3) 
                                            <tr>   
                                                <td class="text-center">{{ $i++ }}</td>   
                                                <td class="text-center">{{ $item3->ProviderID }} </td>
                                               
                                                <td class="text-center" >{{ $item3->Itemcnt }}</td> 
                                                <td class="text-center" >{{ number_format($item3->ChargeAmt, 2) }}</td> 
                                                <td class="text-center" >{{ number_format($item3->ClaimAmt, 2) }}</td> 
                                             
                                                <td class="text-center" >{{ $item3->Reimburser }}</td> 
                                               
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
 
                    </form>
                       
                    </div>
                </div>
            </div>
        </div>

        
    </div>
    </div>
    
    @endsection
    @section('footer')
     <!-- Plugins js -->
     <script src="assets/libs/dropzone/min/dropzone.min.js"></script>
     <script src="assets/js/app.js"></script>
    <script>        
        $(document).ready(function() {
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
        });  
        
    </script>
    <script type="text/javascript">
       
        Dropzone.autoDiscover = false;
  
        var dropzone = new Dropzone('#dropzone_stm', {
              thumbnailWidth: 200,
              maxFilesize: 30,
              maxFiles: 20,
              acceptedFiles: ".jpeg,.jpg,.png,.gif,.xls,.pdf,.xlsx"
            });
           
    </script>
    @endsection
