<?php

include("connect/connect.php");

set_time_limit(0);
// some code

@session_start();

#เงื่อนไขผัง
if(isset($_GET["pang"])){
    $pang = $_SESSION["pang"] = $_GET["pang"];
}else{
    $pang = $_SESSION["pang"];
}


  



$sql_pang_preview=" SELECT p.pang_id, p.pang_fullname, p.pang_instument, p.pang_stm, p.pang_kor_tok, p.pang_kor_tok_icd, p.pang_cancer, p.pang_type
      FROM pang p LEFT OUTER JOIN pang_sub ps ON p.pang_id=ps.pang_id
                  WHERE p.pang_id='$pang' AND p.pang_year='$sir_year'
                  LIMIT 100";
$result_pang_preview = mysqli_query($con_money, $sql_pang_preview) or die(mysqli_error($con_money));
$row_pang_preview = mysqli_fetch_array($result_pang_preview);
$pang_type = $row_pang_preview["pang_type"];##ตรวจว่าเป็นคนไข้ในหรือคนไข้นอก

# pang_pttype #########################################
$concat_pttype_all="";
$sql_concat_pttype=" SELECT pp.pang_pttype FROM pang_pttype pp WHERE pp.pang_id='$pang' LIMIT 500";
$result_concat_pttype = mysqli_query($con_money, $sql_concat_pttype) or die(mysqli_error($con_money));
while($row_concat_pttype = mysqli_fetch_array($result_concat_pttype)){
  $concat_pttype_all.="'".$row_concat_pttype['pang_pttype']."',";
}//loop while row_concat_pttype
$concat_pttype_all=substr($concat_pttype_all,0,strlen($concat_pttype_all)-1);


if($concat_pttype_all!=""){
  $where_pttype=" AND o.pttype IN (".$concat_pttype_all.") ";
}else{
  $where_pttype=" AND ptt.hipdata_code = 'UCS' AND ptt.paidst='02' ";
}
# pang_pttype #########################################

# pang_hospcode #########################################
$concat_hospcode="";
$s_concat_hospcode=" SELECT ph.pang_hospcode FROM pang_hospcode ph WHERE ph.pang_id='$pang' LIMIT 500";
$q_concat_hospcode = mysqli_query($con_money, $s_concat_hospcode) or die(mysqli_error($con_money));
while($r_concat_hospcode = mysqli_fetch_array($q_concat_hospcode)){
  $concat_hospcode.="'".$r_concat_hospcode['pang_hospcode']."',";
}//loop while row_concat_hospcode
$concat_hospcode=substr($concat_hospcode,0,strlen($concat_hospcode)-1);


if($concat_hospcode!=""){
  $where_hospcode_in=" AND o.hospmain IN (".$concat_hospcode.") ";
}else{
  $where_hospcode_in="  ";
}
# pang_hospcode #########################################

# pang_hospcode_notin #########################################
$concat_hospcode_notin="";
$s_concat_hospcode_notin=" SELECT phn.pang_hospcode FROM pang_hospcode_notin phn WHERE phn.pang_id='$pang' LIMIT 500";
$q_concat_hospcode_notin = mysqli_query($con_money, $s_concat_hospcode_notin) or die(mysqli_error($con_money));
while($r_concat_hospcode_notin = mysqli_fetch_array($q_concat_hospcode_notin)){
  $concat_hospcode_notin.="'".$r_concat_hospcode_notin['pang_hospcode']."',";
}//loop while row_concat_hospcode
$concat_hospcode_notin=substr($concat_hospcode_notin,0,strlen($concat_hospcode_notin)-1);


if($concat_hospcode_notin!=""){
  $where_hospcode_notin=" AND o.hospmain NOT IN (".$concat_hospcode_notin.") ";
}else{
  $where_hospcode_notin="  ";
}
# pang_hospcode_notin #########################################


# pang_kor_tok check ข้อตกลง #########################################
$pang_kor_tok = $row_pang_preview["pang_kor_tok"];
$pang_kor_tok_icd = $row_pang_preview["pang_kor_tok_icd"];
# pang_kor_tok check ข้อตกลง #########################################


