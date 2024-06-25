@extends('layouts.pkclaim')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }

    .chartMenu {
        width: 100vw;
        height: 40px;
        background: #1A1A1A;
        color: rgba(255, 26, 104, 1);
    }

    .chartMenu p {
        padding: 10px;
        font-size: 20px;
    }

    .chartCard {
        width: 100vw;
        height: calc(100vh - 40px);
        background: rgba(255, 26, 104, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chartBox {
        width: 700px;
        padding: 20px;
        border-radius: 20px;
        border: solid 3px rgba(255, 26, 104, 1);
        background: white;
    }
    .chartgooglebar{
          width:auto;
          height:auto;        
      }
      .chartgoogle{
          width:auto;
          height:auto;        
      }
</style>   

<div class="container-fluid">
 
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">ประกันสังคม</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">ประกันสังคม</a></li>
                        <li class="breadcrumb-item active">การวินิจฉัยว่างเฉพาะในเขต</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="float-end d-none d-md-inline-block">
                        <div class="dropdown">
                            <a class="text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">ช่วงวันที่<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">วันนี้</a>
                                <a class="dropdown-item" href="#">ย้อนหลัง 1 สัปดาห์</a>
                                <a class="dropdown-item" href="#">ย้อนหลัง 1 เดือน</a>
                                <a class="dropdown-item" href="#">ย้อนหลัง 1 ปี</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4">ประกันสังคม</h4>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm myTable " style="width: 100%;" id="example_user"> 
                              <thead>
                                  <tr height="10px">
                                    <th width="4%">ลำดับ</th>
                                      <th width="7%">VN</th>
                                      <th width="7%">HN</th>
                                      <th width="10%">ชื่อผู้ป่วย</th>
                                      <th>วันที่ตรวจ</th> 
                                      <th>เวลาตรวจ</th> 
                                      <th >ห้อง</th>
                                      <th>คลีนิค</th>
                                      <th>ชื่อสิทธิ์</th>
                                      <th>Eclaim_name</th>
                                      <th>Staff</th>
                                      <th>ค่าใช้จ่าย</th>
                                      <th>แพทย์ผู้รักษา</th> 
                                  </tr>  
                              </thead>
                              <tbody>
                                <?php $i = 1; ?>
                                    @foreach ($sss_check as $item)
                                        <tr id="sid{{ $item->vn }}" height="30">
                                            <td class="text-center" width="3%">{{ $i++ }}</td>  
                                            <td class="text-center" width="7%">{{ $item->vn }} </td>  
                                            <td class="text-center" width="7%">{{ $item->hn }} </td> 
                                            <td class="text-center" width="7%">{{ $item->pname }}{{ $item->fname }} {{ $item->lname }}</td>  
                                            <td class="text-center" width="7%">{{ DateThai($item->vstdate) }} </td> 
                                            <td class="text-center" width="7%">{{ $item->vsttime }} </td> 
                                            <td class="text-center" width="7%"> {{ $item->room }}</td>  
                                            <td class="p-2">{{ $item->clinic }}</td> 
                                            <td class="p-2">{{ $item->pttypename }}</td>
                                            <td class="p-2">{{ $item->eclaim_name }}</td>
                                            <td class="p-2">{{ $item->staff }}</td>
                                            <td class="p-2">{{ $item->income }}</td>
                                            <td class="p-2" >{{ $item->dxdoctor }}</td>
                                            
                                      </tr> 
 
                                   
                                    @endforeach
                              </tbody>
                        </table>
                  </div>


               
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->



</div>  

@endsection
@section('footer') 

 <script src="{{ asset('js/chart.min.js') }}"></script>
 <script src="{{ asset('js/dist-chart.min.js') }}"></script>

 <script>
     $(document).ready(function() {
         $('#example').DataTable();
         $('#example2').DataTable();
         $('#example3').DataTable();
         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });
          
     });
 </script>

 
@endsection
