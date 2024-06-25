@extends('layouts.authenthemes')
@section('title', 'PK-OFFICER || Authen Code')
@section('content')
  
<div class="tabs-animation">
    <form action="{{route('au.authen_check')}}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="row mb-2">
                @foreach ($user_all as $item)
                <input type="hidden" name="cid[]" id="cid" value="{{$item->cid}}">
                @endforeach 
                <div class="col"></div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-primary">ประมวลผล</button> 
                </div>
            </div>
    </form>
            <div class="row"> 
                <div class="col-lg-12 col-xl-12">
                    <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                            <th>ลำดับ</th>
                                <th>vn</th>
                                <th>hn</th>
                                <th>cid</th>
                                <th>auth_code</th>
                                <th>fullname</th> 
                                <th>department</th>
                                <th>staff</th>  
                                <th>name</th>                        
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                            @foreach ($user_all as $item)    
                                <tr>
                                <td>{{ $i++ }}</td>
                                    <td>{{$item->vn}}</td>
                                    <td>{{$item->hn}}</td>
                                    <td>{{$item->cid}}</td>
                                    <td>{{$item->auth_code}}</td>
                                    <td>{{$item->fullname}}</td>
                                    <td>{{$item->department}}</td>
                                    <td>{{$item->staff}}</td> 
                                    <td>{{$item->name}}</td> 
                                </tr>
                            @endforeach 
                        </tbody> 
                    </table>
                </div>
            </div>

            <div class="row"> 
                <div class="col-lg-12 col-xl-12">
                    <div class="main-card mb-3 card" >
                        <div class="grid-menu grid-menu-3col">
                            <div class="g-0 row">
                                <div class="col-sm-4">
                                    <div class="widget-chart widget-chart-hover" id="countalls_show" style="background-color: rgb(50, 117, 206)">
                                        {{-- <div class="widget-chart widget-chart-hover" id="countalls_show" style="background-color: rgb(50, 117, 206)"> --}}
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg bg-primary"></div>
                                            <i class="lnr-users text-white"></i>
                                        </div>
                                        
                                        <div class="widget-numbers">
                                            <label for="" style="font-size: 40px;color:rgb(255, 255, 255)">
                                            {{$countalls}} 
                                        </label>
                                        </div>
                                        <div class="widget-subheading"><label for="" style="font-size: 22px;color:rgb(253, 253, 253)">คนไข้วันนี้ทั้งหมด(คน)</label></div>
                                        <div class="widget-description text-white">
                                            <i class="fa fa-angle-up"></i>
                                            <span class="ps-1">
                                                <label for="" style="font-size: 15px;color:rgb(255, 255, 255)">
                                                100 %
                                            </label>
                                            </span>
                                        </div>                                
                                    </div>
                                </div> 
                                <div class="col-sm-4">
                                    <div class="widget-chart widget-chart-hover" id="countalls_success_show">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg bg-primary"></div>
                                            <i class="lnr-users text-primary"></i>
                                        </div>
                                        
                                        <div class="widget-numbers">
                                            {{$authensuccess}} 
                                        </div>
                                        <div class="widget-subheading"><label for="" style="font-size: 22px;color:green" >ออก Authen Code Success(คน)</label></div>
                                        <div class="widget-description text-primary">
                                            <i class="fa fa-angle-up"></i>
                                            <span class="ps-1">{{number_format($authensuccesstt,2)}} %</span>
                                        </div>
                                        
                                    </div>
                                </div> 
                                <div class="col-sm-4">
                                    <div class="widget-chart widget-chart-hover" id="countalls_nosuccess_show" style="background-color: rgb(228, 24, 24)">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg bg-primary"></div>
                                            <i class="lnr-users text-white"></i>
                                        </div>
                                        
                                        <div class="widget-numbers">
                                        
                                            <?php 
                                                $total_nosuccess = $countkiosnofinish + $countonusersnosuccess; 
                                                $total_percent = $countonusersnosuccesstt + $countkiosnofinisht;
                                            ?>
                                            <label for="" style="font-size: 40px;color:rgb(255, 255, 255)">
                                            {{$total_nosuccess}}
                                            </label>
                                        </div>
                                        <div class="widget-subheading"><label for="" style="font-size: 22px;color:rgb(255, 255, 255)">ออก Authen Code No Success(คน)</label></div>
                                        <div class="widget-description text-white">
                                            <i class="fa fa-angle-up"></i>
                                            <span class="ps-1">
                                                <label for="" style="font-size: 15px;color:rgb(255, 255, 255)">
                                                {{number_format($total_percent,2)}} %
                                            </label>
                                            </span>
                                        </div>
                                        
                                    </div>
                                </div> 
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-lg-12 col-xl-12">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu grid-menu-3col"> 
                            <div class="g-0 row">
                                <div class="col-sm-4">
                                    <div class="widget-chart widget-chart-hover" id="count_kios_all_show" style="background-image: url('{{ asset('assets/images/kios.png')}}');">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg bg-primary"></div> 
                                            <i class="lnr-screen text-primary"></i>
                                        </div>
                                        
                                        
                                        <div class="widget-numbers">{{$countkiosalls}}</div>
                                        <div class="widget-subheading"><label for="" style="font-size: 22px;color:rgb(17, 141, 243)">ผ่านตู้ KIOS(คน)</label></div>
                                        <div class="widget-description text-info">
                                            <i class="fa fa-arrow-right"></i> 
                                            <span class="ps-1"> {{number_format($countkiosallst,2)}} %</span> 
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="widget-chart widget-chart-hover" id="count_kios_success_show">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg bg-info"></div>
                                            <i class="lnr-screen text-success"></i>
                                        </div>
                                        
                                        <div class="widget-numbers">{{$countkiosfinish}}</div>
                                        <div class="widget-subheading"><label for="" style="font-size: 22px;color:green">ผ่านตู้ KIOS SUCCESS(คน)</label></div>
                                        <div class="widget-description text-success">
                                            <i class="fa fa-arrow-right"></i> 
                                            <span class="ps-1">{{number_format($countkiosfinisht,2)}} %</span> 
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="widget-chart widget-chart-hover" id="count_kios_nosuccess_show">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg bg-info"></div>
                                            <i class="lnr-screen text-danger"></i>
                                        </div>
                                            
                                        <div class="widget-numbers">{{$countkiosnofinish}}</div>
                                        <div class="widget-subheading"><label for="" style="font-size: 22px;color:red">ผ่านตู้ KIOS NO SUCCESS(คน)</label></div>
                                        <div class="widget-description text-danger">
                                            <i class="fa fa-arrow-right"></i>
                                            
                                            <span class="ps-1">{{number_format($countkiosnofinisht,2)}} %</span>
                                            
                                        </div>
                                    
                                    </div>
                                </div>
                                    
                                <div class="col-sm-4">
                                    <div class="widget-chart widget-chart-hover" style="background-image: url('{{ asset('assets/images/info.png')}}');">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg bg-primary"></div>
                                            <i class="lnr-users text-info"></i>
                                        </div>
                                        
                                        <div class="widget-numbers">{{$countonusers}}</div>
                                        <div class="widget-subheading"> <label for="" style="font-size: 22px;color:rgb(17, 141, 243)">ออกโดยเจ้าหน้าที่(คน)</label></div>
                                        <div class="widget-description text-primary">
                                            <span class="pe-1">{{number_format($countonuserst,2)}} %</span>
                                            <i class="fa fa-arrow-left"></i>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="widget-chart widget-chart-hover br-br" id="count_userssuccess_show">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg bg-success"></div>
                                            <i class="lnr-users text-success"></i>
                                        </div>
                                        
                                        
                                        <div class="widget-numbers">{{$countonuserssuccess}}</div>
                                        <div class="widget-subheading"><label for="" style="font-size: 22px;color:green">ออกโดยเจ้าหน้าที่ SUCCESS(คน)</label></div>
                                        <div class="widget-description text-success">
                                            <span class="pe-1">{{number_format($countonuserssuccesstt,2)}} %</span>
                                            <i class="fa fa-arrow-left"></i>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="widget-chart widget-chart-hover br-br" id="count_usersnosuccess_show">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg bg-success"></div>
                                            <i class="lnr-users text-danger"></i>
                                        </div>
                                        
                                        <div class="widget-numbers"> {{$countonusersnosuccess}}</div>
                                        <div class="widget-subheading"><label for="" style="font-size: 22px;color:red">ออกโดยเจ้าหน้าที่ NO SUCCESS(คน)</label></div>
                                        <div class="widget-description text-success">
                                            <span class="pe-1">{{number_format($countonusersnosuccesstt,2)}} %</span>
                                            <i class="fa fa-arrow-left"></i>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>              