# pang_cancer ###########
/*
if(isset($row_pang_preview["pang_cancer"])){
  $where_pang_cancer = " AND v.pdx LIKE 'C%' ";
}else{
  $where_pang_cancer = " AND v.pdx NOT LIKE 'C%' ";
}
*/
# pang_cancer ###########


  if((@$_POST["date_sir_f"])!=''&&(@$_POST["date_sir_s"])!='' ){
    $date_sir_f= $_SESSION["date_sir_f"] = $_POST['date_sir_f'];
    $date_sir_s= $_SESSION["date_sir_s"] = $_POST['date_sir_s'];
    $where_vstdate=" AND ps.pang_stamp_dchdate BETWEEN '$date_sir_f' AND '$date_sir_s' ";
  }elseif(isset($_POST['date_sir_f'])){
    $date_sir_f= $_SESSION["date_sir_f"] = $_POST['date_sir_f'];
    $where_vstdate=" AND ps.pang_stamp_dchdate='$date_sir_f' ";
    unset($_SESSION["date_sir_s"]);
  }elseif(isset($_SESSION["date_sir_f"])&&isset($_SESSION["date_sir_s"])){
    $date_sir_f= $_SESSION["date_sir_f"];
    $date_sir_s= $_SESSION["date_sir_s"];
    $where_vstdate=" AND ps.pang_stamp_dchdate BETWEEN '$date_sir_f' AND '$date_sir_s' ";
  }elseif(isset($_SESSION["date_sir_f"])){
    $date_sir_f= $_SESSION["date_sir_f"];
    $where_vstdate=" AND ps.pang_stamp_dchdate='$date_sir_f' ";
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

    </head>
      
<body>

    

<div class="container-fluid" style="">
       
  <?php
    if(empty($date_sir_f)){
    }elseif(isset($date_sir_f)){

      $date_now=date("Y-m-d");
      $sqlshow = "SELECT IF(ps.pang_stamp_an IS NULL,'','Y')AS Stamp
                ,ps.pang_stamp_an AS 'AN'
                ,ps.pang_stamp_hn AS 'HN'
                ,CONCAT(ps.pang_stamp_vstdate,' / ',ps.pang_stamp_dchdate) AS 'วันที่Admit/วันที่Discharge'
                ,ps.pang_stamp_nhso AS 'สิทธิ Stamp'
                ,ps.pang_stamp_uc_money AS stamp_uc_money
                ,ps.pang_stamp_stm_money AS stm
                ,ps.pang_stamp_uc_money_minut_stm_money AS 'ส่วนต่าง'
                ,ps.pang_stamp_send
                ,ps.pang_stamp_id
                FROM $database_ii.pang_stamp ps
                WHERE ps.pang_stamp = '$pang'
                $where_vstdate
                ORDER BY ps.pang_stamp_an
                LIMIT 5000 ";
      $result_show = mysqli_query($con_hos, $sqlshow) or die(mysqli_error($con_hos));
      $field_c = mysqli_num_fields($result_show);
  ?>

<!-- hide show sql #####################################################-->
    <div class="col-md-2 col-lg-2 tidleft">
      
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
<!-- hide show sql #####################################################-->

    
  </div>
</div>
    
<div class="container-fluid">

    <table class="table table-striped table-hover"  border="1" cellpadding="0" cellspacing="0" class="rowstyle-alt no-arrow" id="test1" >
      <thead>
        <tr>
          
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

        for($u=0;$u<10;$u++){
          #echo $test_a[$u];
          $head_no++;
        ?>
          <th class="text-nowrap"><div align="center"><?php echo $head_no." ".$test_a[$u]; ?></div></th>
        <?php
          
        }

        ?>

          
        </tr>
      </thead>


<?php
  

      $no=0;
      while($row_show = mysqli_fetch_array($result_show)){
      $no++;
        
        ?>
        <tr>
          
          <td class="text-nowrap">
              <?php
              $pang_stamp_id = $row_show["pang_stamp_id"]; #pang_stamp_id
              if($row_show["0"]=="Y" && $row_show["pang_stamp_send"]!=""){
              ?>
                <!-- <a class="btn btn-danger" href="#" role="button">แก้ไข ส่งการเงินแล้ว</a> -->
                <a tabindex="0" onclick="showeditsend(this.id)" class="btn btn-md btn-danger" data-bs-placement="right" role="button" data-bs-toggle="popover" data-bs-html="true"  title="แก้ไขที่ส่งการเงินไปแล้ว" data-bs-content="<div id='showeditsend'></div>" 
                  id="<?php echo $pang_stamp_id."|".$pang_type."|".$backto; ?>">แก้ไข ส่งการเงินแล้ว
                </a>
              <?php
              }elseif($row_show["0"]=="Y"){
              ?>
                <!-- <a class="btn btn-primary" href="#" role="button">แก้ไข</a> -->
                <a tabindex="0" onclick="showedit(this.id)" class="btn btn-md btn-primary" data-bs-placement="right" role="button" data-bs-toggle="popover" data-bs-html="true"  title="แก้ไข" data-bs-content="<div id='showedit'></div>" id="<?php echo $pang_stamp_id; ?>">แก้ไข
                </a>
              <?php
              }else{
                echo $row_show["0"];
              }    
              ?>
          </td>

          <td class="text-nowrap" align="left">
              <?php $an=$row_show["1"]; ?>
              
              <a tabindex="0" onclick="show_person(this.id)" class="btn btn-md btn-success" data-bs-trigger="focus" role="button" data-bs-toggle="popover" data-bs-html="true"  title="ICD" 
  data-bs-content="<div id='show_person'></div>" id="<?php echo $an; ?>"><?php echo $row_show["1"]; ?></a>
          </td>

        <?php
        for($i=2;$i<8;$i++){
        ?>
          <td class="text-nowrap">
            <?php
            echo $row_show["$i"]."<BR>";

            ?>
          </td>
        <?php
        }
        ?>
          <!-- ICDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD ############################################## -->
            <td class="text-nowrap" align="left">
              
              <?php echo $row_show["pang_stamp_send"]; ?>
            </td>
            
          <!-- ICDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD ############################################## -->

          <!-- ############################################## -->
          <style type="text/css">.popover {
            /*white-space: pre-wrap; */  
            max-width: 1600px; 
          }</style>
            <td class="text-nowrap" align="right">
              
              <?php echo $row_show["pang_stamp_id"]; ?>
            </td>
          <!-- ############################################## -->
          
<!-- กระบวนการเช็ค stm กระบวนการเช็ค stmกระบวนการเช็ค stmกระบวนการเช็ค stmกระบวนการเช็ค stmกระบวนการเช็ค stmกระบวนการเช็ค stm-->
          <?php
          if($row_pang_preview["pang_stm"]!="doc"){
          $pang_stm = $row_pang_preview["pang_stm"];
          ?>
            <!-- <td class="text-nowrap"> -->
            <?php 
            #echo number_format($row_show["stm"],2);
            $s_check_appeal="SELECT s.stm_claim FROM pang_stamp ps
                              LEFT OUTER JOIN $pang_stm s ON ps.match_hos = s.match_stm
                              WHERE ps.pang_stamp_an='".$row_show["AN"]."' LIMIT 1,1";
            $q_check_appeal=mysqli_query($con_money, $s_check_appeal) or die(mysqli_error($con_money));
            $r_check_appeal = mysqli_fetch_array($q_check_appeal); 
            @$check_stm_claim = $r_check_appeal["stm_claim"];
            if(isset($check_stm_claim)){    
              echo "<span style='color:red;'>(".number_format($check_stm_claim,2).")</span>";
            }
            ?>
            <!-- </td> -->

            <?php
            
            #$match_hos = $row_show["match_hos"];
            if($row_show["stm"]==''){
              $sql_check_stm="SELECT s.stm_claim, s.stm_file_name FROM pang_stamp ps
                              LEFT OUTER JOIN $pang_stm s ON ps.match_hos = s.match_stm
                              WHERE ps.pang_stamp_an='".$row_show["AN"]."'
                              LIMIT 1";
              $query_check_stm=mysqli_query($con_money, $sql_check_stm) or die(mysqli_error($con_money));
              $rowcheck_stm = mysqli_fetch_array($query_check_stm);
              @$stm_claim=$rowcheck_stm["stm_claim"];
              @$stm_file_name=$rowcheck_stm["stm_file_name"];

              if($stm_claim!=''){
                $stm_minut_hos=$stm_claim-$row_show["stamp_uc_money"];
                $update_pang_stamp_stm_money="
                    UPDATE pang_stamp
                    SET pang_stamp_stm_money = '$stm_claim' , pang_stamp_uc_money_minut_stm_money = '$stm_minut_hos'
                    , pang_stamp_stm_file_name = '$stm_file_name'
                    WHERE pang_stamp_an='".$row_show["AN"]."' AND pang_stamp='$pang';
                    ";
                $query_update_pang_stamp_stm_money=mysqli_query($con_money, $update_pang_stamp_stm_money) or die(mysqli_error($con_money));
              ?>
              <script>
              //Using setTimeout to execute a function after 5 seconds.
              setTimeout(function () {
                 //Redirect with JavaScript
                 window.location.href= '<?php echo $backto ?>';
              }, 0);
              </script>
            <?php
              }
            
            } #if($row_show["13"]==''){

          }
          ?>
<!-- กระบวนการเช็ค stm กระบวนการเช็ค stmกระบวนการเช็ค stmกระบวนการเช็ค stmกระบวนการเช็ค stmกระบวนการเช็ค stmกระบวนการเช็ค stm-->


            
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
function showeditsend(str) {
  var xhttp;    
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("showeditsend").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "index_claim/get_edit_stamp_send.php?q="+str, true);
  xhttp.send();
}
</script>

<script>
function showedit(str) {
  var xhttp;    
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("showedit").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "index_claim/get_edit_stamp.php?q="+str, true);
  xhttp.send();
}
</script>

</body>
</html>





