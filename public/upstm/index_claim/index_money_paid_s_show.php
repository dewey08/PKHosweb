<?php

include("connect/connect.php");

set_time_limit(0);
// some code

@session_start();

#เงื่อนไขผัง
if(isset($_REQUEST["pang"])){
    $pang = $_SESSION["pang"] = $_REQUEST["pang"];
}else{
    $pang = $_SESSION["pang"];
}

if(isset($_REQUEST["pt_type"])){
    $pt_type = $_SESSION["pt_type"] = $_REQUEST["pt_type"];
    $show = $_SESSION["show"] = "PAID_".$pt_type;

}else{
    $pt_type = $_SESSION["pt_type"];
    $show = $_SESSION["show"];
}

##ตรวจว่าเป็นคนไข้ในหรือคนไข้นอก
if($pt_type=="OPD"){
  $select_vstdate = " ,(SELECT vstdate FROM ovst WHERE vn=psp.pang_stamp_vn LIMIT 1) AS 'วันที่รับบริการ' ";
}elseif($pt_type=="IPD"){
  $select_vstdate = " ,(SELECT vstdate FROM ovst WHERE an=psp.pang_stamp_vn LIMIT 1) AS 'วันที่รับบริการ' ";
}
##ตรวจว่าเป็นคนไข้ในหรือคนไข้นอก  



$sql_pang_preview=" SELECT p.pang_id, p.pang_fullname, p.pang_instument, p.pang_stm, p.pang_kor_tok, p.pang_kor_tok_icd, p.pang_cancer
      FROM pang p LEFT OUTER JOIN pang_sub ps ON p.pang_id=ps.pang_id
                  WHERE p.pang_id='$pang' AND p.pang_year='$sir_year'
                  LIMIT 100";
$result_pang_preview = mysqli_query($con_money, $sql_pang_preview) or die(mysqli_error($con_money));
$row_pang_preview = mysqli_fetch_array($result_pang_preview);


  if((@$_POST["date_sir_f"])!=''&&(@$_POST["date_sir_s"])!='' ){
    $date_sir_f= $_SESSION["date_sir_f"] = $_POST['date_sir_f'];
    $date_sir_s= $_SESSION["date_sir_s"] = $_POST['date_sir_s'];
    $where_vstdate=" psp.pang_stamp_arrear_date BETWEEN '$date_sir_f' AND '$date_sir_s' ";
  }elseif(isset($_POST['date_sir_f'])){
    $date_sir_f= $_SESSION["date_sir_f"] = $_POST['date_sir_f'];
    $where_vstdate=" psp.pang_stamp_arrear_date='$date_sir_f' ";
    unset($_SESSION["date_sir_s"]);
  }elseif(isset($_SESSION["date_sir_f"])&&isset($_SESSION["date_sir_s"])){
    $date_sir_f= $_SESSION["date_sir_f"];
    $date_sir_s= $_SESSION["date_sir_s"];
    $where_vstdate=" psp.pang_stamp_arrear_date BETWEEN '$date_sir_f' AND '$date_sir_s' ";
  }elseif(isset($_SESSION["date_sir_f"])){
    $date_sir_f= $_SESSION["date_sir_f"];
    $where_vstdate=" psp.pang_stamp_arrear_date='$date_sir_f' ";
  }



    ?>

    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
      <style type="text/css">
      td {
        word-break:break-all;
      }
      .tidleft{
        float: left;
      }
      </style>
      <style type="text/css">.popover {
            /*white-space: pre-wrap; */  
            max-width: 1600px; 
      }</style>
    </head>
      
<body>

    

