<?php
@session_start();
include("session/session_money.php");
include("connect/connect.php");
?>

<style type="text/css">
  /* notification_stm ############################################### */
.notification_re {
  background-color: #B5DEDB;
  color: #6B62B3;
  text-decoration: none;
  position: relative;
  display: inline-block;
  border-radius: 4px;
  padding-left: 10px;
  margin-left: 8px;
  margin-top: 8px;
}

.notification_re:hover {
  background: #6B62B3;
  color: #B5DEDB;
}

.notification_re .badge {
  position: absolute;
  top: -10px;
  right: -10px;
  padding: 8px 10px;
  border-radius: 50%;
  background-color: red;
  color: white;
}
/* notification_stm ############################################### */
</style> 

<div class="main2 row" style="width: 95%; margin-top: 100px;">

  <div class="col-md-12 col-lg-12">

    <div class="row mb-1">
      
     
      <div class="col-2">
        <a class="nav-link notification_re" onclick="window.location.href='index_claim.php?sum=receipt_number&type_rn=input'">ลงเลขที่หนังสือ
          <!-- Notification -->
          <span class="badge"><?php if($count_pang_stamp_id!=0){ echo $count_pang_stamp_id; }?></span>
          <!-- Notification -->
        </a>
      </div>

      

      <div class="col-2" align="left">
        <a class="nav-link notification_re" onclick="window.location.href='index_claim.php?sum=receipt_number&type_rn=receipt'">ลงตัดรายตัว
          <!-- Notification -->
          <span class="badge"><?php if($count_pang_stamp_id_stm!=0){ echo $count_pang_stamp_id_stm; }?></span>
          <!-- Notification -->
        </a>
      </div>
          
    </div>
     
  </div>
    
</div>


    
