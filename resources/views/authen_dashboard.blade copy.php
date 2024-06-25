@extends('layouts.authenthemes')
@section('title', 'PK-OFFICER || Authen Code')
@section('content')
  
<div class="tabs-animation">
    <div class="row"> 
        <div class="col-lg-12 col-xl-12">
            <div class="main-card mb-3 card" id="countalls_show">
                <div class="grid-menu grid-menu-3col">
                    <div class="g-0 row">
                        <div class="col-sm-12">
                            <div class="widget-chart widget-chart-hover">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg bg-primary"></div>
                                    <i class="lnr-users text-primary"></i>
                                </div>
                                 
                                <div class="widget-numbers">
                                    {{$countalls}} 
                                </div>
                                <div class="widget-subheading"><label for="" style="font-size: 22px">คนไข้วันนี้ทั้งหมด(คน)</label></div>
                                <div class="widget-description text-success">
                                    <i class="fa fa-angle-up"></i>
                                    <span class="ps-1">100 %</span>
                                </div>
                                {{-- <button type="button" class="btn me-2 mb-2 btn-primary"
                                data-bs-toggle="modal" data-bs-target="#countalls_showmodal">
                                Basic Modal
                            </button> --}}
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
                                <div class="widget-chart widget-chart-hover" id="count_kios_all_show">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-primary"></div> 
                                        <i class="lnr-screen text-primary"></i>
                                    </div>
                               
                                   
                                    <div class="widget-numbers">{{$countkiosalls}}</div>
                                    <div class="widget-subheading"><label for="" style="font-size: 22px">ผ่านตู้ KIOS(คน)</label></div>
                                    <div class="widget-description text-info">
                                        <i class="fa fa-arrow-right"></i>
                                        {{-- @if ($countkiosallst == '1')
                                        <span class="ps-1"> {{number_format($countkiosallsttnew,2)}} %</span>
                                        @else --}}
                                        <span class="ps-1"> {{number_format($countkiosallst,2)}} %</span>
                                        {{-- @endif --}}
                                        
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
                                    <div class="widget-description text-info">
                                        <i class="fa fa-arrow-right"></i>
                                        {{-- @if ($countkiosfinisht == '1')
                                        <span class="ps-1">{{number_format($countkiosfinishtnew,2)}} %</span>
                                        @else --}}
                                        <span class="ps-1">{{number_format($countkiosfinisht,2)}} %</span>
                                        {{-- @endif --}}
                                       
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
                                        {{-- @if ($countkiosnofinisht == '1')
                                        <span class="ps-1">{{number_format($countkiosnofinishtnew,2)}} %</span>
                                        @else --}}
                                        <span class="ps-1">{{number_format($countkiosnofinisht,2)}} %</span>
                                        {{-- @endif --}}
                                       
                                    </div>
                                
                                </div>
                            </div>
                             
                            <div class="col-sm-4">
                                <div class="widget-chart widget-chart-hover">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-primary"></div>
                                        <i class="lnr-users text-info"></i>
                                    </div>
                                   
                                    <div class="widget-numbers">{{$countonusers}}</div>
                                    <div class="widget-subheading"> <label for="" style="font-size: 22px">ออกโดยเจ้าหน้าที่(คน)</label></div>
                                    <div class="widget-description text-warning">
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
                                    
                                    <?php 
                                    //    if ($countonuserssuccess == '0') {
                                    //         $countonuserssuccesst = 1;
                                    //     } else {
                                    //         $countonuserssuccesst = 100 / $total * $countonuserssuccesst;
                                    //     }
                                       
                                    ?> 
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
        
        {{-- <div class="row"> 
            <div class="col-lg-12 col-xl-12">
                <div class="main-card mb-3 card">
                    <div class="grid-menu grid-menu-3col">
                        <div class="g-0 row">
                            <div class="col-sm-3">
                                <div class="widget-chart widget-chart-hover">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-primary"></div>
                                        <i class="lnr-users text-primary"></i>
                                    </div>
                                    @foreach ($countalls as $countall)  
                                    <div class="widget-numbers">{{$countall->vn}} </div>
                                    <div class="widget-subheading">คนไข้วันนี้ทั้งหมด(คน)</div>
                                    <div class="widget-description text-success">
                                        <i class="fa fa-angle-up"></i>
                                        <span class="ps-1">175.5%</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="widget-chart widget-chart-hover">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-info"></div>
                                        <i class="lnr-users text-info"></i>
                                    </div>
                                    @foreach ($countkiosalls as $countkiosall)  
                                    <div class="widget-numbers">{{$countkiosall->vn}}</div>
                                    <div class="widget-subheading">ผ่านตู้ KIOS</div>
                                    <div class="widget-description text-info">
                                        <i class="fa fa-arrow-right"></i>
                                        <span class="ps-1">175.5%</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="widget-chart widget-chart-hover">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-info"></div>
                                        <i class="lnr-users text-info"></i>
                                    </div>
                                    @foreach ($countkiosfinish as $items)  
                                    <div class="widget-numbers">{{$items->vn}}</div>
                                    <div class="widget-subheading">ผ่านตู้ KIOS SUCCESS</div>
                                    <div class="widget-description text-info">
                                        <i class="fa fa-arrow-right"></i>
                                        <span class="ps-1">175.5%</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="widget-chart widget-chart-hover">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-danger"></div>
                                        <i class="lnr-users text-info"></i>
                                    </div>
                                    @foreach ($countkiosnofinish as $items2)  
                                    <div class="widget-numbers">{{$items2->vn}}</div>
                                    <div class="widget-subheading">ผ่านตู้ KIOS NO SUCCESS</div>
                                    <div class="widget-description text-danger">
                                        <i class="fa fa-arrow-right"></i>
                                        <span class="ps-1">175.5%</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="widget-chart widget-chart-hover">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-danger"></div>
                                        <i class="lnr-laptop-phone text-danger"></i>
                                    </div>
                                    <div class="widget-numbers">5.82k</div>
                                    <div class="widget-subheading">Reports Submitted</div>
                                    <div class="widget-description text-primary">
                                        <span class="pe-1">54.1%</span>
                                        <i class="fa fa-angle-up"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="widget-chart widget-chart-hover br-br">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-success"></div>
                                        <i class="lnr-screen"></i>
                                    </div>
                                    <div class="widget-numbers">17.2k</div>
                                    <div class="widget-subheading">Profiles</div>
                                    <div class="widget-description text-warning">
                                        <span class="pe-1">175.5%</span>
                                        <i class="fa fa-arrow-left"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="widget-chart widget-chart-hover br-br">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-success"></div>
                                        <i class="lnr-screen"></i>
                                    </div>
                                    <div class="widget-numbers">17.2k</div>
                                    <div class="widget-subheading">Profiles</div>
                                    <div class="widget-description text-warning">
                                        <span class="pe-1">175.5%</span>
                                        <i class="fa fa-arrow-left"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="widget-chart widget-chart-hover br-br">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-success"></div>
                                        <i class="lnr-screen"></i>
                                    </div>
                                    <div class="widget-numbers">17.2k</div>
                                    <div class="widget-subheading">Profiles</div>
                                    <div class="widget-description text-warning">
                                        <span class="pe-1">175.5%</span>
                                        <i class="fa fa-arrow-left"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Active Users
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                <button class="active btn btn-focus">Last Week</button>
                                <button class="btn btn-focus">All Month</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th class="text-center">City</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Sales</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center text-muted">#345</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle"
                                                            src="images/avatars/4.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">John Doe</div>
                                                    <div class="widget-subheading opacity-7">Web Developer</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">Madrid</td>
                                    <td class="text-center">
                                        <div class="badge bg-warning">Pending</div>
                                    </td>
                                    <td class="text-center" style="width: 150px;">
                                        <div class="pie-sparkline">2,4,6,9,4</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" id="PopoverCustomT-1" class="btn btn-primary btn-sm">Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center text-muted">#347</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle"
                                                            src="images/avatars/3.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">Ruben Tillman</div>
                                                    <div class="widget-subheading opacity-7">Etiam sit amet orci eget</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">Berlin</td>
                                    <td class="text-center">
                                        <div class="badge bg-success">Completed</div>
                                    </td>
                                    <td class="text-center" style="width: 150px;">
                                        <div id="sparkline-chart4"></div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" id="PopoverCustomT-2" class="btn btn-primary btn-sm">Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center text-muted">#321</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle"
                                                            src="images/avatars/2.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">Elliot Huber</div>
                                                    <div class="widget-subheading opacity-7">
                                                        Lorem ipsum dolor sic
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">London</td>
                                    <td class="text-center">
                                        <div class="badge bg-danger">In Progress</div>
                                    </td>
                                    <td class="text-center" style="width: 150px;">
                                        <div id="sparkline-chart8"></div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" id="PopoverCustomT-3" class="btn btn-primary btn-sm">Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center text-muted">#55</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left me-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle"
                                                            src="images/avatars/1.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">Vinnie Wagstaff</div>
                                                    <div class="widget-subheading opacity-7">UI Designer</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">Amsterdam</td>
                                    <td class="text-center">
                                        <div class="badge bg-info">On Hold</div>
                                    </td>
                                    <td class="text-center" style="width: 150px;">
                                        <div id="sparkline-chart9"></div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" id="PopoverCustomT-4" class="btn btn-primary btn-sm">Details</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-block text-center card-footer">
                        <button class="me-2 btn-icon btn-icon-only btn btn-outline-danger">
                            <i class="pe-7s-trash btn-icon-wrapper"></i>
                        </button>
                        <button class="btn-wide btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>                             --}}
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
       /* @media (min-width: 1500px) {
           .container-fluids {
               width: 1500px;
               margin-left: auto;
               margin-right: auto;
               margin-top: auto;
           } 
       } */
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
                      @foreach ($authenusernosuccess as $item2)    
                          <tr>
                            <td>{{ $i++ }}</td>
                              <td>{{$item2->vn}}</td>
                              <td>{{$item2->hn}}</td>
                              <td>{{$item2->fullname}}</td>
                              <td>{{$item2->department}}</td>
                              <td>{{$item2->staff}}</td>
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