<div class="container-fluid" >
  <div class="row">
    <div class="col-md-3 col-lg-3 tidleft">
      
    </div>
     
  <?php
    if(empty($date_sir_f)){
    }elseif(isset($date_sir_f)){

      $date_now=date("Y-m-d");
      $sqlshow = "SELECT 
                psp.pang_stamp_vn AS VN
                ,psp.pang_stamp_hn AS HN
                $select_vstdate
                ,psp.pang_stamp_arrear_date AS 'stampวันที่ลงค้าง'
                ,psp.pang_stamp_paid_money AS 'stampเงินที่ต้องชำระ'
                ,psp.pang_stamp_arrear_amount AS 'stampเงินค้าง'
                ,(SELECT SUM(bill_amount) FROM rcpt_print rp WHERE rp.vn=psp.pang_stamp_vn LIMIT 1)bill_amount
                
                
                ,'' AS 'คงเหลือค้าง'
                ,IF(psp.pang_stamp_approve_contract!='','มีใบสัญญา',CONCAT(psp.pang_stamp_approve_user,' : ',psp.pang_stamp_approve_reason) ) AS 'ใบสัญญา/เหตุผล'
                FROM $database_ii.pang_stamp_paid psp
                WHERE $where_vstdate
                AND (psp.pang_stamp_approve_status IS NOT NULL OR psp.pang_stamp_approve_status <> '')
                OR (psp.pang_stamp_approve_contract IS NOT NULL OR psp.pang_stamp_approve_contract <> '')
                GROUP BY psp.pang_stamp_hn             
                LIMIT 500 ";
      $result_show = mysqli_query($con_hos, $sqlshow) or die(mysqli_error($con_hos));
      $field_c = mysqli_num_fields($result_show);
  ?>
  
  </div>
</div>
    
<div class="container-fluid">
  <h2>Approve แล้ว</h2>
    <table class="table table-striped table-hover "  border="1" cellpadding="0" cellspacing="0" class="rowstyle-alt no-arrow" id="test1" >
      <thead>
        <tr>
          <th><div align="center">No.</div></th>
        <?php
        $head_no=-1;
        $c=0;
        $test_a=array();
        while($property=mysqli_fetch_field($result_show)){
        
        $test_a[$c]=$property->name;
        $c++
        ?>
          <!-- <th class="text-nowrap"><div align="center"><?php echo $head_no." ".$property->name; ?></div></th> -->
        <?php
        }

        for($u=0;$u<9;$u++){
          #echo $test_a[$u];
          $head_no++;
        ?>
          <th class="text-nowrap"><div align="center"><?php echo $head_no." ".$test_a[$u]; ?></div></th>

        <?php
          
        }
        ?>
          <!-- <th>test</th> -->
          
        </tr>

      </thead>


<?php
  

      $no=0;
      while($row_show = mysqli_fetch_array($result_show)){
      $no++;
      $vn=$row_show["VN"];
      $hn=$row_show["HN"];
      ?>
        <tr>
          
          <td><?php echo $no;?></td>

          

          <?php
          for($i=0;$i<6;$i++){
          ?>
            <td class="text-nowrap" align="center">
              <?php
              echo $row_show["$i"];

              ?>
            </td>
          <?php
          }

          if(isset($row_show["bill_amount"])){
          ?>
            <td>
              <a tabindex="0" onclick="show_rcpt(this.id)" class="btn btn-md btn-warning" data-bs-trigger="focus" role="button" data-bs-toggle="popover" data-bs-html="true" data-bs-placement="left" title="ICD" data-bs-content="<div id='show_rcpt'></div>" id="<?php echo $vn; ?>">
                <?php echo $row_show["bill_amount"]; ?>
              </a>
                
            </td>
          <?php
          }else{ echo "<td></td>";}
          ?>
            <td class="text-nowrap" align="center">
              <?php
              echo ($row_show["stampเงินที่ต้องชำระ"]-$row_show["bill_amount"]);

              ?>
            </td>
          <?php
          for($i=8;$i<9;$i++){
          ?>
            <td class="text-nowrap" align="center">
              <?php
              echo $row_show["$i"];

              ?>
            </td>
          <?php
          }
          ?>
          

          <!-- ############################################## 
          
            <td class="text-nowrap" align="right">
              <?php $vn=$row_show["VN"]; ?>
              
              <a tabindex="0" onclick="showCustomer(this.id)" class="btn btn-md btn-success" role="button" data-bs-toggle="popover" data-bs-html="true"  title="รายการค่ารักษา" 
  data-bs-content="<div id='txtHint'></div>" id="<?php echo $vn; ?>">ค่าใช้จ่าย</a>
            </td>-->
          <!-- ############################################## -->
          <?php



         
          ?>

        </tr>
      <?php
        
      }// loop while
      ?>
    </form>

    </table>

<?php 
  }// if date_sir_f

?>

</div>

<script>
function showCustomer(str) {
  var xhttp;    
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "index_claim/getcustomer.php?q="+str, true);
  xhttp.send();
}
</script>

<script>
function showCus(str) {
  var xhttp;    
  if (str == "") {
    document.getElementById("txtHin").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHin").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "index_claim/getcustomers.php?q="+str, true);
  xhttp.send();
}
</script>


<script>
function showicd(str) {
  var xhttp;    
  if (str == "") {
    document.getElementById("txtHin").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("show_icd").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "index_claim/get_icd.php?q="+str, true);
  xhttp.send();
}
</script>

<script>
function show_person(str) {
  
  var xhttp;    
  if (str == "") {
    document.getElementById("txtHin").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     
      document.getElementById("show_person").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "index_claim/get_person.php?q="+str, true);
  xhttp.send();
}



</script>

<script>
function show_rcpt(str) {
  
  var xhttp;    
  if (str == "") {
    document.getElementById("txtHin").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     
      document.getElementById("show_rcpt").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "index_money/get_rcpt.php?q="+str, true);
  xhttp.send();
}



</script>

<script>
function show_pang_stamp_paid_paisanee(str) {
  
  var xhttp;    
  if (str == "") {
    document.getElementById("txtHin").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     
      document.getElementById("show_pang_stamp_paid_paisanee").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "index_money/get_stamp_paid_paisanee.php?q="+str, true);
  xhttp.send();
}



</script>

</body>
</html>





