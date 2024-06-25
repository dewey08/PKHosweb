@extends('layouts.pkclaim')
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
                        <div class="btn-actions-pane-right">
                            <a href="{{url('prisoner_opd_detail_excel/'.$month.'/'.$startdate.'/'.$enddate)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                <i class="fa-solid fa-file-excel me-2"></i>
                                Export To Excel
                            </a>
                        </div>                    
                    </div>
                    <div class="card-body">
                        
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th> 
                                        {{-- <th>hn</th> --}}
                                        {{-- <th>vn</th> --}}
                                        <th>cid</th> 
                                        <th>vstdate</th>
                                        <th>fullname</th> 
                                        {{-- <th>pttype</th>  --}}
                                        {{-- <th>pttypename</th>  --}}
                                        {{-- <th>pdx</th>  --}}
                                        <th>money_hosxp</th>  
                                        <th>rcpt_money</th>  
                                        <th>debit</th> 
                                        {{-- <th>rcpno</th>  --}}
                                        {{-- <th>amountpay</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($datashow as $item)  
                                        <tr>
                                            <td>{{ $ia++ }}</td>
                                            {{-- <td>{{ $item->hn }}</td>  --}}
                                            {{-- <td>{{ $item->vn }}</td>    --}}
                                            <td>{{ $item->cid }}</td> 
                                            <td>{{ DateThai($item->vstdate )}}</td>  
                                            <td class="p-2">{{ $item->fullname }}</td> 
                                            {{-- <td> 
                                                <?php                                                       
                                                        $pttype_hos = DB::connection('mysql3')->table('pttype')->where('pttype','=',$item->pttype)->first();
                                                        $d = $pttype_hos->name;
                                                ?>
                                                 <button type="button" class="btn btn-icon btn-shadow btn-dashed btn-outline-danger" data-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content=" {{$d}}">
                                                    {{ $item->pttype }}
                                                </button> 
                                            </td>   --}}
                                            {{-- <td class="p-2">{{ $item->tname }}</td>    --}}
                                            {{-- <td>{{ $item->pdx }}</td>  --}}
                                            <td>
                                                
                                                 <button type="button" class="btn btn-icon btn-shadow btn-dashed btn-outline-primary" data-bs-toggle="modal" data-bs-target="#DetailModal{{ $item->vn }}" data-bs-placement="right" title="ค่าใช้จ่าย">{{ number_format($item->money_hosxp,2)}} </button>                                                
                                            </td>                                            
                                            <td>{{ number_format($item->rcpt_money,2) }}</td> 
                                            <td>{{ number_format($item->debit,2) }}</td> 
                                            {{-- <td>{{ $item->rcpno }}</td>   --}}
                                            {{-- <td>{{ number_format($item->AMOUNTPAY,2) }}</td>  --}}
                                        </tr>    

                                        <div class="modal fade" id="DetailModal{{ $item->vn }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            รายละเอียดค่าใช้จ่าย
                                                        </h5> 
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body"> 
                                                        <?php 
                                                            $detail_ =  DB::connection('mysql3')->select('
                                                                SELECT o.vn,o.hn,o.icode,s.name,o.qty,o.unitprice,o.sum_price 
                                                                FROM opitemrece o
                                                                left outer join s_drugitems s on s.icode = o.icode 
                                                                WHERE o.vn ="'.$item->vn.'" 
                                                            '); 
                                                        ?>
                                                         <div class="row">
                                                            <div class="col-md-2 text-primary">
                                                                <label for="">icode </label> 
                                                            </div>
                                                            <div class="col-md-4 text-primary">
                                                                <label for="">รายการ </label> 
                                                            </div> 
                                                            <div class="col-md-2 text-primary">
                                                                <label for="">จำนวน </label> 
                                                            </div>
                                                            <div class="col-md-2 text-primary">
                                                                <label for="">ราคา </label> 
                                                            </div>
                                                            <div class="col-md-2 text-primary">
                                                                <label for="" >รวม</label> 
                                                            </div> 
                                                        </div>
                                                        @foreach ($detail_ as $items) 
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label for="">{{$items->icode}} </label> 
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="">{{$items->name}} </label> 
                                                            </div> 
                                                            <div class="col-md-2">
                                                                <label for="">{{$items->qty}}</label> 
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label for="">{{$items->unitprice}}</label> 
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label for="">{{$items->sum_price}}</label> 
                                                            </div> 
                                                        </div>
                                                        @endforeach
                                                        <div class="row">
                                                            <div class="col"> </div> 
                                                            <div class="col-md-2 text-danger">
                                                                <label for="" >{{ number_format($item->money_hosxp,2)}} บาท</label> 
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="col-md-12 text-end">
                                                            <div class="form-group"> 
                                                                <button type="button"
                                                                    class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger"
                                                                    data-bs-dismiss="modal"><i class="fa-solid fa-xmark me-2"></i>Close</button> 
                                                            </div>
                                                        </div>
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

{{-- <div class="modal fade" id="DetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    รายละเอียดค่าใช้จ่าย
                </h5> 
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-md-2">
                        <label for="">icode</label>
                        <div class="form-group mt-2">
                            <input type="text" name="icode" id="sicode" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">รายการ</label>
                        <div class="form-group mt-2">
                            <input type="text" name="name" id="sname" class="form-control form-control-sm" > 
                        </div>
                    </div>

                    <div class="col-md-1">
                        <label for="">qty</label>
                        <div class="form-group mt-2">
                            <input type="text" name="qty" id="sqty" class="form-control form-control-sm text-end" >
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="">unitprice</label>
                        <div class="form-group mt-2">
                            <input type="text" name="unitprice" id="sunitprice" class="form-control form-control-sm" > 
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="">sum_price</label>
                        <div class="form-group mt-2">
                            <input type="text" name="sum_price" id="ssum_price" class="form-control form-control-sm" > 
                        </div>
                    </div>

                    <input type="text" name="vn" id="svn" class="form-control form-control-sm" > 

                </div>

            </div>

        </div>
    </div>
</div> --}}
      
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

        // $(document).on('click', '.detaildata', function() {
        // var vn = $(this).val();
        // alert(vn);
        // $('#DetailModal').modal('show');
        // $.ajax({
        //     type: "GET",
        //     url: "{{ url('prisoner_opd_detail_show') }}" + '/' + vn,
        //     success: function(data) {
        //         // colsolog(data.detail.icode);
        //         alert(data.vn);
        //         // $('#sicode').val(data.detail.icode)
        //         // $('#sname').val(data.detail.name) 
        //         // $('#svn').val(data.detail.vn)
        //         // $('#sqty').val(data.detail.qty)
        //         // $('#sunitprice').val(data.detail.unitprice)
        //         // $('#ssum_price').val(data.detail.sum_price)
        //     },
        // });
    });
    });

    
</script>
@endsection
 
 