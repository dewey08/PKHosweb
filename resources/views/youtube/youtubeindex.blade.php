
@extends('layouts.youtube')
            
@section('content')         
            
            <div class="container-fluid mt-5"> 
                <div class="row">
                    <div class="col-md-3 ">
                        <div class="card-body" style="width:100%">
                            <iframe width="350" height="260" src="https://www.youtube.com/embed/kEFt7NFQMwA" frameborder="0" allowfullscreen ng-show="showvideo"></iframe>
                            <h5 class="card-title">#Ep 2.การกำหนดสิทธิ์การใช้งาน</h5>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                      
                    <div class="col-md-3 ">
                        <div class="card-body" style="width:100%">
                            <iframe width="350" height="260" src="https://www.youtube.com/embed/lLuP5FwjVO0" frameborder="0" allowfullscreen ng-show="showvideo"></iframe>
                            <h5 class="card-title">#Ep 3.การตั้งค่าข้อมูลการลา</h5>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                      
                    <div class="col-md-3 ">
                        <div class="card-body" style="width:100%">
                            <iframe width="350" height="260" src="https://www.youtube.com/embed/kteNh2lEVgg" frameborder="0" allowfullscreen ng-show="showvideo"></iframe>
                            <h5 class="card-title">#Ep 5.การตั้งค่าหน่วยงาน</h5>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                       
                    <div class="col-md-3 ">
                        <div class="card-body" style="width:100%">
                            <iframe width="350" height="260" src="https://youtu.be/F-MvQpDA25I" frameborder="0" allowfullscreen ng-show="showvideo"></iframe>
                            <h5 class="card-title">#Ep 6.การตั้งค่า Line Notify</h5>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                    
                </div>
            </div>
                
    
            
        

            @endsection

            @section('footer')

            @endsection