</div>
<div class="modal" id="countalls_showmodalvv" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Modal body text goes here.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
 


@endsection
@section('footer')
<script>
    //  window.setTimeout( function() {
    //             window.location.reload();
    //         }, 10000);
    $(document).ready(function() {
        $('#example').DataTable();
    });
    $(document).on('click', '#countalls_show', function() { 
         $('#countalls_showmodal').modal('show'); 
    });
    $(document).on('click', '#count_usersnosuccess_show', function() { 
         $('#count_usersnosuccess_showmodal').modal('show'); 
    });
    $(document).on('click', '#count_userssuccess_show', function() { 
         $('#count_userssuccess_showmodal').modal('show'); 
    });
    $(document).on('click', '#count_kios_nosuccess_show', function() { 
         $('#count_kios_nosuccess_showmodal').modal('show'); 
    });
    $(document).on('click', '#count_kios_success_show', function() { 
         $('#count_kios_success_show').modal('show'); 
    });
    $(document).on('click', '#countalls_success_show', function() { 
         $('#countalls_success_showModal').modal('show'); 
    });
    $(document).on('click', '#countalls_nosuccess_show', function() { 
         $('#countalls_success_noshowModal').modal('show'); 
    });

    
</script>
@endsection
<style>
    @media (min-width: 1200px) {
           .modal {
               --modal-width: 1200px;
           }
       }
       @media (min-width: 1700px) {
           .modal-xls {
               --modal-width: 1700px;
           }
       }
      
