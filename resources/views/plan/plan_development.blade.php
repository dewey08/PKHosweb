@extends('layouts.plannew')
@section('title','PK-OFFICER || Plan')
@section('content')
<style>
    .table th {
        font-family: sans-serif;
        font-size: 12px;
    }
    .table td {
        font-family: sans-serif;
        font-size: 12px;
    }
</style>
<?php
     use App\Http\Controllers\karnController;
     use Illuminate\Support\Facades\DB; 
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
<div class="tabs-animation">
    <div id="preloader">
        <div id="status">
            <div class="spinner">
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-xl-12">                    
                <div class="row">                   
                    <div class="col"><h5 class="mb-sm-0">plan_development </h5></div> 
                    <div class="col-md-2 text-center"></div> 
                    <div class="col-md-2 text-center"></div> 
                    <div class="col"></div> 
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">                     
                    <div class="card-body py-0 px-2 mt-2"> 
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>                                           
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">จำนวนผู้ป่วย(ครั้ง)</th>                                                    
                                    </tr>                                            
                                </thead>
                                {{-- <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($data_prb as $item)
                                        <tr>
                                            <td class="text-center">{{$i++}}</td> 
                                            <td class="text-center">{{DateThai($item->vstdate)}}</td> 
                                            <td class="text-center">
                                                <a href="{{url('prb_opd_subsub/'.$item->vstdate.'/'.$months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->countvn }}</a> 
                                            </td>  
                                        </tr>
                                    @endforeach
                                </tbody> --}}
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
            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();

                $('select').select2();
                $('#ECLAIM_STATUS').select2({
                    dropdownParent: $('#detailclaim')
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                              
            });
           
        </script>    
       
    @endsection
