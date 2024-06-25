@extends('layouts.screening')
@section('title', 'PK-OFFICER || PP')
@section('content')
  
<div class="tabs-animation">
    <div class="row"> 
        <div class="col-lg-12 col-xl-12">
            <div class="main-card mb-3 card" >
                <div class="grid-menu grid-menu-3col"> 
                    <div class="g-0 row">
                        <div class="col-sm-12">
                            {{-- <div class="widget-chart widget-chart-hover" style="background-color: rgb(255, 255, 255)">  --}}
                                <div class="main-card mb-3 card">
                                    <div class="card-header">
                                        การคัดกรองและบำบัดผู้ดื่มสุรา
                                        <div class="btn-actions-pane-right">
                                            <div role="group" class="btn-group-sm btn-group"> 
                                                <button class="active btn btn-focus">ผู้ดื่มสุรา</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        {{-- <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example"> --}}
                                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">cid</th>
                                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                                    <th class="text-center">อายุ</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $ia = 1; ?>
                                                @foreach ($data_spirits as $item)  
                                                    <tr> 
                                                        <td>{{ $ia++ }}</td>
                                                        <td>{{$item->patient_hn}}</td>
                                                        <td>{{$item->cid}}</td>
                                                        <td>{{$item->ptname}}</td>
                                                        <td>{{$item->age}}</td> 
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
        </div>
    </div>
</div> 
      

@endsection
@section('footer')
<script>    
    $(document).ready(function() {
        // $('#example').DataTable();
    });
         
</script>
@endsection
 
  