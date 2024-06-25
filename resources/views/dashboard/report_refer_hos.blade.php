@extends('layouts.report_font')
@section('title', 'PK-OFFICER || REFER')
@section('content')
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
  
<div class="tabs-animation">
    
        <div class="row text-center">  
            <div id="overlay">
                <div class="cv-spinner">
                  <span class="spinner"></span>
                </div>
              </div>
              
        </div> 
        <div class="row"> 
            <div class="col-md-12"> 
                 <div class="main-card mb-3 card">
                    <div class="card-header">
                        Report REFER Hos
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">  
                             
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('rep.report_refer_hos') }}" method="GET" >
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
                                <div class="col-md-4">
                                
                                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                        <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                    </button>
                                   
                                </div>  
                                 <div class="col"></div>   
                            </div> 
                        </form>
                        
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>department</th> 
                                        <th>vn</th>
                                        <th>hn</th>
                                        {{-- <th>icode</th> --}}
                                        <th>ชื่อ-นามสกุล</th> 
                                        <th>refer_date</th>
                                        <th>vstdate</th>
                                        <th>vsttime</th> 
                                        <th>doctor_name</th> 
                                        <th>hospmain</th>
                                        <th>hospname</th> 
                                        <th>AMBULANCE</th> 
                                        <th>พยาบาล</th>  
                                        <th>ค่าพาหนะ</th> 
                                        {{-- <th>ค่ารถ refer รับกลับ</th>  --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $number = 0; ?>
                                    @foreach ($datashow_ as $inforefer)
                                        <?php $number++; ?>  
                                        
                                        <?php   
                                            $detail_ = DB::connection('mysql3')->select('
                                                SELECT o.item_no,o.icode,concat(s.name," ",s.strength," ",s.units) as listname ,o.qty,o.sum_price,o.unitprice,s.nhso_adp_code
                                                from opitemrece o  
                                                left outer join s_drugitems s on s.icode=o.icode   
                                                WHERE o.vn="'.$inforefer->vn.'" 
                                                AND s.nhso_adp_code = "S1801" 
                                              
                                            ');                           
                                        ?> 
                                        @if ($inforefer->with_ambulance == 'Y' && $inforefer->with_nurse == 'Y')
                                            <tr height="20" style="background-color: rgb(182, 243, 238)">
                                                <td class="text-font" style="text-align: center;">{{$number}}</td>  
                                                <td class="text-font text-pedding" style="text-align: left;width: 5%;">{{$inforefer->department}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">
                                                
                                                    @foreach ($detail_ as $item) 
                                                        @if ($item->icode !='3003086')
                                                        <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary"
                                                            data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg{{$inforefer->vn}} ">
                                                            {{$inforefer->vn}} 
                                                        </button>
                                                        @else
                                                        <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger"
                                                            data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg{{$inforefer->vn}} ">
                                                            {{$inforefer->vn}} 
                                                        </button>
                                                        @endif 
                                                    
                                                    @endforeach
                                                </td>
                                                <td class="text-font text-pedding" style="text-align: left;">
                                                    <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning"
                                                        data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg{{$inforefer->vn}} ">
                                                        {{$inforefer->hn}} 
                                                    </button>
                                                
                                                </td>  
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->ptname}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{DateThai($inforefer->refer_date)}}</td>  
                                                <td class="text-font text-pedding" style="text-align: left;">{{DateThai($inforefer->vstdate)}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->vsttime}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->doctor_name}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->hospmain}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->hospname}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->with_ambulance}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->with_nurse}}</td>   
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->PriceRefer}}</td> 
                                                {{-- <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->ReferBack}}</td>  --}}
                                            </tr>
                                        @else
                                            <tr height="20">
                                                <td class="text-font" style="text-align: center;">{{$number}}</td>  
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->department}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">
                                                
                                                    @foreach ($detail_ as $item) 
                                                        @if ($item->icode !='3003086')
                                                        <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary"
                                                            data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg{{$inforefer->vn}} ">
                                                            {{$inforefer->vn}} 
                                                        </button>
                                                        @else
                                                        <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger"
                                                            data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg{{$inforefer->vn}} ">
                                                            {{$inforefer->vn}} 
                                                        </button>
                                                        @endif 
                                                    
                                                    @endforeach
                                                </td>
                                                <td class="text-font text-pedding" style="text-align: left;">
                                                    <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning"
                                                        data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg{{$inforefer->vn}} ">
                                                        {{$inforefer->hn}} 
                                                    </button>
                                                
                                                </td>  
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->ptname}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{DateThai($inforefer->refer_date)}}</td>  
                                                <td class="text-font text-pedding" style="text-align: left;">{{DateThai($inforefer->vstdate)}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->vsttime}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->doctor_name}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->hospmain}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->hospname}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->with_ambulance}}</td>
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->with_nurse}}</td>  
                                                <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->PriceRefer}}</td> 
                                                {{-- <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->ReferBack}}</td>   --}}
                                            </tr>
                                        @endif
                                       
    
                                        
                                        <!-- Large modal -->
                                        <div class="modal fade bd-example-modal-lg{{$inforefer->vn}}" tabindex="-1" role="dialog"
                                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">VN = {{$inforefer->vn}} / ชื่อ-นามสกุล {{$inforefer->ptname}}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body"> 
                                                        <div class="row">
                                                            <div class="col-md-2"><p>icode</p></div>
                                                            <div class="col-md-5"><p>listname</p></div>
                                                            <div class="col-md-1"><p>qty</p></div>
                                                            <div class="col-md-2"><p>unitprice</p></div>
                                                            <div class="col-md-2"><p>sum_price</p></div>
                                                        </div>

                                                        @foreach ($detail_ as $item)  
                                                           
                                                            <div class="row">

                                                                {{-- @if ($item->icode = '3003086')
                                                                <div class="col-md-2"><p style="background-color: red">{{$item->icode}}</p></div>
                                                                @else --}}
                                                                <div class="col-md-2"><p>{{$item->icode}}</p></div>
                                                                {{-- @endif   --}}

                                                                <div class="col-md-5"><p>{{$item->listname}}</p></div>
                                                                <div class="col-md-1"><p>{{$item->qty}}</p></div>
                                                                <div class="col-md-2"><p>{{$item->unitprice}}</p></div>
                                                                <div class="col-md-2"><p>{{$item->sum_price}}</p></div>
                                                            </div>
                                                                
                                                           
                                                            {{-- <div class="row" style="background-color: red">
                                                                <div class="col-md-2"><p>{{$item->icode}}</p></div>
                                                                <div class="col-md-5"><p>{{$item->listname}}</p></div>
                                                                <div class="col-md-1"><p>{{$item->qty}}</p></div>
                                                                <div class="col-md-2"><p>{{$item->unitprice}}</p></div>
                                                                <div class="col-md-2"><p>{{$item->sum_price}}</p></div>
                                                            </div> --}}
                                                                
                                                                                                                   
                                                            
                                                        @endforeach
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-dismiss="modal">
                                                            <i class="fa-solid fa-xmark me-2"></i>
                                                            Close
                                                        </button>
                                                        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                    </div>
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

        $('#example').DataTable();

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $("#spinner-div").hide(); //Request is complete so hide spinner
       
    });
</script>
@endsection
 
 