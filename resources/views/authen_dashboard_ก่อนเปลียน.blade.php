@extends('layouts.authenthemes_new')
@section('title', 'PK-OFFICER || รพ.สต.')
 
@section('content')
    
    <div class="tabs-animation">
        
                <div class="row">
                
                    <div class="col"></div>
                    <div class="col-md-1"> 
                        <button type="button" id="Importexcel" class="btn btn-primary">ประมวลผล</button> 
                    </div>
                </div>
      
    
                {{-- <div class="row"> 
                    <div class="col-lg-12 col-xl-12">
                        <div class="main-card mb-3 card" >
                            <div class="grid-menu grid-menu-3col">
                                <div class="g-0 row">
                                    <div class="col-sm-4">
                                        <div class="widget-chart widget-chart-hover" id="countalls_show" style="background-color: rgb(50, 117, 206)"> 
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-primary"></div>
                                                <i class="lnr-users text-white"></i>
                                            </div>
                                            
                                            <div class="widget-numbers">
                                                <label for="" style="font-size: 40px;color:rgb(255, 255, 255)">
                                             10
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
                                        <div class="widget-chart widget-chart-hover" id="countalls_success_show" style="background-color: rgb(23, 206, 121)">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-primary"></div>
                                                <i class="lnr-users text-white"></i>
                                            </div>
                                            
                                            <div class="widget-numbers">
                                               
                                                  <label for="" style="font-size: 40px;color:rgb(255, 255, 255)">
                                                   100
                                                </label> 
                                            </div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:rgb(255, 255, 255)" >ออก Authen Code Success(คน)</label></div>
                                            <div class="widget-description text-primary">
                                                <i class="fa fa-angle-up"></i>
                                                <span class="ps-1">
                                                    <label for="" style="font-size: 15px;color:rgb(255, 255, 255)">10 %
                                                    </label></span>
                                            </div>
                                            
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <div class="widget-chart widget-chart-hover" id="countalls_nosuccess_show222222" style="background-color: rgb(228, 24, 24)">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-primary"></div>
                                                <i class="lnr-users text-white"></i>
                                            </div>
                                            
                                            <div class="widget-numbers">
                                            
                                               
                                                <label for="" style="font-size: 40px;color:rgb(255, 255, 255)">
                                               10
                                                </label>
                                            </div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:rgb(255, 255, 255)">ออก Authen Code No Success(คน)</label></div>
                                            <div class="widget-description text-white">
                                                <i class="fa fa-angle-up"></i>
                                                <span class="ps-1">
                                                    <label for="" style="font-size: 15px;color:rgb(255, 255, 255)">
                                                    10 %
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
                                            
                                            
                                            <div class="widget-numbers">2124</div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:rgb(17, 141, 243)">ผ่านตู้ KIOS(คน)</label></div>
                                            <div class="widget-description text-info">
                                                <i class="fa fa-arrow-right"></i> 
                                                <span class="ps-1"> 10 %</span> 
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="widget-chart widget-chart-hover" id="count_kios_success_show">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-info"></div>
                                                <i class="lnr-screen text-success"></i>
                                            </div>
                                            
                                            <div class="widget-numbers">20</div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:green">ผ่านตู้ KIOS SUCCESS(คน)</label></div>
                                            <div class="widget-description text-success">
                                                <i class="fa fa-arrow-right"></i> 
                                                <span class="ps-1">10 %</span> 
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="widget-chart widget-chart-hover" id="count_kios_nosuccess_show">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-info"></div>
                                                <i class="lnr-screen text-danger"></i>
                                            </div>
                                                
                                            <div class="widget-numbers">22</div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:red">ผ่านตู้ KIOS NO SUCCESS(คน)</label></div>
                                            <div class="widget-description text-danger">
                                                <i class="fa fa-arrow-right"></i>
                                                
                                                <span class="ps-1">10 %</span>
                                                
                                            </div>
                                        
                                        </div>
                                    </div>
                                        
                                    <div class="col-sm-4">
                                        <div class="widget-chart widget-chart-hover" style="background-image: url('{{ asset('assets/images/info.png')}}');">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-primary"></div>
                                                <i class="lnr-users text-info"></i>
                                            </div>
                                            
                                            <div class="widget-numbers">55</div>
                                            <div class="widget-subheading"> <label for="" style="font-size: 22px;color:rgb(17, 141, 243)">ออกโดยเจ้าหน้าที่(คน)</label></div>
                                            <div class="widget-description text-primary">
                                                <span class="pe-1">11 %</span>
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
                                            
                                            
                                            <div class="widget-numbers">11</div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:green">ออกโดยเจ้าหน้าที่ SUCCESS(คน)</label></div>
                                            <div class="widget-description text-success">
                                                <span class="pe-1">10 %</span>
                                                <i class="fa fa-arrow-left"></i>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="widget-chart widget-chart-hover br-br" id="count_usersnosuccess_show222222222">
                                            <div class="icon-wrapper rounded-circle">
                                                <div class="icon-wrapper-bg bg-success"></div>
                                                <i class="lnr-users text-danger"></i>
                                            </div>
                                            
                                            
                                            <div class="widget-numbers"> FFF</div>
                                            <div class="widget-subheading"><label for="" style="font-size: 22px;color:red">ออกโดยเจ้าหน้าที่ NO SUCCESS(คน)</label></div>
                                            <div class="widget-description text-success">
                                                <span class="pe-1">11 %</span>
                                                <i class="fa fa-arrow-left"></i>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
    </div>
   
 
 
@endsection
@section('footer')
@endsection
