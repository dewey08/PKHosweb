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
                                        การคัดกรองและบำบัดผู้ติดบุหรี่
                                        <div class="btn-actions-pane-right">
                                            <div role="group" class="btn-group-sm btn-group"> 
                                                <button class="active btn btn-focus">บุหรี่</button>
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
                                
                                </div>
                            {{-- </div> --}}
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
        $('#example').DataTable();
    });
    $(document).on('click', '#countalls_show', function() { 
         $('#countalls_showmodal').modal('show'); 
    });       
</script>
@endsection
 
 