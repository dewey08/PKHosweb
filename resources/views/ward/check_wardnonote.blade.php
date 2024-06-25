@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || Ward')
   

@section('content')
   
    <?php  
        $ynow = date('Y')+543;
        $yb =  date('Y')+542;
        $mo =  date('m');
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
               border-top: 10px rgb(212, 106, 124) solid;
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
        
        <div class="row"> 
            <div class="col-xl-12 col-md-3">
                <div class="main-card mb-3 card">  
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="card-title ms-3 mt-3">Detail Ward Admit</h4>
                        <p class="card-title-desc ms-3">รายละเอียดจำนวนผู้ป่วยใน</p>
                    </div>
                    <div class="col"></div>
                    <div class="col-md-2 text-end"></div>
                </div>
                
                    <div class="table-responsive me-2 ms-2 mb-2">
                        <table id="example" class="table table-hover table-sm dt-responsive nowrap"
                        style=" border-spacing: 0; width: 100%;">
                            <thead>
                                <tr style="font-size: 13px"> 
                                    <th width="5%" class="text-center">ลำดับ</th>  
                                    <th class="text-center" width="10%">HN</th> 
                                    <th class="text-center" width="10%">AN</th> 
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th class="text-center" >cid</th>
                                    {{-- <th class="text-center" >ICD10 PDX</th> --}}
                                    <th class="text-center">วันที่ ADMIT</th>
                                    <th class="text-center" >สิทธิ Hosxp</th>
                                    {{-- <th class="text-center">วันที่ DISCHART</th>    --}}
                                    <th class="text-center" >วันนอน</th>
                                    <th class="text-center" >ค่ารักษา</th>
                                    <th class="text-center" >อุปกรณ์</th>
                                    <th class="text-center" >NOTE งานประกัน</th>
                                    <th class="text-center" >ห้องพิเศษ</th>
                                  
                                    <th class="text-center" >สิทธิ สปสช</th>
                                    <th class="text-center" >รพ.HOSXP</th>
                                    <th class="text-center" >รพ.สปสช/วันที่เริ่มใช้</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($data_warddetatil as $item) 
                                    <tr style="font-size: 12px">                                                  
                                        <td class="text-center" width="5%">{{ $i++ }}</td>  
                                        <td class="text-center" width="0%">{{ $item->hn }}</td> 
                                        <td class="text-center" width="0%">{{ $item->an }}</td> 
                                        <td class="p-2">{{ $item->fullname }}</td> 
                                        <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                        {{-- <td class="text-center" width="10%">{{ $item->pdx }}</td>   --}}
                                        <td class="text-center" width="10%">{{ $item->regdate }}</td> 
                                        {{-- <td class="text-center" width="10%">{{ $item->dchdate }}</td>   --}}
                                        <td class="text-center" width="7%">{{ $item->HOSpttype }}</td>  
                                        <td class="text-center" width="7%">{{ $item->admdate }}</td>  
                                        <td class="text-center" width="10%">{{ number_format($item->Aincome , 2)}}</td>  
                                        <td class="text-center" width="7%">{{ $item->inc08 }}</td>  
                                        <td class="p-2" width="10%">{{ $item->nn }}</td>  
                                        <td class="text-center" width="10%">{{ $item->abname }}</td>  
                                      
                                        <td class="text-center" width="10%">{{ $item->spsch }}</td>  
                                        <td class="text-center" width="10%">{{ $item->hospmain }}</td>  
                                        <td class="text-center" width="10%">{{ $item->hosstartdate }}</td>  
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
              
        });
    </script>
    @endsection