</style>

 <!-- Large modal คนไข้วันนี้ทั้งหมด(คน)-->
 <div class="modal fade" id="countalls_showmodal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg w-auto">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">คนไข้วันนี้ ทั้งหมด(คน)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>vn</th>
                            <th>hn</th>
                            <th>fullname</th>
                            {{-- <th>claim_code</th>
                            <th>mobile</th>
                            <th>claim_type</th>
                            <th>authen_type</th> --}}
                            <th>opd_dep</th>
                            <th>staff</th>                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($authen as $item)    
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{$item->vn}}</td>
                                <td>{{$item->hn}}</td>
                                <td>{{$item->fullname}}</td>
                                <td>{{$item->department}}</td>
                                <td>{{$item->staff}}</td>
                                {{-- <td></td>
                                <td></td>
                                <td></td>
                                <td></td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
            </div>
        </div>
    </div>
 </div>

  <!-- Large modal ออก Authen Code Success(คน)-->
  <div class="modal fade" id="countalls_success_showModal" tabindex="-1" role="dialog"
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg w-auto">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLongTitle" style="color: red:" >ออก Authen Code Success(คน)
              </h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              </button>
          </div>
          <div class="modal-body">
              <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                  <thead>
                      <tr>
                          <th>ลำดับ</th>
                          <th>vn</th>
                          <th>hn</th>
                          <th>fullname</th> 
                          <th>opd_dep</th>
                          <th>staff</th>                        
                      </tr>
                  </thead>
                  <tbody>
                      <?php $i = 1; ?>
                      @foreach ($authensuccess_alldata as $item15)    
                          <tr>
                              <td>{{ $i++ }}</td>
                              <td>{{$item15->vn}}</td>
                              <td>{{$item15->hn}}</td>
                              <td>{{$item15->fullname}}</td>
                              <td>{{$item15->department}}</td>
                              <td>{{$item15->staff}}</td> 
                          </tr>                         
                      @endforeach                    
                  </tbody>            
              </table>          
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
          </div>
      </div>
  </div>
</div>

<!-- Large modal ออก Authen Code NO Success(คน)-->
<div class="modal fade" id="countalls_success_noshowModal" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg w-auto">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLongTitle" style="color: red:" >ออก Authen Code No Success(คน)
            </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <div class="modal-body">
            <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>vn</th>
                        <th>hn</th>
                        <th>fullname</th> 
                        <th>opd_dep</th>
                        <th>staff</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php $ia = 1; ?>
                    @foreach ($authen_kiosnofinish as $item19)    
                        <tr>
                            <td>{{ $ia++ }}</td>
                            <td>{{$item19->vn}}</td>
                            <td>{{$item19->hn}}</td>
                            <td>{{$item19->fullname}}</td>
                            <td>{{$item19->department}}</td>
                            <td>{{$item19->staff}}</td> 
                        </tr>  
                                            
                    @endforeach   
                    <?php $jjj = $ia++ ?>                   
                </tbody>     
                  
            </table>   
            <table style="width: 100%;" class="table table-hover table-striped table-bordered">                        
                <tbody>
                    <?php $iii = $jjj ?>
                    @foreach ($authen_kiosnofinish2 as $item12)    
                        <tr>
                            <td>{{ $iii++ }}</td>
                            <td>{{$item12->vn}}</td>
                            <td>{{$item12->hn}}</td>
                            <td>{{$item12->fullname}}</td>
                            <td>{{$item12->department}}</td>
                            <td>{{$item12->staff}}</td> 
                        </tr>
                       
                    @endforeach
                    <?php $j4 = $iii++ ?>
                </tbody>
               
            </table>     
            <table style="width: 100%;" class="table table-hover table-striped table-bordered">                
                <tbody>
                    <?php $i4 = $j4; ?>
                    @foreach ($authenusernosuccess as $item20)    
                        <tr>
                            <td>{{ $i4++ }}</td>
                            <td>{{$item20->vn}}</td>
                            <td>{{$item20->hn}}</td>
                            <td>{{$item20->fullname}}</td>
                            <td>{{$item20->department}}</td>
                            <td>{{$item20->staff}}</td> 
                        </tr>                       
                    @endforeach
                    <?php $j5 = $i4++ ?>
                </tbody>
              
            </table>  
            <table style="width: 100%;" class="table table-hover table-striped table-bordered">                        
                <tbody>
                    <?php $ii6 = $j5 ?>
                    @foreach ($authenusernosuccess2 as $item21)    
                        <tr>
                            <td>{{ $ii6++ }}</td>
                            <td>{{$item21->vn}}</td>
                            <td>{{$item21->hn}}</td>
                            <td>{{$item21->fullname}}</td>
                            <td>{{$item21->department}}</td>
                            <td>{{$item21->staff}}</td> 
                        </tr>                       
                    @endforeach
                </tbody>               
            </table>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
        </div>
    </div>
</div>
</div>

  <!-- Large modal ออกโดยเจ้าหน้าที่ NO SUCCESS(คน)-->
  <div class="modal fade" id="count_usersnosuccess_showmodal" tabindex="-1" role="dialog"
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg w-auto">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLongTitle" style="color: red:" >ออกโดยเจ้าหน้าที่ และยังไม่ใด้ออก Authen(คน)
            </h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              </button>
          </div>
          <div class="modal-body">
              <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                  <thead>
                      <tr>
                        <th>ลำดับ</th>
                          <th>vn</th>
                          <th>hn</th>
                          <th>fullname</th> 
                          <th>opd_dep</th>
                          <th>staff</th>                        
                      </tr>
                  </thead>
                  <tbody>
                    <?php $io = 1; ?>
                      @foreach ($authenusernosuccess as $item2)    
                          <tr>
                            <td>{{ $io++ }}</td>
                              <td>{{$item2->vn}}</td>
                              <td>{{$item2->hn}}</td>
                              <td>{{$item2->fullname}}</td>
                              <td>{{$item2->department}}</td>
                              <td>{{$item2->staff}}</td> 
                          </tr>
                      @endforeach
                      <?php $jo = $io++ ?>
                    </tbody>
                    {{$jo}}
              </table>

              <table style="width: 100%;" class="table table-hover table-striped table-bordered">
               
                <tbody>
                  <?php $ioo = $jo; ?>
                    @foreach ($authenusernosuccess2 as $item8)    
                        <tr>
                          <td>{{ $ioo++ }}</td>
                            <td>{{$item8->vn}}</td>
                            <td>{{$item8->hn}}</td>
                            <td>{{$item8->fullname}}</td>
                            <td>{{$item8->department}}</td>
                            <td>{{$item8->staff}}</td> 
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
          </div>
      </div>
  </div>
</div>

 <!-- Large modal ออกโดยเจ้าหน้าที่ SUCCESS(คน)-->
 <div class="modal fade" id="count_userssuccess_showmodal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg w-auto">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle" style="color: red:" >ออกโดยเจ้าหน้าที่ และใด้ออก Authen(คน)เรียบร้อย
            </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>vn</th>
                            <th>hn</th>
                            <th>fullname</th> 
                            <th>opd_dep</th>
                            <th>staff</th>                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($authenusersuccess as $item3)    
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{$item3->vn}}</td>
                                <td>{{$item3->hn}}</td>
                                <td>{{$item3->fullname}}</td>
                                <td>{{$item3->department}}</td>
                                <td>{{$item3->staff}}</td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
            </div>
        </div>
    </div>
</div>

  <!-- Large modal ผ่านตู้ KIOS SUCCESS(คน)-->
  <div class="modal fade" id="count_kios_success_show" tabindex="-1" role="dialog"
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg w-auto">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLongTitle" style="color: red:" >ผ่านตู้ KIOS SUCCESS(คน)
              </h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              </button>
          </div>
          <div class="modal-body">
              <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                  <thead>
                      <tr>
                          <th>ลำดับ</th>
                          <th>vn</th>
                          <th>hn</th>
                          <th>fullname</th> 
                          <th>opd_dep</th>
                          <th>staff</th>                        
                      </tr>
                  </thead>
                  <tbody>
                      <?php $i = 1; ?>
                      @foreach ($authen_kios_finish as $item13)    
                          <tr>
                              <td>{{ $i++ }}</td>
                              <td>{{$item13->vn}}</td>
                              <td>{{$item13->hn}}</td>
                              <td>{{$item13->fullname}}</td>
                              <td>{{$item13->department}}</td>
                              <td>{{$item13->staff}}</td> 
                          </tr>                         
                      @endforeach                    
                  </tbody>            
              </table>          
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
          </div>
      </div>
  </div>
</div>

  <!-- Large modal ผ่านตู้ KIOS NO SUCCESS(คน)-->
<div class="modal fade" id="count_kios_nosuccess_showmodal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg w-auto">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle" style="color: red:" >ผ่านตู้ KIOS NO SUCCESS(คน)
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>vn</th>
                                <th>hn</th>
                                <th>fullname</th> 
                                <th>opd_dep</th>
                                <th>staff</th>                        
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($authen_kiosnofinish as $item10)    
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{$item10->vn}}</td>
                                    <td>{{$item10->hn}}</td>
                                    <td>{{$item10->fullname}}</td>
                                    <td>{{$item10->department}}</td>
                                    <td>{{$item10->staff}}</td> 
                                </tr>
                               
                            @endforeach
                            <?php $j = $i++ ?>
                        </tbody>
                        {{$j}}
                    </table>

                    <table style="width: 100%;" class="table table-hover table-striped table-bordered">                        
                        <tbody>
                            <?php $ii = $j ?>
                            @foreach ($authen_kiosnofinish2 as $item12)    
                                <tr>
                                    <td>{{ $ii++ }}</td>
                                    <td>{{$item12->vn}}</td>
                                    <td>{{$item12->hn}}</td>
                                    <td>{{$item12->fullname}}</td>
                                    <td>{{$item12->department}}</td>
                                    <td>{{$item12->staff}}</td> 
                                </tr>
                                <?php $j = $i++ ?>
                            @endforeach
                        </tbody>
                       
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
</div>