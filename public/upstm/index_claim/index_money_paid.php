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

if(isset($_REQUEST["pang_type"])){
    $show = $_SESSION["show"] = $_REQUEST["pang_type"];
    #$show = $_SESSION["show"] = "PAID_".$pt_type;
    $show_explode = explode("_", $show);
    $pt_type = $_SESSION["pt_type"] = $show_explode[1];
}else{
    $pt_type = $_SESSION["pt_type"];
    $show = $_SESSION["show"];
}

if($pt_type=="OPD"){
  $left_join_stat = " LEFT OUTER JOIN vn_stat v ON ra.vn=v.vn ";
  $where_vn_an = " vn ";
}elseif($pt_type=="IPD"){
  $left_join_stat = " LEFT OUTER JOIN an_stat v ON ra.vn=v.an ";
  $where_vn_an = " an ";
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

    

<div class="container-fluid" style="">
  <h1>ผังบัญชี<?php echo $row_pang_preview["pang_id"]." - ".$row_pang_preview["pang_fullname"];?> </h1>
  <div class="row">
    <div class="col-md-3 col-lg-3 tidleft">
      <form method="post" action="<?php echo $backto;?>">
        <input type="date" min="<?php echo $start_year?>" value="<?php echo $date_sir_f ?>" max="<?php echo $end_year?>" name="date_sir_f" required="yes">&nbsp;&nbsp;ถึง&nbsp;
        <input type="date" min="<?php echo $start_year?>" value="<?php echo $date_sir_s ?>" max="<?php echo $end_year?>" name="date_sir_s">
        <input type="hidden" name="show" value="<?php echo $show;?>">
        <button type="submit">Preview</button>
      </form>
      
    </div>
     
  <?php
    if(empty($date_sir_f)){
      echo "ระบุวันที่ preview";
    }elseif(isset($date_sir_f)){

      $date_now=date("Y-m-d");
      $sqlshow = "SELECT 
                IF(psp.pang_stamp_hn IS NULL,'','Y')AS Stamp
                , psp.pang_stamp_vn AS VN
                ,psp.pang_stamp_hn AS HN
                ,IF(psp.pang_stamp_pt_type='OPD',(SELECT vstdate FROM ovst WHERE vn=psp.pang_stamp_vn LIMIT 1),(SELECT vstdate FROM ovst WHERE an=psp.pang_stamp_vn LIMIT 1)) AS 'วันที่รับบริการ' 
                ,psp.pang_stamp_arrear_date AS 'stampวันที่ลงค้าง'
                ,psp.pang_stamp_paid_money AS 'stampเงินที่ต้องชำระ'
                ,psp.pang_stamp_arrear_amount AS 'stampเงินค้าง'
                ,(SELECT SUM(bill_amount) FROM rcpt_print rp WHERE rp.vn=psp.pang_stamp_vn LIMIT 1)bill_amount
                
                
                ,psp.pang_stamp_pt_type AS 'ประเภทผู้ป่วย'
                ,psp.pang_stamp_id
                FROM $database_ii.pang_stamp_paid psp
                WHERE (psp.pang_stamp_approve_user IS NULL OR psp.pang_stamp_approve_user = '')
                AND (psp.pang_stamp_approve_contract IS NULL OR psp.pang_stamp_approve_contract = '')
                GROUP BY psp.pang_stamp_hn             
                LIMIT 500 ";
      $result_show = mysqli_query($con_hos, $sqlshow) or die(mysqli_error($con_hos));
      $field_c = mysqli_num_fields($result_show);
  ?>

<!-- hide_show_sql #####################################################-->
    <div class="col-md-2 col-lg-2 tidleft" >
      <button id="hider">Hide SQL</button>
      <button id="shower">Show SQL</button>
      <style>
        p {
          padding: 3px;
          float: center;
          border: 1px solid #000000;
        }
        </style>
        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
             
      <script>
      $( "#hider" ).click(function() {
        $( "p:last-child" ).hide( "fast", function() {
          // Use arguments.callee so we don't need a named function
          $( this ).prev().hide( "fast", arguments.callee );
        });
      });
      $( "#shower" ).click(function() {
        $( "p" ).show( 10 );
      });
      </script>
    </div>

    <div class="container p-3 my-3 ">
      <div class="col-md-12 col-lg-12">
        <div>
          <p style="display: none;"><?php echo $sqlshow?></p>
        </div>
      </div>
    </div>
<!-- hide_show_sql #####################################################-->

    <div class="col-md-1 col-lg-1 mb-1">
      

    </div>
    
  </div>
</div>
    
<div class="container-fluid">
  <h2>รายการที่รอ Approve</h2>
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

        for($u=0;$u<6;$u++){
          #echo $test_a[$u];
          $head_no++;
        ?>
          <th class="text-nowrap"><div align="center"><?php echo $head_no." ".$test_a[$u]; ?></div></th>

        <?php
          
        }
        ?>
        <th>ชำระ</th>
        <?php

        for($u=7;$u<9;$u++){
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
      ?>
        <tr>
          
          <td><?php echo $no;?></td>
          

          <td class="text-nowrap" align="center">
            <a tabindex="0" onclick="show_approve(this.id)" class="btn btn-md btn-danger" role="button" 
                data-bs-toggle="popover" data-bs-html="true"  title="ลบค้าง" data-bs-content="<div id='show_approve'></div>" 
                id="<?php echo $row_show["pang_stamp_id"]."|N"; ?>">ลบค้าง
            </a>
          </td>

            <td class="text-nowrap" align="left">
              <?php $vn=$row_show["VN"]; ?>
              
              <a tabindex="0" onclick="show_person(this.id)" class="btn btn-md btn-success" data-bs-trigger="focus" role="button" data-bs-toggle="popover" data-bs-html="true"  title="ICD" 
  data-bs-content="<div id='show_person'></div>" id="<?php echo $vn; ?>"><?php echo "ข้อมูล"#$row_show["1"]; ?></a>
            </td>

          <?php
          for($i=2;$i<6;$i++){
          ?>
            <td class="text-nowrap" align="center">
              <?php
              echo $row_show["$i"]."<BR>";

              ?>
            </td>
          <?php
          }

          if(isset($row_show["rcpno"])){
          ?>
            <td>
              <a tabindex="0" onclick="show_rcpt(this.id)" class="btn btn-md btn-warning" data-bs-placement="left" data-bs-trigger="focus" role="button" data-bs-toggle="popover" data-bs-html="true"  title="ICD" data-bs-content="<div id='show_rcpt'></div>" id="<?php echo $vn; ?>">
                <?php echo "ชำระ"#$row_show["1"]; ?>
              </a>
            </td>
          <?php
          }else{ echo "<td></td>";}

          for($i=7;$i<9;$i++){
          ?>
            <td class="text-nowrap" align="center">
              <?php
              echo $row_show["$i"]."<BR>";

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
          <td>
            <a tabindex="0" onclick="show_approve(this.id)" class="btn btn-md btn-primary" role="button" 
                data-bs-toggle="popover" data-bs-html="true"  title="ลบค้าง" data-bs-content="<div id='show_approve'></div>" 
                data-bs-placement="left" id="<?php echo $row_show["pang_stamp_id"]."|Y"; ?>">ลงค้าง
            </a>
          </td>
        </tr>
      <?php
        
      }// loop while
      ?>
    

    </table>

<?php 
  }// if date_sir_f
include("index_claim/index_money_paid_s_show.php");
?>

</div>
<script>
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})

$('body').on('click', function (e) {
    $('[data-bs-toggle=popover]').each(function () {
        // hide any open popovers when the anywhere else in the body is clicked
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

</script>
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
function show_approve(str) {
  
  var xhttp;    
  if (str == "") {
    document.getElementById("show_approve").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     
      document.getElementById("show_approve").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "index_claim/get_approve.php?q="+str, true);
  xhttp.send();
}



</script>

</body>
</html>





