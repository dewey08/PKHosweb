@extends('layouts.report_font')
@section('title', 'PK-OFFICER || Colostomy')
 
@section('content')
   
    <?php  
        $ynow = date('Y')+543;
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
   <div class="tabs-animation mb-5">

    <div class="row text-center">
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div> 
    </div>

    <form action="{{ url('ins_a') }}" method="GET">
        @csrf
        <div class="row ms-3 me-3 mt-3"> 
            <div class="col-md-2">
                <h4 class="card-title">Colostomy OPD</h4>
                <p class="card-title-desc">รายละเอียดข้อมูล Colostomy OPD</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-3 text-end">
               
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}" required/>  
                </div> 
            </div>
            <div class="col-md-1 text-end mt-2">แผนก</div>
            <div class="col-md-2">
                <select name="depcode" id="depcode" class="form-control" style="width: 100%">
                    <option value="">--เลือก--</option>
                    @foreach ($datadep as $item)
                    @if ($depcode == $item->depcode)
                        <option value="{{$item->depcode}}" selected>{{$item->department}}</option>
                    @else
                        <option value="{{$item->depcode}}">{{$item->department}}</option>
                    @endif                   
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 text-start">
                <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                    <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                    ค้นหา
                </button> 
            </div>
        </div>
    </form> 

    <div class="row ms-3 me-3">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    รายละเอียดข้อมูล Colostomy
                    <div class="btn-actions-pane-right">

                    </div>
                </div>
                <div class="card-body"> 
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th> 
                                <th class="text-center" >vn</th>
                                <th class="text-center" >hn</th>
                                <th class="text-center" >cid</th>
                                <th class="text-center">ptname</th> 
                                <th class="text-center">vstdate</th> 
                                <th class="text-center">pttype</th> 
                                <th class="text-center">icode</th>
                                <th class="text-center">insname</th> 
                                <th class="text-center">qty</th> 
                                <th class="text-center">unitprice</th> 
                                <th class="text-center">income</th> 
                                <th class="text-center">rcpt_money</th> 
                                <th class="text-center">debit</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number = 0; ?>
                            @foreach ($datashow as $item)
                                <?php $number++; ?>                               
                                <tr height="20" style="font-size: 13px;">
                                    <td class="text-font" style="text-align: center;" width="4%">{{ $number }}</td>  
                                            <td class="text-center" width="8%">{{ $item->vn }}</td> 
                                            <td class="text-center" width="5%">{{ $item->hn }}</td>   
                                            <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                            <td class="p-2" >{{ $item->ptname }}</td>  
                                            <td class="text-center" width="8%">{{ $item->vstdate }}</td>    
                                            <td class="text-center" width="5%">{{ $item->pttype }}</td> 
                                            <td class="text-center" width="5%">{{ $item->icode }}</td> 
                                            <td class="p-2" width="10%">{{ $item->insname }}</td> 
                                            <td class="text-center" width="5%">{{ $item->qty }}</td> 
                                            <td class="text-center" width="5%">{{ $item->unitprice }}</td> 
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="7%">{{ number_format($item->income,2)}}</td> 
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="7%">{{ number_format($item->rcpt_money,2)}}</td> 
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="7%">{{ number_format($item->debit,2)}}</td> 
                                        </td>
                                </tr> 
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
    @apexchartsScripts
    @endsection
    @section('footer') 
 
    <script>
        $(document).ready(function() {
            $('#depcode').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
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
