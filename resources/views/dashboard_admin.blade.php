@extends('layouts.backend_admin')

@section('content')
<style>

.table-cont{
  /**make table can scroll**/
  max-height: 300px;
  overflow: auto;
  /** add some style**/
  /*padding: 2px;*/
  background: #ddd;
  margin: 20px 10px;
  box-shadow: 0 0 1px 3px #ddd;
}


.text-pedding{
   padding-left:10px;
                    }

        .text-font {
    font-size: 14px;
                  }   
</style>
<script>
    function checklogin(){
     window.location.href = '{{route("index")}}'; 
    }
    </script>
<?php
if(Auth::check()){
    $status = Auth::user()->status;
    $id_user = Auth::user()->PERSON_ID;   
}else{    
    echo "<body onload=\"checklogin()\"></body>";
    exit();
} 

  
function Removeformatetime($strtime)
{
  $H = substr($strtime,0,5);
  return $H;
  }

?>

 

    <!-- Page Content -->
    <br>
    <center>    
<div style="max-width:90%;">

@if($id_user == '0')

<div class="row" > 
                        





         <div class="col-6 col-md-4 col-xl-2">
           <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>

                             <i class="fa fa-3x fa-book-open text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">สารบรรณ</div>
                         </div>
                     </div>
                 </a>
             </div> 


             <div class="col-6 col-md-4 col-xl-2">
           <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                   
                             <i class="fa fa-3x fa-boxes text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">งานทรัพย์สิน</div>
                         </div>
                     </div>
                 </a>
             </div>
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center"  > 
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-donate text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark " style="font-size: 15px;">งานพัสดุ</div>
                         </div>
                     </div>
                 </a>
             </div>
      
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center"  >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-ambulance text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ยานพาหนะ</div>
                         </div>
                     </div>
                 </a>
             </div>
         
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center">
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-shield-alt text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">รปภ.</div>
                         </div>
                     </div>
                 </a>
             </div>
           
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-users text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">บุคลากร</div>
                         </div>
                     </div>
                 </a>
             </div>
            
       

             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center"  > 
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-wrench text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">งานซ่อมบำรุง</div>
                         </div>
                     </div>
                 </a>
             </div>

             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-tv text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ศูนย์คอมพิวเตอร์</div>
                         </div>
                     </div>
                 </a>
             </div>

             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-stethoscope text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ศูนย์เครื่องมือแพทย์</div>
                         </div>
                     </div>
                 </a>
             </div>

             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center"  >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-calendar-alt text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ระบบการลา</div>
                         </div>
                     </div>
                 </a>
             </div>

             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center"  >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-tablet-alt text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ระบบห้องประชุม</div>
                         </div>
                     </div>
                 </a>
             </div>
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-history text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ระบบลงเวลา</div>
                         </div>
                     </div>
                 </a>
             </div>



         <!--    <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-notes-medical text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ยาและเวชภัณฑ์</div>
                         </div>
                     </div>
                 </a>
             </div>

             <div class="col-6 col-md-4 col-xl-2">
                    <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-box-open text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">คลังสินค้า</div>
                         </div>
                     </div>
                 </a>
             </div>
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-chart-line text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">บัญชี</div>
                         </div>
                     </div>
                 </a>
             </div>
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center">
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-dolly-flatbed text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">งานจ่ายกลาง</div>
                         </div>
                     </div>
                 </a>
             </div>
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-utensils text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">โภชนาการ</div>
                         </div>
                     </div>
                 </a>
             </div>
           
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-leaf text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">ENV</div>
                         </div>
                     </div>
                 </a>
             </div>
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-hotel text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">บริหารบ้านพัก</div>
                         </div>
                     </div>
                 </a>
             </div>
          
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-project-diagram text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">แผนงาน</div>
                         </div>
                     </div>
                 </a>
             </div>
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-hand-holding-usd text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">เงินเดือน</div>
                         </div>
                     </div>
                 </a>
             </div>
                <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-tshirt text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">ซักฟอก</div>
                         </div>
                     </div>
                 </a>
             </div>

       
           <div class="col-6 col-md-4 col-xl-2">
           <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-file-signature text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">RISK</div>
                         </div>
                     </div>
                 </a>
             </div>
               
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center"  >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-headset text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">CRM</div>
                         </div>
                     </div>
                 </a>
             </div>
           
       </div>-->


