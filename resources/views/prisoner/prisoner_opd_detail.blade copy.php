@extends('layouts.report_font')
@section('title', 'PK-OFFICER || Detail')
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
                        รายละเอียดข้อมูลนักโทษที่มารักษา OPD ช่วงวันที่ {{DateThai($startdate)}} - {{DateThai($enddate)}}                       
                    </div>
                    <div class="card-body">
                        
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th> 
                                        <th>hn</th>
                                        <th>vn</th>
                                        <th>cid</th> 
                                        <th>vstdate</th>
                                        <th>fullname</th> 
                                        <th>pttype</th> 
                                        {{-- <th>pttypename</th>  --}}
                                        <th>pdx</th> 
                                        <th>money_hosxp</th>  
                                        <th>rcpt_money</th>  
                                        <th>debit</th> 
                                        <th>rcpno</th> 
                                        <th>amountpay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($datashow as $item)  
                                        <tr>
                                            <td>{{ $ia++ }}</td>
                                            <td>{{ $item->hn }}</td> 
                                            <td>{{ $item->vn }}</td>   
                                            <td>{{ $item->cid }}</td> 
                                            <td>{{ DateThai($item->vstdate )}}</td>  
                                            <td class="p-2">{{ $item->fullname }}</td> 
                                            <td> 
                                                <?php                                                       
                                                        $pttype_hos = DB::connection('mysql3')->table('pttype')->where('pttype','=',$item->pttype)->first();
                                                        $d = $pttype_hos->name;
                                                ?>
                                                 <button type="button" class="btn btn-icon btn-shadow btn-dashed btn-outline-danger" data-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content=" {{$d}}">
                                                    {{ $item->pttype }}
                                                </button> 
                                            </td>  
                                            {{-- <td class="p-2">{{ $item->tname }}</td>    --}}
                                            <td>{{ $item->pdx }}</td> 
                                            <td>
                                                <?php                                                       
                                                        $money = DB::connection('mysql3')->table('opitemrece')->where('vn','=',$item->vn)->first();
                                                        // $icode = $money->vn;
                                                        $dataitem_ =  DB::connection('mysql3')->select('
                                                            SELECT o.vn,o.hn,o.icode,s.name as dname,o.qty,o.unitprice,o.sum_price 
                                                                    FROM opitemrece o
                                                                    left outer join s_drugitems s on s.icode = o.icode
                                                                WHERE o.vn = "'.$item->vn.'" 
                                                        ');
                                                        foreach ($dataitem_ as $key => $value) {
                                                            $oicode = $value->icode;
                                                            $oname = $value->dname;
                                                            $oname = $value->dname;
                                                        }
                                                ?>
                                                 <button type="button" class="btn btn-icon btn-shadow btn-dashed btn-outline-danger" data-container="body" data-bs-toggle="popover" data-bs-placement="top" 
                                                    data-bs-content="" id="DetailModal">{{ number_format($item->money_hosxp,2)}}
                                                </button>                                                
                                            </td>                                            
                                            <td>{{ number_format($item->rcpt_money,2) }}</td> 
                                            <td>{{ number_format($item->debit,2) }}</td> 
                                            <td>{{ $item->rcpno }}</td>  
                                            <td>{{ number_format($item->amountpay,2) }}</td> 
                                        </tr>    
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                
                    </div>
                </div>
            </div>            
        </div>
</div> 

<div class="modal fade" id="DetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    รายละเอียดค่าใช้จ่าย
                </h5> 
            </div>
            <div class="modal-body"> 
 

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
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        $("#spinner-div").hide(); //Request is complete so hide spinner

        
    });
</script>
@endsection
 
 