@else
 <div class="row" > 
                    <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_person/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-users text-info"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">บุคลากร</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_personcheck/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                        <i class="fa fa-3x fa-history text-dark"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ระบบลงเวลา</div>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_leave/dashboard_leave')}}" target="_blank" >
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                        <i class="fa fa-3x fa-calendar-alt text-info"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ระบบการลา</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                       
         
                    <div class="col-6 col-md-4 col-xl-2">
                      <a class="block block-link-pop text-center" href="{{ url('manager_book/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>

                                        <i class="fa fa-3x fa-book-open text-warning"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">สารบรรณ</div>
                                    </div>
                                </div>
                            </a>
                        </div> 
          

                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_meet/dashboard_meet')}}" target="_blank" >
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-tablet-alt text-success"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ระบบห้องประชุม</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center"  href="{{ url('manager_car/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-ambulance text-xpro"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ยานพาหนะ</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-md-4 col-xl-2">
                      <a class="block block-link-pop text-center" href="{{ url('manager_asset/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                              
                                        <i class="fa fa-3x fa-boxes text-info"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">งานทรัพย์สิน</div>
                                    </div>
                                </div>
                            </a>
                        </div>


                        
                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_supplies/dashboard')}}" target="_blank" > 
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-donate text-success"></i>
                                        <div class="font-w600 mt-2 text-dark " style="font-size: 15px;">งานพัสดุ</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                 
  
      
                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_repairnomal/dashboard')}}" target="_blank" > 
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-wrench text-success"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">งานซ่อมบำรุง</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_repaircom/dashboard')}}" target="_blank" >
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-tv text-warning"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ศูนย์คอมพิวเตอร์</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_repairmedical/dashboard')}}" target="_blank" >
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-stethoscope text-danger"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ศูนย์เครื่องมือแพทย์</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    
              
                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_safe/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-shield-alt text-xmodern"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">รปภ.</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                      
                  
                        <div class="col-6 col-md-4 col-xl-2">
                               <a class="block block-link-pop text-center" href="{{ url('manager_warehouse/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-box-open text-danger"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">คลังวัสดุ</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_medical/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-notes-medical text-info"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ยาและเวชภัณฑ์</div>
                                    </div>
                                </div>
                            </a>
                        </div>

               

                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_plan/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-project-diagram text-xInspire"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">แผนงาน</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_compensation/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-hand-holding-usd text-xplay"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">การเงิน</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                     
                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_person/healthdashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-child text-warning"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">ตรวจสุขภาพ</div>
                                    </div>
                                </div>
                            </a>
                        </div>
            
                        
                  
                      <div class="col-6 col-md-4 col-xl-2">
                      <a class="block block-link-pop text-center" href="{{ url('manager_risk/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-file-signature text-xmodern"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">รายงานความเสี่ยง</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_mpay/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-dolly-flatbed text-primary"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">งานจ่ายกลาง</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-md-4 col-xl-2">
                           <a class="block block-link-pop text-center" href="{{ url('manager_launder/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-tshirt text-warning"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">ซักฟอก</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_guesthouse/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-hotel text-xmodern-lighter"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">บริหารบ้านพัก</div>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_env/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-leaf text-success"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">สาธารณูปโภค</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                       

                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_food/dashboard_food')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-utensils text-xsmooth"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">โภชนศาสตร์</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                      
     
                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_crm/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-headset text-info"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">ทะเบียนรับบริจาค</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        
                   
                        <!--    <div class="col-6 col-md-4 col-xl-2">
                            <a class="block block-link-pop text-center" href="{{ url('manager_account/dashboard')}}" target="_blank">
                                    <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                        <div>
                                        <i class="fa fa-3x fa-chart-line text-xInspire"></i>
                                            <div class="font-w600 mt-2 text-dark" style="font-size: 16px;">บัญชี</div>
                                        </div>
                                    </div>
                                </a>
                            </div>-->
                      
                  </div>

@endif 

<br>

    <script src="{{ asset('google/Charts.js') }}"></script>

    <script>
var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  myIndex++;
  if (myIndex > x.length) {myIndex = 1}    
  x[myIndex-1].style.display = "block";  
  setTimeout(carousel, 5000); // Change image every 2 seconds
}
</script>
<script>

// Code goes here

window.onload = function(){
  var tableCont = document.querySelector('#table-cont')
  var tableCont2 = document.querySelector('#table-cont2')
  /**
   * scroll handle
   * @param {event} e -- scroll event
   */
  function scrollHandle (e){
    var scrollTop = this.scrollTop;
    this.querySelector('thead').style.transform = 'translateY(' + scrollTop + 'px)';
  }
  
  tableCont.addEventListener('scroll',scrollHandle)
  tableCont2.addEventListener('scroll',scrollHandle)
}


</script>

@endsection
